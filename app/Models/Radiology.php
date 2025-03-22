<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Radiology extends Model
{
  protected $fillable = [
    'name',
    'price',
    'category_id',
    'template_id'
  ];
    use HasFactory;

  public function category(): BelongsTo
  {
    return $this->belongsTo(RadiologyCategory::class, 'category_id',);
  }
  public function template(): HasOne
  {
    return $this->hasOne(RadiologyTemplate::class, 'template_id');
  }
  public static function getServiceType()
  {
    return 'radiology';
  }
}
