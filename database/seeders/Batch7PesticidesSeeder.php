<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class Batch7PesticidesSeeder extends Seeder
{
    public function run(): void
    {
        $catTruBenh = Category::where('slug', 'thuoc-tru-benh')->first();
        $catPhanBon = Category::where('slug', 'phan-bon-la')->first();

        $items = [
            [
                'category_id' => $catPhanBon->id,
                'name' => 'King Kong - CHẶN ĐỌT',
                'image' => 'pesticides/king-kong-chan-dot.jpg',
                'active_ingredient' => 'Potassium Phosphonate Lưu dẫn 2 chiều (Lân hai chiều + Kali hữu hiệu)',
                'concentration' => 'Dạng lỏng (Chai 500 ml)',
                'form_type' => 'SL',
                'water_volume' => '400 - 500 lít nước (2 - 2.5 phuy)',
                'usage' => 'Chuyên dùng cho sầu riêng: "Có King Kong khỏi lo ra đọt - Đánh đọt dễ như ăn chuối". Lưu dẫn 2 chiều cực mạnh rễ ⇄ lá, khống chế đọt non, chặn đọt nhanh chóng, làm lá non chuyển lụa dày lá, kích kháng nấm Phytophthora gây xì mủ, hạn chế tối đa rụng hoa và rụng trái non.',
                'target' => 'Chặn đọt sầu riêng, già lá nhanh, kích kháng xì mủ, chống rụng hoa và trái non',
                'crops' => 'Sầu riêng, cam sành, bưởi, mít, xoài, cây ăn trái',
                'manufacturer' => 'Chuyên Dùng Cho Sầu Riêng',
                'registration_number' => 'KINGKONG-500ML',
                'isolation_period' => 'Không áp dụng',
                'notes' => 'Pha 1 chai 500ml cho 400 - 500 lít nước phun phủ ngoài tán lá khi đọt non vừa nhú le lói.',
            ],
            [
                'category_id' => $catPhanBon->id,
                'name' => 'CHẶN ĐỌT FDA (ISRAEL)',
                'image' => 'pesticides/chan-dot-fda-israel.jpg',
                'active_ingredient' => 'Lân hữu hiệu (P2O5), Kali hữu hiệu (K2O) tinh khiết + Phụ gia điều khiển bộ lá (Raw Materials 100% from Israel)',
                'concentration' => 'Dạng lỏng đậm đặc (Chai 500 ml)',
                'form_type' => 'SL',
                'water_volume' => '400 - 500 lít nước (2 - 2.5 phuy)',
                'usage' => 'Chặn đọt - Ức chế đọt non - Điều khiển bộ lá - Hạn chế rụng hoa và trái khi gặp thời tiết bất lợi. Nhập khẩu 100% nguyên liệu chất lượng cao từ Israel. Giúp đọt non đứng bánh tẻ, lá dày xanh đứng, ngăn cạnh tranh dinh dưỡng giữa đọt và trái.',
                'target' => 'Ức chế đọt non, già lá nhanh, giữ trái non, điều khiển bộ lá',
                'crops' => 'Sầu riêng, cam, bưởi, xoài, nhãn, thanh long',
                'manufacturer' => 'Raw Materials 100% Quality from Israel',
                'registration_number' => 'FDA-ISRAEL-500ML',
                'isolation_period' => 'Không áp dụng',
                'notes' => 'Pha 500ml cho 400 - 500 lít nước phun mặt ngoài tán lá.',
            ],
            [
                'category_id' => $catPhanBon->id,
                'name' => 'HPC - 22HXN (DƯỠNG TRÁI)',
                'image' => 'pesticides/hpc-22hxn-duong-trai.jpg',
                'active_ingredient' => 'Đa trung vi lượng NPK cân đối + Chelate vi lượng (Bo, Zn, Fe) và kích phát tố sinh học',
                'concentration' => 'Dạng lỏng đậm đặc (Chai 500 ml)',
                'form_type' => 'SL',
                'water_volume' => '400 - 500 lít nước (2 phuy)',
                'usage' => 'Phân bón lá HPC - 22HXN chuyên dùng giai đoạn ra hoa dưỡng trái, nuôi lớn trái. Tăng khả năng thụ phấn đậu trái, chống rụng trái non sinh lý, thúc trái lớn nhanh, tròn đều, nhân to, cơm dày, mẫu mã bóng đẹp.',
                'target' => 'Nuôi trái lớn nhanh, tăng đậu quả, chống rụng trái non, mập cuống',
                'crops' => 'Mãng cầu, sầu riêng, bơ, mít, thanh long, dưa hấu, chuối, dứa, cam, xoài',
                'manufacturer' => 'HPC Phú Đông (TP. Hồ Chí Minh)',
                'registration_number' => 'HPC-DUONGTRAI-500ML',
                'isolation_period' => 'Không áp dụng',
                'notes' => 'Chai 500ml pha 400 - 500 lít nước phun định kỳ giai đoạn nuôi trái non đến trước thu hoạch.',
            ],
            [
                'category_id' => $catTruBenh->id,
                'name' => 'Nofacol 70WP (Áo giáp Kẽm)',
                'image' => 'pesticides/nofacol-70wp.jpg',
                'active_ingredient' => 'Propineb 70% w/w (700g/kg) + Bổ sung Kẽm tinh khiết (Zinc++)',
                'concentration' => '70WP (Gói 1 Kg)',
                'form_type' => 'WP',
                'water_volume' => '400 - 500 lít nước (2 - 2.5 phuy)',
                'usage' => 'Bảo vệ cây bằng áo giáp kẽm (Zinc++)! Thuốc trừ bệnh phổ rộng tiếp xúc đa điểm. Hoạt chất Propineb ngăn cản sự trao đổi chất của nấm gây hại, ức chế nảy mầm bào tử. Đồng thời bổ sung vi lượng kẽm giúp cây xanh tốt, dày lá, cứng cây, tăng quang hợp.',
                'target' => 'Thán thư ớt, thán thư xoài, đốm lá, rỉ sắt, sương mai, mốc sương, cháy lá, vàng lá',
                'crops' => 'Ớt, xoài, sầu riêng, thanh long, dưa hấu, cà chua, khoai tây, lúa, rau màu',
                'manufacturer' => 'Nofacol Zinc',
                'registration_number' => 'NOFACOL-70WP-1KG',
                'isolation_period' => '7 ngày',
                'notes' => 'Gói 1kg pha 400 - 500 lít nước. Phun ướt đều tán lá khi bệnh chớm xuất hiện hoặc định kỳ phòng bệnh.',
                'diseases' => ['Bệnh thán thư', 'Bệnh đốm lá', 'Bệnh rỉ sắt'],
            ],
            [
                'category_id' => $catPhanBon->id,
                'name' => 'CHẶN ĐỌT HÃM ĐỌT NON (AT - FOSIKA)',
                'image' => 'pesticides/chan-dot-at-fosika.jpg',
                'active_ingredient' => 'Lân hữu hiệu (P2O5), Kali hữu hiệu (K2O) dạng Phosphite/Phosphonate + Phụ gia chặn đọt AT',
                'concentration' => 'Dạng lỏng đậm đặc (Chai 500 ml)',
                'form_type' => 'SL',
                'water_volume' => '200 - 400 lít nước (1 - 2 phuy)',
                'usage' => 'Phân bón lá hỗn hợp PK AT - FOSIKA chuyên dùng chặn đọt hãm đọt non. Giúp lá nhanh già, dày lá; phân hoá mầm hoa, tập trung tạo mầm hoa; ngăn chặn cạnh tranh dinh dưỡng giữa trái và đọt non, chặn đọt cực nhạy không gây cháy lá non.',
                'target' => 'Chặn đọt, hãm đọt non, già lá nhanh, tạo mầm hoa, chống rụng hoa và trái',
                'crops' => 'Sầu riêng, cam, bưởi, quýt, chanh, xoài, nhãn, mãng cầu',
                'manufacturer' => 'AT - FOSIKA',
                'registration_number' => 'AT-FOSIKA-500ML',
                'isolation_period' => 'Không áp dụng',
                'notes' => 'Pha 500ml cho 200 - 400 lít nước tùy sức đọt. Phun phủ ngoài tán khi đọt vừa nhú le lói.',
            ],
        ];

        foreach ($items as $data) {
            $diseaseNames = $data['diseases'] ?? [];
            unset($data['diseases']);

            $pesticide = Pesticide::updateOrCreate(
                ['name' => $data['name']],
                $data
            );

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
