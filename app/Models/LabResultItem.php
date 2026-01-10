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

  /**
   * Automatically determine if the result is Low, High, or Normal based on reference range.
   */
  public function getRemarkAttribute()
  {
      if (!is_numeric($this->value)) return '---';

      $val = floatval($this->value);
      $reference = $this->templateItem->reference ?? '';
      if (!$reference) return '---';

      $matches = [];
      $low = null;
      $high = null;

      // 1. Handle gender-based splits: "Males: 12 – 64,Females: 5 - 38 U/L"
      if (preg_match('/males:/i', $reference) && preg_match('/females:/i', $reference)) {
          $gender = strtolower($this->result->patient->gender ?? 'male');
          if (str_contains($gender, 'female')) {
              preg_match('/females:\s*([\d\.]+)\s*[\-\–]\s*([\d\.]+)/i', $reference, $matches);
          } else {
              preg_match('/males:\s*([\d\.]+)\s*[\-\–]\s*([\d\.]+)/i', $reference, $matches);
          }
      } 
      // 2. Handle simple range: "35 - 52 g/l" or "0.2 - 1.2"
      else {
          preg_match('/([\d\.]+)\s*[\-\–]\s*([\d\.]+)/', $reference, $matches);
      }

      if (count($matches) >= 3) {
          $low = floatval($matches[1]);
          $high = floatval($matches[2]);

          if ($val < $low) return 'Low';
          if ($val > $high) return 'High';
          return 'Normal';
      }

      // 3. Handle single bounds: "<300"
      if (str_contains($reference, '<')) {
          preg_match('/<\s*([\d\.]+)/', $reference, $matches);
          if (isset($matches[1])) {
              return ($val < floatval($matches[1])) ? 'Normal' : 'High';
          }
      }
      if (str_contains($reference, '>')) {
          preg_match('/>\s*([\d\.]+)/', $reference, $matches);
          if (isset($matches[1])) {
              return ($val > floatval($matches[1])) ? 'Normal' : 'Low';
          }
      }

      return '---';
  }
}
