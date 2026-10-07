<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class Batch12PesticidesSeeder extends Seeder
{
    /**
     * Run the database seeds for Batch 12:
     * - AMINO 281 CHIPBET (phân bón lá)
     * - NANO SATE NEWFOSINATE 150SL (thuốc trừ cỏ)
     * - LƯU DẪN 200 GLUX 200SL (thuốc trừ cỏ)
     * - F8 EDTA CHỐNG RỤNG CHẮC CUỐNG (phân bón lá)
     */
    public function run(): void
    {
        $catLa = Category::where('slug', 'phan-bon-la')->first();

        $catCo = Category::firstOrCreate(
            ['slug' => 'thuoc-tru-co'],
            [
                'name' => 'thuốc trừ cỏ',
                'icon' => '🌾',
                'description' => 'Các loại thuốc trừ cỏ dại, cỏ không chọn lọc và cỏ chọn lọc trong vườn cây ăn trái, cây công nghiệp',
            ]
        );

        $items = [
            [
                'category_id' => $catLa->id,
                'name' => 'AMINO 281 CHIPBET - Axit Amin 28,1% (Chai 440ml)',
                'image' => 'pesticides/amino-281-chipbet-440ml.jpg',
                'active_ingredient' => 'Axit Amin (Amino Acid) tổng hợp: 28,1% (theo kết quả thử nghiệm KT3-01936AHO5)',
                'concentration' => '28,1% Axit Amin (Dạng lỏng, lắc đều trước khi dùng)',
                'water_volume' => 'Pha 1 chai 440ml cho 180 - 220 lít nước (1 phuy) phun đều tán lá hoặc tưới gốc',
                'stains_fruit' => false,
                'usage' => 'Lắc đều trước khi sử dụng. Phun qua lá hoặc tưới vùng gốc định kỳ 7 - 14 ngày/lần. Dùng được trong mọi giai đoạn sinh trưởng của cây.',
                'target' => 'Kích rễ mạnh nhanh, dưỡng cây xanh tốt, ổn định sinh lý, chống sốc nhiệt và sốc phân, phục hồi cây nhanh sau thu hoạch, sau ngập úng hoặc sau phun thuốc trừ sâu bệnh nặng.',
                'crops' => 'Đa dụng cho mọi loại cây trồng: Cây ăn trái (Sầu riêng, Cam, Bưởi, Chanh dây), Cây công nghiệp (Cà phê, Tiêu), Rau củ quả và Hoa kiểng',
                'form_type' => 'Chai 440 ml',
                'manufacturer' => 'CHIPBET',
                'registration_number' => 'KT3-01936AHO5',
                'isolation_period' => 'Không áp dụng (Phân bón lá sinh học)',
                'notes' => 'Hàm lượng Axit Amin cao 28,1% giúp cây hấp thu nhanh qua bề mặt lá và rễ, an toàn tuyệt đối cho bông và trái non.',
            ],
            [
                'category_id' => $catCo->id,
                'name' => 'NANO SATE NEWFOSINATE 150SL (Siêu Diệt Cỏ Không Chọn Lọc)',
                'image' => 'pesticides/nano-sate-newfosinate-150sl.jpg',
                'active_ingredient' => 'Glufosinate ammonium: 150 g/l + Phụ gia đặc biệt: 850 g/l',
                'concentration' => '150 g/l Glufosinate ammonium (SL - Dung dịch tan trong nước)',
                'water_volume' => 'Pha 1 lít/bình 16 - 20 lít nước phun ướt đều cỏ dại (Không phun lên cây trồng)',
                'stains_fruit' => false,
                'usage' => 'Phun trực tiếp lên cỏ dại khi cỏ đang sinh trưởng mạnh (chiều cao 10 - 30 cm), phun ướt đều thân lá cỏ. Một lần phun sạch bóng cỏ dại trong 7 - 14 ngày.',
                'target' => 'Siêu diệt cỏ không chọn lọc: tiêu diệt hoàn toàn các loại cỏ dại gồm cỏ tranh, cỏ gấu, cỏ mần trầu, cỏ lồng vực và các loại cỏ lá rộng trong vườn cây ăn trái.',
                'crops' => 'Dùng kiểm soát cỏ dại trong vườn: Sầu riêng, Cà phê, Hồ tiêu, Cao su, Thanh long, Cây ăn trái các loại (Phun chụp, không để thuốc tiếp xúc cây trồng)',
                'form_type' => 'Chai (SL)',
                'manufacturer' => 'Công ty CP Quốc tế Công nghệ Nano Nhật Bản',
                'registration_number' => 'NEWFOSINATE-150SL',
                'isolation_period' => 'Không áp dụng (Thuốc trừ cỏ)',
                'notes' => 'Cảnh báo: Có hại nếu nuốt phải, tiếp xúc da hoặc hít phải. Tránh để thuốc dính vào cây trồng. Không phun khi gió to.',
            ],
            [
                'category_id' => $catCo->id,
                'name' => 'THUỐC TRỪ CỎ LƯU DẪN 200 - GLUX 200SL (USAGRO 900ml)',
                'image' => 'pesticides/luu-dan-200-glux-200sl-usagro-900ml.jpg',
                'active_ingredient' => 'Glufosinate ammonium: 200 g/l + Phụ gia đặc biệt vừa đủ 1 lít',
                'concentration' => '200 g/l Glufosinate ammonium (Lưu dẫn mạnh - Thế hệ mới)',
                'water_volume' => 'Pha 1 lít/bình 16 - 20 lít nước phun ướt đều cỏ dại (Phun ít - Sạch cỏ nhiều)',
                'stains_fruit' => false,
                'usage' => 'Phun trực tiếp lên cỏ đang sinh trưởng. Thuốc lưu dẫn hấp thu qua lá và lan xuống toàn bộ hệ thống rễ, diệt cỏ tận gốc hiệu lực kéo dài 15 - 20 ngày.',
                'target' => 'Diệt cỏ tận gốc - Hiệu lực kéo dài: tiêu diệt mọi loại cỏ dại trong vườn, hàm lượng hoạt chất cao 200g/l, lưu dẫn mạnh, phun ít mà sạch cỏ nhiều.',
                'crops' => 'Kiểm soát cỏ dại trong vườn: Sầu riêng, Cà phê, Hồ tiêu, Cao su, Mía, Cây ăn trái và đất trống trước khi trồng (Phun chụp, tránh cây trồng)',
                'form_type' => 'Chai 900 ml (SL)',
                'manufacturer' => 'USAGRO',
                'registration_number' => 'GLUX-200SL',
                'isolation_period' => 'Không áp dụng (Thuốc trừ cỏ)',
                'notes' => 'Cảnh báo: Có thể có hại nếu nuốt phải, tiếp xúc da hoặc hít phải. Sau khi phun: Cỏ vàng khô sau 5 - 7 ngày, tận gốc sau 10 - 14 ngày.',
            ],
            [
                'category_id' => $catLa->id,
                'name' => 'F8 EDTA - CHỐNG RỤNG CHẮC CUỐNG (Gói 250g - Korea)',
                'image' => 'pesticides/f8-edta-chong-rung-chac-cuong-250g.jpg',
                'active_ingredient' => 'Canxi (Ca): 5%, Silic hữu hiệu (SiO2hh): 3%, Magie (Mg): 1,6%, Sắt (Fe): 60 ppm, Mangan (Mn): 50 ppm (Dạng EDTA Chelate - Nguyên liệu Korea)',
                'concentration' => 'Ca 5% + SiO2 3% + Mg 1.6% + Fe 60ppm + Mn 50ppm (Phân bón lá Trung-Vi lượng EDTA)',
                'water_volume' => 'Pha 250g - 500g cho 200 lít nước (1 phuy) phun ướt đều tán lá và cuống trái',
                'stains_fruit' => false,
                'usage' => 'Phun vào giai đoạn hoa nở, đậu trái non, nuôi trái và 20 - 30 ngày trước thu hoạch. Định kỳ 10 - 15 ngày/lần. Nước pha trong suốt, không gây nám trái, không dính cặn.',
                'target' => 'Chống rụng hoa và rụng trái non tức thì, chắc cuống trái bền vững: xanh lá, dày lá, cứng cây, hoa bền, ngăn nứt dọc cuống; trái tròn đều, xanh da, xanh gai, gai nhìm; cơm vàng đều, chống sượng cơm, tăng trữ lượng đường và tinh bột.',
                'crops' => 'Sầu riêng, Bưởi, Cam, Quýt, Chanh, Xoài, Mít, Thanh long, Nhãn, Vải và tất cả cây ăn trái',
                'form_type' => 'Gói 250 g (EDTA Chelate - Korea)',
                'manufacturer' => 'Nguyên liệu Korea (Hàn Quốc)',
                'registration_number' => null,
                'isolation_period' => 'Không áp dụng (Phân bón lá trung vi lượng)',
                'notes' => 'Pha nước trong suốt hoàn toàn, không gây nám trái, không để lại cặn bám trên trái. An toàn cho bông và trái ở mọi giai đoạn. Nguyên liệu EDTA cao cấp Hàn Quốc.',
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
