<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientTags extends Model
{
    use HasFactory;

  protected $table = 'patient_tags';

  protected $fillable = ['patient_id', 'tag_id'];

  public function patient()
  {
    return $this->belongsTo(Patient::class);
  }

  public function tag()
  {
    return $this->belongsTo(Tag::class);
  }
}
