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
        //
        Schema::table('procedures', function (Blueprint $table) {
          
            $table->string('name')->nullable();
            $table->decimal('procedure_cost', 10, 2)->nullable();
            $table->decimal('theatre_cost', 10, 2)->nullable();
            $table->decimal('anaesthesia_cost', 10, 2)->nullable();
            $table->decimal('surgeon_fee', 10, 2)->nullable();
            $table->integer('category_id')->nullable();
            $table->boolean('in_theather')->nullable()->default(true);
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
