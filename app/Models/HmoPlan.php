<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HmoPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'hmo_id',
        'enrollment_amount',
        'signup_amount',
        'is_insurance',
        'max_no',
        'logo'
        
    ];


    public function hmo(){
        return $this->belongsTo(HmoGroup::class);
    }
}
