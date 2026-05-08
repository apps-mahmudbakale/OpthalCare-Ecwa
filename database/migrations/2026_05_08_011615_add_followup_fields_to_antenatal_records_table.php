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
        Schema::table('antenatal_records', function (Blueprint $table) {
            // Follow-up specific fields
            $table->string('visit_type')->default('new')->after('visit_date'); // 'new' or 'followup'
            $table->string('height_of_fundus')->nullable()->after('visit_type');
            $table->string('presentation_and_position')->nullable()->after('height_of_fundus');
            $table->string('fetal_heart')->nullable()->after('presentation_and_position');
            $table->string('urine')->nullable()->after('fetal_heart');
            $table->string('blood_pressure')->nullable()->after('urine');
            $table->decimal('weight', 5, 2)->nullable()->after('blood_pressure');
            $table->string('edema')->nullable()->after('weight');
            $table->longText('followup_complaint')->nullable()->after('edema');
            $table->longText('followup_treatment')->nullable()->after('followup_complaint');
            $table->longText('followup_notes')->nullable()->after('followup_treatment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antenatal_records', function (Blueprint $table) {
            $table->dropColumn([
                'visit_type',
                'height_of_fundus',
                'presentation_and_position',
                'fetal_heart',
                'urine',
                'blood_pressure',
                'weight',
                'edema',
                'followup_complaint',
                'followup_treatment',
                'followup_notes'
            ]);
        });
    }
};
