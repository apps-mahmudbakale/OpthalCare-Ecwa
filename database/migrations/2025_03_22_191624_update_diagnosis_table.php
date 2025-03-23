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
      Schema::table('diagnoses', function (Blueprint $table) {
        $table->text('disc_right')->nullable();
        $table->text('disc_left')->nullable();
        $table->text('vcdr_right')->nullable();
        $table->text('vcdr_left')->nullable();
        $table->text('macula_right')->nullable();
        $table->text('macula_left')->nullable();
        $table->text('retina_right')->nullable();
        $table->text('retina_left')->nullable();
        $table->text('vessels_right')->nullable();
        $table->text('vessels_left')->nullable();

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
