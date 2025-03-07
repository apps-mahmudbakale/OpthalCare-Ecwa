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
        Schema::table('radiologies', function (Blueprint $table) {
      //
      $table->string('name');
      $table->foreignId('category_id')->nullable()->references('id')->on('radiology_categories');
      $table->foreignId('template_id')->nullable()->references('id')->on('radiology_templates');
      $table->integer('price')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('radiologies', function (Blueprint $table) {
          $table->dropConstrainedForeignId('category_id');
          $table->dropConstrainedForeignId('template_id');
          $table->dropColumn(['price', 'name']);
        });
    }
};
