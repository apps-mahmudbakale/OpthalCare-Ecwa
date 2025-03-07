<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Allergy extends Model
{
    use HasFactory;

    protected $appends = ['type_text'];

  protected $fillable = [
    'type',
    'allergen',
    'reaction_to_allergen',
    'patient_id'
  ];

  public function patient(): BelongsTo
  {
    return $this->belongsTo(Patient::class);
  }

  public function getTypeTextAttribute(): string {

    $types_array = [
      1 => "Drugs",
      2 => "Food",
      3 => "Latex",
      4 => "Environmental Irritant",
      5 => "Mold",
      6 => "Other"
    ];

    return $types_array[$this->type];

  }
}
