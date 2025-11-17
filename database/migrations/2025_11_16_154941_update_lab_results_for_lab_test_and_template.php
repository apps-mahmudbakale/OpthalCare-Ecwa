<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /*************  ✨ Windsurf Command ⭐  *************/
/**
 * Rename lab_id to lab_test_id and add lab_template_id foreign key.
 * Add pathologist_comments column.
 * Optionally remove existing result column.
 */
  /*******  c67b323b-7019-480e-b67a-f46d985f75e0  *******/
  public function up(): void
  {
    // Step 1: Rename lab_id to lab_test_id
    if (Schema::hasColumn('lab_results', 'lab_id')) {
      Schema::table('lab_results', function (Blueprint $table) {
        $table->renameColumn('lab_id', 'lab_test_id');
      });
    }

    // Step 2: Add lab_template_id column after lab_test_id
    Schema::table('lab_results', function (Blueprint $table) {
      $table->foreignId('lab_template_id')
        ->after('lab_test_id')
        ->constrained('lab_templates')
        ->cascadeOnDelete();
    });

    // Step 3: Add pathologist_comments after patient_id
    Schema::table('lab_results', function (Blueprint $table) {
      $table->text('pathologist_comments')
        ->nullable()
        ->after('patient_id');
    });

    // Step 4: Optionally drop the result column
    if (Schema::hasColumn('lab_results', 'result')) {
      Schema::table('lab_results', function (Blueprint $table) {
        $table->dropColumn('result');
      });
    }
  }

  public function down(): void
  {
    Schema::table('lab_results', function (Blueprint $table) {
      if (Schema::hasColumn('lab_results', 'lab_template_id')) {
        $table->dropForeign(['lab_template_id']);
        $table->dropColumn('lab_template_id');
      }

      if (Schema::hasColumn('lab_results', 'pathologist_comments')) {
        $table->dropColumn('pathologist_comments');
      }
    });
  }
};
