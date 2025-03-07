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
      Schema::create('refractions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('patient_id')->constrained()->onDelete('cascade');
        $table->string('itching_right')->nullable();
        $table->string('itching_left')->nullable();
        $table->string('photophobia_right')->nullable();
        $table->string('photophobia_left')->nullable();
        $table->string('pain_right')->nullable();
        $table->string('pain_left')->nullable();
        $table->string('blur_vision_far_right')->nullable();
        $table->string('blur_vision_far_left')->nullable();
        $table->string('diplopia_right')->nullable();
        $table->string('diplopia_left')->nullable();
        $table->timestamps();
      });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refractions');
    }
};
