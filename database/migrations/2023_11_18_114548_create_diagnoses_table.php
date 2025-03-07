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
      $table->integer('icd_id');
      $table->longText('comments');
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
