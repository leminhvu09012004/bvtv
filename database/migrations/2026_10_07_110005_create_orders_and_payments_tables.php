<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->enum('channel', ['pos', 'customer_web'])->default('pos');
            $table->foreignId('warehouse_id')->constrained('warehouses')->restrictOnDelete();
            $table->foreignId('cashier_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('customer_profile_id')->nullable()->constrained('customer_profiles')->nullOnDelete();

            // Snapshot thông tin giao hàng tại thời điểm đặt hàng
            $table->string('shipping_recipient_name');
            $table->string('shipping_phone', 20);
            $table->string('shipping_address_line', 255);
            $table->string('shipping_ward', 100)->nullable();
            $table->string('shipping_district', 100)->nullable();
            $table->string('shipping_province', 100)->nullable();

            $table->unsignedInteger('subtotal');
            $table->unsignedInteger('discount_amount')->default(0);
            $table->string('discount_reason')->nullable();
            $table->unsignedInteger('shipping_fee')->default(0);
            $table->unsignedInteger('total_amount');

            $table->enum('payment_status', ['unpaid', 'partially_paid', 'paid', 'refunded'])->default('unpaid');
            $table->enum('fulfillment_status', ['unfulfilled', 'fulfilled', 'cancelled'])->default('unfulfilled');
            $table->boolean('mixing_warning_acknowledged')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('code');
            $table->index('created_at');
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('variant_id')->constrained('product_variants')->restrictOnDelete();
            $table->string('product_name');
            $table->string('variant_sku', 100);
            $table->string('specification', 100);
            $table->unsignedInteger('unit_cost_price')->default(0);
            $table->unsignedInteger('unit_price');
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('line_total');
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->restrictOnDelete();
            $table->string('payment_code', 50)->unique();
            $table->unsignedInteger('amount');
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->timestamps();
        });

        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained('payments')->restrictOnDelete();
            $table->string('transaction_reference', 100)->unique();
            $table->enum('method', ['cash', 'bank_transfer', 'vnpay', 'momo', 'qr_code'])->default('cash');
            $table->unsignedInteger('amount');
            $table->enum('status', ['initiated', 'success', 'failed'])->default('initiated');
            $table->json('provider_response_payload')->nullable();
            $table->string('idempotency_key', 100)->unique();
            $table->timestamp('created_at')->useCurrent();

            $table->index('transaction_reference');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
