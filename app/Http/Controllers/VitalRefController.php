<?php

namespace App\Http\Controllers;

use App\Models\VitalRef;
use Illuminate\Http\Request;

class VitalRefController extends Controller
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
    return view('vitals.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $vitalRef = VitalRef::create($request->all());
    return redirect()->back()->with('success', 'Vital Reference Added!');
  }

  /**
   * Display the specified resource.
   */
  public function show(VitalRef $vitalRef)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(VitalRef $vitalRef)
  {
    return view('vitals.edit', compact('vitalRef'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, VitalRef $vitalRef)
  {
    $vitalRef->update($request->all());

    return redirect()->back()->with('success', 'Vital Reference Updated');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(VitalRef $vitalRef)
  {
    $vitalRef->delete();
    return redirect()->back()->with('success', 'Vital Reference Deleted');
  }
}
