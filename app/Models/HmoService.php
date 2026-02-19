<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HmoService extends Model
{
    use HasFactory;
    protected $fillable = ['plan_id', 'service_id', 'price'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function plan()
    {
        return $this->belongsTo(HmoPlan::class, 'plan_id');
    }
}
