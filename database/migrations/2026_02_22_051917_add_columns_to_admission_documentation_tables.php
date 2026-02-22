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
            $table->foreignId('admission_id')->constrained()->onDelete('cascade');
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->longText('note')->nullable();
        });

        Schema::table('nursing_notes', function (Blueprint $table) {
            $table->foreignId('admission_id')->constrained()->onDelete('cascade');
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->longText('note')->nullable();
        });

        Schema::table('nursing_tasks', function (Blueprint $table) {
            $table->foreignId('admission_id')->constrained()->onDelete('cascade');
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('task')->nullable();
            $table->string('status')->default('Pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progress_notes', function (Blueprint $table) {
            $table->dropColumn(['admission_id', 'patient_id', 'user_id', 'note']);
        });

        Schema::table('nursing_notes', function (Blueprint $table) {
            $table->dropColumn(['admission_id', 'patient_id', 'user_id', 'note']);
        });

        Schema::table('nursing_tasks', function (Blueprint $table) {
            $table->dropColumn(['admission_id', 'patient_id', 'user_id', 'task', 'status']);
        });
    }
};
