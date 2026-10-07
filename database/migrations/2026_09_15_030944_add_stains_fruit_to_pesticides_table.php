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
        Schema::table('pesticides', function (Blueprint $table) {
            $table->boolean('stains_fruit')->default(false)->after('water_volume');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesticides', function (Blueprint $table) {
            $table->dropColumn('stains_fruit');
        });
    }
};
