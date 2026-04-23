<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempPatient extends Model
{
    use HasFactory;

    protected $table = 'temp_patients';
    protected $fillable = [
      'first_name',
      'last_name',
      'middle_name',
//      'email',
//      'phone',
//      'gender',
//      'date_of_birth',
      'accesscode'
    ];

    /**
     * Get the billing record for this temp patient
     */
    public function billing()
    {
        return $this->hasOne(Billing::class, 'user_id', 'id')
                    ->where('service', 'LIKE', '%Enrollment%');
    }
}
