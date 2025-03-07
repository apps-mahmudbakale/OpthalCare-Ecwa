<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refraction extends Model
{
    use HasFactory;

  protected $fillable = [
    'patient_id',
    'itching_right',
    'itching_left',
    'photophobia_right',
    'photophobia_left',
    'watering_right',
    'watering_left',
    'redness_right',
    'redness_left',
    'visual_acuity_right',
    'visual_acuity_left',
    'refraction_sph_right',
    'refraction_sph_left',
    'refraction_cyl_right',
    'refraction_cyl_left',
    'refraction_axis_right',
    'refraction_axis_left',
    'addition_right',
    'addition_left',
    'pupillary_distance',
    'notes',
  ];
}
