<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Refraction;
use Illuminate\Http\Request;
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

  public function show($patient){
    $refraction = Refraction::find($patient);
    $patient = Patient::find($refraction->patient_id);
    $caseHistoryData = DB::table('refraction_card_case_history')
      ->where('patient_id', $patient->id)
      ->get()
      ->toArray(); // Convert to an array for merging

    $externalExaminationData = DB::table('refraction_card_external_examination')
      ->where('patient_id', $patient->id)
      ->get()
      ->toArray(); // Convert to an array for merging



    $data = array_merge($caseHistoryData, $externalExaminationData); // Merge the arrays
    return view('refraction.show', compact('refraction', 'patient', 'data'));
  }

  public function store(Request $request){
//dd($request->all());
    $case_history_data = $request->only([
      'patient_id',
      'itching_right',
      'itching_left',
      'photophobia_right',
      'photophobia_left',
      'pain_right',
      'pain_left',
      'blur_vision_far_right',
      'blur_vision_far_left',
      'blur_vision_near_right',
      'blur_vision_near_left',
      'diplopia_right',
      'diplopia_left',
      'burning_sensation_right',
      'burning_sensation_left',
      'tearing_right',
      'tearing_left',
      'discharge_right',
      'discharge_left',
      'occipital_headache',
      'frontal_headache',
      'temporal_headache',
      'hypertensive',
      'diabetic'
    ]);
    $external_examination_data = $request->only([
      'patient_id',
      'adnexa_right',
      'adnexa_left',
      'conjuctiva_right',
      'conjuctiva_left',
      'sclera_right',
      'sclera_left',
      'pupil_right',
      'pupil_left',
      'palpebra_right',
      'palpebra_left',
      'cornea_right',
      'cornea_left',
    ]);
    $refraction = Refraction::create($request->all());
    $case_history = DB::table('refraction_card_case_history')->insert(array_merge($case_history_data, ['created_at' => now(), 'updated_at' => now()]));
    $external_examination = DB::table('refraction_card_external_examination')->insert(array_merge($external_examination_data, ['created_at' => now(), 'updated_at' => now()]));

    return redirect()->route('app.patients.show', $request->patient_id)->with('success', 'Refraction record saved successfully.');
  }
}
