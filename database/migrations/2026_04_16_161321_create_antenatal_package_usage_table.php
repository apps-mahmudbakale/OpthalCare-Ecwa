<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('antenatal_package_usage', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('antenatal_record_id'); // the enrollment record
            $table->unsignedBigInteger('package_id');
            $table->string('service_type');   // laboratory, imaging, procedure, pharmacy, consultation
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('billing_id')->nullable(); // linked bill
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->foreign('package_id')->references('id')->on('antenatal_packages')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('antenatal_package_usage');
    }
};
