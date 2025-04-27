<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   * Adds nullable 'qty' and 'store_id' columns to the 'drug_requests' table.
   */
  public function up(): void
  {
    Schema::table('drug_requests', function (Blueprint $table) {
      if (!Schema::hasColumn('drug_requests', 'qty')) {
        $table->integer('qty')->nullable()->after('user_id');
      }
      if (!Schema::hasColumn('drug_requests', 'store_id')) {
        $table->integer('store_id')->nullable()->after('drug_id');
        // Optional: Add foreign key constraint if 'store_id' references a 'stores' table
        // $table->foreign('store_id')->references('id')->on('stores')->onDelete('set null');
      }
    });
  }

  /**
   * Reverse the migrations.
   * Drops the 'qty' and 'store_id' columns from the 'drug_requests' table.
   */
  public function down(): void
  {
    Schema::table('drug_requests', function (Blueprint $table) {
      if (Schema::hasColumn('drug_requests', 'store_id')) {
        // Drop foreign key first if it was added
        // $table->dropForeign(['store_id']);
        $table->dropColumn('store_id');
      }
      if (Schema::hasColumn('drug_requests', 'qty')) {
        $table->dropColumn('qty');
      }
    });
  }
};
