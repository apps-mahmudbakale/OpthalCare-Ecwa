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
        Schema::table('billings', function (Blueprint $table) {
            // Add fields to track who created the billing
            $table->unsignedBigInteger('created_by')->nullable()->after('user_id');
            $table->string('created_from')->nullable()->after('created_by'); // e.g., 'manual', 'auto', 'api'
            $table->text('creation_notes')->nullable()->after('created_from');
            $table->ipAddress('created_ip')->nullable()->after('creation_notes');
            
            // Add foreign key for created_by
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('billings', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn(['created_by', 'created_from', 'creation_notes', 'created_ip']);
        });
    }
};