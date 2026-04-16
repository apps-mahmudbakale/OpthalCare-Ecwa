<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('antenatal_packages', function (Blueprint $table) {
            $table->date('expiry_date')->nullable()->after('services_covered');
        });
    }

    public function down(): void
    {
        Schema::table('antenatal_packages', function (Blueprint $table) {
            $table->dropColumn('expiry_date');
        });
    }
};
