<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->migrator->add('system.checkin_fee', '0');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings_migration', function (Blueprint $table) {
            //
        });
    }
};
