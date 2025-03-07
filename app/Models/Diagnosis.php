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
