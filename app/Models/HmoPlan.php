<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HmoPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'hmo_id',
        'name',
        'enrollment_amount',
        'signup_amount',
        'is_insurance',
        'max_no',
        'logo'
        
    ];


    public function hmo(){
        return $this->belongsTo(HmoGroup::class);
    }

    public function services()
    {
        return $this->hasMany(HmoService::class, 'plan_id');
    }

    public function patients()
    {
        return $this->hasMany(Patient::class, 'hmo_plan_id');
    }

    public function billings()
    {
        return $this->hasMany(Billing::class, 'plan_id');
    }
}
