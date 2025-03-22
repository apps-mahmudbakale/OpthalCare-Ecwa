<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'procedure_cost',
    'theatre_cost',
    'anaesthesia_cost',
    'surgeon_fee',
    'category_id',
    'in_theather'
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
