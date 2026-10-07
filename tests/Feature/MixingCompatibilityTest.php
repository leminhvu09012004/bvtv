<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Pesticide;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MixingCompatibilityTest extends TestCase
{
    use RefreshDatabase;

    private function taoDanhMuc(string $ten = 'Thuốc trừ bệnh', string $slug = 'thuoc-tru-benh'): Category
    {
        return Category::create([
            'name' => $ten,
            'slug' => $slug,
            'emoji' => '🧪',
            'sort_order' => 1,
        ]);
    }

    /** Test: Trang tra cứu kỵ phối trộn trả về 200 và có đầy đủ các khối chức năng. */
    public function test_trang_ky_phoi_tron_tra_ve_200_va_co_day_du_thanh_phan(): void
    {
        $cat = $this->taoDanhMuc();
        Pesticide::create([
            'category_id' => $cat->id,
            'name' => 'Thuốc Test A',
            'active_ingredient' => 'Hexaconazole',
        ]);

        $resp = $this->get(route('phoi-tron.index'));
        $resp->assertStatus(200);
        $resp->assertSee('Tra Cứu Tương Kỵ');
        $resp->assertSee('Công Cụ Kiểm Tra Phối Trộn Trực Quan');
        $resp->assertSee('Bảng Ma Trận Tương Kỵ Các Nhóm Hợp Chất Nông Nghiệp');
        $resp->assertSee('Quy Trình Thử Nghiệm Cốc Nước (Jar Test)');
        $resp->assertSee('Thuốc Test A');
    }

    /** Test: AJAX phân tích phát hiện cấm kỵ giữa Dầu khoáng và Lưu huỳnh (Sulfur). */
    public function test_ajax_kiem_tra_cap_dau_khoang_va_luu_huynh_tra_ve_cam_ky(): void
    {
        $catSau = $this->taoDanhMuc('Thuốc trừ sâu', 'thuoc-tru-sau');
        $catBenh = $this->taoDanhMuc('Thuốc trừ bệnh', 'thuoc-tru-benh');

        $dauKhoang = Pesticide::create([
            'category_id' => $catSau->id,
            'name' => 'Dầu khoáng SK Enspray 99EC',
            'active_ingredient' => 'Petroleum spray oil 99%',
            'form_type' => 'EC',
        ]);

        $luuHuynh = Pesticide::create([
            'category_id' => $catBenh->id,
            'name' => 'Thiovit 80WG Lưu Huỳnh Tinh Khiết',
            'active_ingredient' => 'Sulfur 80%',
            'form_type' => 'WG',
        ]);

        $resp = $this->postJson(route('ajax.kiem-tra-phoi-tron'), [
            'ids' => [$dauKhoang->id, $luuHuynh->id],
        ]);

        $resp->assertStatus(200);
        $resp->assertJsonPath('success', true);
        $resp->assertJsonPath('data.status', 'danger');
        $this->assertStringContainsString('Dầu khoáng + Lưu huỳnh', json_encode($resp->json(), JSON_UNESCAPED_UNICODE));
    }

    /** Test: AJAX phân tích phát hiện cấm kỵ giữa Gốc đồng vô cơ và Chế phẩm Vi sinh. */
    public function test_ajax_kiem_tra_goc_dong_va_vi_sinh_tra_ve_cam_ky(): void
    {
        $catBenh = $this->taoDanhMuc('Thuốc trừ bệnh', 'thuoc-tru-benh');
        $catViSinh = $this->taoDanhMuc('Chế phẩm vi sinh', 'che-pham-vi-sinh');

        $dongDo = Pesticide::create([
            'category_id' => $catBenh->id,
            'name' => 'Norshield 86.2WG Đồng Đỏ',
            'active_ingredient' => 'Cuprous oxide',
            'form_type' => 'WG',
        ]);

        $tricho = Pesticide::create([
            'category_id' => $catViSinh->id,
            'name' => 'Trichoderma Nấm Đối Kháng',
            'active_ingredient' => 'Trichoderma harzianum',
            'form_type' => 'WP',
        ]);

        $resp = $this->postJson(route('ajax.kiem-tra-phoi-tron'), [
            'ids' => [$dongDo->id, $tricho->id],
        ]);

        $resp->assertStatus(200);
        $resp->assertJsonPath('success', true);
        $resp->assertJsonPath('data.status', 'danger');
        $this->assertStringContainsString('Gốc Đồng vô cơ + Chế phẩm Vi sinh vật', json_encode($resp->json(), JSON_UNESCAPED_UNICODE));
    }

    /** Test: AJAX phân tích phát hiện cấm kỵ giữa Canxi cao và MKP Lân cao (kết tủa). */
    public function test_ajax_kiem_tra_canxi_va_mkp_tra_ve_cam_ky(): void
    {
        $catPhan = $this->taoDanhMuc('Phân bón lá', 'phan-bon-la');

        $canxi = Pesticide::create([
            'category_id' => $catPhan->id,
            'name' => 'Canxi Bo Sữa Bo Chelate',
            'active_ingredient' => 'Canxi (CaO) 15%, Bo 2000ppm',
        ]);

        $mkp = Pesticide::create([
            'category_id' => $catPhan->id,
            'name' => 'MKP 0-52-34 Chặn Đọt Tạo Mầm',
            'active_ingredient' => 'Lân hữu hiệu 52%, Kali 34%',
        ]);

        $resp = $this->postJson(route('ajax.kiem-tra-phoi-tron'), [
            'ids' => [$canxi->id, $mkp->id],
        ]);

        $resp->assertStatus(200);
        $resp->assertJsonPath('success', true);
        $resp->assertJsonPath('data.status', 'danger');
        $this->assertStringContainsString('Canxi cao + Lân cao', json_encode($resp->json(), JSON_UNESCAPED_UNICODE));
    }

    /** Test: AJAX phân tích cảnh báo khi trộn 2 thuốc cùng nhóm Triazole FRAC 3. */
    public function test_ajax_kiem_tra_trung_nhom_triazole_tra_ve_canh_bao(): void
    {
        $catBenh = $this->taoDanhMuc('Thuốc trừ bệnh', 'thuoc-tru-benh');

        $anvil = Pesticide::create([
            'category_id' => $catBenh->id,
            'name' => 'Anvil 5SC',
            'active_ingredient' => 'Hexaconazole 50g/l',
            'form_type' => 'SC',
        ]);

        $score = Pesticide::create([
            'category_id' => $catBenh->id,
            'name' => 'Score 250EC',
            'active_ingredient' => 'Difenoconazole 250g/l',
            'form_type' => 'EC',
        ]);

        $resp = $this->postJson(route('ajax.kiem-tra-phoi-tron'), [
            'ids' => [$anvil->id, $score->id],
        ]);

        $resp->assertStatus(200);
        $resp->assertJsonPath('success', true);
        $resp->assertJsonPath('data.status', 'warning');
        $this->assertStringContainsString('Triazole', json_encode($resp->json(), JSON_UNESCAPED_UNICODE));
    }

    /** Test: Trang chi tiết thuốc hiển thị khối tương kỵ và gợi ý phối cộng lực. */
    public function test_trang_chi_tiet_thuoc_hien_thi_dung_khoi_tuong_ky(): void
    {
        $cat = $this->taoDanhMuc('Thuốc trừ bệnh', 'thuoc-tru-benh');
        $thuoc = Pesticide::create([
            'category_id' => $cat->id,
            'name' => 'Norshield 86.2WG Đồng Đỏ',
            'active_ingredient' => 'Cuprous oxide',
            'water_volume' => '400 lít',
        ]);

        $resp = $this->get(route('thuoc.xem', $thuoc));
        $resp->assertStatus(200);
        $resp->assertSee('Lưu Ý Phối Trộn');
        $resp->assertSee('Tuyệt đối không phối với các nhóm sau:');
        $resp->assertSee('Thử phối thuốc này');
    }

    /** Test: AJAX kiểm tra danh mục Thuốc trừ cỏ với danh mục khác trả về cấm kỵ tuyệt đối. */
    public function test_ajax_kiem_tra_danh_muc_thuoc_tru_co_tra_ve_cam_ky(): void
    {
        $catCo = $this->taoDanhMuc('Thuốc trừ cỏ', 'thuoc-tru-co');
        $catPhan = $this->taoDanhMuc('Phân bón lá', 'phan-bon-la');

        $thuocCo = Pesticide::create([
            'category_id' => $catCo->id,
            'name' => 'Glufosinate Cháy Nhanh',
            'active_ingredient' => 'Glufosinate ammonium',
        ]);

        $phanBon = Pesticide::create([
            'category_id' => $catPhan->id,
            'name' => 'Đầu Trâu MKP',
            'active_ingredient' => 'Lân cao',
        ]);

        $resp = $this->postJson(route('ajax.kiem-tra-phoi-tron-danh-muc'), [
            'cat1_id' => $catCo->id,
            'cat2_id' => $catPhan->id,
        ]);

        $resp->assertStatus(200);
        $resp->assertJsonPath('success', true);
        $resp->assertJsonPath('data.status', 'danger');
        $this->assertStringContainsString('Thuốc trừ cỏ tuyệt đối không bao giờ được pha chung', json_encode($resp->json(), JSON_UNESCAPED_UNICODE));
        $this->assertNotEmpty($resp->json('html'));
    }

    /** Test: AJAX kiểm tra Vi sinh và Trừ bệnh phát hiện xung đột giữa nấm đối kháng và gốc đồng. */
    public function test_ajax_kiem_tra_danh_muc_vi_sinh_va_tru_benh_co_san_pham_xung_dot(): void
    {
        $catViSinh = $this->taoDanhMuc('Chế phẩm vi sinh', 'che-pham-vi-sinh');
        $catBenh = $this->taoDanhMuc('Thuốc trừ bệnh', 'thuoc-tru-benh');

        $tricho = Pesticide::create([
            'category_id' => $catViSinh->id,
            'name' => 'Trichoderma Điền Trang',
            'active_ingredient' => 'Trichoderma spp.',
        ]);

        $dong = Pesticide::create([
            'category_id' => $catBenh->id,
            'name' => 'Coc 85WP Đồng Vô Cơ',
            'active_ingredient' => 'Copper Oxychloride',
        ]);

        $resp = $this->postJson(route('ajax.kiem-tra-phoi-tron-danh-muc'), [
            'cat1_id' => $catViSinh->id,
            'cat2_id' => $catBenh->id,
        ]);

        $resp->assertStatus(200);
        $resp->assertJsonPath('success', true);
        $resp->assertJsonPath('data.status', 'danger');
        $this->assertGreaterThan(0, $resp->json('data.total_conflicts'));
        $this->assertStringContainsString('Trichoderma Điền Trang', $resp->json('html'));
        $this->assertStringContainsString('Coc 85WP Đồng Vô Cơ', $resp->json('html'));
    }

    /** Test: Trang chi tiết danh mục hiển thị khối cảnh báo tương kỵ phối trộn. */
    public function test_trang_chi_tiet_danh_muc_hien_thi_canh_bao_phoi_tron(): void
    {
        $catViSinh = $this->taoDanhMuc('Chế phẩm vi sinh', 'che-pham-vi-sinh');
        $catBenh = $this->taoDanhMuc('Thuốc trừ bệnh', 'thuoc-tru-benh');

        Pesticide::create([
            'category_id' => $catViSinh->id,
            'name' => 'Trichoderma Vi Sinh',
            'active_ingredient' => 'Trichoderma harzianum',
        ]);

        Pesticide::create([
            'category_id' => $catBenh->id,
            'name' => 'Norshield Đồng Đỏ',
            'active_ingredient' => 'Cuprous oxide',
        ]);

        $resp = $this->get(route('danhmuc.xem', $catViSinh->slug));
        $resp->assertStatus(200);
        $resp->assertSee('Cảnh Báo Phối Trộn: Danh mục này không được trộn với những danh mục nào?');
        $resp->assertSee('Thuốc trừ bệnh');
    }

    /** Test: Trang phối trộn nhận param cat1 & cat2 hiển thị tab danh mục và kết quả ngay. */
    public function test_trang_phoi_tron_nhan_param_cat1_va_cat2_hien_thi_ket_qua_danh_muc(): void
    {
        $cat1 = $this->taoDanhMuc('Thuốc trừ cỏ', 'thuoc-tru-co');
        $cat2 = $this->taoDanhMuc('Phân bón lá', 'phan-bon-la');

        Pesticide::create([
            'category_id' => $cat1->id,
            'name' => 'Thuốc Diệt Cỏ Cháy',
            'active_ingredient' => 'Paraquat/Diquat',
        ]);

        Pesticide::create([
            'category_id' => $cat2->id,
            'name' => 'Phân Bón NPK 30-10-10',
            'active_ingredient' => 'NPK cao đạm',
        ]);

        $resp = $this->get(route('phoi-tron.index', ['cat1' => $cat1->id, 'cat2' => $cat2->id]));
        $resp->assertStatus(200);
        $resp->assertSee('CẢNH BÁO NGUY CẤP: Thuốc trừ cỏ tuyệt đối không bao giờ được pha chung');
        $resp->assertSee('Thuốc Diệt Cỏ Cháy');
    }
}
