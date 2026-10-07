<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Pesticide;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Test cases cho module Quản lý Thuốc (ThuocController).
 */
class ThuocTest extends TestCase
{
    use RefreshDatabase;

    // =========================================================================
    // Setup helpers
    // =========================================================================

    private function taoDanhMuc(string $ten = 'Nhóm A'): Category
    {
        static $i = 0;
        $i++;
        return Category::create([
            'name'       => $ten,
            'slug'       => 'nhom-' . $i,
            'emoji'      => '🌿',
            'sort_order' => $i,
        ]);
    }

    private function taoThuoc(Category $cat, array $attrs = []): Pesticide
    {
        return Pesticide::create(array_merge([
            'category_id' => $cat->id,
            'name'        => 'Thuốc mẫu',
        ], $attrs));
    }

    // =========================================================================
    // TC-T01–T02: Trang danh sách thuốc
    // =========================================================================

    /** TC-T01 — Trang tra cứu thuốc (User view) trả về 200. */
    public function test_trang_danh_sach_thuoc_tra_ve_200(): void
    {
        $response = $this->get(route('thuoc.danh-sach'));

        $response->assertStatus(200);
        $response->assertSee('Tra Cứu Thuốc Bảo Vệ Thực Vật');
    }

    /** TC-T01b — Trang quản lý thuốc (Admin view) trả về 200. */
    public function test_trang_quan_ly_thuoc_admin_tra_ve_200(): void
    {
        $response = $this->get(route('thuoc.quan-ly'));

        $response->assertStatus(200);
        $response->assertSee('Quản lý thuốc BVTV');
    }

    /** TC-T02 — Trang tìm kiếm theo từ khóa → hiển thị thuốc khớp. */
    public function test_tim_kiem_thuoc_theo_tu_khoa(): void
    {
        $cat = $this->taoDanhMuc();
        $this->taoThuoc($cat, ['name' => 'MANCOZEB XANH']);
        $this->taoThuoc($cat, ['name' => 'LUMORDIE 500WP']);

        $response = $this->get(route('thuoc.danh-sach', ['q' => 'MANCOZEB']));

        $response->assertStatus(200);
        $response->assertSee('MANCOZEB XANH');
        $response->assertDontSee('LUMORDIE 500WP');
    }

    // =========================================================================
    // TC-T03–T04: Trang thêm thuốc
    // =========================================================================

    /** TC-T03 — Trang /thuoc/them-moi trả về 200. */
    public function test_trang_them_thuoc_tra_ve_200(): void
    {
        $response = $this->get(route('thuoc.them'));

        $response->assertStatus(200);
    }

    // =========================================================================
    // TC-T04–T06: Lưu thuốc mới (POST /thuoc)
    // =========================================================================

