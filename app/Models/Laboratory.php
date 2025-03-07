<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'price',
    'category_id',
    'template_id'
  ];

  public function category()
  {
    return $this->belongsTo(LabCategory::class, 'category_id',);
  }
  public function template()
  {
    return $this->hasOne(LabTemplate::class, 'template_id');
  }

  public static function getServiceType()
  {
    return 'laboratory';
  }
}
