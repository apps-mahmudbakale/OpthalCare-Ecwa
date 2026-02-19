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
            $table->string('specialty')->default('Ophthalmology')->after('user_id');
            $table->date('lmp')->nullable();
            $table->date('edd')->nullable();
            $table->string('ga')->nullable();
            $table->integer('gravidity')->nullable();
            $table->integer('parity')->nullable();
            $table->string('last_delivery_date')->nullable();
            $table->text('menstrual_history')->nullable();
            $table->text('pelvic_examination')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diagnoses', function (Blueprint $table) {
            $table->dropColumn([
                'specialty',
                'lmp',
                'edd',
                'ga',
                'gravidity',
                'parity',
                'last_delivery_date',
                'menstrual_history',
                'pelvic_examination'
            ]);
        });
    }
};
