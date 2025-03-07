<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IOP extends Model
{
  use HasFactory;

  protected $fillable = [
    'patient_id',
    'right',
    'left',
  ];

  public function patient()
  {
    return $this->belongsTo(Patient::class);
  }
}
