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
      // Create Admission
      $admission = Admission::create([
        'patient_id' => $request->patient_id, // Assuming patient_id is passed or retrieved
        'ward_id' => $request->ward_id ? $request->ward_id : 1,
        'bed_id' => $request->bed_id ? $request->bed_id : 1,
        'status' => 'active',
      ]);

      // Update Bed Status
//      Bed::find(1)->update(['available' => false]);
//      $bed = Bed::find($request->bed_id)->first();
      $request_ref = $request->request_ref;
      $proceed = ProcedureRequest::where('request_ref', $request_ref)->first();
      $procedure = Procedure::where('id', $proceed->procedure_id)->first();


      $serviceHandler = new ServiceRequestHandler();
//      dd($bed);
      $bed = 'Bed 1';
      $billingRecord = $serviceHandler->handleServiceRequest($bed, $request->patient_id, 'Bed', $request_ref, 1);

      if ($billingRecord) {

      } else{
        Billing::create([
          'service'    => 'Bed:' . $bed,
          'service_id' => 1,
          'user_id'    => $request->patient_id,
          'quantity'   => 1,
          'amount'     => 20000,
          'bill_ref'   => $request_ref,
          'payer_id'   => Auth::id(),
          'status'     => 0,
        ]);
        Billing::create([
          'service'    => 'Procedure:' . $procedure->name,
          'service_id' => $procedure->id,
          'user_id'    => $request->patient_id,
          'quantity'   => 1,
          'amount'     => $procedure->price,
          'bill_ref'   => $request_ref,
          'payer_id'   => Auth::id(),
          'status'     => 0,
        ]);
      }

      // Save Drug Requests
      if ($request->has('drugs')) {
        foreach ($request->drugs['drug_id'] as $index => $drugId) {
          DrugRequest::create([
            'patient_id' => $request->patient_id,
            'store_id' => $request->drugs['store_id'][$index],
            'category_id' => $request->drugs['category_id'][$index],
            'drug_id' => $drugId,
            'quantity' => $request->drugs['qty'][$index],
            'dose' => $request->drugs['dose'][$index],
            'user_id' => auth()->user()->id,
            'status' => 'Pending',
          ]);
          $drug = Drug::find($drugId);
          $serviceHandler = new ServiceRequestHandler();
          $billingRecord = $serviceHandler->handleServiceRequest($drug->name, $request->patient_id, 'Pharmacy', $request_ref, $request->drugs['qty'][$index]);
        }
      }

      // Save Lab Requests
      if ($request->has('labs')) {
        foreach ($request->labs['test_id'] as $index => $testId) {
          LabRequest::create([
            'patient_id' => $request->patient_id,
            'test_id' => $testId,
            'priority' => $request->labs['priority'][$index],
            'request_note' => $request->labs['request_note'][$index],
            'user_id' => auth()->user()->id,
            'status' => 'Pending',
            'request_ref' => $request_ref,
          ]);
          $lab = Laboratory::find($testId); // fix: find by single $testId, not full array
          if ($lab) { // always good to check if lab exists
            $serviceHandler = new ServiceRequestHandler();
            $billingRecord = $serviceHandler->handleServiceRequest(
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
      $proceed = ProcedureRequest::find($proceed->id)->update(['status' => 'Bill Prepared']);
      return redirect()->route('app.admissions.index')->with('success', 'Admission created successfully.');
    } catch (\Exception $e) {
      DB::rollBack();
       dd($e->getMessage());
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(Admission $admission)
  {
    //
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
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Admission $admission)
  {
    //
  }
}
