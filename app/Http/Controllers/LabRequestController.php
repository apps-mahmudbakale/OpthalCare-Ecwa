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
  public function index(Request $request)
  {
    $perPage = $request->get('per_page', 10);
    $search = $request->get('search');
    $status = $request->get('status');
    $patientId = $request->get('patient_id');
    $categoryId = $request->get('category_id');
    $startDate = $request->get('start_date');
    $endDate = $request->get('end_date');

    $labRequests = LabRequest::query()
      ->when($status, function ($query) use ($status) {
        $query->where('status', $status);
      })
      ->when($patientId, function ($query) use ($patientId) {
        $query->where('patient_id', $patientId);
      })
      ->when($categoryId, function ($query) use ($categoryId) {
        $query->where('category_id', $categoryId);
      })
      ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
        $query->whereBetween('request_date', [$startDate, $endDate]);
      })
      ->when($search, function ($query) use ($search) {
        $query->whereHas('patient.user', function($q) use ($search) {
          $q->where('firstname', 'like', '%' . $search . '%')
            ->orWhere('lastname', 'like', '%' . $search . '%');
        })->orWhereHas('test', function($q) use ($search) {
          $q->where('name', 'like', '%' . $search . '%');
        });
      })
      ->latest()
      ->paginate($perPage);

    return view('laboratory.index', compact('labRequests'));
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
      'parameters' => $labTest->template ? $labTest->template->items : collect()
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
    // Use updateOrCreate to handle potential re-submissions or old ID reuse
    $result = LabResult::updateOrCreate(
        ['lab_request_id' => $request->lab_id],
        array_merge($request->all(), [
            'user_id' => auth()->id(),
        ])
    );

    // Ensure we start with a clean list of items for this result
    $result->items()->delete();

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

  public function showResult(Request $request, $id)
  {
    $lab = LabRequest::findOrFail($id);
    // Use the findings relationship to get the specific result for this request
    $result = $lab->findings; 
    
    // Fallback if null: filter by test AND patient to be safer
    if (!$result) {
        $result = LabResult::where('lab_test_id', $lab->test_id)
                           ->where('patient_id', $lab->patient_id)
                           ->latest()
                           ->first();
    }

    $patient = Patient::where('id', $lab->patient_id)->first();

    if ($request->has('modal')) {
        return view('laboratory.result-partial', compact('lab', 'result', 'patient'));
    }

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
    $labRequest = LabRequest::with('test')->find($id);
    if (!$labRequest) {
        return back()->with('error', 'Lab request not found.');
    }

    // Void the unpaid bill so patient doesn't owe
    if ($labRequest->test) {
        \App\Models\Billing::where('bill_ref', $labRequest->request_ref)
            ->where('service', 'Laboratory:' . $labRequest->test->name)
            ->where('status', 0)
            ->delete();
    }

    // Keep the record but mark as Cancelled for audit trail
    $labRequest->update(['status' => 'Cancelled']);
    return back()->with('success', 'Lab request cancelled and bill removed.');
  }

  /**
   * Bulk print multiple lab results in a single sheet
   */
  public function bulkPrintResults(Request $request)
  {
    $request->validate([
      'lab_ids' => 'required|array|min:1',
      'lab_ids.*' => 'exists:lab_requests,id'
    ]);

    // Get all lab requests with their results and related data
    $labRequests = LabRequest::with([
      'patient.user', 
      'test', 
      'findings.items.templateItem.parameter'
    ])
    ->whereIn('id', $request->lab_ids)
    ->where('status', 'Result Ready')
    ->get();

    if ($labRequests->isEmpty()) {
      return back()->with('error', 'No valid lab results found for printing.');
    }

    return view('laboratory.bulk-print', compact('labRequests'));
  }
}
