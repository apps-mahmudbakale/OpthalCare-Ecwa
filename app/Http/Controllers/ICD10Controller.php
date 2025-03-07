<?php

namespace App\Http\Controllers;

use App\Imports\ICD10Import;
use App\Imports\LabTestImport;
use App\Models\ICD10;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ICD10Controller extends Controller
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
    return view('icd.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $icd = ICD10::create($request->all());

    return redirect()->back()->with('success', 'ICD Added!');
  }

  public function import(Request $request)
  {

    Excel::import(new ICD10Import, $request->file('csv')->store('files'));

    return redirect()->back()->with('success', 'ICD10 data imported successfully!');
  }

  /**
   * Display the specified resource.
   */
  public function show(ICD10 $iCD10)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(ICD10 $iCD10)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, ICD10 $iCD10)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(ICD10 $iCD10)
  {
    //
  }
}
