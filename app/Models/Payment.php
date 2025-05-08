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
      'paying_amount',
      'user_id'
    ];

    public function user()

    {
      return $this->belongsTo(User::class);
    }
  public function cashPoint()
  {
    return $this->belongsTo(CashPoint::class, 'cashpoint_id');
  }
  public function paymentMethod(){
      return $this->belongsTo(PaymentMethod::class);
  }
  public function billing(){
      return $this->belongsTo(Billing::class, 'billing_id');
  }
}

