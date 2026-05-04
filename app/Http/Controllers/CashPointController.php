<?php

namespace App\Http\Controllers;

use App\Models\CashPoint;
use App\Models\TempPatient;
use App\Services\ServiceRequestHandler;
use Illuminate\Http\Request;

class CashPointController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('cashpoint.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $cashpoint = CashPoint::create($request->all());
    return redirect()->back()->with('success', 'Cash Point Added!');
  }

  public function newPatient(String $id)
  {

    // Decode the values from Base64
    $patientId = base64_decode($id);

    $tempPatient = TempPatient::find($patientId);
//    dd($tempPatient);

    // Now you can use the decrypted patient ID and name in your view or logic
    return view('billing.new-enroll', compact('tempPatient'));
  }

  public function billPatient(Request $request)
  {
//    dd($request->all());
    $request_ref = str()->random(6);
    $serviceHandler = new ServiceRequestHandler();
    $class = 'App\Services\BillingService';

    if (class_exists($class)) {
      $billserviceInstance = app($class);

      if (method_exists($billserviceInstance, $request->service_category)) {
        $result = $billserviceInstance->{$request->service_category."Services"}($request->service_id);

        $billingRecord = $serviceHandler->handleServiceRequest(
          $result->name, 
          $request->patient_id, 
          ucfirst($request->service_category), 
          'fresh', 
          $request_ref, 
          1,
          null,
          'cashpoint_billing',
          'Service requested via cashpoint by ' . auth()->user()->firstname . ' ' . auth()->user()->lastname,
          $result->id
        );
        return  view('billing.new-enroll-pay', compact('billingRecord'));

      } else {
        return response()->json(['error' => 'Method not found'], 404);
      }
    } else {
      return response()->json(['error' => 'Service class not found'], 404);
    }
  }
  /**
   * Display the specified resource.
   */
  public function show(CashPoint $cashPoint)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $cashPoint = CashPoint::where('id', $id)->first();
    return view('cashpoint.edit', compact('cashPoint'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
      $cashpoint = CashPoint::where('id', $id)->first();

      $cashpoint->update($request->all());

      return redirect()->back()->with('success', 'Cash Point Updated');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    $cashpoint = CashPoint::where('id', $id)->first();

    $cashpoint->delete();
    return redirect()->back()->with('success', 'Cash Point Deleted');
  }
}
