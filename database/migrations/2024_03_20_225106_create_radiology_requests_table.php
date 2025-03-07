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
    Schema::create('radiology_requests', function (Blueprint $table) {
      $table->id();
      $table->integer('patient_id');
      $table->integer('imaging_id');
      $table->integer('user_id');
      $table->string('request_note')->nullable();
      $table->string('priority')->nullable();
      $table->string('status');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('radiology_requests');
  }
};
