<?php

namespace Database\Seeders;

use App\Models\CompatibilityRule;
use App\Models\Inventory;
use App\Models\Pesticide;
use App\Models\ProductVariant;
use App\Models\ResistanceProfile;
use App\Models\StockMovement;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BootstrapWarehouseAndVariantsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Khởi tạo người dùng hệ thống (Admin & Thu ngân POS)
        $admin = User::firstOrCreate(
            ['email' => 'admin@bvtvtaynguyen.vn'],
            [
                'name' => 'Quản Trị Viên',
                'phone' => '0988888888',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        $cashier = User::firstOrCreate(
            ['email' => 'pos@bvtvtaynguyen.vn'],
            [
                'name' => 'Thu Ngân Quầy POS',
                'phone' => '0977777777',
                'password' => Hash::make('password123'),
                'role' => 'staff',
                'is_active' => true,
            ]
        );

        // 2. Khởi tạo Kho Đa Điểm (Multi-Warehouse)
        $khoKRP = Warehouse::firstOrCreate(
            ['code' => 'KHO-KRP'],
            [
                'name' => 'Kho Tổng Krông Pắk - Đắk Lắk',
                'address' => 'Thị trấn Phước An, Huyện Krông Pắk, Tỉnh Đắk Lắk',
                'phone' => '0985 123 456',
                'is_active' => true,
            ]
        );

        $khoBMT = Warehouse::firstOrCreate(
            ['code' => 'KHO-BMT'],
            [
                'name' => 'Chi Nhánh Buôn Ma Thuột',
                'address' => 'Đường Lê Duẩn, TP. Buôn Ma Thuột, Tỉnh Đắk Lắk',
                'phone' => '0987 654 321',
                'is_active' => true,
            ]
        );

        // 3. Khởi tạo Variants độc lập & Tồn kho cho toàn bộ Pesticide
        $pesticides = Pesticide::all();

        foreach ($pesticides as $p) {
            $existingVariants = ProductVariant::where('pesticide_id', $p->id)->get();
            if ($existingVariants->isNotEmpty()) {
                continue;
            }

            $variantsList = [];

            // Kiểm tra trường json variants cũ
            $rawVariants = $p->variants;
            if (is_array($rawVariants) && !empty($rawVariants)) {
                foreach ($rawVariants as $idx => $v) {
                    $spec = is_array($v) ? ($v['name'] ?? $v['size'] ?? 'Quy cách ' . ($idx + 1)) : (string)$v;
                    $price = is_array($v) ? (int)($v['price'] ?? $p->price ?? 120000) : (int)($p->price ?? 120000);
                    if ($price <= 0) $price = 120000;

                    $variantsList[] = [
                        'spec' => $spec,
                        'price' => $price,
                    ];
                }
            }

            if (empty($variantsList)) {
                $basePrice = (int)($p->price ?? 120000);
                if ($basePrice <= 0) $basePrice = 120000;
                $variantsList[] = [
                    'spec' => 'Chai 500ml / Gói chuẩn',
                    'price' => $basePrice,
                ];
            }

            foreach ($variantsList as $vIndex => $vData) {
                $sku = sprintf('BVTV-%03d-%s', $p->id, Str::slug($vData['spec']));
                $barcode = sprintf('893%04d%04d%d', $p->id, $vIndex + 1, rand(1, 9));

                $costPrice = (int)round($vData['price'] * 0.75); // Giá vốn giả định 75%
                $sellingPrice = (int)$vData['price'];

                $variant = ProductVariant::create([
                    'pesticide_id' => $p->id,
                    'sku' => $sku,
                    'barcode' => $barcode,
                    'specification' => $vData['spec'],
                    'unit' => str_contains(mb_strtolower($vData['spec']), 'gói') ? 'Gói' : 'Chai',
                    'cost_price' => $costPrice,
                    'selling_price' => $sellingPrice,
                    'promotional_price' => null,
                    'weight_grams' => 500,
                    'status' => 'active',
                ]);

                // Khởi tạo Tồn kho KHO-KRP
                $invKRP = Inventory::firstOrCreate(
                    [
                        'warehouse_id' => $khoKRP->id,
                        'variant_id' => $variant->id,
                    ],
                    [
                        'quantity_on_hand' => 80,
                        'quantity_reserved' => 0,
                        'reorder_point' => 15,
                        'bin_location' => 'Kệ A-' . ($p->id % 10 + 1),
                    ]
                );

                StockMovement::create([
                    'movement_code' => 'INIT-KRP-' . $variant->id,
                    'warehouse_id' => $khoKRP->id,
                    'destination_warehouse_id' => null,
                    'variant_id' => $variant->id,
                    'type' => 'purchase_receipt',
                    'quantity_change' => 80,
                    'balance_before' => 0,
                    'balance_after' => 80,
                    'unit_cost' => $costPrice,
                    'reference_type' => 'SystemInit',
                    'reference_id' => $p->id,
                    'created_by' => $admin->id,
                    'notes' => 'Khởi tạo số dư ban đầu kho Krông Pắk',
                ]);

                // Khởi tạo Tồn kho KHO-BMT
                $invBMT = Inventory::firstOrCreate(
                    [
                        'warehouse_id' => $khoBMT->id,
                        'variant_id' => $variant->id,
                    ],
                    [
                        'quantity_on_hand' => 30,
                        'quantity_reserved' => 0,
                        'reorder_point' => 10,
                        'bin_location' => 'Kệ BMT-' . ($p->id % 5 + 1),
                    ]
                );

                StockMovement::create([
                    'movement_code' => 'INIT-BMT-' . $variant->id,
                    'warehouse_id' => $khoBMT->id,
                    'destination_warehouse_id' => null,
                    'variant_id' => $variant->id,
                    'type' => 'purchase_receipt',
                    'quantity_change' => 30,
                    'balance_before' => 0,
                    'balance_after' => 30,
                    'unit_cost' => $costPrice,
                    'reference_type' => 'SystemInit',
                    'reference_id' => $p->id,
                    'created_by' => $admin->id,
                    'notes' => 'Khởi tạo số dư ban đầu chi nhánh BMT',
                ]);
            }
        }

        // 4. Khởi tạo Bảng Hồ Sơ Tính Kháng Quốc Tế (Resistance Profiles)
        $resistanceData = [
            [
                'code_type' => 'FRAC',
                'code_value' => 'FRAC 11',
                'target_site_of_action' => 'Ức chế hô hấp ty thể tại vị trí phức hợp III (QoI - Cytochrome bc1)',
                'risk_level' => 'HIGH',
                'cross_resistance_group' => 'Strobilurins (Azoxystrobin, Pyraclostrobin, Kresoxim-methyl)',
                'rotation_advice' => 'Tối đa 2 lần phun liên tiếp; luân phiên bắt buộc với FRAC 3 (DMI) hoặc nhóm tiếp xúc đa vị trí FRAC M01/M02.',
            ],
            [
                'code_type' => 'FRAC',
                'code_value' => 'FRAC 3',
                'target_site_of_action' => 'Ức chế sinh tổng hợp Sterol trong màng tế bào nấm (DMI - 14α-demethylase)',
                'risk_level' => 'MEDIUM',
                'cross_resistance_group' => 'Triazoles (Hexaconazole, Difenoconazole, Tebuconazole)',
                'rotation_advice' => 'Luân phiên với nhóm FRAC 11 hoặc nhóm Kích kháng sinh học FRAC P07.',
            ],
            [
                'code_type' => 'FRAC',
                'code_value' => 'FRAC M01',
                'target_site_of_action' => 'Tác động tiếp xúc đa điểm vô cơ (Inorganic Copper - Gốc Đồng)',
                'risk_level' => 'LOW',
                'cross_resistance_group' => 'Copper Oxychloride, Cuprous Oxide, Bordeaux',
                'rotation_advice' => 'Khả năng kháng bệnh cực thấp; dùng làm thuốc nền rửa vườn hoặc phối luân phiên với nhóm nội hấp.',
            ],
            [
                'code_type' => 'FRAC',
                'code_value' => 'FRAC M02',
                'target_site_of_action' => 'Tác động tiếp xúc đa điểm vô cơ (Inorganic Sulfur - Lưu Huỳnh)',
                'risk_level' => 'LOW',
                'cross_resistance_group' => 'Sulfur nguyên chất',
                'rotation_advice' => 'Khả năng kháng thuốc không đáng kể; tuyệt đối không pha chung với dầu khoáng.',
            ],
            [
                'code_type' => 'IRAC',
                'code_value' => 'IRAC 4A',
                'target_site_of_action' => 'Chất điều biến thụ thể Nicotinic acetylcholine thần kinh (Neonicotinoid)',
                'risk_level' => 'HIGH',
                'cross_resistance_group' => 'Imidacloprid, Thiamethoxam, Acetamiprid, Clothianidin',
                'rotation_advice' => 'Luân phiên với IRAC 16 (Ức chế lột xác Buprofezin) hoặc IRAC 6 (Avermectin).',
            ],
            [
                'code_type' => 'IRAC',
                'code_value' => 'IRAC 6',
                'target_site_of_action' => 'Kích hoạt kênh Chloride qua thụ thể GABA/Glutamate (Avermectins)',
                'risk_level' => 'MEDIUM',
                'cross_resistance_group' => 'Abamectin, Emamectin benzoate',
                'rotation_advice' => 'Luân phiên với nhóm tiếp xúc vi sinh hoặc dầu khoáng sinh học.',
            ],
        ];

        foreach ($resistanceData as $r) {
            ResistanceProfile::updateOrCreate(
                ['code_type' => $r['code_type'], 'code_value' => $r['code_value']],
                $r
            );
        }

        // 5. Khởi tạo Bộ Luật Tương Kỵ Hóa Lý Có Dẫn Chứng Thực Tế (Compatibility Rules)
        $rulesData = [
            [
                'rule_code' => 'R-CU-OIL-01',
                'scope' => 'group_specific',
                'entity_a_type' => 'chemical_group',
                'entity_a_key' => 'inorganic_copper',
                'entity_b_type' => 'chemical_group',
                'entity_b_key' => 'mineral_oil',
                'status' => 'FORBIDDEN',
                'priority' => 100,
                'title' => 'Đồng Vô Cơ + Dầu Khoáng gây cháy lá, rụng bông nghiêm trọng',
                'reason' => 'Dầu khoáng phá vỡ lớp biểu bì bảo vệ (cutin), tạo điều kiện cho ion đồng Cu2+ tự do thấm ồ ạt vào tế bào mô lá dẫn đến ngộ độc kim loại nặng cấp tính.',
                'conditions' => 'Cách ly tối thiểu 10 - 14 ngày giữa 2 lần phun.',
                'source_type' => 'manufacturer_label',
                'source_reference' => 'Nhãn Bordeaux & Cẩm nang BVTV Cục Bảo vệ Thực vật 2024',
                'confidence' => 'HIGH',
                'advice' => 'Phun dầu khoáng riêng và thuốc gốc đồng riêng, giãn cách tối thiểu 10-14 ngày.',
            ],
            [
                'rule_code' => 'R-OIL-SULFUR-01',
                'scope' => 'group_specific',
                'entity_a_type' => 'chemical_group',
                'entity_a_key' => 'mineral_oil',
                'entity_b_type' => 'chemical_group',
                'entity_b_key' => 'sulfur',
                'status' => 'FORBIDDEN',
                'priority' => 100,
                'title' => 'Dầu Khoáng + Lưu Huỳnh gây độc cháy lá diện rộng',
                'reason' => 'Màng dầu lưu giữ các phân tử lưu huỳnh bốc hơi dưới ánh nắng mặt trời tạo phản ứng quang hóa thiêu cháy diệp lục tố của lá non và vỏ trái.',
                'conditions' => 'Tuyệt đối cấm pha chung hoặc phun cách nhau dưới 15 ngày.',
                'source_type' => 'official_standard',
                'source_reference' => 'FAO Guidelines on Pesticide Tank-Mix Safety and Specifications',
                'confidence' => 'HIGH',
                'advice' => 'Cách ly 15-20 ngày giữa 2 đợt phun dầu khoáng và lưu huỳnh.',
            ],
            [
                'rule_code' => 'R-CU-BIO-01',
                'scope' => 'group_specific',
                'entity_a_type' => 'chemical_group',
                'entity_a_key' => 'inorganic_copper',
                'entity_b_type' => 'chemical_group',
                'entity_b_key' => 'biopesticide',
                'status' => 'FORBIDDEN',
                'priority' => 100,
                'title' => 'Gốc Đồng Vô Cơ tiêu diệt toàn bộ Chế phẩm Vi sinh vật đối kháng',
                'reason' => 'Ion đồng Cu2+ là chất diệt khuẩn/nấm phổ cực rộng, sẽ làm biến tính protein và tiêu diệt hoàn toàn bào tử sống của nấm Trichoderma, Bacillus và xạ khuẩn.',
                'conditions' => 'Không trộn chung trong bất kỳ trường hợp nào.',
                'source_type' => 'scientific_paper',
                'source_reference' => 'Tạp chí Nông nghiệp & Phát triển Nông thôn - Nghiên cứu tính đối kháng hóa học',
                'confidence' => 'HIGH',
                'advice' => 'Phun gốc đồng tẩy nấm trước 7-10 ngày, sau đó mới cấy vi sinh vật đối kháng lại đất và lá.',
            ],
            [
                'rule_code' => 'R-CA-PHOSPHATE-01',
                'scope' => 'group_specific',
                'entity_a_type' => 'chemical_group',
                'entity_a_key' => 'high_calcium',
                'entity_b_type' => 'chemical_group',
                'entity_b_key' => 'high_phosphorus',
                'status' => 'FORBIDDEN',
                'priority' => 100,
                'title' => 'Canxi cao + Lân cao (MKP) tạo kết tủa Canxi Photphat lắng đáy',
                'reason' => 'Ion Ca2+ phản ứng trực tiếp với ion PO4(3-) tạo thành muối Ca3(PO4)2 hoàn toàn không tan trong nước, vón cục đóng cặn nghẹt béc phun và mất dinh dưỡng.',
                'conditions' => 'Nồng độ phân bón lá đậm đặc trong cùng một phuy.',
                'source_type' => 'official_standard',
                'source_reference' => 'Sổ tay Hòa tan & Tương thích Phân bón Nông nghiệp hòa tan',
                'confidence' => 'HIGH',
                'advice' => 'Phun Canxi Bo riêng vào buổi mát, phun Lân tạo mầm (MKP) riêng vào cữ khác.',
            ],
            [
                'rule_code' => 'R-ABA-BUPRO-01',
                'scope' => 'group_specific',
                'entity_a_type' => 'chemical_group',
                'entity_a_key' => 'avermectin',
                'entity_b_type' => 'chemical_group',
                'entity_b_key' => 'buprofezin',
                'status' => 'COMPATIBLE',
                'priority' => 100,
                'title' => 'Abamectin + Buprofezin tương thích tốt và cộng lực diệt rầy',
                'reason' => 'Không phát sinh tương tác hóa lý bất lợi; Abamectin hạ gục nhanh rầy trưởng thành còn Buprofezin ức chế lột xác diệt sạch ấu trùng non và trứng.',
                'conditions' => 'Hòa tan theo thứ tự WP/SC trước, EC sau.',
                'source_type' => 'manufacturer_label',
                'source_reference' => 'Khảo nghiệm diện rộng Cục Bảo vệ Thực vật 2023',
                'confidence' => 'HIGH',
                'advice' => 'Phối hợp hiệu quả cao vào giai đoạn rầy rộ lứa, phun ướt đều 2 mặt lá.',
            ],
        ];

        foreach ($rulesData as $rule) {
            CompatibilityRule::updateOrCreate(
                ['rule_code' => $rule['rule_code']],
                $rule
            );
        }
    }
}
