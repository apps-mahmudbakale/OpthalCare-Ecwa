<?php

namespace App\Http\Controllers;

use App\Charts\BloodPressureChart;
use App\Charts\PulseChart;
use App\Charts\TemperatureChart;
use App\Charts\WeightChart;
use App\Models\Admission;
use App\Models\Bed;
use App\Models\Billing;
use App\Models\Drug;
use App\Models\DrugRequest;
use App\Models\Laboratory;
use App\Models\LabRequest;
use App\Models\Patient;
use App\Models\Procedure;
use App\Models\ProcedureRequest;
use App\Services\ServiceRequestHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdmissionController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $activeStatuses = ['pending', 'prepared', 'billed', 'active'];
    $tab       = $request->get('tab', 'active');
    $search    = $request->get('search', '');
    $ward_id   = $request->get('ward_id', '');
    $patient_id = $request->get('patient_id', '');

    $query = Admission::with(['patient.user', 'ward', 'bed'])
        ->when($tab === 'active',     fn($q) => $q->whereIn('admissions.status', $activeStatuses))
        ->when($tab === 'discharged', fn($q) => $q->where('admissions.status', 'discharged'))
        ->when($ward_id,    fn($q) => $q->where('admissions.ward_id', $ward_id))
        ->when($patient_id, fn($q) => $q->where('admissions.patient_id', $patient_id))
        ->when($search, fn($q) => $q->whereHas('patient.user', fn($sq) =>
            $sq->where('firstname', 'like', "%$search%")
               ->orWhere('lastname',  'like', "%$search%")
        ))
        ->latest('admissions.created_at');

    $admissions      = $query->paginate(15)->withQueryString();
    $activeCount     = Admission::whereIn('status', $activeStatuses)->count();
    $dischargedCount = Admission::where('status', 'discharged')->count();
    $patients        = Patient::with('user')->get();
    $wards           = \App\Models\Ward::all();

    return view('admission.index', compact(
        'admissions', 'activeCount', 'dischargedCount',
        'patients', 'wards', 'tab', 'search', 'ward_id', 'patient_id'
    ));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {

  }

  public function requestAdmission($id){
    $patient = Patient::find($id);
    $wards = \App\Models\Ward::all();
    return view('admission.create', compact('patient', 'wards'));
  }

  public function storeAdmissionRequest(Request $request)
  {
      $request->validate([
          'patient_id' => 'required|exists:patients,id',
          'ward_id' => 'required|exists:wards,id',
          'bed_id' => 'required|exists:beds,id',
          'reason_for_admission' => 'required|string',
      ]);

      $ref = str()->upper(str()->random(6));

      Admission::create([
          'patient_id' => $request->patient_id,
          'ward_id' => $request->ward_id,
          'bed_id' => $request->bed_id,
          'reason_for_admission' => $request->reason_for_admission,
          'user_id' => auth()->id(),
          'status' => 'pending',
          'ref' => $ref,
      ]);

      // Mark bed as occupied
      Bed::where('id', $request->bed_id)->update(['available' => 0]);

      return redirect()->back()->with('success', 'Admission request submitted successfully.');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    DB::beginTransaction();
    try {
      $request_ref = $request->request_ref;

      Admission::where('ref', $request_ref)->update([
        'status' => 'prepared'
      ]);

      // Save Drug Requests (if any)
      if ($request->has('drugs') && isset($request->drugs['drug_id']) && empty($request->drugs['drug_id'])) {
        foreach ($request->drugs['drug_id'] as $index => $drugId) {
          DrugRequest::create([
            'patient_id' => $request->patient_id,
            'category_id' => $request->drugs['category_id'][$index],
            'drug_id' => $drugId,
            'quantity' => $request->drugs['qty'][$index],
            'dose' => $request->drugs['dose'][$index],
            'user_id' => auth()->id(),
            'status' => 'Pending',
          ]);

          if ($drug = Drug::find($drugId)) {
            $serviceHandler = new ServiceRequestHandler();
            $serviceHandler->handleServiceRequest(
              $drug->name,
              $request->patient_id,
              'Pharmacy',
              'fresh',
              $request_ref,
              $request->drugs['qty'][$index],
              null,
              'admission_billing',
              'Drug requested during admission by ' . auth()->user()->firstname . ' ' . auth()->user()->lastname,
              $drug->id
            );
          }
        }
      }

      // Save Lab Requests (if any)
      if ($request->has('labs') && isset($request->labs['test_id'])) {
        foreach ($request->labs['test_id'] as $index => $testId) {
          LabRequest::create([
            'patient_id' => $request->patient_id,
            'test_id' => $testId,
            'priority' => $request->labs['priority'][$index],
            'request_note' => $request->labs['request_note'][$index],
            'user_id' => auth()->id(),
            'status' => 'Pending',
            'request_ref' => $request_ref,
          ]);

          if ($lab = Laboratory::find($testId)) {
            $serviceHandler = new ServiceRequestHandler();
            $serviceHandler->handleServiceRequest(
              $lab->name,
              $request->patient_id,
              'Laboratory',
              'fresh',
              $request_ref,
              1,
              null,
              'admission_billing',
              'Lab test requested during admission by ' . auth()->user()->firstname . ' ' . auth()->user()->lastname,
              $lab->id
            );
          }
        }
      }

      DB::commit();
      return redirect()->route('app.admissions.index')->with('success', 'Admission created successfully.');

    } catch (\Exception $e) {
      DB::rollBack();
      return back()->with('error', 'Something went wrong: ' . $e->getMessage());
    }
  }


  public function bill($admission){
    $admission = Admission::where('ref', $admission)->first();
    return view('admission.bill', compact('admission'));
  }


  public function billAdmission(Request $request){
    $procedure = Procedure::where('id', $request->procedure_id)->first();
    $billAdmission = Billing::create([
      'service'    => 'Admission:'.$procedure->name,
      'service_id' => $procedure->id,
      'user_id'    => $request->patient_id,
      'quantity'   => 1,
      'amount'     => $request->amount,
      'bill_ref'   => $request->ref,
      'payer_id'   => Auth::id(),
      'status'     => 0,
    ]);

    $admission = Admission::where('ref', $request->ref)->update([
      'status' => 'billed'
    ]);

    return redirect()->route('app.admissions.index')->with('success', 'Admission Billed successfully.');
  }

  /**
   * Display the specified resource.
   */
  public function show(BloodPressureChart $chart, PulseChart $pulse, TemperatureChart $temperature, WeightChart $weight, Admission $admission)
  {
    $patient = Patient::where('id', $admission->patient_id)->first();
    $wallet_balance = $patient->wallet ? $patient->wallet->balance : 0;
    $outstanding_balance = Billing::where('user_id', $admission->patient_id)->where('status', 0)->sum('amount');

    $progressNotes = \App\Models\ProgressNote::with('user')
        ->where('admission_id', $admission->id)->latest()->paginate(10, ['*'], 'progress_page');
    $nursingNotes = \App\Models\NursingNote::with('user')
        ->where('admission_id', $admission->id)->latest()->paginate(10, ['*'], 'nursing_page');
    $nursingTasks = \App\Models\NursingTask::with('user')
        ->where('admission_id', $admission->id)->latest()->paginate(10, ['*'], 'task_page');
    $labRequests     = \App\Models\LabRequest::with('test')->where('patient_id', $admission->patient_id)->latest()->paginate(10, ['*'], 'lab_page');
    $imagingRequests = \App\Models\RadiologyRequest::with('test')->where('patient_id', $admission->patient_id)->latest()->paginate(10, ['*'], 'imaging_page');
    $drugRequests    = \App\Models\DrugRequest::with('drug')->where('patient_id', $admission->patient_id)->latest()->paginate(10, ['*'], 'drug_page');

    return view('admission.show', [
      'admission'           => $admission,
      'patient'             => $patient,
      'blood_pressure'      => $chart->build($patient->id),
      'pulse'               => $pulse->build($patient->id),
      'temperature'         => $temperature->build($patient->id),
      'weight'              => $weight->build($patient->id),
      'outstanding_balance' => $outstanding_balance,
      'wallet_balance'      => $wallet_balance,
      'progressNotes'       => $progressNotes,
      'nursingNotes'        => $nursingNotes,
      'nursingTasks'        => $nursingTasks,
      'labRequests'         => $labRequests,
      'imagingRequests'     => $imagingRequests,
      'drugRequests'        => $drugRequests,
    ]);
  }

  public function assignBed($ref){
    $admission = Admission::where('ref', $ref)->first();
    return view('admission.assign-bed', compact('admission'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Admission $admission)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Admission $admission)
  {
    $billing = Billing::where('bill_ref', $request->ref)->first();

    if ($billing->status == 0){
      return redirect()->back()->with('error', 'Patient Admission Bill not settled');
    }

    // Mark old bed as available if changing beds
    if ($admission->bed_id && $admission->bed_id != $request->bed_id) {
        Bed::where('id', $admission->bed_id)->update(['available' => 1]);
    }

    // Mark new bed as occupied
    Bed::where('id', $request->bed_id)->update(['available' => 0]);

    Admission::where('ref', $request->ref)->update([
      'ward_id' => $request->ward_id,
      'bed_id'  => $request->bed_id,
      'status'  => 'active'
    ]);

    return redirect()->route('app.admissions.index')->with('success', 'Admission Bed Assigned successfully.');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Admission $admission)
  {
    //
  }

  public function discharge(Request $request, Admission $admission)
  {
      $request->validate([
          'discharge_note' => 'nullable|string',
          'discharged_at'  => 'required|date',
      ]);

      // Free up the bed
      if ($admission->bed_id) {
          Bed::where('id', $admission->bed_id)->update(['available' => 1]);
      }

      $admission->update([
          'status'         => 'discharged',
          'discharge_note' => $request->discharge_note,
          'discharged_at'  => $request->discharged_at,
      ]);

      return redirect()->route('app.admissions.index')
          ->with('success', 'Patient discharged successfully.');
  }
}
