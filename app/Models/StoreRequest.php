<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

class StoreRequest extends Model
{
    use HasFactory;

    protected $fillable = [
      'store_id',
      'user_id',
      'drug_id',
      'qty',
      'status',
      'ref',
      'approved_by'
    ];


    public function user(){
      return $this->belongsTo(User::class);
    }

    public function store(){
      return $this->belongsTo(DrugStore::class, 'store_id');
    }

    public function drug(){
      return $this->belongsTo(Drug::class);
    }
    public function category(){
      return $this->belongsTo(DrugCategory::class);
    }
}
