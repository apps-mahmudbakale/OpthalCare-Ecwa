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
    Schema::create('refraction_card_retinoscopy_findings', function (Blueprint $table) {
      $table->id();
      $table->integer('patient_id')->nullable();
      $table->string('sph_right')->nullable();
      $table->string('sph_left')->nullable();
      $table->string('cyl_right')->nullable();
      $table->string('cyl_left')->nullable();
      $table->string('axis_right')->nullable();
      $table->string('axis_left')->nullable();
      $table->string('prism_right')->nullable();
      $table->string('prism_left')->nullable();
      $table->string('base_right')->nullable();
      $table->string('base_left')->nullable();
      $table->string('va_right')->nullable();
      $table->string('va_left')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('refraction_card_retinoscopy_findings');
  }
};
