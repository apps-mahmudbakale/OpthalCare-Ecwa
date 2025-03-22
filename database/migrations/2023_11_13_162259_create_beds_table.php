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
    Schema::create('beds', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->foreignId('ward_id')->references('id')->on('wards')->onDelete('cascade');
      $table->boolean('available')->default(true);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('beds');
  }
};
