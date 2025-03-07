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
    Schema::create('refraction_card_external_examination', function (Blueprint $table) {
      $table->id();
      $table->integer('patient_id')->nullable();
      $table->string('adnexa_right')->nullable();
      $table->string('adnexa_left')->nullable();
      $table->string('conjuctiva_right')->nullable();
      $table->string('conjuctiva_left')->nullable();
      $table->string('sclera_right')->nullable();
      $table->string('sclera_left')->nullable();
      $table->string('pupil_right')->nullable();
      $table->string('pupil_left')->nullable();
      $table->string('palpebra_right')->nullable();
      $table->string('palpebra_left')->nullable();
      $table->string('cornea_right')->nullable();
      $table->string('cornea_left')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('refraction_card_external_examination');
  }
};
