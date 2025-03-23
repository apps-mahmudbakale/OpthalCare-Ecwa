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
    Schema::create('diagnoses', function (Blueprint $table) {
      $table->id();
      $table->integer('patient_id');
      $table->text('history');
      $table->string('uncorrected_right')->nullable();
      $table->string('uncorrected_left')->nullable();
      $table->string('pinhole_right')->nullable();
      $table->string('pinhole_left')->nullable();
      $table->string('va_glass_right')->nullable();
      $table->string('va_glass_left')->nullable();
      $table->string('near_vision_right')->nullable();
      $table->string('near_vision_far_left')->nullable();
      $table->string('lid_right')->nullable();
      $table->string('lid_left')->nullable();
      $table->string('globe_right')->nullable();
      $table->string('globe_left')->nullable();
      $table->string('eomm_right')->nullable();
      $table->string('eomm_left')->nullable();
      $table->string('conjuctiva_right')->nullable();
      $table->string('conjuctiva_left')->nullable();
      $table->string('cornea_right')->nullable();
      $table->string('cornea_left')->nullable();
      $table->string('anterior_cha_right')->nullable();
      $table->string('anterior_cha_left')->nullable();
      $table->string('iris_right')->nullable();
      $table->string('iris_left')->nullable();
      $table->string('pupil_right')->nullable();
      $table->string('pupil_left')->nullable();
      $table->string('lens_right')->nullable();
      $table->string('lens_left')->nullable();
      $table->string('iop_right')->nullable();
      $table->string('iop_left')->nullable();
      $table->string('vitreous_right')->nullable();
      $table->string('vitreous_left')->nullable();
      $table->enum('disability', ['Visual', 'Hearing', 'Physical', 'Intellectual', 'Mental', 'Multiple', 'None']);
      $table->text('assessment')->nullable();
      $table->text('treatment')->nullable();
      $table->integer('icd_id');
      $table->longText('comments')->nullable();
      $table->longText('sketch')->nullable();
      $table->string('status');
      $table->integer('user_id');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('diagnoses');
  }
};
