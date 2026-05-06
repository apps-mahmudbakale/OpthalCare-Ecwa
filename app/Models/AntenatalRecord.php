<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntenatalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'user_id',
        'complaint',
        'treatment_plan',
        'note',
        'visit_date',
        'gravida',
        'parity',
        'last_menstrual_period',
        'current_pregnancy',
        'alive',
        'miscarriage',
        'enrolment_package_id',
    ];

    protected $casts = [
        'visit_date'            => 'date',
        'last_menstrual_period' => 'date',
    ];

    public function enrolmentPackage()
    {
        return $this->belongsTo(\App\Models\AntenatalPackage::class, 'enrolment_package_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }
}
