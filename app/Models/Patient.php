<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'hospital_no',
    'middlename',
    'phone',
    'date_of_birth',
    'gender',
    'religion_id',
    'occupation',
    'marital_status',
    'tribe',
    'state_of_residence',
    'lga_of_residence',
    'state_of_origin',
    'lga_of_origin',
    'residential_address',
    'hmo_id',
    'dependent',
    'principal_id',
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }


  public function getAge()
  {
    return Carbon::parse($this->date_of_birth)->age . " yrs";
  }

  public function religion()
  {
    return $this->belongsTo(Religion::class);
  }

  public function hmo()
  {
    return $this->hasOne(HmoGroup::class, 'id');
  }

  public function state()
  {
    return $this->belongsTo(State::class);
  }

  public function isCheckedInToday()
  {
    $today = Carbon::today();
    return $this->checkIns()->whereDate('check_in_date', $today)->exists();
  }

  public function checkIns()
  {
    return $this->hasMany(CheckIn::class);
  }
  public function wallet()
  {
    return $this->hasOne(Wallet::class);
  }

  public function depositToWallet($amount)
  {
    $this->wallet->balance += $amount;
    $this->wallet->save();
  }

  public function withdrawFromWallet($amount)
  {
    if ($this->wallet->balance < $amount) {
      throw new \Exception('Insufficient balance');
    }

    $this->wallet->balance -= $amount;
    $this->wallet->save();
  }

  public function hasSufficientBalance($amount)
  {
    return $this->wallet->balance >= $amount;
  }

  public function lastVisitMoreThanFiveDays()
  {
    $lastVisit = $this->checkIns()->latest()->first(); // Assuming you have a `visits` relationship

    if (!$lastVisit) {
      return true; // If no visits, allow check-in
    }

    return now()->diffInDays($lastVisit->created_at) > 5;
  }

}
