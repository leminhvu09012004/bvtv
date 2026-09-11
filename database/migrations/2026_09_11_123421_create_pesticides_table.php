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
        Schema::create('pesticides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // Tên thương phẩm
            $table->string('active_ingredient')->nullable(); // Hoạt chất
            $table->string('concentration')->nullable(); // Hàm lượng
            $table->text('usage')->nullable(); // Công dụng / trị gì
            $table->text('target')->nullable(); // Đối tượng phòng/trừ
            $table->text('crops')->nullable(); // Cây trồng sử dụng
            $table->string('form_type')->nullable(); // Dạng thuốc: EC, WP, SC...
            $table->string('manufacturer')->nullable(); // Nhà sản xuất
            $table->string('registration_number')->nullable(); // Số đăng ký
            $table->string('isolation_period')->nullable(); // Thời gian cách ly
            $table->text('notes')->nullable(); // Ghi chú thực tế
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesticides');
    }
};
