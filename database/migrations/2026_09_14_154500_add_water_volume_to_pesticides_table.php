<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesticides', function (Blueprint $table) {
            $table->string('water_volume')->nullable()->after('concentration'); // Lượng nước pha khuyến cáo (vd: Pha 400 - 500 lít)
        });
    }

    public function down(): void
    {
        Schema::table('pesticides', function (Blueprint $table) {
            $table->dropColumn('water_volume');
        });
    }
};
