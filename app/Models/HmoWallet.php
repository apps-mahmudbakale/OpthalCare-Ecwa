<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HmoWallet extends Model
{
    use HasFactory;

    protected $fillable = ['hmo_group_id', 'balance'];

    public function hmoGroup()
    {
        return $this->belongsTo(HmoGroup::class);
    }

    public function transactions()
    {
        return $this->hasMany(HmoWalletTransaction::class);
    }

    public function credit($amount, $description, $reference = null)
    {
        $this->increment('balance', $amount);
        return $this->transactions()->create([
            'amount' => $amount,
            'type' => 'credit',
            'description' => $description,
            'reference' => $reference,
        ]);
    }

    public function debit($amount, $description, $reference = null)
    {
        if ($this->balance < $amount) {
            throw new \Exception('Insufficient HMO wallet balance.');
        }
        $this->decrement('balance', $amount);
        return $this->transactions()->create([
            'amount' => $amount,
            'type' => 'debit',
            'description' => $description,
            'reference' => $reference,
        ]);
    }
}
