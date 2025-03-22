<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'price',
    'quantity',
    'category_id',
    'threshold',
    'is_active',
    'store_id',
    'expiry_date'
  ];

  public function category()
  {
    return $this->belongsTo(DrugCategory::class, 'category_id',);
  }

  public static function getServiceType()
  {
    return 'drug';
  }
}
