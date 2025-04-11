<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashPoint extends Model
{
    use HasFactory;

    protected $fillable = [
      'name',
      'location'
    ];

  public function payments()
  {
    return $this->hasMany(Payment::class);
  }
}
