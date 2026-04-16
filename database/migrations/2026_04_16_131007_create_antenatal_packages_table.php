<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('antenatal_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->timestamps();
        });

        // Update the FK on antenatal_records to point to the new table
        Schema::table('antenatal_records', function (Blueprint $table) {
            $table->dropForeign(['enrolment_package_id']);
            $table->foreign('enrolment_package_id')
                  ->references('id')->on('antenatal_packages')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('antenatal_records', function (Blueprint $table) {
            $table->dropForeign(['enrolment_package_id']);
        });
        Schema::dropIfExists('antenatal_packages');
    }
};
