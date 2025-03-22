<?php

namespace App\Http\Controllers;

use App\Models\LabRequest;
use App\Models\LabResult;
use App\Models\Patient;
use App\Models\Radiology;
use App\Models\RadiologyResult;
use Illuminate\Http\Request;
use App\Models\RadiologyRequest;
use App\Services\ServiceRequestHandler;

class RadiologyRequestController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('radiology.index');
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }
   public function addFindings(){

   }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $imagingrequest = RadiologyRequest::create(array_merge($request->except('status'), ['status' => 'Pending']));
    $imaging = Radiology::find($request->imaging_id);
    $serviceHandler = new ServiceRequestHandler();
    $billingRecord = $serviceHandler->handleServiceRequest($imaging->name, $request->patient_id, 'Radiology');
    return redirect()->back()->with('success', 'Imaging Requested!');
  }

  public function addResult(Request $request){
    $result = RadiologyResult::create($request->all());
    $update = RadiologyRequest::where('id', $result->imaging_id)->update(['status' => 'Result Ready']);
    return redirect()->back()->with('success', 'Result Collected!');
  }

  public function showResult($id){
    $image = RadiologyRequest::where('id', $id)->first();
    $result = RadiologyResult::where('imaging_id', $id)->first();
    $patient = Patient::where('id', $image->patient_id)->first();
    return view('radiology.print', compact('image', 'result', 'patient'));
  }

  /**
   * Display the specified resource.
   */
  public function show(RadiologyRequest $radiologyRequest)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $request = RadiologyRequest::where('id', $id)->first();
    return view('radiology.result', compact('request'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, RadiologyRequest $radiologyRequest)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(RadiologyRequest $radiologyRequest)
  {
    //
  }
}
