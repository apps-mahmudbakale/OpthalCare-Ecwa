<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabResultItem extends Model
{
  use HasFactory;
  protected $fillable = ['lab_result_id', 'lab_template_item_id', 'value'];

  public function templateItem()
  {
    return $this->belongsTo(LabTemplateItem::class, 'lab_template_item_id');
  }

  public function result()
  {
    return $this->belongsTo(LabResult::class, 'lab_result_id');
  }
}
