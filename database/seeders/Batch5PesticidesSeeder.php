<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class Batch5PesticidesSeeder extends Seeder
{
    public function run(): void
    {
        $catTruBenh = Category::where('slug', 'thuoc-tru-benh')->first();
        $catPhanBon = Category::where('slug', 'phan-bon-la')->first();

        $items = [
            [
                'category_id' => $catTruBenh->id,
                'name' => 'XANH MANCO 80WP',
                'image' => 'pesticides/xanh-manco-80wp.jpg',
                'active_ingredient' => 'Mancozeb 800 g/kg',
                'concentration' => '80WP (Gói 1 Kg)',
                'form_type' => 'WP',
                'water_volume' => '400 - 500 lít nước (2 - 2.5 phuy)',
                'usage' => 'Thuốc trừ bệnh phổ rộng tiếp xúc đa điểm thế hệ mới của An Nông. Tạo lớp màng bảo vệ xanh bền, ức chế nảy mầm bào tử nấm. Phòng trị thán thư, đốm lá, rỉ sắt, sương mai, nứt thân xì mủ.',
                'target' => 'Thán thư, đốm lá, rỉ sắt, sương mai, mốc sương, nứt thân xì mủ',
                'crops' => 'Sầu riêng, thanh long, xoài, mít, cam quýt, lúa, rau màu',
                'manufacturer' => 'An Nông (Annong)',
                'registration_number' => 'AN-MANCO-80WP',
                'isolation_period' => '7 ngày',
                'notes' => 'Gói 1kg pha 400 - 500 lít nước phun ướt đều tán lá khi bệnh chớm xuất hiện hoặc định kỳ phòng ngừa mùa mưa.',
                'diseases' => ['Bệnh thán thư', 'Bệnh đốm lá', 'Bệnh rỉ sắt'],
            ],
            [
                'category_id' => $catTruBenh->id,
                'name' => 'Amtech 100EW',
                'image' => 'pesticides/amtech-100ew.jpg',
                'active_ingredient' => 'Anacardic Acid 100g/l',
                'concentration' => '100EW (Chai 250ml)',
                'form_type' => 'EW',
                'water_volume' => '200 - 400 lít nước (1 - 2 phuy)',
                'usage' => 'Thuốc trừ bệnh hữu cơ sinh học cao cấp, bảo hộ sáng chế độc quyền. Phòng và đặc trị cả bệnh do vi khuẩn và nấm. Phun xong thu hoạch ngay, sau khi phun rau củ quả sẽ tươi lâu hơn.',
                'target' => 'Bệnh thối nhũn vi khuẩn, cháy bìa lá, đốm sọc, thán thư, phấn trắng',
                'crops' => 'Rau ăn lá, dưa leo, cà chua, bầu bí, ớt, cây ăn trái, hoa kiểng',
                'manufacturer' => 'HP (Hóa Nông Hợp Phát)',
                'registration_number' => 'HP-AMTECH-100EW',
                'isolation_period' => '0 ngày (Thu hoạch ngay)',
                'notes' => 'Pha 1 chai 250ml cho 200 - 400L nước. An toàn sinh học tuyệt đối, thích hợp cho nông sản sạch VietGAP, GlobalGAP.',
                'diseases' => ['Bệnh thán thư', 'Bệnh đốm lá'],
            ],
            [
                'category_id' => $catPhanBon->id,
                'name' => 'FETRILON COMBI',
                'image' => 'pesticides/fetrilon-combi.jpg',
                'active_ingredient' => 'Magie 2%, S 3% + Vi lượng Chelate: Fe 40.000ppm, Mn 40.000ppm, Zn 15.000ppm, Cu 15.000ppm, Bo 5.000ppm, Mo 1.000ppm',
                'concentration' => 'Chelate 100% (Gói 25g)',
                'form_type' => 'SP',
                'water_volume' => '200 lít nước (1 phuy)',
                'usage' => 'Phân bón lá vi lượng Chelate cao cấp nhập khẩu từ Đức (COMPO EXPERT / Behn Meyer). Hòa tan 100%, hấp thu tức thì qua biểu bì lá. Khắc phục triệt để hiện tượng vàng lá gân xanh, xoăn đọt, rụng hoa và trái non.',
                'target' => 'Thiếu hụt vi lượng, vàng lá gân xanh, xoăn đọt non, rụng hoa, suy cây sau thu hoạch',
                'crops' => 'Sầu riêng, cam sành, bưởi da xanh, xoài, cà phê, hồ tiêu, lúa, rau hoa kiểng',
                'manufacturer' => 'COMPO EXPERT GmbH (Đức) / Behn Meyer AgriCare',
                'registration_number' => 'BM-FETRILON-25G',
                'isolation_period' => 'Không áp dụng',
                'notes' => 'Gói 25g pha cho 200 lít nước (1 phuy). Phun định kỳ giai đoạn phát triển đọt non, trước trổ hoa và nuôi dưỡng trái.',
                'diseases' => ['Bệnh vàng lá'],
            ],
            [
                'category_id' => $catPhanBon->id,
                'name' => 'Egibo 80SG',
                'image' => 'pesticides/egibo-80sg.jpg',
                'active_ingredient' => 'Gibberellic acid 80% w/w (GA3) + Special Additives',
                'concentration' => '80% w/w (Hạt hòa tan SG)',
                'form_type' => 'SG',
                'water_volume' => '200 - 400 lít nước (1 - 2 phuy)',
                'usage' => 'Thuốc điều hòa sinh trưởng chất lượng cao công nghệ Thụy Sĩ. Kích hoạt tế bào kéo dài, đánh thức mầm ngủ, bung đọt non đồng loạt, vọt hoa nhanh, tăng tỷ lệ đậu trái, giãn tế bào giúp trái lớn nhanh bóng đẹp.',
                'target' => 'Bung đọt non, vọt hoa đồng loạt, tăng đậu trái, chống nghẹn bông chai trái',
                'crops' => 'Sầu riêng, thanh long, xoài, nhãn, cam quýt, lúa, rau ăn trái',
                'manufacturer' => 'Made in Switzerland (Thụy Sĩ)',
                'registration_number' => 'SWISS-EGIBO-80SG',
                'isolation_period' => '3 ngày',
                'notes' => 'Pha 1 gói cho 200 - 400 lít nước tùy giai đoạn kéo đọt hoặc kéo cơi đọt.',
                'diseases' => [],
            ],
            [
                'category_id' => $catTruBenh->id,
                'name' => 'MAXSURAN 80WG',
                'image' => 'pesticides/maxsuran-80wg.jpg',
                'active_ingredient' => 'Dimethomorph 80% w/w (800g/kg)',
                'concentration' => '80WG (Gói 102g)',
                'form_type' => 'WG',
                'water_volume' => '200 lít nước (1 phuy)',
                'usage' => 'Hoạt chất Dimethomorph nhóm acid cinnamic hàm lượng siêu cao 80%. Tác động nội hấp và tiếp xúc cực mạnh, ức chế tổng hợp thành tế bào nấm Oomycetes. Đặc trị chết nhanh hồ tiêu, nứt thân xì mủ sầu riêng, sương mai.',
                'target' => 'Chết nhanh hồ tiêu, nứt thân xì mủ, thối rễ, sương mai, phấn trắng',
                'crops' => 'Hồ tiêu, sầu riêng, cao su, dưa hấu, cà chua, khoai tây, hoa cúc',
                'manufacturer' => 'CQ Pharma',
                'registration_number' => 'CQ-MAXSURAN-80WG',
                'isolation_period' => '7 ngày',
                'notes' => 'Gói 102g pha cho 200 lít nước (1 phuy). Phun ướt đều tán lá hoặc tưới gốc khi vết bệnh vừa xuất hiện.',
                'diseases' => ['Bệnh thán thư', 'Bệnh đạo ôn'],
            ],
        ];

        foreach ($items as $data) {
            $diseaseNames = $data['diseases'] ?? [];
            unset($data['diseases']);

            $pesticide = Pesticide::updateOrCreate(
                ['name' => $data['name']],
                $data
            );

            // Gán vào bệnh nếu có
            if (!empty($diseaseNames)) {
                $diseaseIds = Disease::whereIn('name', $diseaseNames)->pluck('id');
                if ($diseaseIds->isNotEmpty()) {
                    $pesticide->diseases()->syncWithoutDetaching($diseaseIds);
                }
            }

            echo "Đã thêm/cập nhật thuốc: {$pesticide->name}\n";
        }
    }
}
