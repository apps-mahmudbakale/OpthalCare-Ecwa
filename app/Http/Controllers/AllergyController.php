<?php

namespace App\Http\Controllers;

use App\Http\Requests\Allergy\StoreAllergyRequest;
use App\Models\Allergy;
use Illuminate\Http\Request;

class AllergyController extends Controller
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
  public function store(StoreAllergyRequest $request)
  {
    $allergy = Allergy::create($request->all());
    return redirect()->back()->with('success', 'Allergy Created Successfully');
  }

  /**
   * Display the specified resource.
   */
  public function show(Allergy $allergy)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Allergy $allergy)
  {
    $this->allergy = $allergy;
    return view('allergies.edit', compact('allergy'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Allergy $allergy)
  {
    $allergy->update($request->all());
    return redirect()->back()->with('success', 'Allergy Updated Successfully');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    $allergy = Allergy::find($id);
    $allergy->delete();
    return redirect()->back()->with('success', 'Allergy Deleted Successfully');
  }
}
