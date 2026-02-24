<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HmoService extends Model
{
    use HasFactory;
    protected $fillable = ['plan_id', 'type', 'service_id', 'price'];

    public function getServiceItemAttribute()
    {
        if (!$this->type || !$this->service_id) {
            return null;
        }

        switch (strtolower($this->type)) {
            case 'pharmacy':
                return \App\Models\Drug::find($this->service_id);
            case 'laboratory':
                return \App\Models\Laboratory::find($this->service_id);
            case 'procedures':
            case 'procedure':
                return \App\Models\Procedure::find($this->service_id);
            case 'radiology':
                return \App\Models\Radiology::find($this->service_id);
            case 'admissions':
            case 'admission':
                return \App\Models\Bed::find($this->service_id);
            case 'consultations':
            case 'consultation':
                return \App\Models\Speciality::find($this->service_id);
            case 'ophthicals':
            case 'antenatal':
                return \App\Models\Antenatal::find($this->service_id);
            default:
                return null;
        }
    }

    public function getServiceNameAttribute()
    {
        $item = $this->service_item;
        return $item ? $item->name : 'Unknown Service';
    }

    public function getServiceBasePriceAttribute()
    {
        $item = $this->service_item;
        return $item ? $item->price : 0;
    }

    public function plan()
    {
        return $this->belongsTo(HmoPlan::class, 'plan_id');
    }
}
