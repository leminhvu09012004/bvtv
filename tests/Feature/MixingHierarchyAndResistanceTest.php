<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\CompatibilityRule;
use App\Models\Pesticide;
use App\Models\ResistanceProfile;
use App\Services\MixingCompatibilityService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MixingHierarchyAndResistanceTest extends TestCase
{
    use RefreshDatabase;

    private function createCat(): Category
    {
        return Category::create([
            'name' => 'Thuốc trừ bệnh',
            'slug' => 'thuoc-tru-benh',
            'emoji' => '🧪',
            'sort_order' => 1,
        ]);
    }

    public function test_4_states_hierarchy_and_product_specific_override(): void
    {
        $cat = $this->createCat();
        $service = app(MixingCompatibilityService::class);

        // Tạo 2 sản phẩm: Prod A (gốc đồng) và Prod B (dầu khoáng)
        $prodA = Pesticide::create([
            'category_id' => $cat->id,
            'name' => 'Thuốc Đồng Đặc Biệt A',
            'active_ingredient' => 'Copper Hydroxide',
            'form_type' => 'WG',
        ]);

        $prodB = Pesticide::create([
            'category_id' => $cat->id,
            'name' => 'Dầu Khoáng Công Nghệ Mới B',
            'active_ingredient' => 'Mineral Oil',
            'form_type' => 'EC',
        ]);

        // Mặc định nhóm gốc đồng + dầu khoáng là FORBIDDEN (Group rule priority 100)
        $resGroup = $service->checkPair($prodA, $prodB);
        $this->assertEquals('FORBIDDEN', $resGroup['compatibility_status']);
        $this->assertEquals('danger', $resGroup['status']);

        // Bây giờ tạo 1 Product-specific rule đặc biệt (priority 200) cho phép tương thích theo điều kiện đặc biệt
        CompatibilityRule::create([
            'rule_code' => 'R-PROD-SPEC-001',
            'scope' => 'product_specific',
            'entity_a_type' => 'product',
            'entity_a_key' => (string) $prodA->id,
            'entity_b_type' => 'product',
            'entity_b_key' => (string) $prodB->id,
            'status' => 'COMPATIBLE',
            'priority' => 200,
            'title' => 'Khảo nghiệm công nghệ chelate nano cho phép phối trộn',
            'reason' => 'Hạt nano bọc màng không bị phá vỡ bởi nhũ tương dầu khoáng.',
            'source_type' => 'scientific_paper',
            'source_reference' => 'Tạp chí Khoa học Nông nghiệp 2025, Số 4',
            'confidence' => 'HIGH',
            'advice' => 'Hòa tan theo tỷ lệ 1:400.',
        ]);

        // Kiểm tra lại: Product rule (priority 200) phải đè lên Group rule
        $resProduct = $service->checkPair($prodA, $prodB);
        $this->assertEquals('COMPATIBLE', $resProduct['compatibility_status']);
        $this->assertEquals('safe', $resProduct['status']);
        $this->assertEquals('R-PROD-SPEC-001', $resProduct['conflicts'][0]['rule_code']);
        $this->assertEquals('scientific_paper', $resProduct['conflicts'][0]['source_type']);
    }

    public function test_resistance_management_separated_from_physical_mixing(): void
    {
        $cat = $this->createCat();
        $service = app(MixingCompatibilityService::class);

        // Tạo Resistance Profile cho FRAC 3
        ResistanceProfile::create([
            'code_type' => 'FRAC',
            'code_value' => 'FRAC 3',
            'target_site_of_action' => 'DMI - 14α-demethylase',
            'risk_level' => 'MEDIUM',
            'cross_resistance_group' => 'Triazoles',
            'rotation_advice' => 'Luân phiên với nhóm tiếp xúc đa điểm.',
        ]);

        // Hai sản phẩm cùng mã FRAC 3
        $tilt = Pesticide::create([
            'category_id' => $cat->id,
            'name' => 'Propiconazole 250EC',
            'active_ingredient' => 'Propiconazole',
            'form_type' => 'EC',
            'frac_code' => 'FRAC 3',
        ]);

        $score = Pesticide::create([
            'category_id' => $cat->id,
            'name' => 'Difenoconazole 250EC',
            'active_ingredient' => 'Difenoconazole',
            'form_type' => 'EC',
            'frac_code' => 'FRAC 3',
        ]);

        $res = $service->checkPair($tilt, $score);
        $this->assertNotEmpty($res['resistance_warnings']);
        $rw = $res['resistance_warnings'][0];
        $this->assertEquals('FRAC', $rw['type']);
        $this->assertEquals('FRAC 3', $rw['code']);
        $this->assertStringContainsString('DMI', $rw['mechanism']);
    }

    public function test_unknown_status_when_no_scientific_data_available(): void
    {
        $cat = $this->createCat();
        $service = app(MixingCompatibilityService::class);

        // Hai hoạt chất giả định chưa có dữ liệu tương kỵ nào trong hệ thống
        $p1 = Pesticide::create([
            'category_id' => $cat->id,
            'name' => 'Chất Hóa Học Mới X',
            'active_ingredient' => 'NovelChemicalCompoundX',
            'form_type' => 'SC',
        ]);

        $p2 = Pesticide::create([
            'category_id' => $cat->id,
            'name' => 'Chất Hóa Học Mới Y',
            'active_ingredient' => 'NovelChemicalCompoundY',
            'form_type' => 'SL',
        ]);

        $res = $service->checkPair($p1, $p2);
        // Không tự kết luận "an toàn" hoặc "cấm", mà trạng thái compatibility_status là UNKNOWN
        $this->assertEquals('UNKNOWN', $res['compatibility_status']);
    }
}
