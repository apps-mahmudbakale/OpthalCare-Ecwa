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
    $drugs = DrugRequest::create(array_merge($request->except('status'), ['status' => 'Pending', 'user_id' => auth()->user()->id]));
    $drug = Drug::find($request->drug_id);
    $serviceHandler = new ServiceRequestHandler();
    $billingRecord = $serviceHandler->handleServiceRequest($drug->name, $request->patient_id, 'Pharmacy');
    return redirect()->back()->with('success', 'Drugs Requested!');
  }

  public function show($id)
  {
    $request = DrugRequest::find($id);
    // dd($request);
    return view('pharmacy.details', compact('request'));
  }


  public function edit($id)
  {

    $request = DrugRequest::find($id);
    // dd($request);
    return view('pharmacy.fill', compact('request'));
  }

  public function print($id)
  {
    $request = DrugRequest::find($id);
    return view('pharmacy.print', compact('request'));
  }


  public function update(Request $request, $id)
  {
    $pharmacy = DrugRequest::find($id);
    // dd($pharmacy);
    $serviceHandler = new ServiceRequestHandler();
    $service = "Pharmacy:" . $pharmacy->drug->name;
    $paid = $serviceHandler->isBilled($pharmacy->drug->id, $service);

    if ($paid) {
      $pharmacy->update(['collected_by' => $request->collected_by, 'status' => 'Filled']);
      return redirect()->back()->with('success', 'Drugs Filled');
    } else {
      // dd("Service Has Not Been Paid");
      return redirect()->back()->with('error', 'Service Has Not Been Paid For Yet');
    }

    // return view('pharmacy.fill', compact('request'));
  }
}
