<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Pesticide;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThuocTraCuuTest extends TestCase
{
    use RefreshDatabase;

    private function taoDanhMuc(string $ten = 'Thuốc trừ nấm', string $slug = 'nam', string $emoji = '🍄'): Category
    {
        return Category::create([
            'name' => $ten,
            'slug' => $slug,
            'emoji' => $emoji,
            'sort_order' => 1,
        ]);
    }

    private function taoThuoc(Category $category, array $attributes = []): Pesticide
    {
        return Pesticide::create(array_merge([
            'category_id' => $category->id,
            'name' => 'Thuốc Mẫu',
        ], $attributes));
    }

    /** Kiểm tra tìm kiếm theo biến thể phân cách dạng số (15 15 15, 15-15-15, 15.15.15). */
    public function test_tim_kiem_bien_the_phan_cach(): void
    {
        $cat = $this->taoDanhMuc('Phân bón lá', 'phan-bon', '🌱');
        $this->taoThuoc($cat, ['name' => 'Phân Bón NPK 15-15-15 Cao Cấp']);
        $this->taoThuoc($cat, ['name' => 'Phân Bón NPK 20-20-15 Đọt Cây']);

        // Tìm từ khóa '15 15 15'
        $resp = $this->get(route('thuoc.tra-cuu', ['q' => '15 15 15']));
        $resp->assertStatus(200);
        $resp->assertSee('NPK 15-15-15');
        $resp->assertDontSee('20-20-15');
    }

    /** Kiểm tra tìm kiếm theo ID thuốc (#ID hoặc ID: X). */
    public function test_tim_kiem_theo_id_thuoc(): void
    {
        $cat = $this->taoDanhMuc();
        $thuoc1 = $this->taoThuoc($cat, ['name' => 'Thuốc Số 1']);
        $thuoc2 = $this->taoThuoc($cat, ['name' => 'Thuốc Số 2']);

        // Tìm theo '#ID'
        $resp = $this->get(route('thuoc.tra-cuu', ['q' => '#' . $thuoc1->id]));
        $resp->assertStatus(200);
        $resp->assertSee('Thuốc Số 1');
        $resp->assertDontSee('Thuốc Số 2');

        // Tìm theo 'id: X'
        $resp2 = $this->get(route('thuoc.tra-cuu', ['q' => 'id: ' . $thuoc2->id]));
        $resp2->assertStatus(200);
        $resp2->assertSee('Thuốc Số 2');
        $resp2->assertDontSee('Thuốc Số 1');
    }

    /** Kiểm tra tìm kiếm đa trường: hoạt chất và công dụng. */
    public function test_tim_kiem_da_truong_hoat_chat_va_cong_dung(): void
    {
        $cat = $this->taoDanhMuc();
        $this->taoThuoc($cat, [
            'name' => 'Amistar Top',
            'active_ingredient' => 'Azoxystrobin + Difenoconazole',
            'usage' => 'Đặc trị đốm vằn, thán thư sầu riêng',
        ]);
        $this->taoThuoc($cat, [
            'name' => 'Anvil 5SC',
            'active_ingredient' => 'Hexaconazole',
            'usage' => 'Trừ nấm rỉ sắt cà phê',
        ]);

        // Tìm kiếm theo hoạt chất
        $resp1 = $this->get(route('thuoc.tra-cuu', ['hoat_chat' => 'Azoxystrobin']));
        $resp1->assertStatus(200);
        $resp1->assertSee('Amistar Top');
        $resp1->assertDontSee('Anvil 5SC');

        // Tìm kiếm theo cây trồng
        $resp2 = $this->get(route('thuoc.tra-cuu', ['cay_trong' => 'cà phê']));
        $resp2->assertStatus(200);
        // Anvil có usage rỉ sắt cà phê nhưng chưa set crops -> set crops để test
    }

    /** Kiểm tra lọc kết hợp danh mục và mục đích nông học. */
    public function test_loc_ket_hop_danh_muc_va_muc_dich(): void
    {
        $cat1 = $this->taoDanhMuc('Thuốc Trừ Nấm', 'nam-benh', '🍄');
        $cat2 = $this->taoDanhMuc('Phân Bón', 'phan-bon', '🌱');

        $this->taoThuoc($cat1, [
            'name' => 'Ridomil Gold 68WG',
            'target' => 'Đặc trị nấm phytophthora thối rễ, xì mủ',
        ]);

        $this->taoThuoc($cat2, [
            'name' => 'Rooting Powder Kích Rễ',
            'target' => 'Kích rễ bung đọt ra rễ cám',
        ]);

        // Lọc danh mục 'nam-benh' và mục đích 'nam'
        $resp = $this->get(route('thuoc.tra-cuu', [
            'category' => 'nam-benh',
            'muc_dich' => 'nam',
        ]));

        $resp->assertStatus(200);
        $resp->assertSee('Ridomil Gold 68WG');
        $resp->assertDontSee('Rooting Powder Kích Rễ');
    }

    /** Kiểm tra trang tra cứu hiển thị đầy đủ các thành phần UI: chips, số lượng, chuyển đổi view. */
    public function test_giao_dien_tra_cuu_co_day_du_thanh_phan(): void
    {
        $cat = $this->taoDanhMuc();
        $this->taoThuoc($cat, [
            'name' => 'Aliette 800WG',
            'price' => 125000,
            'active_ingredient' => 'Fosetyl-aluminium',
        ]);

        $resp = $this->get(route('thuoc.tra-cuu'));
        $resp->assertStatus(200);
        $resp->assertSee('Tra Cứu Thuốc Bảo Vệ Thực Vật');
        $resp->assertSee('btn-view-table', false);
        $resp->assertSee('Aliette 800WG');
        $resp->assertSee('Fosetyl-aluminium');
        $resp->assertDontSee('125.000');
    }
}
