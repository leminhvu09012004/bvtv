<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Phiếu Nhập Kho Mua Hàng
        Schema::create('purchase_receipts', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_code', 50)->unique();
            $table->foreignId('warehouse_id')->constrained('warehouses')->restrictOnDelete();
            $table->string('supplier_name', 191);
            $table->enum('status', ['draft', 'approved', 'cancelled'])->default('draft');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->unsignedBigInteger('total_amount')->default(0);
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });

        Schema::create('purchase_receipt_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_receipt_id')->constrained('purchase_receipts')->cascadeOnDelete();
            $table->foreignId('variant_id')->constrained('product_variants')->restrictOnDelete();
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('unit_cost');
            $table->unsignedBigInteger('line_total');
            $table->timestamps();
        });

        // 2. Phiếu Xuất Kho Nội Bộ / Xuất Hủy
        Schema::create('stock_issues', function (Blueprint $table) {
            $table->id();
            $table->string('issue_code', 50)->unique();
            $table->foreignId('warehouse_id')->constrained('warehouses')->restrictOnDelete();
            $table->enum('reason', ['internal_use', 'damage_writeoff', 'supplier_return', 'sample'])->default('internal_use');
            $table->enum('status', ['draft', 'approved', 'cancelled'])->default('draft');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });

        Schema::create('stock_issue_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_issue_id')->constrained('stock_issues')->cascadeOnDelete();
            $table->foreignId('variant_id')->constrained('product_variants')->restrictOnDelete();
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('unit_cost')->default(0);
            $table->timestamps();
        });

        // 3. Phiếu Chuyển Kho Đa Chi Nhánh
        Schema::create('stock_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_code', 50)->unique();
            $table->foreignId('from_warehouse_id')->constrained('warehouses')->restrictOnDelete();
            $table->foreignId('to_warehouse_id')->constrained('warehouses')->restrictOnDelete();
            $table->enum('status', ['draft', 'dispatched', 'received', 'cancelled'])->default('draft');
            $table->timestamp('dispatched_at')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });

        Schema::create('stock_transfer_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_transfer_id')->constrained('stock_transfers')->cascadeOnDelete();
            $table->foreignId('variant_id')->constrained('product_variants')->restrictOnDelete();
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('received_quantity')->nullable();
            $table->timestamps();
        });

        // 4. Phiếu Kiểm Kê Kho
        Schema::create('inventory_counts', function (Blueprint $table) {
            $table->id();
            $table->string('count_code', 50)->unique();
            $table->foreignId('warehouse_id')->constrained('warehouses')->restrictOnDelete();
            $table->enum('status', ['draft', 'in_progress', 'reconciled', 'cancelled'])->default('draft');
            $table->foreignId('reconciled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reconciled_at')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();
        });

        Schema::create('inventory_count_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_count_id')->constrained('inventory_counts')->cascadeOnDelete();
            $table->foreignId('variant_id')->constrained('product_variants')->restrictOnDelete();
            $table->integer('system_quantity');
            $table->integer('counted_quantity');
            $table->integer('difference')->storedAs('counted_quantity - system_quantity');
            $table->timestamps();
        });

        // 5. Sổ Cái Biến Động Kho Bất Biến (Immutable Stock Movements Ledger)
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->string('movement_code', 50)->unique();
            $table->foreignId('warehouse_id')->constrained('warehouses')->restrictOnDelete();
            $table->foreignId('destination_warehouse_id')->nullable()->constrained('warehouses')->restrictOnDelete();
            $table->foreignId('variant_id')->constrained('product_variants')->restrictOnDelete();
            $table->enum('type', [
                'purchase_receipt',
                'pos_sale',
                'online_sale',
                'customer_return',
                'supplier_return',
                'stock_transfer_out',
                'stock_transfer_in',
                'count_adjustment',
                'damage_writeoff'
            ]);
            $table->integer('quantity_change'); // Dương (+) hoặc Âm (-)
            $table->integer('balance_before');
            $table->integer('balance_after');
            $table->unsignedInteger('unit_cost')->default(0);
            $table->string('reference_type', 100); // PurchaseReceipt, Order, StockTransfer, InventoryCount, StockIssue
            $table->unsignedBigInteger('reference_id');
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['reference_type', 'reference_id']);
            $table->index('variant_id');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('inventory_count_items');
        Schema::dropIfExists('inventory_counts');
        Schema::dropIfExists('stock_transfer_items');
        Schema::dropIfExists('stock_transfers');
        Schema::dropIfExists('stock_issue_items');
        Schema::dropIfExists('stock_issues');
        Schema::dropIfExists('purchase_receipt_items');
        Schema::dropIfExists('purchase_receipts');
    }
};
