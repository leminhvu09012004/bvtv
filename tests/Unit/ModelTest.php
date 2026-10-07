<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Unit tests cho các Model: Disease, Pesticide, Category.
 * Kiểm tra accessor, relationship, và scope.
 */
class ModelTest extends TestCase
{
    use RefreshDatabase;

    // =========================================================================
    // Setup helpers
    // =========================================================================

    private function taoDanhMuc(): Category
    {
        return Category::create([
            'name'       => 'Nhóm test',
            'slug'       => 'nhom-test-' . uniqid(),
            'emoji'      => '🌿',
            'sort_order' => 1,
        ]);
    }

    // =========================================================================
    // TC-M01–M03: Model Disease
    // =========================================================================

    /** TC-M01 — Disease::image_url trả về null khi không có ảnh. */
    public function test_disease_image_url_null_khi_khong_co_anh(): void
    {
        $benh = Disease::create(['name' => 'Bệnh test', 'image' => null]);

        $this->assertNull($benh->image_url);
    }

    /** TC-M02 — Disease::image_url trả về URL đầy đủ khi có đường dẫn storage. */
    public function test_disease_image_url_tra_ve_url_storage(): void
    {
        $benh = Disease::create(['name' => 'Bệnh test', 'image' => 'diseases/benh.jpg']);

        $this->assertStringContainsString('storage/diseases/benh.jpg', $benh->image_url);
    }

    /** TC-M03 — Disease::image_url trả về URL gốc nếu là https://... */
    public function test_disease_image_url_giu_nguyen_url_tuyet_doi(): void
    {
        $url  = 'https://example.com/benh.jpg';
        $benh = Disease::create(['name' => 'Bệnh test', 'image' => $url]);

        $this->assertEquals($url, $benh->image_url);
    }

    /** TC-M04 — Disease <-> Pesticide quan hệ Many-to-Many hoạt động. */
    public function test_disease_pesticide_quan_he_nhieu_nhieu(): void
    {
        $cat   = $this->taoDanhMuc();
        $benh  = Disease::create(['name' => 'Bệnh X']);
        $thuoc = Pesticide::create(['category_id' => $cat->id, 'name' => 'Thuốc X']);

        $benh->pesticides()->attach($thuoc->id);

        $this->assertCount(1, $benh->pesticides);
        $this->assertTrue($benh->pesticides->contains($thuoc));

        // Ngược lại
        $this->assertCount(1, $thuoc->diseases);
        $this->assertTrue($thuoc->diseases->contains($benh));
    }

    // =========================================================================
    // TC-M05–M07: Model Pesticide
    // =========================================================================

    /** TC-M05 — Pesticide::image_url trả về null khi không có ảnh. */
    public function test_pesticide_image_url_null_khi_khong_co_anh(): void
    {
        $cat   = $this->taoDanhMuc();
        $thuoc = Pesticide::create(['category_id' => $cat->id, 'name' => 'T', 'image' => null]);

        $this->assertNull($thuoc->image_url);
    }

    /** TC-M06 — Pesticide::image_url trả về URL storage đầy đủ. */
    public function test_pesticide_image_url_tra_ve_url_storage(): void
    {
        $cat   = $this->taoDanhMuc();
        $thuoc = Pesticide::create(['category_id' => $cat->id, 'name' => 'T', 'image' => 'pesticides/t.jpg']);

        $this->assertStringContainsString('storage/pesticides/t.jpg', $thuoc->image_url);
    }

    /** TC-M07 — Pesticide::scopeSearch lọc đúng theo tên. */
    public function test_pesticide_scope_search_theo_ten(): void
    {
        $cat = $this->taoDanhMuc();
        Pesticide::create(['category_id' => $cat->id, 'name' => 'MANCOZEB XANH']);
        Pesticide::create(['category_id' => $cat->id, 'name' => 'LUMORDIE 500WP']);

        $results = Pesticide::search('MANCOZEB')->get();

        $this->assertCount(1, $results);
        $this->assertEquals('MANCOZEB XANH', $results->first()->name);
    }

    /** TC-M08 — Pesticide::scopeSearch với null trả về tất cả. */
    public function test_pesticide_scope_search_null_tra_tat_ca(): void
    {
        $cat = $this->taoDanhMuc();
        Pesticide::create(['category_id' => $cat->id, 'name' => 'A']);
        Pesticide::create(['category_id' => $cat->id, 'name' => 'B']);

        $results = Pesticide::search(null)->get();

        $this->assertCount(2, $results);
    }

    /** TC-M09 — Pesticide::scopeSearch lọc theo hoạt chất. */
    public function test_pesticide_scope_search_theo_hoat_chat(): void
    {
        $cat = $this->taoDanhMuc();
        Pesticide::create(['category_id' => $cat->id, 'name' => 'T1', 'active_ingredient' => 'Cypermethrin']);
        Pesticide::create(['category_id' => $cat->id, 'name' => 'T2', 'active_ingredient' => 'Glyphosate']);

        $results = Pesticide::search('Cypress')->get(); // Không khớp → 0

        // Kiểm tra tìm đúng
        $results2 = Pesticide::search('Cypermethrin')->get();
        $this->assertCount(1, $results2);
    }

    // =========================================================================
    // TC-M10–M11: Model Category
    // =========================================================================

    /** TC-M10 — Category có quan hệ hasMany với Pesticide. */
    public function test_category_co_quan_he_nhieu_pesticide(): void
    {
        $cat = $this->taoDanhMuc();
        Pesticide::create(['category_id' => $cat->id, 'name' => 'T1']);
        Pesticide::create(['category_id' => $cat->id, 'name' => 'T2']);

        $this->assertCount(2, $cat->pesticides);
    }

    /** TC-M11 — withCount pesticides trả về đúng số lượng. */
    public function test_category_with_count_pesticides(): void
    {
        $cat = $this->taoDanhMuc();
        Pesticide::create(['category_id' => $cat->id, 'name' => 'T1']);
        Pesticide::create(['category_id' => $cat->id, 'name' => 'T2']);
        Pesticide::create(['category_id' => $cat->id, 'name' => 'T3']);

        $result = Category::withCount('pesticides')->find($cat->id);

        $this->assertEquals(3, $result->pesticides_count);
    }
}
