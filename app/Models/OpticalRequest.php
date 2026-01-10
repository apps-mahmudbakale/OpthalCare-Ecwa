<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpticalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
      'patient_id',
      'service_id',
      'lens',
      'ref',
      'user_id',
      'comments',
      'status'
    ];


    public  function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function service()
    {
        return $this->belongsTo(Antenatal::class, 'service_id');
    }
}
