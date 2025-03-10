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
    Schema::create('refraction_card_diagnosis', function (Blueprint $table) {
      $table->id();
      $table->integer('patient_id')->nullable();
      $table->longText('diagnosis')->nullable();
      $table->longText('additional_info')->nullable();

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('refraction_card_diagnosis');
  }
};
