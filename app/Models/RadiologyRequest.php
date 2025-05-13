<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadiologyRequest extends Model
{
  use HasFactory;

  protected $fillable = [
    'patient_id',
    'user_id',
    'imaging_id',
    'request_note',
    'request_ref',
    'priority',
    'status'
  ];

  public function test()
  {
    return $this->belongsTo(Radiology::class, 'imaging_id');
  }

  public function patient()
  {
    return $this->belongsTo(Patient::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function findings(){
    return $this->hasOne(RadiologyResult::class, 'imaging_id');
  }
}
