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
    Schema::create('next_of_kin', function (Blueprint $table) {
      $table->id();
      $table->integer('patient_id')->nullable();
      $table->string('next_of_kin_name')->nullable();
      $table->string('next_of_kin_relation')->nullable();
      $table->string('next_of_kin_phone')->nullable();
      $table->longText('next_of_kin_address')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('next_of_kin');
  }
};
