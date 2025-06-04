<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admission extends Model
{
  use HasFactory;

  protected $fillable = [
    'patient_id',
    'ward_id',
    'bed_id',
    'status'
  ];

  public static function getServiceType()
  {
    return 'admission';
  }

  public function patient()
  {
    return $this->belongsTo(Patient::class, 'patient_id');
  }

  public function ward()
  {
    return $this->belongsTo(Ward::class, 'ward_id');
  }

  public function bed()
  {
    return $this->belongsTo(Bed::class, 'bed_id');
  }
}
