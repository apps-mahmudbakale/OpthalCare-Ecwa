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
    Schema::create('drug_requests', function (Blueprint $table) {
      $table->id();
      $table->integer('patient_id');
      $table->integer('drug_id');
      $table->integer('user_id');
      $table->string('dose')->nullable();
      $table->string('collected_by')->nullable();
      $table->string('status');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    //
  }
};
