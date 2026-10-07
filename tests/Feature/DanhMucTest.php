<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Pesticide;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Test cases cho module Quản lý Danh Mục (DanhMucController).
 */
class DanhMucTest extends TestCase
{
    use RefreshDatabase;

    // =========================================================================
    // Setup helpers
    // =========================================================================

    private function taoDanhMuc(array $attrs = []): Category
    {
        return Category::create(array_merge([
            'name'       => 'Danh mục mẫu',
            'slug'       => 'danh-muc-mau',
            'emoji'      => '🌿',
            'sort_order' => 1,
        ], $attrs));
    }

    // =========================================================================
    // TC-DM01–DM02: Xem trang
    // =========================================================================

    /** TC-DM01 — Trang /danh-muc trả về 200 và tiêu đề đúng. */
    public function test_trang_danh_muc_tra_ve_200(): void
    {
        $response = $this->get(route('danhmuc.danh-sach'));

        $response->assertStatus(200);
        $response->assertSee('Quản lý danh mục');
    }

    /** TC-DM02 — Trang hiển thị danh mục đã tồn tại. */
    public function test_trang_hien_thi_danh_muc(): void
    {
        $this->taoDanhMuc(['name' => 'Thuốc trừ sâu', 'slug' => 'thuoc-tru-sau']);

        $response = $this->get(route('danhmuc.danh-sach'));

        $response->assertStatus(200);
        $response->assertSee('Thuốc trừ sâu');
    }

    // =========================================================================
    // TC-DM03–DM05: Thêm danh mục (AJAX POST /ajax/danh-muc)
    // =========================================================================

    /** TC-DM03 — Thêm danh mục mới → thành công, trả về 201. */
    public function test_them_danh_muc_thanh_cong(): void
    {
        $response = $this->postJson(route('ajax.danhmuc.them'), [
            'name'  => 'Nhóm thuốc mới',
            'emoji' => '🌱',
        ]);

        $response->assertStatus(201)
                 ->assertJson(['success' => true])
                 ->assertJsonPath('danh_muc.name', 'Nhóm thuốc mới');

        $this->assertDatabaseHas('categories', ['name' => 'Nhóm thuốc mới']);
    }

