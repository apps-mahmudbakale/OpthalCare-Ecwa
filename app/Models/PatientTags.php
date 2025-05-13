<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientTags extends Model
{
    use HasFactory;

    protected $fillable = [
      'patient_id',
      'tag_id'
    ];


    public function patient(){
      return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function tag(){
      return $this->belongsTo(Tag::class, 'tag_id');
    }
}
