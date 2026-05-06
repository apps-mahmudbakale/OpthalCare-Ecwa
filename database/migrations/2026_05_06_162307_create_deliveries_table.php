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
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('antenatal_record_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Doctor/midwife who recorded
            
            // Delivery Information
            $table->dateTime('delivery_date');
            $table->enum('delivery_type', ['normal', 'cesarean', 'assisted', 'vacuum', 'forceps'])->default('normal');
            $table->enum('presentation', ['vertex', 'breech', 'transverse', 'compound'])->nullable();
            $table->integer('gestation_weeks')->nullable();
            $table->integer('gestation_days')->nullable();
            
            // Labor Information
            $table->dateTime('labor_onset')->nullable();
            $table->integer('labor_duration_hours')->nullable();
            $table->integer('labor_duration_minutes')->nullable();
            $table->text('labor_complications')->nullable();
            
            // Baby Information
            $table->enum('baby_gender', ['male', 'female'])->nullable();
            $table->decimal('birth_weight', 5, 2)->nullable(); // in kg
            $table->integer('birth_length')->nullable(); // in cm
            $table->integer('head_circumference')->nullable(); // in cm
            $table->integer('apgar_1_min')->nullable();
            $table->integer('apgar_5_min')->nullable();
            $table->text('baby_condition')->nullable();
            $table->text('baby_complications')->nullable();
            
            // Placenta Information
            $table->enum('placenta_delivery', ['complete', 'incomplete', 'retained'])->nullable();
            $table->decimal('placenta_weight', 5, 2)->nullable(); // in grams
            $table->text('placenta_condition')->nullable();
            
            // Mother's Condition
            $table->text('maternal_condition')->nullable();
            $table->decimal('blood_loss', 6, 2)->nullable(); // in ml
            $table->text('perineal_condition')->nullable();
            $table->text('complications')->nullable();
            
            // Post-delivery Care
            $table->text('immediate_care')->nullable();
            $table->text('medications_given')->nullable();
            $table->text('feeding_plan')->nullable();
            
            // General Notes
            $table->text('delivery_notes')->nullable();
            $table->text('recommendations')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
