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
    return redirect()->route('app.patients.show', $allergy->patient_id)->with('success', 'Allergy Created Successfully');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Allergy $allergy)
    {
       $allergy->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Allergy $allergy)
    {
        $allergy->delete();
    return redirect()->back()->with('success', 'Allergy Deleted Successfully');
    }
}