    /** TC-T04 — Lưu thuốc mới hợp lệ → redirect về trang xem, DB có bản ghi. */
    public function test_luu_thuoc_moi_thanh_cong(): void
    {
        $cat = $this->taoDanhMuc();

        $response = $this->post(route('thuoc.luu'), [
            'category_id' => $cat->id,
            'name'        => 'Norshield 86.2WG',
            'usage'       => 'Trị đốm lá',
            'crops'       => 'Lúa, cà phê',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('pesticides', ['name' => 'Norshield 86.2WG']);
    }

    /** TC-T05 — Lưu thuốc thiếu tên → redirect về form với lỗi. */
    public function test_luu_thuoc_thieu_ten_tra_loi_validation(): void
    {
        $cat = $this->taoDanhMuc();

        $response = $this->post(route('thuoc.luu'), [
            'category_id' => $cat->id,
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    /** TC-T06 — Lưu thuốc không có category_id → lỗi validation. */
    public function test_luu_thuoc_khong_co_danh_muc_tra_loi_validation(): void
    {
        $response = $this->post(route('thuoc.luu'), [
            'name' => 'Thuốc không danh mục',
        ]);

        $response->assertSessionHasErrors(['category_id']);
    }

    /** TC-T07 — Lưu thuốc với ảnh hợp lệ → ảnh lưu vào storage. */
    public function test_luu_thuoc_voi_anh_hop_le(): void
    {
        Storage::fake('public');
        $cat = $this->taoDanhMuc();

        $this->post(route('thuoc.luu'), [
            'category_id' => $cat->id,
            'name'        => 'Thuốc có ảnh',
            'image'       => UploadedFile::fake()->image('thuoc.jpg', 300, 300),
        ]);

        $thuoc = Pesticide::where('name', 'Thuốc có ảnh')->first();
        $this->assertNotNull($thuoc->image);
        Storage::disk('public')->assertExists($thuoc->image);
    }

    // =========================================================================
    // TC-T08: Xem chi tiết thuốc
    // =========================================================================

    /** TC-T08 — Trang chi tiết thuốc hiển thị tên thuốc. */
    public function test_xem_chi_tiet_thuoc(): void
    {
        $cat   = $this->taoDanhMuc();
        $thuoc = $this->taoThuoc($cat, ['name' => 'Thuốc xem chi tiết', 'usage' => 'Trị bệnh X']);

        $response = $this->get(route('thuoc.xem', $thuoc));

        $response->assertStatus(200);
        $response->assertSee('Thuốc xem chi tiết');
    }

    // =========================================================================
    // TC-T09–T10: Cập nhật thuốc (PUT /thuoc/{id})
    // =========================================================================

    /** TC-T09 — Cập nhật thuốc hợp lệ → DB thay đổi. */
    public function test_cap_nhat_thuoc_thanh_cong(): void
    {
        $cat   = $this->taoDanhMuc();
        $thuoc = $this->taoThuoc($cat);

        $response = $this->put(route('thuoc.cap-nhat', $thuoc), [
            'category_id' => $cat->id,
            'name'        => 'Thuốc đã cập nhật',
            'scroll_y'    => '1450',
        ]);

        $response->assertRedirect(route('thuoc.quan-ly', [
            'updated_id' => $thuoc->id,
            'scroll_y'   => '1450',
        ]));
        $this->assertDatabaseHas('pesticides', [
            'id'   => $thuoc->id,
            'name' => 'Thuốc đã cập nhật',
        ]);
    }

    /** TC-T10 — Cập nhật thuốc với xoa_anh=1 → ảnh cũ bị xóa. */
    public function test_cap_nhat_thuoc_xoa_anh(): void
    {
        Storage::fake('public');
        $cat  = $this->taoDanhMuc();
        $file = UploadedFile::fake()->image('old.jpg');
        $path = Storage::disk('public')->putFile('pesticides', $file);
        $thuoc = $this->taoThuoc($cat, ['image' => $path]);

        $this->put(route('thuoc.cap-nhat', $thuoc), [
            'category_id' => $cat->id,
            'name'        => $thuoc->name,
            'xoa_anh'     => '1',
        ]);

        Storage::disk('public')->assertMissing($path);
        $this->assertNull($thuoc->fresh()->image);
    }

    // =========================================================================
    // TC-T11: Xóa thuốc (DELETE /thuoc/{id})
    // =========================================================================

    /** TC-T11 — Xóa thuốc → bị xóa khỏi DB. */
    public function test_xoa_thuoc_thanh_cong(): void
    {
        $cat   = $this->taoDanhMuc();
        $thuoc = $this->taoThuoc($cat);

        $response = $this->delete(route('thuoc.xoa', $thuoc));

        $response->assertRedirect();
        $this->assertDatabaseMissing('pesticides', ['id' => $thuoc->id]);
    }

    // =========================================================================
    // TC-T12–T13: AJAX endpoints thuốc
    // =========================================================================

    /** TC-T12 — AJAX tìm kiếm → trả về JSON có danh sách thuốc. */
    public function test_ajax_tim_kiem_thuoc(): void
    {
        $cat = $this->taoDanhMuc();
        $this->taoThuoc($cat, ['name' => 'Thuốc ABC']);
        $this->taoThuoc($cat, ['name' => 'Thuốc XYZ']);

        $response = $this->getJson(route('ajax.tim-kiem', ['q' => 'ABC']));

        $response->assertStatus(200)
                 ->assertJsonPath('total', 1)
                 ->assertJsonFragment(['ten' => 'Thuốc ABC']);
    }

    /** TC-T13 — AJAX thêm nhanh → trả về 200, DB có bản ghi mới. */
    public function test_ajax_them_nhanh_thuoc(): void
    {
        $cat = $this->taoDanhMuc();

        $response = $this->postJson(route('ajax.them-nhanh'), [
            'category_id' => $cat->id,
            'name'        => 'Thuốc thêm nhanh',
            'usage'       => 'Trị sâu',
        ]);

        $response->assertStatus(200)
                 ->assertJson(['success' => true])
                 ->assertJsonPath('thuoc.ten', 'Thuốc thêm nhanh');

        $this->assertDatabaseHas('pesticides', ['name' => 'Thuốc thêm nhanh']);
    }

    /** TC-T14 — AJAX xóa đơn → thuốc bị xóa khỏi DB. */
    public function test_ajax_xoa_thuoc(): void
    {
        $cat   = $this->taoDanhMuc();
        $thuoc = $this->taoThuoc($cat, ['name' => 'Thuốc AJAX xóa']);

        $response = $this->deleteJson(route('ajax.xoa', $thuoc));

        $response->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseMissing('pesticides', ['id' => $thuoc->id]);
    }

    /** TC-T15 — AJAX xóa nhiều → tất cả bị xóa. */
    public function test_ajax_xoa_nhieu_thuoc(): void
    {
        $cat    = $this->taoDanhMuc();
        $thuoc1 = $this->taoThuoc($cat, ['name' => 'T1']);
        $thuoc2 = $this->taoThuoc($cat, ['name' => 'T2']);
        $thuoc3 = $this->taoThuoc($cat, ['name' => 'T3']);

        $response = $this->deleteJson(route('ajax.xoa-nhieu'), [
            'ids' => [$thuoc1->id, $thuoc2->id],
        ]);

        $response->assertOk()
                 ->assertJson(['success' => true, 'da_xoa' => 2]);

        $this->assertDatabaseMissing('pesticides', ['id' => $thuoc1->id]);
        $this->assertDatabaseMissing('pesticides', ['id' => $thuoc2->id]);
        $this->assertDatabaseHas('pesticides', ['id' => $thuoc3->id]);
    }

    // =========================================================================
    // TC-T16: Xuất CSV
    // =========================================================================

    /** TC-T16 — Xuất CSV → trả về StreamedResponse với Content-Type đúng. */
    public function test_xuat_csv_tra_ve_file(): void
    {
        $cat = $this->taoDanhMuc();
        $this->taoThuoc($cat, ['name' => 'Thuốc CSV']);

        $response = $this->get(route('thuoc.xuat-csv'));

        $response->assertStatus(200);
        $this->assertStringContainsString(
            'text/csv',
            $response->headers->get('Content-Type')
        );
    }

    /** TC-T17 — Tra cứu thuốc với category slug trả về 200 và truyền selectedCategorySlug. */
    public function test_tra_cuu_thuoc_voi_category_slug(): void
    {
        $cat = $this->taoDanhMuc('Phân bón gốc');
        $this->taoThuoc($cat, ['name' => 'NPK Đầu Trâu']);

        $response = $this->get(route('thuoc.tra-cuu', ['category' => $cat->slug]));

        $response->assertStatus(200);
        $response->assertViewHas('selectedCategorySlug', $cat->slug);
        $response->assertViewHas('selectedCategoryId', (string) $cat->id);
    }

    /** TC-T18 — AJAX tìm kiếm thuốc với category slug. */
    public function test_ajax_tim_kiem_thuoc_voi_category_slug(): void
    {
        $cat1 = $this->taoDanhMuc('Thuốc sâu');
        $cat2 = $this->taoDanhMuc('Thuốc bệnh');
        $this->taoThuoc($cat1, ['name' => 'Thuốc sâu A']);
        $this->taoThuoc($cat2, ['name' => 'Thuốc bệnh B']);

        $response = $this->getJson(route('ajax.tim-kiem', ['category' => $cat1->slug]));

        $response->assertStatus(200)
                 ->assertJsonPath('total', 1)
                 ->assertJsonFragment(['ten' => 'Thuốc sâu A'])
                 ->assertJsonMissing(['ten' => 'Thuốc bệnh B']);
    }

    /** TC-T19 — Xuất 1 cột tên sản phẩm ra file Excel/CSV. */
    public function test_xuat_ten_san_pham_1_cot_excel(): void
    {
        $cat = $this->taoDanhMuc();
        $this->taoThuoc($cat, ['name' => 'Thuốc Tên A']);
        $this->taoThuoc($cat, ['name' => 'Thuốc Tên B']);

        $response = $this->get(route('thuoc.xuat-ten'));

        $response->assertStatus(200);
        $this->assertStringContainsString('text/csv', $response->headers->get('Content-Type'));
        $this->assertStringContainsString('danh-sach-ten-san-pham-', $response->headers->get('Content-Disposition'));
    }

    /** TC-T20 — Cập nhật thuốc giữ nguyên bộ lọc và scroll_y khi chuyển hướng về trang quản lý. */
    public function test_cap_nhat_thuoc_giu_nguyen_bo_loc_va_scroll(): void
    {
        $cat = $this->taoDanhMuc();
        $thuoc = $this->taoThuoc($cat, ['name' => 'Thuốc Ban Đầu']);

        $response = $this->put(route('thuoc.cap-nhat', $thuoc), [
            'category_id'        => $cat->id,
            'name'               => 'Thuốc Đã Sửa',
            'scroll_y'           => 1450,
            'filter_q'           => 'mancozeb',
            'filter_category_id' => (string) $cat->id,
            'filter_has_image'   => 'no',
            'filter_sort'        => 'newest',
        ]);

        $response->assertRedirect(route('thuoc.quan-ly', [
            'updated_id'  => $thuoc->id,
            'scroll_y'    => 1450,
            'q'           => 'mancozeb',
            'category_id' => $cat->id,
            'has_image'   => 'no',
            'sort'        => 'newest',
        ]));
    }

    /** TC-T21 — Tìm kiếm theo tên sản phẩm chuẩn xác (ví dụ "15 15 15" khớp "15-15-15"). */
    public function test_tim_kiem_theo_ten_sp_chuan_xac(): void
    {
        $cat = $this->taoDanhMuc();
        $this->taoThuoc($cat, ['name' => 'Xô NPK 15-15-15 EDTA']);
        $this->taoThuoc($cat, ['name' => 'NPK 15.15.15 EDTA']);
        $this->taoThuoc($cat, ['name' => 'Thuốc Khác 150g']);

        $response = $this->getJson(route('ajax.tim-kiem', [
            'q' => '15 15 15',
            'search_by' => 'name',
        ]));

        $response->assertStatus(200)
                 ->assertJsonPath('total', 2)
                 ->assertJsonFragment(['ten' => 'Xô NPK 15-15-15 EDTA'])
                 ->assertJsonFragment(['ten' => 'NPK 15.15.15 EDTA'])
                 ->assertJsonMissing(['ten' => 'Thuốc Khác 150g']);
    }

    /** TC-T22 — Lọc sản phẩm theo mục đích (Rễ, Hoa, Nấm bệnh, Rệp...) */
    public function test_loc_thuoc_theo_muc_dich(): void
    {
        $catPhanBon = $this->taoDanhMuc('Phân bón lá');
        $catBenh = $this->taoDanhMuc('Thuốc trừ bệnh');
        $catSau = $this->taoDanhMuc('Thuốc sâu');

        $this->taoThuoc($catPhanBon, [
            'name' => 'Humic Kích Rễ Cực Mạnh',
            'target' => 'Kích rễ tơ bung trắng xóa, phục hồi bộ rễ sau thu hoạch',
        ]);

        $this->taoThuoc($catPhanBon, [
            'name' => '10.60.10 Tạo Mầm Hoa',
            'target' => 'Tạo mầm hoa cực mạnh, kích ra hoa đồng loạt',
        ]);

        $this->taoThuoc($catBenh, [
            'name' => 'Antracol Trừ Nấm',
            'target' => 'Đặc trị thán thư, nấm hồng do nấm gây hại',
        ]);

        $this->taoThuoc($catSau, [
            'name' => 'Mospilan Đặc Trị Rệp Sáp',
            'target' => 'Đặc trị rệp sáp, rầy xanh, bọ trĩ',
        ]);

        // 1. Lọc mục đích: rễ (muc_dich=re)
        $respRe = $this->get(route('thuoc.danh-sach', ['muc_dich' => 're']));
        $respRe->assertStatus(200)
               ->assertSee('Humic Kích Rễ Cực Mạnh')
               ->assertDontSee('10.60.10 Tạo Mầm Hoa');

        // 2. Lọc mục đích: hoa (muc_dich=hoa)
        $respHoa = $this->get(route('thuoc.danh-sach', ['muc_dich' => 'hoa']));
        $respHoa->assertStatus(200)
                ->assertSee('10.60.10 Tạo Mầm Hoa')
                ->assertDontSee('Humic Kích Rễ Cực Mạnh');

        // 3. Lọc mục đích: nấm (muc_dich=nam)
        $respNam = $this->get(route('thuoc.danh-sach', ['muc_dich' => 'nam']));
        $respNam->assertStatus(200)
                ->assertSee('Antracol Trừ Nấm')
                ->assertDontSee('Mospilan Đặc Trị Rệp Sáp');

        // 4. Lọc mục đích: rệp (muc_dich=rep)
        $respRep = $this->get(route('thuoc.danh-sach', ['muc_dich' => 'rep']));
        $respRep->assertStatus(200)
                ->assertSee('Mospilan Đặc Trị Rệp Sáp')
                ->assertDontSee('Humic Kích Rễ Cực Mạnh');
    }
}
