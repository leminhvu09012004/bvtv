<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Pesticide;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductVariantPriceTest extends TestCase
{
    use RefreshDatabase;

    private function taoDanhMuc(): Category
    {
        return Category::create([
            'name' => 'Phân bón lá',
            'slug' => 'phan-bon-la',
            'emoji' => '🌿',
            'sort_order' => 1,
        ]);
    }

    /** Test: Chi tiết thuốc là giao diện sổ tay học tập, không hiển thị ô giá hay các nút chọn size. */
    public function test_chi_tiet_thuoc_khong_hien_thi_gia_va_size_variants(): void
    {
        $cat = $this->taoDanhMuc();
        $thuoc = Pesticide::create([
            'category_id' => $cat->id,
            'name' => '1.0.16 Huỳnh Lâm Test',
            'active_ingredient' => 'Chitosan 1%',
            'water_volume' => '200 lít',
            'target' => 'Bệnh đốm lá',
            'usage' => 'Pha 200 lít nước',
        ]);

        $resp = $this->get(route('thuoc.xem', $thuoc));
        $resp->assertStatus(200);

        // Không hiển thị khung giá bán và bộ chọn size
        $resp->assertDontSee('id="detail-price-box"', false);
        $resp->assertDontSee('id="variant-selector-group"', false);
        $resp->assertDontSee('chonKichThuoc');

        // Hiển thị thông tin học thuốc
        $resp->assertSee('1.0.16 Huỳnh Lâm Test');
        $resp->assertSee('Chitosan 1%');
        $resp->assertSee('200 lít');
        $resp->assertSee('Bệnh đốm lá');
    }

    /** Test: Model formatted_variants và price_range luôn trả về rỗng / null an toàn. */
    public function test_model_variants_va_price_tra_ve_an_toan(): void
    {
        $cat = $this->taoDanhMuc();
        $thuoc = Pesticide::create([
            'category_id' => $cat->id,
            'name' => 'Thuốc Kiểm Tra Model',
        ]);

        $this->assertEquals([], $thuoc->formatted_variants);
        $this->assertNull($thuoc->price_range);
        $this->assertNull($thuoc->formatted_price);
    }
}
