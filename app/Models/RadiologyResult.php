<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadiologyResult extends Model
{
    use HasFactory;

  protected $fillable = [
    'imaging_id',
    'patient_id',
    'result'
  ];
}
