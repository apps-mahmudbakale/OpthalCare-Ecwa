<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Models\DrugRequest;
use Illuminate\Http\Request;
use App\Services\ServiceRequestHandler;

class PharmacyController extends Controller
{
  public function index()
  {
    return view('pharmacy.index');
  }


  public function store(Request $request)
  {
//    dd($request->all());
    $request_ref = str()->random(6);
    foreach ($request->drug_id as $index => $testId) {
      DrugRequest::create([
                'patient_id' => $request->patient_id,
                'store_id' => $request->store_id[$index],
                'category_id' => $request->category_id[$index],
                'drug_id' => $request->drug_id[$index],
                'qty' => $request->qty[$index],
                'dose' => $request->dose[$index],
                'user_id' => auth()->user()->id,
                'status' => 'Pending',
                'request_ref' => $request_ref,
      ]);
      $drug = Drug::find($request->drug_id[$index]);
      $serviceHandler = new ServiceRequestHandler();
      $billingRecord = $serviceHandler->handleServiceRequest($drug->name, $request->patient_id, 'Pharmacy', $request_ref, $request->qty[$index]);
    }
    return redirect()->back()->with('success', 'Drugs Requested!');
  }

  public function show($id)
  {
    $requests = DrugRequest::with(['patient.user', 'drug'])
      ->where('request_ref', $id)
      ->get()
      ->filter(fn($item) => is_object($item));

    return view('pharmacy.details', compact('requests'));
  }


  public function edit($id)
  {

    $requests = DrugRequest::with(['patient.user', 'drug'])
      ->where('request_ref', $id)
      ->get()
      ->filter(fn($item) => is_object($item));
    return view('pharmacy.fill', compact('requests'));
  }

  public function print($id)
  {
    $request = DrugRequest::find($id);
    return view('pharmacy.print', compact('request'));
  }


  public function update(Request $request, $id)
  {
    $collectedBys = $request->collected_by;
    $qtys = $request->qty;

    $requests = DrugRequest::where('request_ref', $id)->get();

    foreach ($requests as $index => $drugRequest) {
      $drug = optional($drugRequest->drug);
      $service = "Pharmacy:" . $drug->name;

      $serviceHandler = new ServiceRequestHandler();
      $paid = $serviceHandler->isBilled($drug->id, $service);

      if ($paid) {
        $drugRequest->update([
          'collected_by' => $collectedBys[$index],
          'status' => 'Filled'
        ]);

        if ($drug->id) {
          Drug::where('id', $drug->id)->decrement('quantity', $qtys[$index]);
        }
      } else {
        return redirect()->back()->with('error', "Service for {$drug->name} has not been paid.");
      }
    }

    return redirect()->back()->with('success', 'All drugs filled successfully.');
  }
}
