<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabResult extends Model
{
  use HasFactory;
  protected $fillable = ['lab_request_id', 'lab_test_id', 'lab_template_id', 'patient_id', 'user_id', 'pathologist_comments', 'image'];

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

  public function request()
  {
      return $this->belongsTo(LabRequest::class, 'lab_request_id');
  }

  public function user()
  {
      return $this->belongsTo(User::class);
  }

  public function items()
  {
    return $this->hasMany(LabResultItem::class);
  }
}
