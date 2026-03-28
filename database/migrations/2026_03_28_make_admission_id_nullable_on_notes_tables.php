<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('progress_notes', function (Blueprint $table) {
            $table->unsignedBigInteger('admission_id')->nullable()->change();
        });

        Schema::table('nursing_notes', function (Blueprint $table) {
            $table->unsignedBigInteger('admission_id')->nullable()->change();
        });

        Schema::table('nursing_tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('admission_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('progress_notes', function (Blueprint $table) {
            $table->unsignedBigInteger('admission_id')->nullable(false)->change();
        });

        Schema::table('nursing_notes', function (Blueprint $table) {
            $table->unsignedBigInteger('admission_id')->nullable(false)->change();
        });

        Schema::table('nursing_tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('admission_id')->nullable(false)->change();
        });
    }
};
