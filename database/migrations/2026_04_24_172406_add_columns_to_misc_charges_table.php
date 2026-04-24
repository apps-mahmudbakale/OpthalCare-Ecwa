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
        Schema::table('misc_charges', function (Blueprint $table) {
            $table->foreignId('billing_id')->constrained('billings')->onDelete('cascade');
            $table->string('description');
            $table->decimal('unit_price', 10, 2);
            $table->integer('quantity')->default(1);
            $table->decimal('amount', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('misc_charges', function (Blueprint $table) {
            $table->dropForeign(['billing_id']);
            $table->dropColumn(['billing_id', 'description', 'unit_price', 'quantity', 'amount']);
        });
    }
};
