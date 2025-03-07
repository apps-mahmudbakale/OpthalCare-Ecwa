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
    Schema::create('refraction_card_case_history', function (Blueprint $table) {
      $table->id();
      $table->integer('patient_id')->nullable();
      $table->string('itching_right')->nullable();
      $table->string('itching_left')->nullable();
      $table->string('photophobia_right')->nullable();
      $table->string('photophobia_left')->nullable();
      $table->string('pain_right')->nullable();
      $table->string('pain_left')->nullable();
      $table->string('blur_vision_far_right')->nullable();
      $table->string('blur_vision_far_left')->nullable();
      $table->string('blur_vision_near_right')->nullable();
      $table->string('blur_vision_near_left')->nullable();
      $table->string('diplopia_right')->nullable();
      $table->string('diplopia_left')->nullable();
      $table->string('burning_sensation_right')->nullable();
      $table->string('burning_sensation_left')->nullable();
      $table->string('tearing_right')->nullable();
      $table->string('tearing_left')->nullable();
      $table->string('discharge_right')->nullable();
      $table->string('discharge_left')->nullable();
      $table->string('occipital_headache')->nullable();
      $table->string('frontal_headache')->nullable();
      $table->string('temporal_headache')->nullable();
      $table->string('hypertensive')->nullable();
      $table->string('diabetic')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('refraction_card_case_history');
  }
};
