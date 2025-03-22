<?php

namespace App\Models;

use App\Http\Livewire\Laboratories;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabRequest extends Model
{
  use HasFactory;

  protected $fillable = [
    'patient_id',
    'user_id',
    'test_id',
    'request_note',
    'priority',
    'status'
  ];

  public function test()
  {
    return $this->belongsTo(Laboratory::class, 'test_id');
  }

  public function patient()
  {
    return $this->belongsTo(Patient::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
  public function user_details()
  {
    return $this->patient->user();
  }
}
