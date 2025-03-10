<?php

namespace App\Http\Controllers;

use App\Models\Laboratory;
use App\Models\LabRequest;
use App\Models\LabResult;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Services\ServiceRequestHandler;

class LabRequestController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('laboratory.index');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $labrequest = LabRequest::create(array_merge($request->except('status'), ['status' => 'Pending']));
    $lab = Laboratory::find($request->test_id);
    $serviceHandler = new ServiceRequestHandler();
    $billingRecord = $serviceHandler->handleServiceRequest($lab->name, $request->patient_id, 'Laboratory');
    return redirect()->back()->with('success', 'Lab Test Requested!');
  }

  /**
   * Display the specified resource.
   */
  public function show($id)
  {
    $request = LabRequest::where('id', $id)->first();
    return view('laboratory.result', compact('request'));
  }

  public function specimen($labRequest)
  {
    $lab = LabRequest::find($labRequest);
    $serviceHandler = new ServiceRequestHandler();
    $service = "Laboratory:" . $lab->test->name;
    $paid = $serviceHandler->isBilled($lab->test_id, $service);

    if ($paid) {
      $lab->update(['status' => 'Specimen Collected']);
      return redirect()->back()->with('success', 'Specimen Collected!');
    } else {
      // dd("Service Has Not Been Paid");
      return redirect()->back()->with('error', 'Service Has Not Been Paid For Yet');
    }
  }

  public function addResult(Request $request){
    $result = LabResult::create($request->all());
    $update = LabRequest::where('id', $result->lab_id)->update(['status' => 'Result Ready']);
    return redirect()->back()->with('success', 'Result Collected!');
  }

  public function showResult($id){
    $lab = LabRequest::where('id', $id)->first();
    $result = LabResult::where('lab_id', $id)->first();
    $patient = Patient::where('id', $lab->patient_id)->first();
    return view('laboratory.print', compact('lab', 'result', 'patient'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(LabRequest $labRequest)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, LabRequest $labRequest)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(LabRequest $labRequest)
  {
    //
  }
}
