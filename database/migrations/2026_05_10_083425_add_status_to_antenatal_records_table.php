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
        Schema::table('antenatal_records', function (Blueprint $table) {
            $table->enum('status', ['active', 'concluded'])->default('active')->after('visit_type');
            $table->timestamp('concluded_at')->nullable()->after('status');
            $table->unsignedBigInteger('concluded_by')->nullable()->after('concluded_at');
            $table->text('conclusion_notes')->nullable()->after('concluded_by');
            
            $table->foreign('concluded_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antenatal_records', function (Blueprint $table) {
            $table->dropForeign(['concluded_by']);
            $table->dropColumn(['status', 'concluded_at', 'concluded_by', 'conclusion_notes']);
        });
    }
};
