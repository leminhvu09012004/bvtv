<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class Batch11PesticidesSeeder extends Seeder
{
    /**
     * Run the database seeds for Batch 11 products.
     */
    public function run(): void
    {
        $catLa = Category::where('slug', 'phan-bon-la')->first();
        $catGoc = Category::where('slug', 'phan-bon-goc')->first();

        $items = [
            [
                'category_id' => $catLa->id,
                'name' => 'MX 3 (1-21-21+3Zn) CÂY ĂN TRÁI - MAI XUÂN',
                'image' => 'pesticides/mx3-1-21-21-3zn-mai-xuan.jpg',
                'active_ingredient' => 'Đạm (Nts): 1%, Lân hữu hiệu (P2O5): 21%, Kali hữu hiệu (K2O): 21%, Kẽm (Zn): 3% (30.000 ppm)',
                'concentration' => '1-21-21 + 3% Zn (Dạng bột tinh khiết hòa tan)',
                'water_volume' => 'Pha 400g - 500g cho 200 - 220 lít nước (1 phuy) phun đều tán lá',
                'stains_fruit' => false,
                'usage' => 'Phun khi cơi đọt đã mở hết lá hoặc trước khi làm bông 15 - 20 ngày. Định kỳ phun 2 lần cách nhau 7 - 10 ngày để lá già đồng loạt, ức chế đọt non phát triển.',
                'target' => 'Lá già nhanh, chuyển lụa đồng loạt, tạo mầm hoa cực tốt, ức chế đọt non bung ngoài ý muốn khi cây đang mang bông hoặc mang trái non, hạn chế rụng hoa và rụng trái non sinh lý.',
                'crops' => 'Sầu riêng, Cam, Quýt, Bưởi, Xoài, Nhãn, Mãng cầu, Vải, Mận, Chôm chôm, Cây ăn trái các loại',
                'form_type' => 'Hũ (Dạng bột)',
                'manufacturer' => 'Công ty TNHH Mai Xuân (Tem bảo đảm chính hãng)',
                'registration_number' => null,
                'isolation_period' => 'Không áp dụng (Phân bón lá)',
                'notes' => 'Chuyên dùng chặn đọt và tạo mầm hoa sầu riêng vụ nghịch và vụ thuận. Giúp cuống hoa mập khỏe, tỷ lệ đậu trái cao.',
            ],
            [
                'category_id' => $catGoc->id,
                'name' => 'ROOTS Humic Amino 100% Organic Korea (Xô)',
                'image' => 'pesticides/roots-humic-amino-korea.jpg',
                'active_ingredient' => 'Humic Acid tinh khiết + Acid Fulvic + Amino Acid tự nhiên + Tinh chất Tảo biển Seaweed 100% Organic Hàn Quốc',
                'concentration' => '100% Organic Made in Korea (Dạng cao cấp hòa tan)',
                'water_volume' => '1 xô hòa 3.000 - 5.000 lít nước (15 - 25 phuy 200L) tưới gốc hoặc bón 150 - 300g/gốc',
                'stains_fruit' => false,
                'usage' => 'Tưới gốc quanh tán cây định kỳ 15 - 20 ngày/lần vào đầu mùa mưa, sau thu hoạch hoặc giai đoạn phục hồi rễ.',
                'target' => 'Kích ra rễ tơ cực mạnh, hạ phèn, giải độc hữu cơ, xốp đất phì nhiêu, nuôi rễ khỏe, tăng khả năng hấp thu phân bón đa trung vi lượng, phục hồi cây suy kiệt vàng lá thối rễ.',
                'crops' => 'Sầu riêng, Cà phê, Hồ tiêu, Cam, Bưởi, Chanh dây, Mít, Thanh long, Bơ, Cây ăn trái và rau màu',
                'form_type' => 'Xô (Dạng hòa tan tưới gốc)',
                'manufacturer' => 'Made in Korea (Hàn Quốc)',
                'registration_number' => null,
                'isolation_period' => 'Không áp dụng (Hữu cơ sinh học)',
                'notes' => 'Sự kết hợp hoàn hảo giữa Humic, Organic, Amino và Sea Weed giúp hệ vi sinh vật đất phát triển mạnh, rễ bung trắng xóa.',
            ],
            [
                'category_id' => $catLa->id,
                'name' => 'N3M - Ra Rễ Cực Mạnh (Hũ 100g)',
                'image' => 'pesticides/n3m-ra-re-cuc-manh-100g.jpg',
                'active_ingredient' => 'Nts: 11%, P2O5hh: 3%, K2Ohh: 2.5%, Mn, Fe, Zn, Cu mỗi loại: 2.000 ppm, B: 200 ppm + Phụ gia vừa đủ 100%',
                'concentration' => 'N-P-K + Vi lượng chelate đậm đặc (Hũ 100g)',
                'water_volume' => 'Giâm cành: 20g/L nước; Tưới gốc: 20g/10L nước; Phun lá: 20g/16L nước; Ngâm hạt: 20g/20L nước',
                'stains_fruit' => false,
                'usage' => 'Dùng giâm chiết cành, tưới phục hồi gốc cây suy yếu hoặc cây mới trồng, ngâm kích thích nảy mầm hạt giống, phun dưỡng lá non đâm tược.',
                'target' => 'Kích thích phát triển rễ cực mạnh trong giâm cành, chiết cành, chuyển chậu; phục hồi bộ rễ hư tổn sau ngập úng, khô hạn hoặc nhiễm phèn.',
                'crops' => 'Cây ăn trái, Cây kiểng (Mai vàng, Đào, Bonsai, Hoa lan, Hoa hồng), Cây công nghiệp, Rau màu và vườn ươm giống',
                'form_type' => 'Hũ 100 g',
                'manufacturer' => 'Công ty TNHH MTV Sinh Hóa Nông Phú Lâm',
                'registration_number' => null,
                'isolation_period' => 'Không áp dụng (Phân bón lá kích rễ)',
                'notes' => 'Thương hiệu kích rễ quốc dân N3M nổi tiếng hiệu quả, an toàn, kích ra rễ nhanh chóng chỉ sau 5 - 7 ngày sử dụng.',
            ],
            [
                'category_id' => $catLa->id,
                'name' => 'ALL PURPOSE PLANT FOOD 10-10-10 GRO-POWER (Chai 240ml)',
                'image' => 'pesticides/gro-power-10-10-10-plant-food-240ml.jpg',
                'active_ingredient' => 'N: 10%, P2O5: 10%, K2O: 10% + Chelated Trace Elements (Sắt, Kẽm, Mangan, Đồng, Bo dạng chelate hấp thụ cao)',
                'concentration' => '10-10-10 (100% Water Soluble Liquid Concentrate with Chelated Trace Elements)',
                'water_volume' => 'Pha 1 - 2ml/lít nước (Chai 240ml pha cho 150 - 250 lít nước) phun lá hoặc tưới gốc',
                'stains_fruit' => false,
                'usage' => 'Phun định kỳ 7 - 14 ngày/lần trong mọi giai đoạn sinh trưởng của cây trồng, đặc biệt dưỡng cây sau thu hoạch hoặc giai đoạn nuôi trái non.',
                'target' => 'Dinh dưỡng toàn năng 10-10-10 cân đối tuyệt hảo: Dưỡng cây khỏe, dày lá xanh mướt, tăng sức đề kháng sâu bệnh, dưỡng hoa bung đều và trái lớn bóng đẹp.',
                'crops' => 'Cây ăn trái (Sầu riêng, Cam quýt bưởi, Nho, Bơ), Cây công nghiệp, Rau củ quả, Hoa cảnh và Turf cỏ sân vườn',
                'form_type' => 'Chai 8 oz (240 ml)',
                'manufacturer' => 'GRO-POWER (USA / Nhập khẩu cao cấp)',
                'registration_number' => null,
                'isolation_period' => 'Không áp dụng (Dinh dưỡng lỏng vi lượng)',
                'notes' => '100% Water Soluble Liquid Concentrate with Chelated Trace Elements. Công thức nhập khẩu chuyên dụng cho cây mẫn cảm.',
            ],
            [
                'category_id' => $catLa->id,
                'name' => 'AMINO - SEAWEED XANH UM (Đại Lợi 01 - MONYKA 10KG)',
                'image' => 'pesticides/amino-seaweed-xanh-um-dai-loi-01-10kg.jpg',
                'active_ingredient' => 'Axit Amin hữu hiệu từ đạm cá biển + Tinh chất Tảo biển Seaweed Hàn Quốc + NPK đa lượng + Vi lượng Chelate',
                'concentration' => 'Dạng cô đặc cao cấp (Nguyên liệu xuất xứ Hàn Quốc)',
                'water_volume' => 'Pha 1 gói 10kg cho 2.000 - 4.000 lít nước (10 - 20 phuy 200L) tưới gốc hoặc phun tán lá',
                'stains_fruit' => false,
                'usage' => 'Pha nước tưới gốc hoặc phun ướt đều tán lá định kỳ 10 - 15 ngày/lần giai đoạn cây con, sau thu hoạch, đâm chồi hoặc dưỡng trái lớn.',
                'target' => 'Ra rễ nhanh, đâm chồi cực mạnh, xanh um bộ lá, dày lá bóng mượt, phục hồi cây suy kiệt, dưỡng trái non mau lớn, nở trái bóng trái, tăng năng suất tối đa.',
                'crops' => 'Tất cả các loại Cây ăn quả (Sầu riêng, Mít, Cam, Bưởi, Thanh long), Cây công nghiệp (Cà phê, Tiêu), Rau màu, Cây lấy củ, Cây giống',
                'form_type' => 'Bao tráng bạc 10 KG (Dạng cô đặc)',
                'manufacturer' => 'MONYKA (Nguyên liệu cao cấp sản xuất tại Hàn Quốc)',
                'registration_number' => null,
                'isolation_period' => 'Không áp dụng (Phân bón sinh học cao cấp)',
                'notes' => 'Sản phẩm kết hợp giữa nguyên liệu cao cấp nhập khẩu Hàn Quốc. Dùng chung cho tất cả các loại cây trồng, tan hoàn toàn.',
            ]
        ];

        foreach ($items as $item) {
            Pesticide::updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}
