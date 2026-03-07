<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HmoWalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['hmo_wallet_id', 'amount', 'type', 'description', 'reference'];

    public function wallet()
    {
        return $this->belongsTo(HmoWallet::class, 'hmo_wallet_id');
    }
}
