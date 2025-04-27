<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   * Makes the 'file' column in 'lab_results' table nullable.
   */
  public function up(): void
  {
    Schema::table('lab_results', function (Blueprint $table) {
      if (Schema::hasColumn('lab_results', 'file')) {
        $table->string('file')->nullable()->change();
      }
    });
  }

  /**
   * Reverse the migrations.
   * Restores the 'file' column to non-nullable.
   */
  public function down(): void
  {
    Schema::table('lab_results', function (Blueprint $table) {
      if (Schema::hasColumn('lab_results', 'file')) {
        $table->string('file')->nullable(false)->change();
      }
    });
  }
};
