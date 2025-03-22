<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
      'billing_id',
      'cashpoint_id',
      'payment_method',
      'paying_amount'
    ];
}
