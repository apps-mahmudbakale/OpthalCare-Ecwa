<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
  use HasFactory;

  protected $fillable = [
    'patient_id',
    'check_in_date'
  ];
}
