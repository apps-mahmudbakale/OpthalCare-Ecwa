<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consumable extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'quantity',
        'category_id',
        'threshold',
        'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(ConsumableCategory::class, 'category_id',);
    }
}
