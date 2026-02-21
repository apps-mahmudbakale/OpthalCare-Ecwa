<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('diagnoses', function (Blueprint $table) {
            $table->string('specialty')->default('General Out-Patient')->change();
        });

        // Update existing records
        \Illuminate\Support\Facades\DB::table('diagnoses')
            ->where('specialty', 'Ophthalmology')
            ->update(['specialty' => 'General Out-Patient']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diagnoses', function (Blueprint $table) {
            $table->string('specialty')->default('Ophthalmology')->change();
        });
    }
};
