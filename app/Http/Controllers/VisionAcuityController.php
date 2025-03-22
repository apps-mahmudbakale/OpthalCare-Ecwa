<?php

namespace App\Http\Controllers;

use App\Models\VisionAcuity;
use Illuminate\Http\Request;

class VisionAcuityController extends Controller
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
    $va = VisionAcuity::create($request->all());
    return redirect()->back()->with('success', 'Vision Acuity Recorded!');
  }

  /**
   * Display the specified resource.
   */
  public function show(VisionAcuity $visionAcuity)
  {
    // dd($visionAcuity);
    return view('va.details', compact('visionAcuity'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(VisionAcuity $visionAcuity)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, VisionAcuity $visionAcuity)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(VisionAcuity $visionAcuity)
  {
    //
  }
}
