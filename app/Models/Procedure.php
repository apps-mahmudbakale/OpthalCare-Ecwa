<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'price_cost',
    'category_id',
  ];

  public function category()
  {
    return $this->belongsTo(ProcedureCategory::class, 'category_id',);
  }

  public static function getServiceType()
  {
    return 'procedure';
  }
}