    /** TC-DM04 — Thêm danh mục trùng tên → 422. */
    public function test_them_danh_muc_trung_ten_tra_ve_422(): void
    {
        $this->taoDanhMuc(['name' => 'Thuốc trừ cỏ', 'slug' => 'thuoc-tru-co']);

        $response = $this->postJson(route('ajax.danhmuc.them'), [
            'name' => 'Thuốc trừ cỏ',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }

    /** TC-DM05 — Thêm danh mục không có tên → 422. */
    public function test_them_danh_muc_khong_ten_tra_ve_422(): void
    {
        $response = $this->postJson(route('ajax.danhmuc.them'), [
            'emoji' => '🌿',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }

    /** TC-DM06 — Thêm 2 danh mục cùng tên nhưng khác slug → slug tự tăng số. */
    public function test_slug_tu_dong_tang_khi_trung(): void
    {
        $this->postJson(route('ajax.danhmuc.them'), ['name' => 'Nhóm A']);
        $this->postJson(route('ajax.danhmuc.them'), ['name' => 'Nhom A']); // Sau khi slug thứ nhất là 'nhom-a'

        $slugs = Category::pluck('slug')->toArray();
        $this->assertCount(count(array_unique($slugs)), $slugs, 'Các slug phải là duy nhất');
    }

    // =========================================================================
    // TC-DM07–DM08: Cập nhật (AJAX PUT /ajax/danh-muc/{id})
    // =========================================================================

    /** TC-DM07 — Cập nhật tên danh mục → DB thay đổi. */
    public function test_cap_nhat_danh_muc_thanh_cong(): void
    {
        $cat = $this->taoDanhMuc();

        $response = $this->putJson(route('ajax.danhmuc.cap-nhat', $cat), [
            'name'  => 'Danh mục đã sửa',
            'emoji' => '🧪',
        ]);

        $response->assertOk()->assertJson(['success' => true]);

        $this->assertDatabaseHas('categories', [
            'id'   => $cat->id,
            'name' => 'Danh mục đã sửa',
        ]);
    }

    /** TC-DM08 — Cập nhật thành tên đã tồn tại (khác record) → 422. */
    public function test_cap_nhat_ten_trung_voi_danh_muc_khac_tra_422(): void
    {
        $cat1 = $this->taoDanhMuc(['name' => 'Danh mục 1', 'slug' => 'danh-muc-1']);
        $cat2 = $this->taoDanhMuc(['name' => 'Danh mục 2', 'slug' => 'danh-muc-2']);

        $response = $this->putJson(route('ajax.danhmuc.cap-nhat', $cat2), [
            'name' => 'Danh mục 1', // Trùng với cat1
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }

    // =========================================================================
    // TC-DM09–DM10: Xóa đơn (AJAX DELETE /ajax/danh-muc/{id})
    // =========================================================================

    /** TC-DM09 — Xóa danh mục rỗng → bị xóa. */
    public function test_xoa_danh_muc_thanh_cong(): void
    {
        $cat = $this->taoDanhMuc();

        $response = $this->deleteJson(route('ajax.danhmuc.xoa', $cat));

        $response->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseMissing('categories', ['id' => $cat->id]);
    }

    /** TC-DM10 — Xóa danh mục có thuốc → thuốc cũng bị xóa. */
    public function test_xoa_danh_muc_cung_xoa_thuoc_lien_quan(): void
    {
        $cat     = $this->taoDanhMuc();
        $pesticide = Pesticide::create(['category_id' => $cat->id, 'name' => 'Thuốc bị xóa theo']);

        $this->deleteJson(route('ajax.danhmuc.xoa', $cat))->assertOk();

        $this->assertDatabaseMissing('categories', ['id' => $cat->id]);
        $this->assertDatabaseMissing('pesticides', ['id' => $pesticide->id]);
    }

    // =========================================================================
    // TC-DM11: Xóa nhiều (AJAX DELETE /ajax/danh-muc-nhieu)
    // =========================================================================

    /** TC-DM11 — Xóa nhiều danh mục → tất cả bị xóa, trả về đúng số lượng. */
    public function test_xoa_nhieu_danh_muc_thanh_cong(): void
    {
        $cat1 = $this->taoDanhMuc(['name' => 'DM 1', 'slug' => 'dm-1']);
        $cat2 = $this->taoDanhMuc(['name' => 'DM 2', 'slug' => 'dm-2']);
        $cat3 = $this->taoDanhMuc(['name' => 'DM 3', 'slug' => 'dm-3']);

        $response = $this->deleteJson(route('ajax.danhmuc.xoa-nhieu'), [
            'ids' => [$cat1->id, $cat2->id],
        ]);

        $response->assertOk()
                 ->assertJson(['success' => true, 'da_xoa' => 2]);

        $this->assertDatabaseMissing('categories', ['id' => $cat1->id]);
        $this->assertDatabaseMissing('categories', ['id' => $cat2->id]);
        $this->assertDatabaseHas('categories', ['id' => $cat3->id]);
    }

    // =========================================================================
    // TC-DM12: Xem chi tiết danh mục
    // =========================================================================

    /** TC-DM12 — Xem trang chi tiết danh mục theo slug → hiển thị đúng tên. */
    public function test_xem_chi_tiet_danh_muc_theo_slug(): void
    {
        $cat = $this->taoDanhMuc(['name' => 'Nhóm đặc biệt', 'slug' => 'nhom-dac-biet']);

        $response = $this->get(route('danhmuc.xem', 'nhom-dac-biet'));

        $response->assertStatus(200);
        $response->assertSee('Nhóm đặc biệt');
    }

    /** TC-DM13 — Xem chi tiết danh mục với slug không tồn tại → 404. */
    public function test_xem_danh_muc_slug_khong_ton_tai_tra_404(): void
    {
        $response = $this->get(route('danhmuc.xem', 'slug-khong-ton-tai'));

        $response->assertStatus(404);
    }
}
