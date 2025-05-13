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
      Schema::table('admissions', function (Blueprint $table) {
        $table->integer('patient_id')->after('id');
        $table->integer('ward_id')->after('patient_id');
        $table->integer('bed_id')->after('ward_id');
        $table->string('status')->after('bed_id');
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
