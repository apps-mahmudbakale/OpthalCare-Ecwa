<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\TempPatient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
  public function index(Request $request)
{
  // Fetch patients with their user relationship to get the name
  $patients = Patient::with(['user:id,firstname,lastname']) // Eager load user details
  ->get()
    ->map(function($patient) {
      return [
        'id' => $patient->id,
        'full_name' => $patient->user->firstname . ' ' . $patient->user->lastname
      ];
    });

  return response()->json($patients);
}

public function store(Request $request)
{
  $temp = TempPatient::create($request->all());

  return $temp;
}

}
