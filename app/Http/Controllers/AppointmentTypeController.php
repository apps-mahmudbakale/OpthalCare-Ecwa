<?php

namespace App\Http\Controllers;

use App\Models\AppointmentType;
use Illuminate\Http\Request;

class AppointmentTypeController extends Controller
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
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $appointmentType = AppointmentType::create($request->all());
    return redirect()->route('app.settings.consultations')->with('success', 'Appointment Type Added !');
  }

  /**
   * Display the specified resource.
   */
  public function show(AppointmentType $appointmentType)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(AppointmentType $appointmentType)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, AppointmentType $appointmentType)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(AppointmentType $appointmentType)
  {
    $appointmentType->delete();
    return redirect()->route('app.settings.consultations')->with('success', 'Appointment Type Deleted !');
  }
}
