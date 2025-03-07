<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class ReportController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {

    $today = now()->toDateString(); // Current date in 'Y-m-d' format

    // Fetch patients who registered today
    $patientTodayCount = Patient::whereDate('created_at', $today)->count();
    $patientsCount = Patient::count();




    return view('report.index', compact('patientTodayCount', 'patientsCount'));

  }

  public function generalReport(Request $request)
  {
    return view('report.general');
  }


  public function pharmacyReport(Request $request)
  {
    return view('report.pharmacy');
  }

  public function labReport(Request $request)
  {
    return view('report.lab');
  }

  public function radiologyReport(Request $request)
  {
    return view('report.radiology');
  }

  public function procedureReport(Request $request)
  {
    return view('report.procedure');
  }

  public function billingReport(Request $request)
  {
    return view('report.billing');
  }


  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
