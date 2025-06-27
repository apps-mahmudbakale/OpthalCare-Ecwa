<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpticalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
      'patient_id',
      'service_id',
      'ref',
      'user_id',
      'status'
    ];
}
