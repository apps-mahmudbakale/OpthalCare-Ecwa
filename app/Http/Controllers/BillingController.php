<?php

namespace App\Http\Controllers;

use App\Models\Billing;
use App\Models\Laboratory;
use App\Models\Speciality;
use App\Services\ServiceRequestHandler;
use Illuminate\Http\Request;

class BillingController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('billing.index');
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


    if ($request->service_category == 'consultations') {
      $consult = Speciality::find($request->service_id);
//      dd($request->all());
      $serviceHandler = new ServiceRequestHandler();
      $billingRecord = $serviceHandler->handleServiceRequest($consult->name, $request->patient_id, 'consultations');
      // Generate unique access code
//      $accessCode = 'FU-' . strtoupper(Str::random(6));

    }
    return redirect()->back()->with('success', 'Bill Added Successfully!');

  }

  /**
   * Display the specified resource.
   */
  public function show(Billing $billing)
  {
    return view('billing.show', compact('billing'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Billing $billing)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Billing $billing)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Billing $billing)
  {
    //
  }
}
