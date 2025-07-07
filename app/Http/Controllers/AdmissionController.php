<?php

namespace App\Http\Controllers;

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
  public function index()
  {
    return view('admission.index');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {

  }

  public function requestAdmission($id){
    $patient = Patient::find($id);
    return view('admission.create', compact('patient'));
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
      if ($request->has('drugs') && isset($request->drugs['drug_id'])) {
        foreach ($request->drugs['drug_id'] as $index => $drugId) {
          DrugRequest::create([
            'patient_id' => $request->patient_id,
            'store_id' => $request->drugs['store_id'][$index],
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
              $request_ref,
              $request->drugs['qty'][$index]
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
              $request_ref,
              1
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
  public function show(Admission $admission)
  {
    //
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

    $admission = Admission::where('ref', $request->ref)->update([
      'ward_id' => $request->ward_id,
      'bed_id' =>$request->bed_id,
      'status' => 'active'
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
}
