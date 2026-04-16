<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('antenatal_records', function (Blueprint $table) {
            $table->unsignedTinyInteger('gravida')->nullable()->after('visit_date');
            $table->unsignedTinyInteger('parity')->nullable()->after('gravida');
            $table->date('last_menstrual_period')->nullable()->after('parity');
            $table->string('current_pregnancy')->nullable()->after('last_menstrual_period');
            $table->unsignedTinyInteger('alive')->nullable()->after('current_pregnancy');
            $table->unsignedTinyInteger('miscarriage')->nullable()->after('alive');
            $table->unsignedBigInteger('enrolment_package_id')->nullable()->after('miscarriage');

            $table->foreign('enrolment_package_id')->references('id')->on('antenatals')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('antenatal_records', function (Blueprint $table) {
            $table->dropForeign(['enrolment_package_id']);
            $table->dropColumn([
                'gravida', 'parity', 'last_menstrual_period',
                'current_pregnancy', 'alive', 'miscarriage', 'enrolment_package_id',
            ]);
        });
    }
};
