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
        'status',
        'concluded_at',
        'concluded_by',
        'conclusion_notes',
        'gravida',
        'parity',
        'last_menstrual_period',
        'current_pregnancy',
        'alive',
        'miscarriage',
        'enrolment_package_id',
        'plan_id',
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
        'concluded_at'          => 'datetime',
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

    public function concludedBy()
    {
        return $this->belongsTo(User::class, 'concluded_by');
    }

    public function hmoPlan()
    {
        return $this->belongsTo(\App\Models\HmoPlan::class, 'plan_id');
    }

    /**
     * Check if the enrollment is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check if the enrollment is concluded
     */
    public function isConcluded()
    {
        return $this->status === 'concluded';
    }

    /**
     * Conclude the antenatal enrollment
     */
    public function conclude($notes = null, $userId = null)
    {
        $this->update([
            'status' => 'concluded',
            'concluded_at' => now(),
            'concluded_by' => $userId ?? auth()->id(),
            'conclusion_notes' => $notes,
        ]);
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
