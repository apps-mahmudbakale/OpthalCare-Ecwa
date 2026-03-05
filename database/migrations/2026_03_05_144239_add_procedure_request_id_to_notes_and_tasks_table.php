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
        Schema::table('progress_notes', function (Blueprint $table) {
            $table->unsignedBigInteger('procedure_request_id')->nullable()->after('admission_id');
        });

        Schema::table('nursing_notes', function (Blueprint $table) {
            $table->unsignedBigInteger('procedure_request_id')->nullable()->after('admission_id');
        });

        Schema::table('nursing_tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('procedure_request_id')->nullable()->after('admission_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progress_notes', function (Blueprint $table) {
            $table->dropColumn('procedure_request_id');
        });

        Schema::table('nursing_notes', function (Blueprint $table) {
            $table->dropColumn('procedure_request_id');
        });

        Schema::table('nursing_tasks', function (Blueprint $table) {
            $table->dropColumn('procedure_request_id');
        });
    }
};
