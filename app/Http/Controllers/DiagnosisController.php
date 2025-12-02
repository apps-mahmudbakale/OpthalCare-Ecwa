<?php

namespace App\Http\Controllers;

use App\Models\Diagnosis;
use Illuminate\Http\Request;

class DiagnosisController extends Controller
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

    $diagnosis = Diagnosis::create(array_merge($request->except('status'), ['status' => 'Pending', 'user_id' => auth()->user()->id]));

    return $diagnosis;
  }

  /**
   * Display the specified resource.
   */
  public function show($diagnosis)
  {
    $diagnosis = Diagnosis::findOrFail($diagnosis);
    return view('diagnosis.show', compact('diagnosis'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($diagnosis)
  {
    $diagnosis = Diagnosis::findOrFail($diagnosis);
    return view('diagnosis.edit', compact('diagnosis'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id)
  {
    $diagnosis = Diagnosis::findOrFail($id);
    $diagnosis->update($request->except('status'));
    return $diagnosis;
  }

  public function print($diagnosis)
  {
    $diagnosis = Diagnosis::findOrFail($diagnosis);
    return view('diagnosis.print', compact('diagnosis'));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    $diagnosis = Diagnosis::findOrFail($id);
    if($diagnosis->delete()){
      return response()->json(['success' => true]);
    }
  }
}
