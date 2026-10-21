<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Disease;
use App\Models\Pesticide;
use App\Models\User;
use Database\Seeders\ChanhDayDiseasesSeeder;
use Database\Seeders\SauRiengDiseasesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EngineerDiseaseTest extends TestCase
{
    use RefreshDatabase;

    protected User $engineer;
    protected User $admin;
    protected User $customer;
    protected User $staff;

    protected function setUp(): void
    {
        parent::setUp();

        $this->engineer = User::create([
            'name' => 'Kỹ Sư Nông Nghiệp Test',
            'email' => 'engineer.disease@bvtv.vn',
            'password' => bcrypt('password'),
            'role' => 'engineer',
            'is_active' => true,
        ]);

        $this->admin = User::create([
            'name' => 'Admin Disease Test',
            'email' => 'admin.disease@bvtv.vn',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->customer = User::create([
            'name' => 'Nông Dân Test',
            'email' => 'customer.disease@bvtv.vn',
            'password' => bcrypt('password'),
            'role' => 'customer',
            'is_active' => true,
        ]);

        $this->staff = User::create([
            'name' => 'Nhân Viên Thu Ngân Test',
            'email' => 'staff.disease@bvtv.vn',
            'password' => bcrypt('password'),
            'role' => 'staff',
            'is_active' => true,
        ]);

        $category = Category::create([
            'name' => 'Thuốc trừ bệnh',
            'slug' => 'thuoc-tru-benh',
        ]);

        Pesticide::create([
            'category_id' => $category->id,
            'name' => 'Asmiltatop Super 400SC',
            'active_ingredient' => 'Azoxystrobin 250g/l + Difenoconazole 150g/l',
        ]);
        Pesticide::create([
            'category_id' => $category->id,
            'name' => 'Mancozeb 80WP 1KG',
            'active_ingredient' => 'Mancozeb 800g/kg',
        ]);
        Pesticide::create([
            'category_id' => $category->id,
            'name' => 'Ridomil Gold 68WG',
            'active_ingredient' => 'Metalaxyl M 40 g/kg + Mancozeb 640 g/kg',
        ]);

        $this->seed(\Database\Seeders\CropsSeeder::class);
        $this->seed(\Database\Seeders\ConsolidateDiseasesAndLinkCropsSeeder::class);
    }

    /**
     * Khách chưa đăng nhập cố tình vào /ky-su/benh-hai -> redirect login
     */
    public function test_khach_chua_dang_nhap_bi_chuyen_huong(): void
    {
        $response = $this->get(route('engineer.benh.index'));
        $response->assertRedirect(route('login'));
    }

    /**
     * Customer và Staff bị chặn 403 Forbidden
     */
    public function test_customer_va_staff_bi_chan_403(): void
    {
        $resCustomer = $this->actingAs($this->customer)->get(route('engineer.benh.index'));
        $resCustomer->assertStatus(403);

        $resStaff = $this->actingAs($this->staff)->get(route('engineer.benh.index'));
        $resStaff->assertStatus(403);
    }

    /**
     * Engineer truy cập thành công giao diện bệnh cây trồng với 8 bệnh chanh dây
     */
    public function test_engineer_truy_cap_danh_sach_benh_thanh_cong(): void
    {
        $response = $this->actingAs($this->engineer)->get(route('engineer.benh.index'));

        $response->assertStatus(200);
        $response->assertSee('PHÂN HỆ KỸ SƯ BVTV');
        $response->assertSee('Chanh dây');
        $response->assertSee('Bệnh Đốm Nâu — Alternaria');
        $response->assertSee('Phytophthora');
        $response->assertSee('Fusarium');
        $response->assertSee('Colletotrichum');
        $response->assertSee('Septoria');
        $response->assertSee('Phấn Trắng');
        $response->assertSee('Virus');
        $response->assertSee('Tuyến Trùng');
    }

    /**
     * Admin toàn quyền truy cập
     */
    public function test_admin_truy_cap_thanh_cong(): void
    {
        $response = $this->actingAs($this->admin)->get(route('engineer.benh.index'));

        $response->assertStatus(200);
        $response->assertSee('PHÂN HỆ KỸ SƯ BVTV');
    }

    /**
     * AJAX lấy chi tiết 1 bệnh
     */
    public function test_ajax_lay_chi_tiet_benh(): void
    {
        $disease = Disease::where('name', 'like', '%Alternaria%')->firstOrFail();

        $response = $this->actingAs($this->engineer)->getJson(route('engineer.benh.show', $disease->id));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'disease' => [
                'id' => $disease->id,
                'name' => $disease->name,
                'crop_name' => $disease->crop_name,
                'pathogen_type' => 'nam',
            ],
        ]);
        $this->assertContains('Chanh dây', $disease->crop_names);
    }

    /**
     * AJAX Thêm mới bệnh cây trồng
     */
    public function test_ajax_them_benh_moi_thanh_cong(): void
    {
        $response = $this->actingAs($this->engineer)->postJson(route('engineer.benh.store'), [
            'name' => 'Bệnh Cháy Lá Vi Khuẩn Mới',
            'crop_name' => 'Chanh dây',
            'pathogen_type' => 'vi_khuan',
            'caunho' => 'Vi khuẩn → Cháy loang lổ sũng nước',
            'symptoms_la' => 'Vết sũng nước ở mép lá',
            'prevention' => 'Vệ sinh vườn sau mưa',
            'treatment' => 'Phun thuốc gốc đồng hoặc kháng sinh nông nghiệp',
            'chemical_groups' => 'Đồng oxyclorua, Kasugamycin',
        ]);

        $response->assertStatus(201);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('diseases', [
            'name' => 'Bệnh Cháy Lá Vi Khuẩn Mới',
            'pathogen_type' => 'vi_khuan',
        ]);
    }

    /**
     * AJAX Cập nhật thông tin bệnh
     */
    public function test_ajax_cap_nhat_benh_thanh_cong(): void
    {
        $disease = Disease::where('name', 'like', '%Alternaria%')->firstOrFail();

        $response = $this->actingAs($this->engineer)->postJson(route('engineer.benh.update', $disease->id), [
            'name' => $disease->name,
            'crop_name' => 'Chanh dây',
            'pathogen_type' => 'nam',
            'caunho' => 'Câu nhớ đã cập nhật cực hay',
            'symptoms_la' => 'Triệu chứng lá mới',
            'prevention' => $disease->prevention,
            'treatment' => $disease->treatment,
            'chemical_groups' => 'Mancozeb, Difenoconazole',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('diseases', [
            'id' => $disease->id,
            'caunho' => 'Câu nhớ đã cập nhật cực hay',
        ]);
    }

    /**
     * AJAX Xóa bệnh thành công
     */
    public function test_ajax_xoa_benh_thanh_cong(): void
    {
        $disease = Disease::create([
            'name' => 'Bệnh Thử Nghiệm Cần Xóa',
            'crop_name' => 'Chanh dây',
            'pathogen_type' => 'nam',
        ]);

        $response = $this->actingAs($this->engineer)->deleteJson(route('engineer.benh.destroy', $disease->id));

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseMissing('diseases', [
            'id' => $disease->id,
        ]);
    }

    /**
     * Engineer truy cập thành công trang to toàn màn hình xem chi tiết bệnh
     */
    public function test_engineer_truy_cap_trang_to_chi_tiet_benh_thanh_cong(): void
    {
        $disease = Disease::where('name', 'like', '%Alternaria%')->firstOrFail();

        $response = $this->actingAs($this->engineer)->get(route('engineer.benh.chi-tiet', $disease->id));

        $response->assertStatus(200);
        $response->assertSee($disease->name);
        $response->assertSee('CÂY MẪN CẢM:');
        $response->assertSee('Chanh dây');
        $response->assertSee('THƯ VIỆN ẢNH TRIỆU CHỨNG');
        $response->assertSee('BIỆN PHÁP PHÒNG NGỪA');
        $response->assertSee('BIỆN PHÁP ĐIỀU TRỊ');
        $response->assertSee('Quay lại danh sách bệnh');
    }

    /**
     * Thẻ bệnh trên trang danh sách chứa link trỏ đến trang to chi tiết
     */
    public function test_the_benh_chua_link_den_trang_to_chi_tiet(): void
    {
        $disease = Disease::where('name', 'like', '%Alternaria%')->firstOrFail();

        $response = $this->actingAs($this->engineer)->get(route('engineer.benh.index'));

        $response->assertStatus(200);
        $response->assertSee(route('engineer.benh.chi-tiet', $disease->id));
        $response->assertSee('Xem chi tiết phác đồ');
    }

    /**
     * Tự động quét và liên kết thuốc có cùng hoạt chất
     */
    public function test_tu_dong_quet_va_gan_thuoc_theo_hoat_chat(): void
    {
        $disease = Disease::where('name', 'like', '%Alternaria%')->firstOrFail();

        $response = $this->actingAs($this->engineer)->postJson(route('engineer.benh.auto-sync-thuoc', $disease->id));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $this->assertGreaterThanOrEqual(1, $disease->fresh()->pesticides()->count());
    }

    /**
     * API Tìm thuốc theo chuỗi hoạt chất nhập vào
     */
    public function test_api_tim_thuoc_theo_hoat_chat(): void
    {
        $response = $this->actingAs($this->engineer)->postJson(route('engineer.benh.tim-thuoc-hoat-chat'), [
            'chemical_groups' => 'Mancozeb, Difenoconazole, Azoxystrobin',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);
        $this->assertNotEmpty($response->json('pesticide_ids'));
    }

    /**
     * Khi tạo bệnh mới mà không chọn thuốc thủ công, tự động gắn thuốc theo hoạt chất
     */
    public function test_them_benh_moi_tu_dong_gan_thuoc_theo_hoat_chat(): void
    {
        $response = $this->actingAs($this->engineer)->postJson(route('engineer.benh.store'), [
            'name' => 'Bệnh Nấm Thử Nghiệm Tự Động Gắn',
            'crop_name' => 'Chanh dây',
            'pathogen_type' => 'nam',
            'chemical_groups' => 'Azoxystrobin, Difenoconazole',
            'prevention' => 'Phòng bệnh',
            'treatment' => 'Trị bệnh',
        ]);

        $response->assertStatus(201);
        $newDisease = Disease::where('name', 'Bệnh Nấm Thử Nghiệm Tự Động Gắn')->firstOrFail();
        $this->assertGreaterThanOrEqual(1, $newDisease->pesticides()->count());
    }

    /**
     * Kỹ sư xem danh sách sầu riêng thấy đủ 20 đối tượng và Cheat Sheet sầu riêng
     */
    public function test_ky_su_xem_danh_sach_benh_sau_rieng_day_du_20_doi_tuong(): void
    {
        $response = $this->actingAs($this->engineer)->get(route('engineer.benh.index', ['crop' => 'Sầu riêng']));

        $response->assertStatus(200);
        $response->assertSee('Bệnh Xì Mủ / Thối Gốc / Thối Rễ / Thối Trái — Phytophthora');
        $response->assertSee('Bọ Trĩ Hại Cây Trồng — Thrips spp.');
        $response->assertSee('Rầy Hại Cây Trồng (Rầy Xanh, Rầy Phấn, Rầy Nhảy)');
        $response->assertSee('Sâu Đục Cành, Thân');
        $response->assertSee('Tuyến Trùng Hại Rễ');

        $loadedDiseases = $response->viewData('diseases');
        $this->assertGreaterThanOrEqual(20, $loadedDiseases->count());
    }

    /**
     * Lọc theo sâu hại hiển thị đúng các đối tượng sâu & côn trùng
     */
    public function test_bo_loc_sau_hai_hoat_dong_chinh_xac(): void
    {
        $response = $this->actingAs($this->engineer)->get(route('engineer.benh.index', [
            'crop' => 'Sầu riêng',
            'pathogen' => 'sau_hai',
        ]));

        $response->assertStatus(200);
        $response->assertSee('Bọ Trĩ Hại Cây Trồng');
        $response->assertSee('Nhện Đỏ');
        $response->assertSee('Rầy Nhảy');

        $loadedDiseases = $response->viewData('diseases');
        $this->assertTrue($loadedDiseases->every(fn ($d) => $d->pathogen_type === 'sau_hai'));
        $this->assertGreaterThanOrEqual(7, $loadedDiseases->count());
    }

    /**
     * Thêm mới đối tượng sâu hại với pathogen_type sau_hai thành công
     */
    public function test_them_moi_sau_hai_thanh_cong(): void
    {
        $crop = \App\Models\Crop::where('name', 'Sầu riêng')->firstOrFail();

        $response = $this->actingAs($this->engineer)->postJson(route('engineer.benh.store'), [
            'name' => 'Bọ cánh cứng ăn lá sầu riêng Test',
            'crop_ids' => [$crop->id],
            'pathogen_type' => 'sau_hai',
            'caunho' => 'Bọ cánh cứng = Ăn khuyết mép lá ban đêm',
            'chemical_groups' => 'Abamectin, Spinetoram',
            'prevention' => 'Rung cây bắt ban đêm',
            'treatment' => 'Phun thuốc vị độc xông hơi',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('diseases', [
            'name' => 'Bọ cánh cứng ăn lá sầu riêng Test',
            'pathogen_type' => 'sau_hai',
        ]);

        $created = Disease::where('name', 'Bọ cánh cứng ăn lá sầu riêng Test')->firstOrFail();
        $this->assertTrue($created->crops->contains('id', $crop->id));
    }

    /**
     * Test 1 bệnh có thể gắn nhiều cây trồng và xuất hiện khi lọc từng cây
     */
    public function test_mot_benh_co_the_gan_nhieu_cay_trong(): void
    {
        $sauRieng = \App\Models\Crop::where('name', 'Sầu riêng')->firstOrFail();
        $chanhDay = \App\Models\Crop::where('name', 'Chanh dây')->firstOrFail();

        $response = $this->actingAs($this->engineer)->postJson(route('engineer.benh.store'), [
            'name' => 'Bệnh Nấm Đa Cây Thử Nghiệm',
            'crop_ids' => [$sauRieng->id, $chanhDay->id],
            'pathogen_type' => 'nam',
            'chemical_groups' => 'Mancozeb',
        ]);

        $response->assertStatus(201);
        $diseaseId = $response->json('disease.id');

        // Bệnh phải xuất hiện khi xem sầu riêng
        $resSR = $this->actingAs($this->engineer)->get(route('engineer.benh.index', ['crop' => 'Sầu riêng']));
        $this->assertTrue($resSR->viewData('diseases')->contains('id', $diseaseId));

        // Bệnh cũng phải xuất hiện khi xem chanh dây
        $resCD = $this->actingAs($this->engineer)->get(route('engineer.benh.index', ['crop' => 'Chanh dây']));
        $this->assertTrue($resCD->viewData('diseases')->contains('id', $diseaseId));

        // Kiểm tra cơ sở dữ liệu chỉ có đúng 1 bản ghi Disease
        $this->assertEquals(1, Disease::where('name', 'Bệnh Nấm Đa Cây Thử Nghiệm')->count());
    }

    /**
     * Test Bệnh Đốm Dầu / Bã Trầu Chanh Dây và các bệnh chuẩn hóa
     */
    public function test_benh_dom_dau_ba_trau_chanh_day_va_khong_trung_lap_thoi_trai(): void
    {
        $this->seed(\Database\Seeders\ConsolidateDiseasesAndLinkCropsSeeder::class);

        // Kiểm tra bệnh Đốm Dầu / Bã Trầu có tồn tại và gắn đúng chanh dây
        $domDau = Disease::where('name', 'like', '%Bã Trầu%')->firstOrFail();
        $this->assertContains('Chanh dây', $domDau->crop_names);
        $this->assertStringContainsString('Pseudomonas', $domDau->name);
        $this->assertNotEmpty($domDau->pesticides);

        // Kiểm tra mục 13 thối trái đã gộp vào Phytophthora, không có bản ghi riêng lẻ
        $this->assertEquals(0, Disease::where('name', 'like', '%Thối Trái Sầu Riêng%')->count());
        $phyto = Disease::where('name', 'like', '%Phytophthora%')->firstOrFail();
        $this->assertStringContainsString('Thối Trái', $phyto->name);
        $this->assertContains('Sầu riêng', $phyto->crop_names);

        // Kiểm tra Alternaria và Septoria đã được gắn Sầu riêng
        $alternaria = Disease::where('name', 'like', '%Alternaria%')->firstOrFail();
        $this->assertContains('Sầu riêng', $alternaria->crop_names);
        $this->assertContains('Chanh dây', $alternaria->crop_names);

        $septoria = Disease::where('name', 'like', '%Septoria%')->firstOrFail();
        $this->assertContains('Sầu riêng', $septoria->crop_names);
    }

    /**
     * Test xem trang chi tiết bệnh toàn màn hình (GET /ky-su/benh-hai/{id})
     * Đảm bảo layout engineer và blade render hoàn toàn không có lỗi cú pháp
     */
    public function test_xem_trang_chi_tiet_benh_toan_man_hinh(): void
    {
        $this->seed(\Database\Seeders\ConsolidateDiseasesAndLinkCropsSeeder::class);
        $disease = Disease::firstOrFail();

        // Kỹ sư truy cập trang chi tiết
        $resEng = $this->actingAs($this->engineer)->get(route('engineer.benh.chi-tiet', $disease->id));
        $resEng->assertStatus(200);
        $resEng->assertSee($disease->name);
        $resEng->assertSee('PHÂN HỆ KỸ SƯ BVTV');

        // Admin truy cập trang chi tiết
        $resAdmin = $this->actingAs($this->admin)->get(route('engineer.benh.chi-tiet', $disease->id));
        $resAdmin->assertStatus(200);
        $resAdmin->assertSee($disease->name);
        $resAdmin->assertSee('QUẢN TRỊ VIÊN');
    }

    /**
     * Test trang chỉnh sửa bệnh là 1 trang riêng biệt độc lập và có quản lý hình ảnh (CRUD Ảnh)
     */
    public function test_chinh_sua_benh_trang_rieng_biet_co_crud_anh(): void
    {
        $this->seed(\Database\Seeders\ConsolidateDiseasesAndLinkCropsSeeder::class);
        $disease = Disease::firstOrFail();

        // Kỹ sư truy cập trang chỉnh sửa riêng biệt
        $response = $this->actingAs($this->engineer)->get(route('engineer.benh.edit', $disease->id));
        $response->assertStatus(200);
        $response->assertSee('Chỉnh Sửa Thông Tin Bệnh');
        $response->assertSee($disease->name);
        $response->assertSee('Tự động chọn theo hoạt chất');

        // Xác nhận trang chỉnh sửa có phần quản lý CRUD ảnh đầy đủ
        $response->assertSee('Quản lý thư viện hình ảnh triệu chứng (CRUD Ảnh)', false);
        $response->assertSee('type="file"', false);
        $response->assertSee('Tải thêm ảnh mới', false);

        // Khách hoặc role khác không có quyền
        $resCustomer = $this->actingAs($this->customer)->get(route('engineer.benh.edit', $disease->id));
        $resCustomer->assertStatus(403);
    }

    /**
     * Test xóa ảnh bệnh qua AJAX
     */
    public function test_xoa_anh_benh_qua_ajax(): void
    {
        $disease = Disease::create([
            'name' => 'Bệnh Thử Nghiệm Xóa Ảnh',
            'pathogen_type' => 'nam',
            'images' => ['/images/diseases/test1.jpg', '/images/diseases/test2.jpg'],
        ]);

        $this->assertCount(2, $disease->fresh()->images);

        // Xóa ảnh thứ nhất
        $response = $this->actingAs($this->engineer)->postJson(route('engineer.benh.delete-image', $disease->id), [
            'image_url' => '/images/diseases/test1.jpg',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $fresh = $disease->fresh();
        $this->assertCount(1, $fresh->images);
        $this->assertEquals(['/images/diseases/test2.jpg'], array_values($fresh->images));
    }

    /**
     * Test tải ảnh bệnh qua AJAX
     */
    public function test_upload_anh_benh_qua_ajax(): void
    {
        $disease = Disease::create([
            'name' => 'Bệnh Thử Nghiệm Tải Ảnh',
            'pathogen_type' => 'nam',
            'images' => ['/images/diseases/test1.jpg'],
        ]);

        // Thêm link ảnh
        $response = $this->actingAs($this->engineer)->postJson(route('engineer.benh.upload-image', $disease->id), [
            'image_url' => 'https://example.com/anh-benh-moi.jpg',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $fresh = $disease->fresh();
        $this->assertCount(2, $fresh->images);
        $this->assertContains('https://example.com/anh-benh-moi.jpg', $fresh->images);
    }

    /**
     * Test đặt làm ảnh chính qua AJAX
     */
    public function test_dat_anh_chinh_qua_ajax(): void
    {
        $disease = Disease::create([
            'name' => 'Bệnh Thử Nghiệm Đặt Ảnh Chính',
            'pathogen_type' => 'nam',
            'images' => ['/images/diseases/anh1.jpg', '/images/diseases/anh2.jpg'],
        ]);

        // Đặt ảnh thứ 2 (index 1) làm ảnh chính
        $response = $this->actingAs($this->engineer)->postJson(route('engineer.benh.set-primary-image', $disease->id), [
            'image_index' => 1,
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
        ]);

        $fresh = $disease->fresh();
        $this->assertEquals('/images/diseases/anh2.jpg', $fresh->images[0]);
    }

    /**
     * Test trang chi tiết bệnh gộp hoạt chất và thuốc BVTV vào cùng 1 khối
     */
    public function test_chi_tiet_benh_gop_hoat_chat_va_thuoc_bvtv(): void
    {
        $this->seed(\Database\Seeders\ConsolidateDiseasesAndLinkCropsSeeder::class);
        $disease = Disease::whereNotNull('chemical_groups')->firstOrFail();

        $response = $this->actingAs($this->engineer)->get(route('engineer.benh.chi-tiet', $disease->id));
        $response->assertStatus(200);

        // Nút chỉnh sửa trỏ tới trang riêng biệt
        $response->assertSee(route('engineer.benh.edit', $disease->id));

        // Khối hợp nhất hoạt chất và thuốc BVTV
        $response->assertSee('BIỆN PHÁP ĐIỀU TRỊ', false);
        $response->assertSee('HOẠT CHẤT TRỊ BỆNH & SẢN PHẨM TƯƠNG ỨNG TRONG KHO', false);
    }
}
