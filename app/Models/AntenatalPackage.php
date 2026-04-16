<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntenatalPackage extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'services_covered', 'expiry_date'];

    protected $casts = [
        'services_covered' => 'array',
        'expiry_date'      => 'date',
    ];

    public function records()
    {
        return $this->hasMany(AntenatalRecord::class, 'enrolment_package_id');
    }
}
