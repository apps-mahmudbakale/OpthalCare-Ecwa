<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\TempPatient;
use Illuminate\Http\Request;

class PatientBillController extends Controller
{
  public function index(Request $request)
  {
    // Fetch patients with their user relationship to get the name
    $patients = Patient::with(['user:id,firstname,lastname']) // Eager load user details
    ->get()
      ->map(function($patient) {
        return [
          'id' => $patient->id,
          'full_name' => $patient->user->firstname . ' ' . $patient->user->lastname,
          'hospital_no' => $patient->hospital_no
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
