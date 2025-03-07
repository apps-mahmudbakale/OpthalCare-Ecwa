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
    Schema::create('vision_acuities', function (Blueprint $table) {
      $table->id();
      $table->integer('patient_id');
      $table->string('right')->nullable();
      $table->string('left')->nullable();
      $table->string('right_pinhole')->nullable();
      $table->string('left_pinhole')->nullable();
      $table->string('right_glasses')->nullable();
      $table->string('left_glasses')->nullable();
      $table->string('disablities')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('vision_acuities');
  }
};
