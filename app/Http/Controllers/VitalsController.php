<?php

namespace App\Http\Controllers;

use App\Models\Vitals;
use Illuminate\Http\Request;

class VitalsController extends Controller
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
    // dd($request->all());
    // // $vitals = Vitals::create($request->all());
    $patient = $request->input('patient_id');
    $parameters = $request->input('parameter', []);
    $values = $request->input('value', []);

    // Save the form data to the database
    foreach ($parameters as $key => $parameter) {
      $value = $values[$key] ?? null; // Get th
      Vitals::create([
        'parameter' => $parameter,
        'value' => $value,
        'patient_id' => $patient
      ]);
    }
    return redirect()->route('app.patients.show', $patient)->with('success', 'Vital Recorded!');
  }

  /**
   * Display the specified resource.
   */
  public function show(Vitals $vitals)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Vitals $vitals)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Vitals $vitals)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Vitals $vitals)
  {
    //
  }
}
