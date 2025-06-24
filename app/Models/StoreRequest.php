<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreRequest extends Model
{
    use HasFactory;

    protected $fillable = [
      'store_id',
      'user_id',
      'drug_id',
      'qty',
      'status',
      'approved_by'
    ];
}
