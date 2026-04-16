<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AntenatalPackageUsage extends Model
{
    protected $table = 'antenatal_package_usage';

    protected $fillable = [
        'patient_id',
        'antenatal_record_id',
        'package_id',
        'service_type',
        'service_id',
        'billing_id',
    ];

    public function patient()    { return $this->belongsTo(Patient::class); }
    public function package()    { return $this->belongsTo(AntenatalPackage::class, 'package_id'); }
    public function billing()    { return $this->belongsTo(Billing::class); }
}
