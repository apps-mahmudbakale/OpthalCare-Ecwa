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
    Schema::table('procedures', function (Blueprint $table) {
      // Drop unwanted columns if they exist
      if (Schema::hasColumn('procedures', 'procedure_cost')) {
        $table->dropColumn('procedure_cost');
      }
      if (Schema::hasColumn('procedures', 'theatre_cost')) {
        $table->dropColumn('theatre_cost');
      }
      if (Schema::hasColumn('procedures', 'anaesthesia_cost')) {
        $table->dropColumn('anaesthesia_cost');
      }
      if (Schema::hasColumn('procedures', 'surgeon_fee')) {
        $table->dropColumn('surgeon_fee');
      }
      if (Schema::hasColumn('procedures', 'in_theather')) {
        $table->dropColumn('in_theather');
      }

      // Rename procedure_cost to price if needed
      if (!Schema::hasColumn('procedures', 'price')) {
        $table->decimal('price', 10, 2)->nullable();
      }

      // Ensure only name, price, and category_id remain
      // Add columns if missing
      if (!Schema::hasColumn('procedures', 'name')) {
        $table->string('name')->nullable();
      }
      if (!Schema::hasColumn('procedures', 'category_id')) {
        $table->unsignedBigInteger('category_id')->nullable();
      }
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('procedures', function (Blueprint $table) {
      // Optionally re-add the dropped columns (if you want to reverse the change)
      $table->decimal('procedure_cost', 10, 2)->nullable();
      $table->decimal('theatre_cost', 10, 2)->nullable();
      $table->decimal('anaesthesia_cost', 10, 2)->nullable();
      $table->decimal('surgeon_fee', 10, 2)->nullable();
      $table->boolean('in_theather')->nullable()->default(true);

      // Drop new simplified columns
      $table->dropColumn(['price']);
    });
  }
};
