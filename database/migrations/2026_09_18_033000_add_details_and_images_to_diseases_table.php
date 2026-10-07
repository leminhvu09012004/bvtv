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
            $table->json('images')->nullable()->after('image');          // Danh sách nhiều ảnh minh họa
            $table->text('symptoms')->nullable()->after('images');        // 1.1. Triệu chứng
            $table->text('prevention')->nullable()->after('symptoms');     // 1.2. Cách phòng bệnh
            $table->text('treatment')->nullable()->after('prevention');    // 1.3. Cách điều trị
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('diseases', function (Blueprint $table) {
            $table->dropColumn(['images', 'symptoms', 'prevention', 'treatment']);
        });
    }
};
