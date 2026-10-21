<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name', 191);
            $table->string('address', 255);
            $table->string('phone', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warehouse_id')->constrained('warehouses')->restrictOnDelete();
            $table->foreignId('variant_id')->constrained('product_variants')->restrictOnDelete();
            $table->integer('quantity_on_hand')->default(0);
            $table->integer('quantity_reserved')->default(0);
            $table->integer('quantity_available')->storedAs('quantity_on_hand - quantity_reserved');
            $table->integer('reorder_point')->default(10);
            $table->string('bin_location', 100)->nullable();
            $table->timestamp('last_counted_at')->nullable();
            $table->timestamps();

            $table->unique(['warehouse_id', 'variant_id'], 'uq_warehouse_variant');
            $table->index('quantity_available');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
        Schema::dropIfExists('warehouses');
    }
};
