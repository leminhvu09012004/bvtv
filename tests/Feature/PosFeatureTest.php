<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Pesticide;
use App\Models\ProductVariant;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PosFeatureTest extends TestCase
{
    use RefreshDatabase;

    private function setupPosData(): array
    {
        $user = \App\Models\User::create([
            'name' => 'Thu Ngân Test',
            'email' => 'cashier.test@bvtv.vn',
            'password' => bcrypt('password'),
            'role' => 'staff',
        ]);
        $this->actingAs($user);

        $warehouse = Warehouse::create([
            'code' => 'KHO-TEST',
            'name' => 'Kho Thử Nghiệm POS',
            'address' => '123 Đường Hùng Vương, TT. Phước An',
            'province' => 'Đắk Lắk',
            'is_active' => true,
        ]);

        $cat = Category::create([
            'name' => 'Thuốc trừ sâu',
            'slug' => 'thuoc-tru-sau',
            'emoji' => '🐛',
            'sort_order' => 1,
        ]);

        $pesticide = Pesticide::create([
            'category_id' => $cat->id,
            'name' => 'Virtako 40WG',
            'active_ingredient' => 'Chlorantraniliprole 100g/kg + Thiamethoxam 300g/kg',
            'form_type' => 'WG',
            'irac_code' => 'IRAC 28 + IRAC 4A',
        ]);

        $variant = ProductVariant::create([
            'pesticide_id' => $pesticide->id,
            'sku' => 'VIR-40WG-3G',
            'barcode' => '893600000001',
            'specification' => 'Gói 3g',
            'unit' => 'Gói',
            'selling_price' => 18000,
            'cost_price' => 12000,
            'status' => 'active',
        ]);

        $inventory = Inventory::create([
            'warehouse_id' => $warehouse->id,
            'variant_id' => $variant->id,
            'quantity_on_hand' => 50,
            'quantity_reserved' => 0,
        ]);

        return [$warehouse, $variant, $inventory];
    }

    public function test_pos_index_loads_successfully(): void
    {
        [$warehouse, $variant] = $this->setupPosData();

        $response = $this->get(route('pos.index'));
        $response->assertStatus(200);
        $response->assertSee('BVTV POS');
        $response->assertSee('Virtako 40WG');
        $response->assertSee('VIR-40WG-3G');
    }

    public function test_pos_checkout_enforces_server_price_and_deducts_stock(): void
    {
        [$warehouse, $variant, $inventory] = $this->setupPosData();

        $response = $this->postJson(route('pos.checkout'), [
            'warehouse_id' => $warehouse->id,
            'items' => [
                [
                    'variant_id' => $variant->id,
                    'quantity' => 5,
                    'price' => 1000, // Client tries to spoof price as 1,000 VND
                ]
            ],
            'customer_name' => 'Nông Dân A',
            'customer_phone' => '0912345678',
            'discount_amount' => 5000,
            'payment_method' => 'CASH',
            'cash_tendered' => 100000,
            'idempotency_key' => 'IDEM-POS-TEST-1',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);
        // Server price is 18,000 x 5 = 90,000 - 5,000 = 85,000 VND (NOT 5 x 1000)
        $response->assertJsonPath('order.total_amount', 85000);
        $response->assertJsonPath('order.subtotal_amount', 90000);

        // Verify stock deducted in DB from 50 to 45
        $this->assertDatabaseHas('inventories', [
            'warehouse_id' => $warehouse->id,
            'variant_id' => $variant->id,
            'quantity_on_hand' => 45,
        ]);

        // Verify immutable StockMovement created
        $this->assertDatabaseHas('stock_movements', [
            'warehouse_id' => $warehouse->id,
            'variant_id' => $variant->id,
            'type' => 'pos_sale',
            'quantity_change' => -5,
            'balance_after' => 45,
        ]);

        // Verify Payment Transaction created
        $this->assertDatabaseHas('payment_transactions', [
            'method' => 'cash',
            'status' => 'success',
            'amount' => 85000,
        ]);
    }

    public function test_pos_checkout_fails_when_insufficient_stock(): void
    {
        [$warehouse, $variant] = $this->setupPosData();

        // Tồn kho là 50, client mua 60
        $response = $this->postJson(route('pos.checkout'), [
            'warehouse_id' => $warehouse->id,
            'items' => [
                [
                    'variant_id' => $variant->id,
                    'quantity' => 60,
                ]
            ],
            'payment_method' => 'CASH',
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('success', false);
        $this->assertStringContainsString('Không đủ tồn kho khả dụng', $response->json('message'));
    }
}
