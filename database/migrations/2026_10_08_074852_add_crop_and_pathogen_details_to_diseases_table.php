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
        Schema::table('diseases', function (Blueprint $table) {
            $table->string('crop_name')->default('Chanh dây')->index()->after('name');
            $table->string('pathogen_type')->nullable()->index()->after('crop_name'); // nam, virus, tuyen_trung, vi_khuan
            $table->text('caunho')->nullable()->after('pathogen_type');
            $table->json('symptoms_detail')->nullable()->after('symptoms');
            $table->text('chemical_groups')->nullable()->after('treatment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diseases', function (Blueprint $table) {
            $table->dropColumn([
                'crop_name',
                'pathogen_type',
                'caunho',
                'symptoms_detail',
                'chemical_groups',
            ]);
        });
    }
};
