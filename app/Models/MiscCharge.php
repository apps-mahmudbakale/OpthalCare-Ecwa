<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiscCharge extends Model
{
    use HasFactory;

    protected $fillable = [
        'billing_id',
        'description',
        'unit_price',
        'quantity',
        'amount',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
        'amount' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function billing()
    {
        return $this->belongsTo(Billing::class);
    }
}
