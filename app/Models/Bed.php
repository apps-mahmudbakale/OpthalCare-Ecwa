<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'ward_id',
    'price',
    'available'
  ];

  public function ward()
  {
    return $this->belongsTo(Ward::class);
  }
}
