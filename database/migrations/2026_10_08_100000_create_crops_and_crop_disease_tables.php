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
        // 1. Tạo bảng crops (Cây trồng)
        Schema::create('crops', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique()->index();
            $table->string('emoji', 16)->default('🌱');
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // 2. Tạo bảng pivot crop_disease (Quan hệ Nhiều - Nhiều giữa Cây trồng và Bệnh hại)
        Schema::create('crop_disease', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crop_id')->constrained('crops')->cascadeOnDelete();
            $table->foreignId('disease_id')->constrained('diseases')->cascadeOnDelete();
            $table->text('notes_on_crop')->nullable(); // Triệu chứng/lưu ý đặc thù riêng của bệnh trên cây này
            $table->timestamps();

            $table->unique(['crop_id', 'disease_id']);
        });

        // 3. Cho phép crop_name trên bảng diseases nullable để chuyển dần sang quan hệ crops
        Schema::table('diseases', function (Blueprint $table) {
            $table->string('crop_name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('crop_disease');
        Schema::dropIfExists('crops');

        Schema::table('diseases', function (Blueprint $table) {
            $table->string('crop_name')->default('Chanh dây')->change();
        });
    }
};
