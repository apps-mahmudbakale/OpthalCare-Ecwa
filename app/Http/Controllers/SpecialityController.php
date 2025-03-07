<?php

namespace App\Http\Controllers;

use App\Models\Speciality;
use Illuminate\Http\Request;

class SpecialityController extends Controller
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
    $speciality = Speciality::create($request->all());

    return redirect()->route('app.settings.consultations')->with('success', 'Speciality Added !');
  }

  /**
   * Display the specified resource.
   */
  public function show(Speciality $speciality)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Speciality $speciality)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Speciality $speciality)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Speciality $speciality)
  {
    $speciality->delete();

    return redirect()->route('app.settings.consultations')->with('success', 'Speciality Deleted');
  }
}
