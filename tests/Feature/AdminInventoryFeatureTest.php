<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\InventoryCount;
use App\Models\InventoryCountItem;
use App\Models\Pesticide;
use App\Models\ProductVariant;
use App\Models\PurchaseReceipt;
use App\Models\PurchaseReceiptItem;
use App\Models\StockTransfer;
use App\Models\StockTransferItem;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminInventoryFeatureTest extends TestCase
{
    use RefreshDatabase;

    private function setupData(): array
    {
        $user = User::create([
            'name' => 'Admin Kho',
            'email' => 'admin.kho@bvtv.vn',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
        $this->actingAs($user);

        $whKrp = Warehouse::create([
            'code' => 'KHO-KRP',
            'name' => 'Kho Krông Pắk',
            'address' => 'TT Phước An',
            'province' => 'Đắk Lắk',
            'is_active' => true,
        ]);

        $whBmt = Warehouse::create([
            'code' => 'KHO-BMT',
            'name' => 'Kho Buôn Ma Thuột',
            'address' => 'Lê Duẩn, BMT',
            'province' => 'Đắk Lắk',
            'is_active' => true,
        ]);

        $cat = Category::create([
            'name' => 'Thuốc trừ bệnh',
            'slug' => 'thuoc-tru-benh',
            'emoji' => '🧪',
            'sort_order' => 1,
        ]);

        $pesticide = Pesticide::create([
            'category_id' => $cat->id,
            'name' => 'Anvil 5SC',
            'active_ingredient' => 'Hexaconazole 50g/l',
            'form_type' => 'SC',
        ]);

        $variant = ProductVariant::create([
            'pesticide_id' => $pesticide->id,
            'sku' => 'ANV-5SC-1L',
            'barcode' => '893600000002',
            'specification' => 'Chai 1 Lít',
            'unit' => 'Chai',
            'selling_price' => 240000,
            'cost_price' => 190000,
            'status' => 'active',
        ]);

        $invKrp = Inventory::create([
            'warehouse_id' => $whKrp->id,
            'variant_id' => $variant->id,
            'quantity_on_hand' => 100,
            'quantity_reserved' => 0,
            'reorder_point' => 20,
        ]);

        $invBmt = Inventory::create([
            'warehouse_id' => $whBmt->id,
            'variant_id' => $variant->id,
            'quantity_on_hand' => 10,
            'quantity_reserved' => 0,
            'reorder_point' => 15,
        ]);

        return [$user, $whKrp, $whBmt, $variant, $invKrp, $invBmt];
    }

    public function test_admin_inventory_index_and_movements_page_load(): void
    {
        $this->setupData();

        $resp = $this->get(route('admin.inventory.index'));
        $resp->assertStatus(200);
        $resp->assertSee('Quản Lý Tồn Kho Đa Chi Nhánh');
        $resp->assertSee('Kho Krông Pắk');
        $resp->assertSee('Anvil 5SC');

        $respLedger = $this->get(route('admin.inventory.movements'));
        $respLedger->assertStatus(200);
        $respLedger->assertSee('Sổ Cái Biến Động Kho Bất Biến');
    }

    public function test_stock_transfer_dispatch_and_receive_workflows(): void
    {
        [$user, $whKrp, $whBmt, $variant, $invKrp, $invBmt] = $this->setupData();

        // Tạo phiếu chuyển kho 20 chai từ Krông Pắk sang BMT
        $transfer = StockTransfer::create([
            'transfer_code' => 'TRF-TEST-001',
            'from_warehouse_id' => $whKrp->id,
            'to_warehouse_id' => $whBmt->id,
            'status' => 'draft',
            'created_by' => $user->id,
        ]);

        StockTransferItem::create([
            'stock_transfer_id' => $transfer->id,
            'variant_id' => $variant->id,
            'quantity' => 20,
        ]);

        // 1. Dispatch transfer: trừ kho Krông Pắk từ 100 xuống 80
        $respDispatch = $this->post(route('admin.inventory.transfers.dispatch', $transfer));
        $respDispatch->assertRedirect();

        $this->assertDatabaseHas('inventories', [
            'warehouse_id' => $whKrp->id,
            'variant_id' => $variant->id,
            'quantity_on_hand' => 80,
        ]);

        $this->assertDatabaseHas('stock_transfers', [
            'id' => $transfer->id,
            'status' => 'dispatched',
        ]);

        // 2. Receive transfer: cộng kho BMT từ 10 lên 30
        $respReceive = $this->post(route('admin.inventory.transfers.receive', $transfer));
        $respReceive->assertRedirect();

        $this->assertDatabaseHas('inventories', [
            'warehouse_id' => $whBmt->id,
            'variant_id' => $variant->id,
            'quantity_on_hand' => 30,
        ]);

        $this->assertDatabaseHas('stock_transfers', [
            'id' => $transfer->id,
            'status' => 'received',
        ]);
    }

    public function test_purchase_receipt_approval_increases_stock_and_records_ledger(): void
    {
        [$user, $whKrp, $whBmt, $variant] = $this->setupData();

        $receipt = PurchaseReceipt::create([
            'receipt_code' => 'RCP-TEST-001',
            'warehouse_id' => $whKrp->id,
            'supplier_name' => 'Syngenta Việt Nam',
            'status' => 'draft',
            'total_cost' => 1900000,
            'created_by' => $user->id,
        ]);

        PurchaseReceiptItem::create([
            'purchase_receipt_id' => $receipt->id,
            'variant_id' => $variant->id,
            'quantity' => 10,
            'unit_cost' => 190000,
            'line_total' => 1900000,
        ]);

        // Duyệt nhập kho: kho Krông Pắk từ 100 tăng lên 110
        $resp = $this->post(route('admin.inventory.receipts.approve', $receipt));
        $resp->assertRedirect();

        $this->assertDatabaseHas('inventories', [
            'warehouse_id' => $whKrp->id,
            'variant_id' => $variant->id,
            'quantity_on_hand' => 110,
        ]);

        $this->assertDatabaseHas('stock_movements', [
            'warehouse_id' => $whKrp->id,
            'variant_id' => $variant->id,
            'type' => 'purchase_receipt',
            'quantity_change' => 10,
            'balance_after' => 110,
        ]);
    }

    public function test_inventory_count_reconciliation_adjusts_ledger(): void
    {
        [$user, $whKrp, $whBmt, $variant] = $this->setupData();

        // Hệ thống đang có 100, nhưng đếm thực tế chỉ có 95 (hao hụt 5 chai)
        $count = InventoryCount::create([
            'count_code' => 'CNT-TEST-001',
            'warehouse_id' => $whKrp->id,
            'status' => 'draft',
            'created_by' => $user->id,
        ]);

        InventoryCountItem::create([
            'inventory_count_id' => $count->id,
            'variant_id' => $variant->id,
            'system_quantity' => 100,
            'counted_quantity' => 95,
        ]);

        $resp = $this->post(route('admin.inventory.counts.reconcile', $count));
        $resp->assertRedirect();

        // Tồn kho sau cân đối phải là 95
        $this->assertDatabaseHas('inventories', [
            'warehouse_id' => $whKrp->id,
            'variant_id' => $variant->id,
            'quantity_on_hand' => 95,
        ]);

        // Sổ cái ghi nhận count_adjustment -5
        $this->assertDatabaseHas('stock_movements', [
            'warehouse_id' => $whKrp->id,
            'variant_id' => $variant->id,
            'type' => 'count_adjustment',
            'quantity_change' => -5,
            'balance_after' => 95,
        ]);
    }

    /**
     * Xác nhận giao diện Admin chỉ chứa nghiệp vụ quản trị, không lẫn lộn User/POS.
     */
    public function test_giao_dien_admin_khong_chua_chuc_nang_cua_user_va_pos(): void
    {
        $this->setupData();

        $response = $this->get(route('admin.inventory.index'));
        $response->assertStatus(200);

        // Phải có các mục nghiệp vụ Admin
        $response->assertSee('BVTV QUẢN TRỊ');
        $response->assertSee('KHO VẬN');
        $response->assertSee('SẢN PHẨM');
        $response->assertSee('Mã sản phẩm / SKU');

        // TUYỆT ĐỐI không chứa các mục của User và Quầy POS
        $response->assertDontSee('TRA CỨU (USER)');
        $response->assertDontSee('Kênh Staff POS');
        $response->assertDontSee('Mở quầy bán hàng ➔');
        $response->assertDontSee('cart-badge-sidebar');
    }

    /**
     * Kiểm tra endpoint AJAX tìm kiếm sản phẩm theo tên, SKU, hoạt chất và tồn kho chi nhánh
     */
    public function test_ajax_search_variants_endpoint(): void
    {
        [$user, $whKrp, $whBmt, $variant] = $this->setupData();

        // 1. Tìm theo tên thuốc "Anvil"
        $resp = $this->getJson(route('admin.inventory.ajax.variants.search', [
            'q' => 'Anvil',
            'warehouse_id' => $whKrp->id,
        ]));

        $resp->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonFragment([
                'id' => $variant->id,
                'name' => 'Anvil 5SC',
                'sku' => 'ANV-5SC-1L',
                'stock' => 100,
            ]);

        // 2. Tìm với kho Buôn Ma Thuột (tồn kho 10)
        $respBmt = $this->getJson(route('admin.inventory.ajax.variants.search', [
            'q' => 'ANV',
            'warehouse_id' => $whBmt->id,
        ]));

        $respBmt->assertStatus(200)
            ->assertJsonFragment([
                'id' => $variant->id,
                'stock' => 10,
            ]);

        // 3. Tìm từ khóa không tồn tại
        $respNone = $this->getJson(route('admin.inventory.ajax.variants.search', [
            'q' => 'KhôngCóThuốcNày123XYZ',
        ]));

        $respNone->assertStatus(200)
            ->assertJson([
                'success' => true,
                'results' => [],
            ]);
    }

    public function test_admin_inventory_index_ajax_and_filters(): void
    {
        [$user, $whKrp, $whBmt, $variant] = $this->setupData();

        // 1. AJAX request returns JSON with table HTML and stats
        $respAjax = $this->getJson(route('admin.inventory.index', [
            'warehouse_id' => $whKrp->id,
            'q' => 'Anvil',
        ]));

        $respAjax->assertStatus(200)
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure([
                'success',
                'html',
                'stats' => ['totalItems', 'lowStockCount', 'totalSkuCount'],
                'pagination' => ['total', 'current_page', 'last_page'],
            ]);

        // 2. Filter low_stock = 1
        $respLow = $this->get(route('admin.inventory.index', ['low_stock' => '1']));
        $respLow->assertStatus(200);

        // 3. Movements with filters
        $respMov = $this->get(route('admin.inventory.movements', [
            'warehouse_id' => $whKrp->id,
            'type' => 'purchase_receipt',
            'q' => 'ANV',
        ]));
        $respMov->assertStatus(200);
    }

    public function test_admin_transfer_store_and_ajax_dispatch_receive(): void
    {
        [$user, $whKrp, $whBmt, $variant] = $this->setupData();

        // 1. View transfers page
        $this->get(route('admin.inventory.transfers'))->assertStatus(200);

        // 2. Validation failure: same source and destination warehouse
        $respVal = $this->post(route('admin.inventory.transfers.store'), [
            'from_warehouse_id' => $whKrp->id,
            'to_warehouse_id' => $whKrp->id,
            'items' => [
                ['variant_id' => $variant->id, 'quantity' => 5],
            ],
        ]);
        $respVal->assertSessionHasErrors('to_warehouse_id');

        // 3. Store draft transfer
        $respStore = $this->post(route('admin.inventory.transfers.store'), [
            'from_warehouse_id' => $whKrp->id,
            'to_warehouse_id' => $whBmt->id,
            'notes' => 'Chuyển hàng kiểm thử',
            'items' => [
                ['variant_id' => $variant->id, 'quantity' => 10],
            ],
        ]);
        $respStore->assertRedirect(route('admin.inventory.transfers'));
        $respStore->assertSessionHas('success');

        $transfer = StockTransfer::latest('id')->first();
        $this->assertNotNull($transfer);
        $this->assertEquals('draft', $transfer->status);

        // 4. Dispatch via JSON
        $respJsonDispatch = $this->postJson(route('admin.inventory.transfers.dispatch', $transfer));
        $respJsonDispatch->assertStatus(200)
            ->assertJson([
                'success' => true,
                'status' => 'dispatched',
            ]);

        // 5. Duplicate dispatch returns 422 JSON
        $respDupDispatch = $this->postJson(route('admin.inventory.transfers.dispatch', $transfer));
        $respDupDispatch->assertStatus(422)
            ->assertJson(['success' => false]);

        // 6. Receive via JSON
        $respJsonReceive = $this->postJson(route('admin.inventory.transfers.receive', $transfer));
        $respJsonReceive->assertStatus(200)
            ->assertJson([
                'success' => true,
                'status' => 'completed',
            ]);

        // 7. Store with dispatch_now = true
        $respStoreNow = $this->post(route('admin.inventory.transfers.store'), [
            'from_warehouse_id' => $whKrp->id,
            'to_warehouse_id' => $whBmt->id,
            'dispatch_now' => 1,
            'items' => [
                ['variant_id' => $variant->id, 'quantity' => 5],
            ],
        ]);
        $respStoreNow->assertRedirect(route('admin.inventory.transfers'));
        $respStoreNow->assertSessionHas('success');
    }

    public function test_admin_receipts_store_and_ajax_approval(): void
    {
        [$user, $whKrp, $whBmt, $variant] = $this->setupData();

        // 1. View receipts page
        $this->get(route('admin.inventory.receipts'))->assertStatus(200);

        // 2. Validation failure: missing items
        $respVal = $this->post(route('admin.inventory.receipts.store'), [
            'warehouse_id' => $whKrp->id,
            'items' => [],
        ]);
        $respVal->assertSessionHasErrors('items');

        // 3. Store draft purchase receipt
        $respDraft = $this->post(route('admin.inventory.receipts.store'), [
            'warehouse_id' => $whKrp->id,
            'supplier_name' => 'Bayer Cropscience',
            'notes' => 'Hàng mẫu đợt 1',
            'items' => [
                ['variant_id' => $variant->id, 'quantity' => 20, 'unit_cost' => 180000],
            ],
        ]);
        $respDraft->assertRedirect(route('admin.inventory.receipts'));
        $respDraft->assertSessionHas('success');

        $receipt = PurchaseReceipt::latest('id')->first();
        $this->assertNotNull($receipt);
        $this->assertEquals('draft', $receipt->status);

        // 4. Approve via JSON
        $respApprove = $this->postJson(route('admin.inventory.receipts.approve', $receipt));
        $respApprove->assertStatus(200)
            ->assertJson([
                'success' => true,
                'status' => 'received',
            ]);

        // 5. Already approved returns 422 JSON
        $respDup = $this->postJson(route('admin.inventory.receipts.approve', $receipt));
        $respDup->assertStatus(422)
            ->assertJson(['success' => false]);

        // 6. Store with approve_now = 1
        $respNow = $this->post(route('admin.inventory.receipts.store'), [
            'warehouse_id' => $whKrp->id,
            'approve_now' => 1,
            'items' => [
                ['variant_id' => $variant->id, 'quantity' => 15, 'unit_cost' => 185000],
            ],
        ]);
        $respNow->assertRedirect(route('admin.inventory.receipts'));
        $respNow->assertSessionHas('success');
    }

    public function test_admin_stock_issues_store_approve_and_print(): void
    {
        [$user, $whKrp, $whBmt, $variant] = $this->setupData();

        // 1. View issues page with filters
        $respIndex = $this->get(route('admin.inventory.issues', [
            'warehouse_id' => $whKrp->id,
            'reason' => 'damage_writeoff',
            'status' => 'draft',
        ]));
        $respIndex->assertStatus(200);

        // 2. Validation failure: missing reason
        $respVal = $this->post(route('admin.inventory.issues.store'), [
            'warehouse_id' => $whKrp->id,
            'items' => [
                ['variant_id' => $variant->id, 'quantity' => 2],
            ],
        ]);
        $respVal->assertSessionHasErrors('reason');

        // 3. Store draft issue
        $respDraft = $this->post(route('admin.inventory.issues.store'), [
            'warehouse_id' => $whKrp->id,
            'reason' => 'internal_use',
            'notes' => 'Dùng thí nghiệm',
            'items' => [
                ['variant_id' => $variant->id, 'quantity' => 2, 'unit_cost' => 190000],
            ],
        ]);
        $respDraft->assertRedirect(route('admin.inventory.issues'));
        $respDraft->assertSessionHas('success');

        $issue = \App\Models\StockIssue::latest('id')->first();
        $this->assertNotNull($issue);
        $this->assertEquals('draft', $issue->status);

        // 4. View print issue view
        $this->get(route('admin.inventory.issues.print', $issue))->assertStatus(200);

        // 5. Approve issue via JSON
        $respApprove = $this->postJson(route('admin.inventory.issues.approve', $issue));
        $respApprove->assertStatus(200)
            ->assertJson([
                'success' => true,
                'status' => 'approved',
            ]);

        // 6. Duplicate approve returns 422 JSON
        $respDup = $this->postJson(route('admin.inventory.issues.approve', $issue));
        $respDup->assertStatus(422)
            ->assertJson(['success' => false]);

        // 7. Store issue with approve_now = 1
        $respNow = $this->post(route('admin.inventory.issues.store'), [
            'warehouse_id' => $whKrp->id,
            'reason' => 'damage_writeoff',
            'approve_now' => 1,
            'items' => [
                ['variant_id' => $variant->id, 'quantity' => 1, 'unit_cost' => 190000],
            ],
        ]);
        $respNow->assertRedirect(route('admin.inventory.issues'));
        $respNow->assertSessionHas('success');
    }

    public function test_admin_inventory_counts_index_and_json_reconcile(): void
    {
        [$user, $whKrp, $whBmt, $variant] = $this->setupData();

        // 1. View counts page
        $this->get(route('admin.inventory.counts'))->assertStatus(200);

        // 2. Count reconciliation via JSON
        $count = InventoryCount::create([
            'count_code' => 'CNT-JSON-001',
            'warehouse_id' => $whKrp->id,
            'status' => 'draft',
            'created_by' => $user->id,
        ]);

        InventoryCountItem::create([
            'inventory_count_id' => $count->id,
            'variant_id' => $variant->id,
            'system_quantity' => 100,
            'counted_quantity' => 98,
        ]);

        $respJson = $this->postJson(route('admin.inventory.counts.reconcile', $count));
        $respJson->assertStatus(200)
            ->assertJson([
                'success' => true,
                'status' => 'reconciled',
            ]);

        // 3. Duplicate reconcile returns 422 JSON
        $respDup = $this->postJson(route('admin.inventory.counts.reconcile', $count));
        $respDup->assertStatus(422)
            ->assertJson(['success' => false]);
    }
}

