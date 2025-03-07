<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisionAcuity extends Model
{
  use HasFactory;

  protected $fillable = [
    'patient_id',
    'right',
    'left',
    'left_pinhole',
    'right_pinhole',
    'left_glasses',
    'right_glasses',
    'disablities',
  ];

  public function patient()
  {
    return $this->belongsTo(Patient::class);
  }
}
