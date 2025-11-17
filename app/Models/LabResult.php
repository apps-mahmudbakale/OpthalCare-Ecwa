<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabResult extends Model
{
  use HasFactory;
  protected $fillable = ['lab_test_id', 'lab_template_id', 'patient_id', 'pathologist_comments', 'image'];

  public function labTest()
  {
    return $this->belongsTo(Laboratory::class, 'lab_test_id'); // assuming Laboratory model
  }

  public function template()
  {
    return $this->belongsTo(LabTemplate::class, 'lab_template_id');
  }

  public function patient()
  {
    return $this->belongsTo(Patient::class);
  }

  public function items()
  {
    return $this->hasMany(LabResultItem::class);
  }
}
