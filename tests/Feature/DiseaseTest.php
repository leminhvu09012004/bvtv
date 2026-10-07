<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * Test cases cho module Quản lý Bệnh (DiseaseController).
 *
 * Bao gồm: xem trang, thêm, cập nhật, xóa đơn, xóa nhiều (AJAX).
 */
class DiseaseTest extends TestCase
{
    use RefreshDatabase;

    // =========================================================================
    // Setup helpers
    // =========================================================================

    /** Tạo một danh mục + một thuốc dùng chung trong các test. */
    private function taoThuoc(string $ten = 'Thuốc A'): Pesticide
    {
        $cat = Category::firstOrCreate(
            ['slug' => 'danh-muc-test'],
            [
                'name'       => 'Danh mục test',
                'emoji'      => '🌿',
                'sort_order' => 1,
            ]
        );

        return Pesticide::create([
            'category_id' => $cat->id,
            'name'        => $ten,
        ]);
    }

    /** Tạo một bệnh mẫu. */
    private function taoBenh(array $attrs = []): Disease
    {
        return Disease::create(array_merge([
            'name'  => 'Bệnh đạo ôn',
            'notes' => 'Ghi chú mẫu',
        ], $attrs));
    }

    // =========================================================================
    // TC-D01: Xem trang danh sách bệnh
    // =========================================================================

    /** TC-D01 — Trang /benh trả về HTTP 200 và có tiêu đề đúng. */
    public function test_trang_danh_sach_benh_tra_ve_200(): void
    {
        $response = $this->get(route('benh.danh-sach'));

        $response->assertStatus(200);
        $response->assertSee('Các bài thuốc');
    }

    /** TC-D02 — Trang hiển thị bệnh đã có trong DB. */
    public function test_trang_hien_thi_danh_sach_benh(): void
    {
        $this->taoBenh(['name' => 'Bệnh vàng lá']);

        $response = $this->get(route('benh.danh-sach'));

        $response->assertStatus(200);
        $response->assertSee('Bệnh vàng lá');
    }

    /** TC-D02b — Trang Quản lý bài thuốc (Admin) trả về HTTP 200 và có chức năng CRUD. */
    public function test_trang_quan_ly_benh_admin_tra_ve_200(): void
    {
        $this->taoBenh(['name' => 'Bệnh đốm mắt cua']);

        $response = $this->get(route('benh.quan-ly'));

        $response->assertStatus(200);
        $response->assertSee('Quản lý bài thuốc');
        $response->assertSee('Thêm bệnh mới');
        $response->assertSee('Bệnh đốm mắt cua');
    }

    // =========================================================================
    // TC-D03–D05: Thêm bệnh (AJAX POST /ajax/benh)
    // =========================================================================

    /** TC-D03 — Thêm bệnh mới không có thuốc, không có ảnh → thành công. */
    public function test_them_benh_khong_co_thuoc_thanh_cong(): void
    {
        $response = $this->postJson(route('ajax.benh.them'), [
            'name'  => 'Bệnh thán thư',
            'notes' => 'Lá bị đốm nâu',
        ]);

        $response->assertStatus(201)
                 ->assertJson(['success' => true])
                 ->assertJsonPath('benh.name', 'Bệnh thán thư');

        $this->assertDatabaseHas('diseases', ['name' => 'Bệnh thán thư']);
    }

    /** TC-D04 — Thêm bệnh kèm danh sách thuốc → bảng pivot được ghi đúng. */
    public function test_them_benh_voi_thuoc_tao_pivot_dung(): void
    {
        $thuoc1 = $this->taoThuoc('Thuốc X');
        $thuoc2 = Pesticide::create(['category_id' => $thuoc1->category_id, 'name' => 'Thuốc Y']);

        $response = $this->postJson(route('ajax.benh.them'), [
            'name'          => 'Bệnh đốm lá',
            'pesticide_ids' => [$thuoc1->id, $thuoc2->id],
        ]);

        $response->assertStatus(201)->assertJson(['success' => true]);

        $benh = Disease::where('name', 'Bệnh đốm lá')->first();
        $this->assertNotNull($benh);
        $this->assertCount(2, $benh->pesticides);
        $this->assertTrue($benh->pesticides->contains($thuoc1));
        $this->assertTrue($benh->pesticides->contains($thuoc2));
    }

