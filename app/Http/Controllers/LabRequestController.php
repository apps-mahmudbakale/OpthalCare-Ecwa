<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\LabResult;
use App\Models\Laboratory;
use App\Models\LabRequest;
use Illuminate\Http\Request;
use App\Models\LabResultItem;
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
    //    dd($request->all());
    $request_ref = str()->random(6);
    foreach ($request->test_id as $index => $testId) {
      LabRequest::create([
        'test_id' => $testId,
        'priority' => $request->priority[$index],
        'request_note' => $request->request_note[$index],
        'request_ref' => $request_ref,
        'patient_id' => $request->patient_id,
        'user_id' => $request->user_id,
        'status' => 'Pending'
      ]);

      $lab = Laboratory::find($testId); // fix: find by single $testId, not full array
      if ($lab) { // always good to check if lab exists
        $serviceHandler = new ServiceRequestHandler();
        $billingRecord = $serviceHandler->handleServiceRequest($lab->name, $request->patient_id, 'Laboratory', 'fresh', $request_ref, 1);
      }
    }

    return redirect()->back()->with('success', 'Lab Test Requested!');
  }


  /**
   * Display the specified resource.
   */
  public function show($id)
  {
    $request = LabRequest::where('id', $id)->first();
    $labTest = Laboratory::with('template.items.parameter')->findOrFail($request->test_id);


    return view('laboratory.result', [
      'request' => $request,
      'labTest' => $labTest,
      'template' => $labTest->template,
      'parameters' => $labTest->template->items
    ]);
  }

  public function specimen($labRequest)
  {
    $lab = LabRequest::find($labRequest);
    $serviceHandler = new ServiceRequestHandler();
    $service = "Laboratory:" . $lab->test->name;
    $paid = $serviceHandler->isBilled($lab->test_id, $service, $lab->request_ref);

    if ($paid) {
      $lab->update(['status' => 'Specimen Collected']);
      return redirect()->back()->with('success', 'Specimen Collected!');
    } else {
      // dd("Service Has Not Been Paid");
      return redirect()->back()->with('error', 'Service Has Not Been Paid For Yet');
    }
  }

  public function addResult(Request $request)
  {
    // dd($request->all());
    $result = LabResult::create(array_merge($request->all(), ['user_id' => auth()->user()->id]));

    foreach ($request->items as $templateItemId => $value) {
      LabResultItem::create([
        'lab_result_id' => $result->id,
        'lab_template_item_id' => $templateItemId,
        'value' => $value,
      ]);
    }
    $update = LabRequest::where('id', $request->lab_id)->update(['status' => 'Result Ready']);
    return redirect()->back()->with('success', 'Result Collected!');
  }

  public function showResult($id)
  {
    $lab = LabRequest::where('id', $id)->first();
    $result = LabResult::where('lab_test_id', $lab->test_id)->first();
    $patient = Patient::where('id', $lab->patient_id)->first();
    return view('laboratory.print', compact('lab', 'result', 'patient'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $lab = LabRequest::find($id);
    return view('laboratory.edit', compact('lab'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $labRequest = LabRequest::findOrFail($id);

    $labRequest->update([
      'test_id' => $request->test_id,
      'priority' => $request->priority,
      'request_note' => $request->request_note,
      'patient_id' => $request->patient_id,
      'user_id' => $request->user_id,
    ]);

    return redirect()->back()->with('success', 'Lab Request Updated Successfully!');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    $request = LabRequest::find($id);
    $request->delete();
    return response()->json(['success' => true]);
  }
}
