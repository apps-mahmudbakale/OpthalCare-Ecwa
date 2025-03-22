<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProceudreRequest extends Model
{
  use HasFactory;

  protected $fillable = [
    'patient_id',
    'procedure_id',
    'ICD10',
    'status'
  ];

  public function procedure()
  {
    return $this->belongsTo(Procedure::class);
  }
}
