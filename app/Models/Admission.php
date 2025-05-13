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
}
