<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speciality extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'price',
    'follow_up_price'
  ];

  public static function getServiceType()
  {
    return 'speciality';
  }
}
