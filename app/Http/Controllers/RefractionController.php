<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Refraction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RefractionController extends Controller
{


  public function index()
  {
  }

  public function create($id)
  {
    $patient = Patient::where('id', $id)->first();
    return view('refraction.create', compact('patient'));
  }

  public function edit($id){
    $refraction = Refraction::where('id', $id)->first();
    $patient = Patient::where('id', $refraction->patient_id)->first();
    return view('refraction.edit', compact('refraction', 'patient'));
  }

  public function show($patient){
    $refraction = Refraction::find($patient);
    $patient = Patient::find($refraction->patient_id);
    return view('refraction.show', compact('refraction', 'patient'));
  }

  public function store(Request $request){
    $refraction = Refraction::create(array_merge($request->all(), ['user_id' => Auth::user()->id]));
    return redirect()->route('app.patients.show', $request->patient_id)->with('success', 'Refraction record saved successfully.');
  }

  public function update(Request $request, $id){
      $refraction = Refraction::find($id);
      $refraction->update($request->all());
      return redirect()->route('app.patients.show', $request->patient_id)->with('success', 'Refraction record updated successfully.');
  }

  public function destroy($id){
    $refraction = Refraction::find($id);
    if($refraction->delete()){
      return response()->json(['success' => true]);
    }

  }
}