    /** TC-D05 — Thêm bệnh trùng tên → lỗi validation 422. */
    public function test_them_benh_trung_ten_tra_ve_422(): void
    {
        $this->taoBenh(['name' => 'Bệnh ghẻ lúa']);

        $response = $this->postJson(route('ajax.benh.them'), [
            'name' => 'Bệnh ghẻ lúa',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }

    /** TC-D06 — Thêm bệnh không có tên → lỗi validation 422. */
    public function test_them_benh_thieu_ten_tra_ve_422(): void
    {
        $response = $this->postJson(route('ajax.benh.them'), [
            'notes' => 'Ghi chú không có tên',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name']);
    }

    /** TC-D07 — Thêm bệnh có ảnh → ảnh được lưu vào storage. */
    public function test_them_benh_voi_anh_luu_vao_storage(): void
    {
        Storage::fake('public');

        $response = $this->postJson(route('ajax.benh.them'), [
            'name'  => 'Bệnh rỉ sắt',
            'image' => UploadedFile::fake()->image('benh.jpg', 200, 200),
        ]);

        $response->assertStatus(201)->assertJson(['success' => true]);

        $benh = Disease::where('name', 'Bệnh rỉ sắt')->first();
        $this->assertNotNull($benh->image);
        Storage::disk('public')->assertExists($benh->image);
    }

    // =========================================================================
    // TC-D08–D10: Cập nhật bệnh (AJAX POST /ajax/benh/{id})
    // =========================================================================

    /** TC-D08 — Cập nhật tên và ghi chú → DB được cập nhật. */
    public function test_cap_nhat_benh_thanh_cong(): void
    {
        $benh = $this->taoBenh();

        $response = $this->postJson(route('ajax.benh.cap-nhat', $benh), [
            'name'  => 'Bệnh đạo ôn (cập nhật)',
            'notes' => 'Ghi chú mới',
        ]);

        $response->assertOk()->assertJson(['success' => true]);

        $this->assertDatabaseHas('diseases', [
            'id'    => $benh->id,
            'name'  => 'Bệnh đạo ôn (cập nhật)',
            'notes' => 'Ghi chú mới',
        ]);
    }

    /** TC-D09 — Cập nhật danh sách thuốc → pivot được đồng bộ lại. */
    public function test_cap_nhat_benh_dong_bo_thuoc(): void
    {
        $thuoc1 = $this->taoThuoc('Thuốc A');
        $thuoc2 = Pesticide::create(['category_id' => $thuoc1->category_id, 'name' => 'Thuốc B']);
        $benh   = $this->taoBenh();
        $benh->pesticides()->attach($thuoc1->id);

        // Cập nhật: chỉ giữ thuoc2, bỏ thuoc1
        $response = $this->postJson(route('ajax.benh.cap-nhat', $benh), [
            'name'          => $benh->name,
            'pesticide_ids' => [$thuoc2->id],
        ]);

        $response->assertOk()->assertJson(['success' => true]);

        $benh->refresh()->load('pesticides');
        $this->assertCount(1, $benh->pesticides);
        $this->assertTrue($benh->pesticides->contains($thuoc2));
        $this->assertFalse($benh->pesticides->contains($thuoc1));
    }

    /** TC-D10 — Cập nhật với xoa_anh=1 → ảnh cũ bị xóa khỏi storage. */
    public function test_cap_nhat_benh_xoa_anh(): void
    {
        Storage::fake('public');

        // Tạo bệnh có ảnh
        $file = UploadedFile::fake()->image('old.jpg');
        $path = Storage::disk('public')->putFile('diseases', $file);
        $benh = $this->taoBenh(['image' => $path]);

        $response = $this->postJson(route('ajax.benh.cap-nhat', $benh), [
            'name'    => $benh->name,
            'xoa_anh' => '1',
        ]);

        $response->assertOk()->assertJson(['success' => true]);

        Storage::disk('public')->assertMissing($path);
        $this->assertNull($benh->fresh()->image);
    }

    // =========================================================================
    // TC-D11–D12: Xóa đơn (AJAX DELETE /ajax/benh/{id})
    // =========================================================================

    /** TC-D11 — Xóa bệnh → bị xóa khỏi DB và pivot. */
    public function test_xoa_benh_thanh_cong(): void
    {
        $thuoc = $this->taoThuoc();
        $benh  = $this->taoBenh();
        $benh->pesticides()->attach($thuoc->id);

        $response = $this->deleteJson(route('ajax.benh.xoa', $benh));

        $response->assertOk()->assertJson(['success' => true]);

        $this->assertDatabaseMissing('diseases', ['id' => $benh->id]);
        $this->assertDatabaseMissing('disease_pesticide', ['disease_id' => $benh->id]);
    }

    /** TC-D12 — Xóa bệnh có ảnh → ảnh bị xóa khỏi storage. */
    public function test_xoa_benh_xoa_anh_trong_storage(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('benh.jpg');
        $path = Storage::disk('public')->putFile('diseases', $file);
        $benh = $this->taoBenh(['image' => $path]);

        $this->deleteJson(route('ajax.benh.xoa', $benh))->assertOk();

        Storage::disk('public')->assertMissing($path);
    }

    // =========================================================================
    // TC-D13: Xóa nhiều bệnh (AJAX DELETE /ajax/benh-nhieu)
    // =========================================================================

    /** TC-D13 — Xóa nhiều bệnh → tất cả bị xóa khỏi DB. */
    public function test_xoa_nhieu_benh_thanh_cong(): void
    {
        $benh1 = $this->taoBenh(['name' => 'Bệnh 1']);
        $benh2 = $this->taoBenh(['name' => 'Bệnh 2']);
        $benh3 = $this->taoBenh(['name' => 'Bệnh 3']);

        $response = $this->deleteJson(route('ajax.benh.xoa-nhieu'), [
            'ids' => [$benh1->id, $benh2->id],
        ]);

        $response->assertOk()
                 ->assertJson(['success' => true, 'da_xoa' => 2]);

        $this->assertDatabaseMissing('diseases', ['id' => $benh1->id]);
        $this->assertDatabaseMissing('diseases', ['id' => $benh2->id]);
        $this->assertDatabaseHas('diseases', ['id' => $benh3->id]); // Không bị xóa
    }

    /** TC-D14 — Xóa nhiều bệnh không truyền ids → 422. */
    public function test_xoa_nhieu_benh_khong_ids_tra_ve_422(): void
    {
        $response = $this->deleteJson(route('ajax.benh.xoa-nhieu'), []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['ids']);
    }

    // =========================================================================
    // TC-D15–D18: Nhiều ảnh & Chi tiết Triệu chứng, Phòng bệnh, Điều trị
    // =========================================================================

    /** TC-D15 — Thêm bệnh có nhiều ảnh và đầy đủ triệu chứng, phòng bệnh, điều trị. */
    public function test_them_benh_voi_nhieu_anh_va_thong_tin_chi_tiet(): void
    {
        Storage::fake('public');

        $img1 = UploadedFile::fake()->image('anh1.jpg', 200, 200);
        $img2 = UploadedFile::fake()->image('anh2.jpg', 200, 200);

        $response = $this->postJson(route('ajax.benh.them'), [
            'name'       => 'Bệnh xì mủ sầu riêng',
            'symptoms'   => 'Nứt thân, chảy nhựa màu nâu đỏ',
            'prevention' => 'Đắp mô cao, quét vôi hàng năm',
            'treatment'  => 'Cạo sạch vỏ bệnh và quét thuốc lưu dẫn',
            'notes'      => 'Ghi chú thêm',
            'images'     => [$img1, $img2],
        ]);

        $response->assertStatus(201)
                 ->assertJson(['success' => true])
                 ->assertJsonPath('benh.name', 'Bệnh xì mủ sầu riêng');

        $benh = Disease::where('name', 'Bệnh xì mủ sầu riêng')->first();
        $this->assertNotNull($benh);
        $this->assertEquals('Nứt thân, chảy nhựa màu nâu đỏ', $benh->symptoms);
        $this->assertEquals('Đắp mô cao, quét vôi hàng năm', $benh->prevention);
        $this->assertEquals('Cạo sạch vỏ bệnh và quét thuốc lưu dẫn', $benh->treatment);

        $this->assertIsArray($benh->images);
        $this->assertCount(2, $benh->images);
        $this->assertEquals($benh->images[0], $benh->image);

        Storage::disk('public')->assertExists($benh->images[0]);
        Storage::disk('public')->assertExists($benh->images[1]);
    }

    /** TC-D16 — Cập nhật bệnh: xóa 1 ảnh cũ, thêm 1 ảnh mới, cập nhật nội dung chi tiết. */
    public function test_cap_nhat_benh_voi_nhieu_anh_va_xoa_anh_cu(): void
    {
        Storage::fake('public');

        $fileA = UploadedFile::fake()->image('fileA.jpg');
        $fileB = UploadedFile::fake()->image('fileB.jpg');
        $pathA = Storage::disk('public')->putFile('diseases', $fileA);
        $pathB = Storage::disk('public')->putFile('diseases', $fileB);

        $benh = $this->taoBenh([
            'name'       => 'Bệnh nấm rễ',
            'image'      => $pathA,
            'images'     => [$pathA, $pathB],
            'symptoms'   => 'Triệu chứng ban đầu',
            'prevention' => 'Phòng ngừa ban đầu',
            'treatment'  => 'Điều trị ban đầu',
        ]);

        // Giữ lại pathB, bỏ pathA, thêm fileC
        $fileC = UploadedFile::fake()->image('fileC.jpg');

        $response = $this->postJson(route('ajax.benh.cap-nhat', $benh), [
            'name'            => 'Bệnh nấm rễ cập nhật',
            'symptoms'        => 'Triệu chứng mới',
            'prevention'      => 'Phòng bệnh mới',
            'treatment'       => 'Điều trị mới',
            'existing_images' => [$pathB],
            'images'          => [$fileC],
        ]);

        $response->assertOk()->assertJson(['success' => true]);

        // pathA phải bị xóa khỏi disk
        Storage::disk('public')->assertMissing($pathA);
        // pathB vẫn còn
        Storage::disk('public')->assertExists($pathB);

        $benh->refresh();
        $this->assertCount(2, $benh->images);
        $this->assertContains($pathB, $benh->images);
        $this->assertEquals('Triệu chứng mới', $benh->symptoms);
        $this->assertEquals('Phòng bệnh mới', $benh->prevention);
        $this->assertEquals('Điều trị mới', $benh->treatment);
    }

    /** TC-D17 — Xóa bệnh có mảng nhiều ảnh → toàn bộ ảnh trong disk bị xóa. */
    public function test_xoa_benh_nhieu_anh_xoa_toan_bo_khoi_storage(): void
    {
        Storage::fake('public');

        $file1 = UploadedFile::fake()->image('img1.jpg');
        $file2 = UploadedFile::fake()->image('img2.jpg');
        $path1 = Storage::disk('public')->putFile('diseases', $file1);
        $path2 = Storage::disk('public')->putFile('diseases', $file2);

        $benh = $this->taoBenh([
            'image'  => $path1,
            'images' => [$path1, $path2],
        ]);

        $this->deleteJson(route('ajax.benh.xoa', $benh))->assertOk();

        Storage::disk('public')->assertMissing($path1);
        Storage::disk('public')->assertMissing($path2);
    }

    /** TC-D18 — Trang tra cứu hiển thị chi tiết triệu chứng, phòng bệnh và điều trị. */
    public function test_trang_tra_cuu_hien_thi_tri_eu_chung_phong_benh_dieu_tri(): void
    {
        $this->taoBenh([
            'name'       => 'Bệnh nấm quả',
            'symptoms'   => 'Vết đốm tròn trên vỏ quả',
            'prevention' => 'Bao trái sớm',
            'treatment'  => 'Phun thuốc gốc đồng',
        ]);

        $response = $this->get(route('benh.danh-sach'));

        $response->assertStatus(200);
        $response->assertSee('Bệnh nấm quả');
        $response->assertSee('1.1. Triệu chứng');
        $response->assertSee('Vết đốm tròn trên vỏ quả');
        $response->assertSee('1.2. Cách phòng bệnh');
        $response->assertSee('Bao trái sớm');
        $response->assertSee('1.3. Cách điều trị');
        $response->assertSee('Phun thuốc gốc đồng');
    }

    /** TC-D19 — Thêm bệnh kèm nhiều combo phác đồ điều trị tùy chọn. */
    public function test_them_benh_kem_cac_combo_phac_do_tuy_y(): void
    {
        $thuoc1 = $this->taoThuoc('Thuốc Trừ Nấm X');
        $thuoc2 = $this->taoThuoc('Kháng Sinh Y');

        $combos = [
            [
                'title'        => 'Combo 1: Cặp đôi thần tốc',
                'badge'        => 'Cặp đôi phối hợp',
                'stage'        => 'Giai đoạn cơi đọt non',
                'dosage_guide' => 'Pha 1 chai X + 1 gói Y cho 400L nước',
                'safety_note'  => 'Không phối hợp gốc đồng',
                'groups'       => [
                    [
                        'label'                => 'Thuốc trừ nấm',
                        'primary_pesticide_id' => $thuoc1->id,
                        'substitute_ids'       => [],
                    ],
                    [
                        'label'                => 'Kháng sinh vi khuẩn',
                        'primary_pesticide_id' => $thuoc2->id,
                        'substitute_ids'       => [],
                    ],
                ],
            ],
            [
                'title'        => 'Combo 2: Phun rửa vườn cành già',
                'badge'        => 'Phun đơn',
                'stage'        => 'Sau thu hoạch',
                'dosage_guide' => 'Pha 500g cho 200L nước',
                'safety_note'  => 'Phun ướt đẫm thân cành',
                'groups'       => [
                    [
                        'label'                => 'Sát khuẩn mạnh',
                        'primary_pesticide_id' => $thuoc1->id,
                        'substitute_ids'       => [],
                    ],
                ],
            ],
        ];

        $response = $this->postJson(route('ajax.benh.them'), [
            'name'            => 'Bệnh rỉ sắt',
            'treatment_plans' => json_encode($combos),
        ]);

        $response->assertStatus(201);
        $benh = Disease::where('name', 'Bệnh rỉ sắt')->first();
        $this->assertNotNull($benh);
        $this->assertCount(2, $benh->treatment_plans);
        $this->assertEquals('Combo 1: Cặp đôi thần tốc', $benh->treatment_plans[0]['title']);
        $this->assertEquals('Combo 2: Phun rửa vườn cành già', $benh->treatment_plans[1]['title']);
        // Verify pesticides automatically linked in Many-to-Many
        $this->assertTrue($benh->pesticides->contains($thuoc1->id));
        $this->assertTrue($benh->pesticides->contains($thuoc2->id));
    }

    /** TC-D20 — Cập nhật bệnh thay đổi các combo phác đồ điều trị. */
    public function test_cap_nhat_benh_thay_doi_combo_phac_do(): void
    {
        $thuoc1 = $this->taoThuoc('Thuốc A');
        $thuoc2 = $this->taoThuoc('Thuốc B');

        $benh = $this->taoBenh([
            'name'            => 'Bệnh nứt thân xì mủ',
            'treatment_plans' => [
                [
                    'title'  => 'Phác đồ cũ',
                    'groups' => [
                        ['primary_pesticide_id' => $thuoc1->id],
                    ],
                ],
            ],
        ]);

        $newCombos = [
            [
                'title'        => 'Phác đồ mới: Quét vết bệnh đậm đặc',
                'badge'        => 'Quét đặc',
                'dosage_guide' => 'Hòa 50g với 1L nước quét lên vết cạo',
                'groups'       => [
                    [
                        'label'                => 'Thuốc quét',
                        'primary_pesticide_id' => $thuoc2->id,
                        'substitute_ids'       => [$thuoc1->id],
                    ],
                ],
            ],
        ];

        $response = $this->postJson(route('ajax.benh.cap-nhat', $benh), [
            'name'            => 'Bệnh nứt thân xì mủ',
            'treatment_plans' => $newCombos,
        ]);

        $response->assertOk();
        $benh->refresh();
        $this->assertCount(1, $benh->treatment_plans);
        $this->assertEquals('Phác đồ mới: Quét vết bệnh đậm đặc', $benh->treatment_plans[0]['title']);
        $this->assertEquals($thuoc2->id, $benh->treatment_plans[0]['groups'][0]['primary_pesticide_id']);
        $this->assertTrue($benh->pesticides->contains($thuoc2->id));
    }
}

