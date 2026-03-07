<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HmoGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'address'
    ];

    public function wallet()
    {
        return $this->hasOne(HmoWallet::class);
    }

    public function getWallet()
    {
        return $this->wallet ?: $this->wallet()->create(['balance' => 0]);
    }
}
