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
    Schema::create('refraction_card_vision_acuity', function (Blueprint $table) {
      $table->id();
      $table->integer('patient_id')->nullable();
      $table->string('distance_right')->nullable();
      $table->string('distance_left')->nullable();
      $table->string('ph_right')->nullable();
      $table->string('ph_left')->nullable();
      $table->string('near_right')->nullable();
      $table->string('near_left')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('refraction_card_vision_acuity');
  }
};
