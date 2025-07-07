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
      Schema::table('optical_requests', function (Blueprint $table) {
        $table->string('lens')->after('service_id')->nullable();
        $table->string('comments')->after('ref')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
      Schema::table('optical_requests', function (Blueprint $table) {
        $table->dropColumn('lens');
        $table->dropColumn('comments');
      });
    }
};
