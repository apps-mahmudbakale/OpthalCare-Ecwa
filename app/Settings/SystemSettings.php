<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SystemSettings extends Settings
{

  public ?string $clinic_name;
  public ?string $address;
  public ?string $logo;
  public bool $check_in;
  public ?string $checkin_fee;

  public bool $auto_bill;
  public ?string $number_prefix;
  public bool $insurance_providers;
  public ?string $favicon;
  public ?string $footer;

  public static function group(): string
  {
    return 'system';
  }
}
