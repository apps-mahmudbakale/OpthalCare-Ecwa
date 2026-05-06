<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'antenatal_record_id',
        'user_id',
        'delivery_date',
        'delivery_type',
        'presentation',
        'gestation_weeks',
        'gestation_days',
        'labor_onset',
        'labor_duration_hours',
        'labor_duration_minutes',
        'labor_complications',
        'baby_gender',
        'birth_weight',
        'birth_length',
        'head_circumference',
        'apgar_1_min',
        'apgar_5_min',
        'baby_condition',
        'baby_complications',
        'placenta_delivery',
        'placenta_weight',
        'placenta_condition',
        'maternal_condition',
        'blood_loss',
        'perineal_condition',
        'complications',
        'immediate_care',
        'medications_given',
        'feeding_plan',
        'delivery_notes',
        'recommendations',
    ];

    protected $casts = [
        'delivery_date' => 'datetime',
        'labor_onset' => 'datetime',
        'birth_weight' => 'decimal:2',
        'placenta_weight' => 'decimal:2',
        'blood_loss' => 'decimal:2',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function antenatalRecord()
    {
        return $this->belongsTo(AntenatalRecord::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getGestationAttribute()
    {
        if ($this->gestation_weeks || $this->gestation_days) {
            $weeks = $this->gestation_weeks ?? 0;
            $days = $this->gestation_days ?? 0;
            return "{$weeks}w {$days}d";
        }
        return null;
    }

    public function getLaborDurationAttribute()
    {
        if ($this->labor_duration_hours || $this->labor_duration_minutes) {
            $hours = $this->labor_duration_hours ?? 0;
            $minutes = $this->labor_duration_minutes ?? 0;
            return "{$hours}h {$minutes}m";
        }
        return null;
    }
}
