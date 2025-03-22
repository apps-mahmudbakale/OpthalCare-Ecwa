<?php

namespace App\Models;

use App\Http\Livewire\Drugs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugRequest extends Model
{
  use HasFactory;

  // protected $table = 'drugs_requests';

  protected $fillable = [
    'patient_id',
    'user_id',
    'drug_id',
    'dose',
    'collected_by',
    'status'
  ];

  public function drug()
  {
    return $this->belongsTo(Drug::class);
  }
  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function patient()
  {
    return $this->belongsTo(Patient::class);
  }
}
