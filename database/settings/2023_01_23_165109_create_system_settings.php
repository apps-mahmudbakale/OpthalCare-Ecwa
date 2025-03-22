<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateSystemSettings extends SettingsMigration
{
  public function up(): void
  {
    $this->migrator->add('system.clinic_name', 'Spatie');
    $this->migrator->add('system.address', 'Address');
    $this->migrator->add('system.logo', 'logo');
    $this->migrator->add('system.check_in', true);
    $this->migrator->add('system.auto_bill', true);
    $this->migrator->add('system.number_prefix', 'VTC');
    $this->migrator->add('system.insurance_providers', true);
    $this->migrator->add('system.favicon', 'favicon');
    $this->migrator->add('system.footer', 'footer');
  }
}
