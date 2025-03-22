<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
  use HasFactory;

  protected $fillable = [
    'service',
    'service_id',
    'user_id',
    'quantity',
    'amount',
    'payer_id',
    'status',
  ];

  public function patient()
  {
    return $this->belongsTo(Patient::class, 'user_id');
  }
}
