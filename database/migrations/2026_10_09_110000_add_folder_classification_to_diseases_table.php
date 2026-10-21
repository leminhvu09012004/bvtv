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
            $table->string('folder_code', 20)->nullable()->after('pathogen_type');
            $table->string('folder_group', 30)->nullable()->after('folder_code');
            $table->string('folder_name', 150)->nullable()->after('folder_group');
            $table->unsignedInteger('folder_number')->nullable()->after('folder_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diseases', function (Blueprint $table) {
            $table->dropColumn(['folder_code', 'folder_group', 'folder_name', 'folder_number']);
        });
    }
};
