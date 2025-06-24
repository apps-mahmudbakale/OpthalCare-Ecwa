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
    Schema::table('admissions', function (Blueprint $table) {
      $table->integer('procedure_id')->after('bed_id');

      $table->integer('ward_id')->nullable()->change();
      $table->integer('bed_id')->nullable()->change();
      $table->string('status')->change();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('admissions', function (Blueprint $table) {
      $table->dropColumn('procedure_id');

      $table->integer('ward_id')->nullable(false)->change();
      $table->integer('bed_id')->nullable(false)->change();
    });
  }
};
