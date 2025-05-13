<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcedureRequest extends Model
{
  use HasFactory;

  protected $fillable = [
    'patient_id',
    'procedure_id',
    'request_ref',
    'user_id',
    'status'
  ];

  public function procedure(){
    return $this->belongsTo(Procedure::class, 'procedure_id');
  }

  public function user(){
    return $this->belongsTo(User::class, 'user_id');
  }

  public function patient(){
    return $this->belongsTo(Patient::class, 'patient_id');
  }
}
