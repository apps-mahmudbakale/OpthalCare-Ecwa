<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class RadiologyResult extends Model
{
    use HasFactory, HasTrixRichText;

  protected $fillable = [
    'imaging_id',
    'patient_id',
    'result',
    'image',
    'user_id'
  ];
}
