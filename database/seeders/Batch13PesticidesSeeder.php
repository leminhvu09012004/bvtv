<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class Batch13PesticidesSeeder extends Seeder
{
    /**
     * Run the database seeds for Batch 13:
     * - ĐH 10 SR Run Fast (phân bón lá điều khiển bộ lá sầu riêng)
     * - Validacin 5SL Sumitomo (thuốc trừ bệnh - Validamycin A)
     */
    public function run(): void
    {
        $catLa = Category::where('slug', 'phan-bon-la')->first();
        $catBenh = Category::where('slug', 'thuoc-tru-benh')->first();

        $items = [
            [
                'category_id' => $catLa->id,
                'name' => 'ĐH 10 SR - Phân Bón Run Fast Điều Khiển Bộ Lá Sầu Riêng (Chai 1L)',
                'image' => 'pesticides/dh10-sr-dieu-khien-bo-la-sau-rieng-1lit.jpg',
                'active_ingredient' => 'Hỗn hợp NPK cân bằng + Vi lượng Chelate + Điều tiết sinh trưởng (Phân bón Run Fast chuyên sầu riêng)',
                'concentration' => 'Dạng lỏng 1L (Chuyên dùng cho Sầu Riêng - ISO 9001)',
                'water_volume' => 'Pha 1 chai 1L cho 200 lít nước (1 phuy) phun ướt đều tán lá sầu riêng',
                'stains_fruit' => false,
                'usage' => 'Phun khi cây đang nuôi đọt hoặc chuẩn bị làm hoa. Giúp điều khiển bộ lá đồng loạt, lá già nhanh, tập trung dinh dưỡng nuôi mầm hoa và cuống hoa mập khỏe.',
                'target' => 'Điều khiển bộ lá sầu riêng: già lá đồng loạt, ức chế đọt non bung ngoài ý muốn, kích thích ra mầm hoa tập trung, hoa bung cùng lúc để thu hoạch đồng loạt.',
                'crops' => 'Chuyên dùng cho Sầu Riêng (Musang King, Monthong, Ri6, D24, Chuồng Bò)',
                'form_type' => 'Chai 1 lít',
                'manufacturer' => 'Phân Bón Run Fast (ISO 9001)',
                'registration_number' => null,
                'isolation_period' => 'Không áp dụng (Phân bón lá điều khiển sinh trưởng)',
                'notes' => 'Sản phẩm New - Chuyên biệt 100% cho cây sầu riêng. Giúp nông dân kiểm soát thời điểm ra hoa, thu hoạch đồng loạt theo ý muốn.',
            ],
            [
                'category_id' => $catBenh->id,
                'name' => 'Validacin 5SL - Xanh Cây Sạch Gốc (Sumitomo 450ml)',
                'image' => 'pesticides/validacin-5sl-sumitomo-450ml.jpg',
                'active_ingredient' => 'Validamycin A: 50 g/lít (Nhóm 26 - Thuốc trừ bệnh sinh học)',
                'concentration' => '5SL - 50 g/l Validamycin A (Thể tích: 450 ml)',
                'water_volume' => 'Pha 1 chai 450ml cho 400 - 600 lít nước (2 - 3 phuy) tưới gốc hoặc pha 10 - 15ml/bình 8 lít phun qua lá',
                'stains_fruit' => false,
                'usage' => 'Tưới vào gốc cây hoặc phun ướt gốc thân và tán lá. Đặc biệt hiệu quả khi tưới gốc phòng trị lở cổ rễ và vàng lá thối gốc.',
                'target' => 'Đặc trị nấm bệnh vùng rễ và gốc thân: Lở cổ rễ (Rhizoctonia solani), Khô vằn lúa, Vàng lá thối gốc, Thối rễ nấm đất - Xanh cây - Sạch gốc.',
                'crops' => 'Lúa, Sầu riêng, Rau cải, Dưa hấu, Cây ăn trái, Cà phê, Hồ tiêu và hầu hết cây trồng nông nghiệp',
                'form_type' => 'Chai 450 ml (SL)',
                'manufacturer' => 'Sumitomo Chemical',
                'registration_number' => 'SL005 (Nhóm 26 - Thuốc trừ bệnh)',
                'isolation_period' => '3 ngày',
                'notes' => 'Kháng sinh sinh học an toàn nhóm 26, không gây kháng thuốc, không dính màu lên trái, không độc hại cho môi trường. Hiệu quả đặc biệt trong điều kiện đất ẩm nhiều.',
            ],
        ];

        foreach ($items as $item) {
            Pesticide::updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}
