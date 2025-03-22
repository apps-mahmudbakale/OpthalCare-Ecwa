<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
  use HasFactory;

  protected $fillable = [
    'patient_id',
    'comments',
    'sketch',
    'icd_id',
    'user_id',
    'status',
    'history',
    'uncorrected_right',
    'uncorrected_left',
    'pinhole_right',
    'pinhole_left',
    'va_glass_right',
    'va_glass_left',
    'near_vision_right',
    'near_vision_far_left',
    'lid_right',
    'lid_left',
    'globe_right',
    'globe_left',
    'eomm_right',
    'eomm_left',
    'conjuctiva_right',
    'conjuctiva_left',
    'cornea_right',
    'cornea_left',
    'anterior_cha_right',
    'anterior_cha_left',
    'iris_right',
    'iris_left',
    'pupil_right',
    'pupil_left',
    'lens_right',
    'lens_left',
    'iop_right',
    'iop_left',
    'vitreous_right',
    'vitreous_left',
    'disability',
    'assessment',
    'treatment'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function patient()
  {
    return $this->belongsTo(Patient::class, 'patient_id');
  }

  public function ICD()
  {
    return $this->belongsTo(ICD10::class, 'icd_id');
  }
}
