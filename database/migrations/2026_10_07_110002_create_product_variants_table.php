<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesticides', function (Blueprint $table) {
            if (!Schema::hasColumn('pesticides', 'frac_code')) {
                $table->string('frac_code', 50)->nullable()->index()->after('active_ingredient');
            }
            if (!Schema::hasColumn('pesticides', 'irac_code')) {
                $table->string('irac_code', 50)->nullable()->index()->after('frac_code');
            }
            if (!Schema::hasColumn('pesticides', 'hrac_code')) {
                $table->string('hrac_code', 50)->nullable()->index()->after('irac_code');
            }
            if (!Schema::hasColumn('pesticides', 'chemical_group')) {
                $table->string('chemical_group', 100)->nullable()->index()->after('hrac_code');
            }
        });

        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesticide_id')->constrained('pesticides')->cascadeOnDelete();
            $table->string('sku', 100)->unique();
            $table->string('barcode', 100)->unique()->nullable();
            $table->string('specification', 100); // vd: Chai 500ml, Gói 100g, Can 5L
            $table->string('unit', 50)->default('Chai'); // Chai, Gói, Can, Hũ, Thùng
            $table->unsignedInteger('cost_price')->default(0); // Giá nhập
            $table->unsignedInteger('selling_price'); // Giá bán lẻ niêm yết
            $table->unsignedInteger('promotional_price')->nullable(); // Giá khuyến mãi
            $table->unsignedInteger('weight_grams')->default(500); // Trọng lượng
            $table->string('image')->nullable();
            $table->enum('status', ['active', 'inactive', 'discontinued'])->default('active')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
        Schema::table('pesticides', function (Blueprint $table) {
            $table->dropColumn(['frac_code', 'irac_code', 'hrac_code', 'chemical_group']);
        });
    }
};
