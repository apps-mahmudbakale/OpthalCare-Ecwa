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
        'visit_type',
        'gravida',
        'parity',
        'last_menstrual_period',
        'current_pregnancy',
        'alive',
        'miscarriage',
        'enrolment_package_id',
        // Follow-up fields
        'height_of_fundus',
        'presentation_and_position',
        'fetal_heart',
        'urine',
        'blood_pressure',
        'weight',
        'edema',
        'followup_complaint',
        'followup_treatment',
        'followup_notes',
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

    /**
     * Check if the patient has any new antenatal visits
     */
    public static function patientHasNewVisit($patientId)
    {
        return self::where('patient_id', $patientId)
            ->where('visit_type', 'new')
            ->exists();
    }

    /**
     * Get the latest antenatal record for a patient
     */
    public static function getLatestForPatient($patientId)
    {
        return self::where('patient_id', $patientId)
            ->orderBy('visit_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * Get follow-up records for a patient
     */
    public static function getFollowupsForPatient($patientId)
    {
        return self::where('patient_id', $patientId)
            ->where('visit_type', 'followup')
            ->orderBy('visit_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
