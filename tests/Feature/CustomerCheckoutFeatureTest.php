<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Pesticide;
use App\Models\ProductVariant;
use App\Models\StockMovement;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerCheckoutFeatureTest extends TestCase
{
    use RefreshDatabase;

    private function setupStoreData(): array
    {
        $user = User::create([
            'name' => 'Admin Test',
            'email' => 'admin@bvtv.vn',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $warehouse = Warehouse::create([
            'code' => 'KHO-KRP',
            'name' => 'Kho Krông Pắk',
            'address' => 'Thị trấn Phước An, Huyện Krông Pắk',
            'province' => 'Đắk Lắk',
            'is_active' => true,
        ]);

        $cat = Category::create([
            'name' => 'Thuốc trừ nấm bệnh',
            'slug' => 'thuoc-tru-nam-benh',
            'emoji' => '🍄',
            'sort_order' => 1,
        ]);

        // Sản phẩm 1: Ridomil Gold
        $pesticide1 = Pesticide::create([
            'category_id' => $cat->id,
            'name' => 'Ridomil Gold 68WG',
            'active_ingredient' => 'Metalaxyl-M 40g/kg + Mancozeb 640g/kg',
            'form_type' => 'WG',
            'frac_code' => 'FRAC 4 + FRAC M03',
        ]);

        $variant1 = ProductVariant::create([
            'pesticide_id' => $pesticide1->id,
            'sku' => 'RID-100G',
            'barcode' => '893500000001',
            'specification' => 'Gói 100g',
            'unit' => 'Gói',
            'selling_price' => 55000,
            'cost_price' => 42000,
            'status' => 'active',
        ]);

        Inventory::create([
            'warehouse_id' => $warehouse->id,
            'variant_id' => $variant1->id,
            'quantity_on_hand' => 50,
            'quantity_reserved' => 0,
        ]);

        // Sản phẩm 2: Dầu khoáng (để test tương kỵ hoặc mua nhiều món)
        $pesticide2 = Pesticide::create([
            'category_id' => $cat->id,
            'name' => 'Dầu khoáng SK Enspray 99EC',
            'active_ingredient' => 'Petroleum spray oil 99%',
            'form_type' => 'EC',
        ]);

        $variant2 = ProductVariant::create([
            'pesticide_id' => $pesticide2->id,
            'sku' => 'SK-1L',
            'barcode' => '893500000002',
            'specification' => 'Chai 1 lít',
            'unit' => 'Chai',
            'selling_price' => 125000,
            'cost_price' => 95000,
            'status' => 'active',
        ]);

        Inventory::create([
            'warehouse_id' => $warehouse->id,
            'variant_id' => $variant2->id,
            'quantity_on_hand' => 30,
            'quantity_reserved' => 0,
        ]);

        return compact('user', 'warehouse', 'variant1', 'variant2', 'pesticide1', 'pesticide2');
    }

    public function test_cart_page_renders_and_calculates_summary(): void
    {
        $data = $this->setupStoreData();

        // Giỏ hàng có 2 gói Ridomil Gold (55.000 x 2 = 110.000)
        session(['customer_cart' => [$data['variant1']->id => 2]]);

        $response = $this->get(route('cart.index'));
        $response->assertStatus(200);
        $response->assertSee('Giỏ hàng của bạn');
        $response->assertSee('Ridomil Gold 68WG');
        $response->assertSee('110.000');
    }

    public function test_ajax_cart_lifecycle(): void
    {
        $data = $this->setupStoreData();

        // 1. Thêm vào giỏ
        $addRes = $this->postJson(route('ajax.cart.add'), [
            'variant_id' => $data['variant1']->id,
            'quantity' => 3,
        ]);

        $addRes->assertStatus(200);
        $addRes->assertJsonPath('success', true);
        $addRes->assertJsonPath('cart.count', 3);
        $addRes->assertJsonPath('cart.subtotal', 165000);

        // 2. Cập nhật số lượng
        $updRes = $this->postJson(route('ajax.cart.update'), [
            'variant_id' => $data['variant1']->id,
            'quantity' => 1,
        ]);
        $updRes->assertStatus(200);
        $updRes->assertJsonPath('cart.count', 1);
        $updRes->assertJsonPath('cart.subtotal', 55000);

        // 3. Xóa sản phẩm
        $delRes = $this->postJson(route('ajax.cart.remove'), [
            'variant_id' => $data['variant1']->id,
        ]);
        $delRes->assertStatus(200);
        $delRes->assertJsonPath('cart.count', 0);
        $delRes->assertJsonPath('cart.subtotal', 0);
    }

    public function test_checkout_validation_rules(): void
    {
        $data = $this->setupStoreData();
        session(['customer_cart' => [$data['variant1']->id => 1]]);

        // Submit thiếu các trường bắt buộc
        $res = $this->post(route('checkout.process'), []);
        $res->assertSessionHasErrors([
            'shipping_recipient_name',
            'shipping_phone',
            'shipping_province',
            'shipping_district',
            'shipping_address_line',
            'payment_method',
        ]);
    }

    public function test_successful_web_checkout_with_server_price_authority_and_inventory_ledger(): void
    {
        $data = $this->setupStoreData();

        // Khách hàng đưa vào giỏ 4 gói Ridomil (55.000 * 4 = 220.000)
        session(['customer_cart' => [$data['variant1']->id => 4]]);

        $payload = [
            'shipping_recipient_name' => 'Nguyễn Văn Nông',
            'shipping_phone' => '0912345678',
            'shipping_province' => 'Đắk Lắk',
            'shipping_district' => 'Krông Pắk',
            'shipping_ward' => 'Xã Ea Kly',
            'shipping_address_line' => 'Thôn 10, gần hồ Ea Nhái',
            'payment_method' => 'cash',
            'warehouse_id' => $data['warehouse']->id,
            'notes' => 'Giao vào buổi sáng giúp tôi',
        ];

        $res = $this->post(route('checkout.process'), $payload);

        $order = Order::where('shipping_phone', '0912345678')->first();
        $this->assertNotNull($order);
        $this->assertEquals('customer_web', $order->channel);
        $this->assertEquals(220000, $order->subtotal);
        $this->assertEquals(30000, $order->shipping_fee); // dưới 500k -> 30k ship
        $this->assertEquals(250000, $order->total_amount);
        $this->assertEquals('Nguyễn Văn Nông', $order->shipping_recipient_name);
        $this->assertEquals('Thôn 10, gần hồ Ea Nhái', $order->shipping_address_line);

        // Kiểm tra trừ kho đúng 4 gói (từ 50 xuống 46)
        $inv = Inventory::where('warehouse_id', $data['warehouse']->id)
            ->where('variant_id', $data['variant1']->id)
            ->first();
        $this->assertEquals(46, $inv->quantity_on_hand);

        // Kiểm tra đã phát sinh StockMovement bất biến
        $movement = StockMovement::where('reference_id', $order->id)
            ->where('reference_type', 'Order')
            ->first();
        $this->assertNotNull($movement);
        $this->assertEquals(-4, $movement->quantity_change);
        $this->assertEquals('online_sale', $movement->type);

        // Kiểm tra giỏ hàng trong session đã được dọn sạch
        $this->assertEmpty(session('customer_cart', []));

        // Kiểm tra chuyển hướng tới trang thành công
        $res->assertRedirect(route('don-hang.thanh-cong', $order->code));

        // Kiểm tra truy cập trang thành công xem hóa đơn
        $successPage = $this->get(route('don-hang.thanh-cong', $order->code));
        $successPage->assertStatus(200);
        $successPage->assertSee($order->code);
        $successPage->assertSee('Nguyễn Văn Nông');
        $successPage->assertSee('250.000');
    }
}
