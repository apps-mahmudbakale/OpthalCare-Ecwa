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
    Schema::create('refraction_card_auto_refraction', function (Blueprint $table) {
      $table->id();
      $table->string('auto_refraction_right')->nullable();
      $table->string('auto_refraction_left')->nullable();
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
    Schema::dropIfExists('refraction_card_auto_refraction');
  }
};
