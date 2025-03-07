<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SystemSettings extends Settings
{

  public string $clinic_name;
  public string $address;
  public string $logo;
  public string $check_in;
  public string $auto_bill;
  public string $number_prefix;
  public string $insurance_providers;
  public string $favicon;
  public string $footer;

  public static function group(): string
  {
    return 'system';
  }
}
