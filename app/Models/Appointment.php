<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_type_id',
        'appointment_start_date',
        'appointment_end_date',
        'created_by',
        'appointment_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function doctor()
    {
      return $this->belongsTo(User::class, 'doctor_id');
    }
    public function appointmentType()
    {
      return $this->belongsTo(AppointmentType::class, 'appointment_type_id');
    }

    public function patient()
    {
      return $this->belongsTo(Patient::class, 'patient_id');
    }
}
