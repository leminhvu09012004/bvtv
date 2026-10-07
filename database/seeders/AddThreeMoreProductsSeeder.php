<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class AddThreeMoreProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catPhanLa = Category::where('slug', 'phan-bon-la')->first()?->id ?? 31;
        $catViSinh = Category::where('slug', 'che-pham-vi-sinh')->first()?->id ?? 32;

        // 1. BỰ TỔ - NPK 21-21-21 PREMIUM TE
        Pesticide::updateOrCreate(
            ['name' => 'BỰ TỔ - NPK 21-21-21 PREMIUM TE (Gói 1kg)'],
            [
                'category_id'         => $catPhanLa,
                'image'               => 'pesticides/npk-21-21-21-premium-te-bu-to-1kg.jpg',
                'price'               => null,
                'active_ingredient'   => 'Đạm (Nts): 21%, Lân (P2O5hh): 21%, Kali (K2Ohh): 21% + TE (Vi lượng Chelate: Fe, Zn, Cu, Mn, B, Mo)',
                'concentration'       => 'NPK 21-21-21 + TE hòa tan hoàn toàn 100%',
                'form_type'           => 'GÓI 1KG - Dạng bột tinh thể hòa tan tinh khiết',
                'water_volume'        => '400 - 800 lít nước (2 - 4 phuy)',
                'stains_fruit'        => false,
                'target'              => 'Dinh dưỡng cân đối toàn diện: Dưỡng cây, dưỡng đọt, dưỡng hoa, thúc trái lớn nhanh, chống rụng trái non, trái to tròn đều, nhân to, tăng độ ngọt và màu sắc đẹp.',
                'crops'               => 'Sầu riêng, cam, bưởi, quýt, chanh, thanh long, xoài, cà phê, hồ tiêu, rau màu',
                'usage'               => "• Phun qua lá: Pha 25 - 50g cho bình 25 lít nước, hoặc 1 gói 1kg cho 400 - 800 lít nước (2 - 4 phuy 200L).\n• Tưới gốc / Tưới nhỏ giọt: Pha 1kg cho 400 - 600 lít nước tưới đều quanh vùng rễ.\n• Sử dụng định kỳ 7 - 10 ngày/lần trong giai đoạn cây con phát triển, giai đoạn nuôi hoa và giai đoạn nuôi trái lớn nhanh.",
                'manufacturer'        => 'NPK Premium High Tech Formula',
                'registration_number' => null,
                'isolation_period'    => 'Không áp dụng (Phân bón an toàn)',
                'notes'               => "Dòng phân bón NPK cao cấp tỉ lệ vàng 1:1:1 bổ sung vi lượng TE dạng Chelate:\n- Hòa tan nhanh và tan hoàn toàn 100% trong nước, không lắng cặn, không nghẹt béc phun.\n- Cân đối N-P-K giúp cây phát triển toàn diện, lá xanh dày bóng, đọt mập khỏe.\n- Dưỡng trái lớn nhanh đồng đều, nở gai sầu riêng, hạn chế nứt trái và thối trái.\n- Tăng sức chống chịu của cây trồng khi gặp thời tiết khắc nghiệt như hạn hán, ngập úng.",
                'variants'            => [
                    [
                        'size'         => 'Gói 1kg',
                        'price'        => null,
                        'water_volume' => '400 - 800 lít nước (2 - 4 phuy)',
                        'image'        => 'pesticides/npk-21-21-21-premium-te-bu-to-1kg.jpg',
                    ],
                ],
            ]
        );

        // 2. E.M PROTEASE (PHÂN Ủ EM) - CHẾ PHẨM SINH HỌC MT
        Pesticide::updateOrCreate(
            ['name' => 'E.M PROTEASE - Men Vi Sinh Ủ Phân Hữu Cơ (Chai 1L)'],
            [
                'category_id'         => $catViSinh,
                'image'               => 'pesticides/em-protease-phan-u-em-1l.jpg',
                'price'               => null,
                'active_ingredient'   => 'Tập đoàn vi sinh vật phân giải hữu cơ (Bacillus spp., Actinomyces spp., Saccharomyces spp., Lactobacillus spp.) + Enzyme thủy phân Protease & Cellulase',
                'concentration'       => 'Mật độ vi sinh vật hữu ích ≥ 10^8 CFU/ml',
                'form_type'           => 'CHAI 1 LÍT - Dạng dung dịch lên men vi sinh đậm đặc',
                'water_volume'        => 'Ủ 1 - 2 tấn nguyên liệu phân chuồng, rơm rạ hoặc 200 - 300kg cá tạp/bánh dầu',
                'stains_fruit'        => false,
                'target'              => 'Chế phẩm sinh học chuyên ủ phân hữu cơ: Phân giải nhanh rơm rạ, phân chuồng, cá tạp, bánh dầu; khử sạch mùi hôi thối, diệt trừ nấm bệnh và trứng tuyến trùng trong chất thải hữu cơ.',
                'crops'               => 'Ủ phân bón cho cây sầu riêng, cây có múi, cà phê, hồ tiêu, cây ăn trái và rau màu hữu cơ',
                'usage'               => "• Ủ phân cá / Bánh dầu: Pha 1 lít E.M Protease với 20 - 30 lít nước, tưới đều cho 200 - 300kg cá tạp hoặc bã đậu/bánh dầu. Bổ sung thêm mật rỉ đường, đậy kín ủ 30 - 45 ngày là dùng được.\n• Ủ phân chuồng / Rơm rạ / Vỏ cà phê: Pha 1 lít với 100 lít nước, tưới đều cho 1 - 2 tấn nguyên liệu độ ẩm 50 - 60%, đảo trộn định kỳ sau 15 ngày.\n• Khử mùi hôi chuồng trại: Pha 1 lít cho 50 - 100 lít nước phun trực tiếp lên đệm lót sinh học.",
                'manufacturer'        => 'CÔNG TY TNHH PHÂN BÓN MINH THẮNG (Đắk Lắk)',
                'registration_number' => null,
                'isolation_period'    => 'Không áp dụng (Chế phẩm sinh học thân thiện môi trường)',
                'notes'               => "Chế phẩm sinh học men ủ EM công nghệ mới của Phân Bón Minh Thắng:\n- Enzyme Protease phân cắt mạch đạm protein động vật cực nhanh, biến cá tạp thành dinh dưỡng axit amin dễ tiêu cho rễ cây hấp thụ ngay.\n- Khử mùi hôi thối chuồng trại và hố ủ phân vượt trội.\n- Bổ sung mật độ vi sinh vật đối kháng có lợi vào đất, ngăn ngừa thối rễ, vàng lá vi sinh vật gây hại.",
                'variants'            => [
                    [
                        'size'         => 'Chai 1 Lít',
                        'price'        => null,
                        'water_volume' => 'Ủ 1 - 2 tấn nguyên liệu hoặc 200 - 300kg cá tạp',
                        'image'        => 'pesticides/em-protease-phan-u-em-1l.jpg',
                    ],
                ],
            ]
        );

        // 3. PHÂN BÓN HỮU CƠ INNOzim
        Pesticide::updateOrCreate(
            ['name' => 'Phân Bón Hữu Cơ INNOzim (Lá To, Xanh, Dày - Phục Hồi Cây Suy)'],
            [
                'category_id'         => $catPhanLa,
                'image'               => 'pesticides/phan-bon-huu-co-innozim-500ml.jpg',
                'price'               => null,
                'active_ingredient'   => 'Hợp chất hữu cơ sinh học cao cấp, Axit Amin, Enzyme sinh học, Axit Fulvic và trung vi lượng chelate (Mg, Zn, B, Fe)',
                'concentration'       => 'Chất hữu cơ: ≥ 20%, bổ sung Axit Amin & Enzyme',
                'form_type'           => 'CHAI 500ML - Dạng dinh dưỡng hữu cơ sinh học lỏng',
                'water_volume'        => '400 - 500 lít nước (2 phuy)',
                'stains_fruit'        => false,
                'target'              => 'Lá to, xanh, dày bóng; phục hồi cây suy kiệt sau thu hoạch; kích thích ra hoa đậu quả đồng loạt; giảm rụng hoa và quả non; giúp cây trồng giải stress, vượt qua sốc nhiệt do nắng nóng hoặc mưa dầm.',
                'crops'               => 'Sầu riêng, cam, chanh, bưởi, mãng cầu, bơ, xoài, thanh long, cà phê, hồ tiêu, dưa leo, cà chua và rau màu',
                'usage'               => "• Pha 25ml cho bình 25 lít nước, hoặc 1 chai 500ml cho 400 - 500 lít nước (2 phuy 200L).\n• Phun ướt đều 2 mặt lá vào sáng sớm hoặc chiều mát.\n• Định kỳ 10 - 15 ngày/lần trong các giai đoạn phát triển cơi đọt, chuẩn bị làm bông, nuôi trái non và phục hồi sau thu hoạch.",
                'manufacturer'        => 'InnoLife Agroscience',
                'registration_number' => null,
                'isolation_period'    => 'Không áp dụng (Hữu cơ sinh học an toàn)',
                'notes'               => "Phân bón hữu cơ sinh học cao cấp INNOzim:\n- Tác động nhanh vào tế bào diệp lục giúp phiến lá nở to, xanh mướt, tăng độ dày của bản lá.\n- Kích hoạt cơ chế kháng sinh tự nhiên của cây, phục hồi nhanh chóng cây bị vàng lá, suy kiệt rễ.\n- Giúp hoa thụ phấn đều, cuống trái dai khỏe, giảm thiểu hiện tượng rụng trái non do sốc nước hoặc sốc nhiệt.\n- Dạng hữu cơ sinh học mát hoa, mát trái non, không gây lem nám trái.",
                'variants'            => [
                    [
                        'size'         => 'Chai 500ml',
                        'price'        => null,
                        'water_volume' => '400 - 500 lít nước (2 phuy)',
                        'image'        => 'pesticides/phan-bon-huu-co-innozim-500ml.jpg',
                    ],
                ],
            ]
        );
    }
}
