<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressNote extends Model
{
    use HasFactory;
    protected $fillable = ['admission_id', 'procedure_request_id', 'patient_id', 'user_id', 'note'];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function procedureRequest()
    {
        return $this->belongsTo(ProcedureRequest::class, 'procedure_request_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
