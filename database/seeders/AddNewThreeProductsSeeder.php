<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class AddNewThreeProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $catSau = Category::where('slug', 'thuoc-sau')->first()?->id ?? 29;
        $catNam = Category::where('slug', 'thuoc-nam')->first()?->id ?? 30;
        $catPhanGoc = Category::where('slug', 'phan-bon-goc')->first()?->id ?? 34;

        // 1. Agrifarm DOREEN HQ 77
        $p1 = Pesticide::updateOrCreate(
            ['name' => 'Agrifarm DOREEN HQ 77 (Phân bón hữu cơ 1kg)'],
            [
                'category_id'         => $catPhanGoc,
                'image'               => 'pesticides/agrifarm-doreen-hq-77-1kg.jpg',
                'price'               => null,
                'active_ingredient'   => 'Chất hữu cơ, Kali (K2O), Sắt (Fe), Magie (Mg), Canxi (Ca), Axit Humic & Fulvic sinh học',
                'concentration'       => 'Hữu cơ sinh học cao cấp bổ sung trung vi lượng (Fe, Mg, Ca, K)',
                'form_type'           => 'HŨ 1KG - Dạng bột hòa tan',
                'water_volume'        => '400 - 800 lít nước (2 - 4 phuy)',
                'stains_fruit'        => false,
                'target'              => 'Cân bằng và ổn định pH đất (Balances pH), kích thích phát triển bộ rễ cực mạnh (Root Booster), giải độc phèn, ngộ độc hữu cơ, tăng tốc độ hấp thu dưỡng chất (Faster nutrient uptake), phục hồi cây suy kiệt.',
                'crops'               => 'Sầu riêng, cam, chanh, bưởi, quýt, thanh long, cây ăn trái, hoa màu và cây công nghiệp',
                'usage'               => "• Tưới gốc: Pha 1kg cho 400 - 800 lít nước (2 - 4 phuy 200L), tưới đều quanh vùng tán rễ cây.\n• Rải gốc: Trộn đều với phân chuồng hoai mục hoặc phân NPK rải 50 - 100g/gốc tùy tuổi cây.\n• Định kỳ: Sử dụng 15 - 20 ngày/lần trong giai đoạn cây con, phục hồi sau thu hoạch hoặc phục hồi rễ bị nghẹt phèn.",
                'manufacturer'        => 'Agrifarm - Organic Fertilizer',
                'registration_number' => null,
                'isolation_period'    => 'Không áp dụng (An toàn sinh học)',
                'notes'               => "Phân bón hữu cơ cao cấp nhập khẩu công thức cân bằng pH đất tối ưu:\n- Balances pH: Tác động trực tiếp vào vùng rễ, nâng pH đất chua phèn về ngưỡng tối ưu 6.5 - 7.0.\n- Root Booster: Kích hoạt rễ tơ, rễ cám bung nhanh và dày đặc.\n- Faster Nutrient Uptake: Giúp cây hấp thụ phân bón khác nhanh gấp nhiều lần, hạn chế rửa trôi phân bón.",
                'variants'            => [
                    [
                        'size'         => 'Hũ 1kg',
                        'price'        => null,
                        'water_volume' => '400 - 800 lít nước (2 - 4 phuy)',
                        'image'        => 'pesticides/agrifarm-doreen-hq-77-1kg.jpg',
                    ],
                ],
            ]
        );

        // 2. Goldmite 240SC
        $p2 = Pesticide::updateOrCreate(
            ['name' => 'Goldmite 240SC (Đặc trị nhện kháng thuốc)'],
            [
                'category_id'         => $catSau,
                'image'               => 'pesticides/goldmite-240sc.jpg',
                'price'               => null,
                'active_ingredient'   => 'Spirodiclofen: 240 g/l + Phụ gia đặc biệt: 760 g/l',
                'concentration'       => '240SC (240 g/l)',
                'form_type'           => 'Huyền phù đậm đặc (SC)',
                'water_volume'        => '200 - 400 lít nước (1 - 2 phuy)',
                'stains_fruit'        => false,
                'target'              => 'Đặc trị nhện đỏ kháng thuốc, nhện vàng, nhện trắng hại lá và trái; diệt sạch nhện non, nhện trưởng thành và làm ung trứng nhện.',
                'crops'               => 'Sầu riêng, cam, chanh, quýt, bưởi, hoa hồng, chè, cây ăn trái và rau màu',
                'usage'               => "• Pha 20 - 25ml cho bình 25 lít nước, hoặc 1 chai cho 200 - 400 lít nước (1 - 2 phuy 200L).\n• Phun ướt đều tán lá, đặc biệt là mặt dưới của lá non và chùm đọt nơi nhện ẩn nấp.\n• Phun khi nhện mới chớm xuất hiện mật độ từ 3 - 5 con/lá.",
                'manufacturer'        => 'Goldmite Agroscience',
                'registration_number' => null,
                'isolation_period'    => '7 ngày',
                'notes'               => "Thuốc trừ nhện thế hệ mới với các đặc tính ưu việt:\n- Lưu dẫn 2 chiều cực mạnh: Thuốc ngấm sâu và phân bố đều tới mọi bề mặt lá.\n- Diệt nhện kháng thuốc: Cơ chế ức chế tổng hợp lipid độc đáo triệt tiêu các dòng nhện đã nhờn thuốc.\n- Làm ung trứng: Ngăn chặn triệt để lứa nhện tiếp theo nở ra.\n- Dạng SC hạt siêu mịn, mát bông, mát trái non, không gây lem trái hay nám da trái.",
                'variants'            => [
                    [
                        'size'         => 'Chai 240ml',
                        'price'        => null,
                        'water_volume' => '200 - 400 lít nước (1 - 2 phuy)',
                        'image'        => 'pesticides/goldmite-240sc.jpg',
                    ],
                ],
            ]
        );

        // 3. Amtech 100EW
        $p3 = Pesticide::updateOrCreate(
            ['name' => 'Amtech 100EW (Thỏ Ngọc - Cuộc Sống Mong Chờ)'],
            [
                'category_id'         => $catNam,
                'image'               => 'pesticides/amtech-100ew-250ml.jpg',
                'price'               => null,
                'active_ingredient'   => 'Anacardic Acid: 100 g/l + Phụ gia đặc biệt: 900 g/l',
                'concentration'       => '100EW (100 g/l)',
                'form_type'           => 'CHAI 250ML - Nhũ tương dầu trong nước (EW)',
                'water_volume'        => '200 - 400 lít nước (1 - 2 phuy)',
                'stains_fruit'        => false,
                'target'              => 'Phòng và trị cả bệnh do vi khuẩn và nấm hại: Thán thư, thối nhũn vi khuẩn, cháy bìa lá, đốm mắt cua, sương mai, ghẻ loét sẹo trái.',
                'crops'               => 'Rau màu, dưa leo, cà chua, ớt, sầu riêng, thanh long, cây có múi, lúa và hoa kiểng',
                'usage'               => "• Pha 25 - 30ml cho bình 25 lít nước, hoặc 1 chai 250ml cho 200 - 400 lít nước (1 - 2 phuy 200L).\n• Phun ướt đều thân lá khi bệnh mới chớm xuất hiện hoặc định kỳ phòng bệnh trước thời tiết bất lợi.\n• Phun xong thu hoạch ngay, rất thích hợp cho rau quả ăn tươi và xuất khẩu tiêu chuẩn sạch.",
                'manufacturer'        => 'Hóa Nông Hợp Phát (HP Guarantee)',
                'registration_number' => 'Bảo hộ sáng chế 20 năm số 1886/QĐ-SHTT (08/01/2019)',
                'isolation_period'    => '0 ngày (Phun xong thu hoạch ngay)',
                'notes'               => "Thuốc trừ bệnh hữu cơ sinh học đột phá công nghệ:\n- Bảo hộ sáng chế độc quyền 20 năm được Cục Sở hữu Trí tuệ cấp bằng chứng nhận.\n- Tác động kép: Tiêu diệt cả vi khuẩn và nấm gây bệnh hại mà không gây kháng thuốc.\n- An toàn tuyệt đối: Thời gian cách ly 0 ngày, tuyệt đối an toàn cho người tiêu dùng và môi trường.\n- Tươi lâu sau thu hoạch: Tăng sức đề kháng tế bào biểu bì, giúp rau củ quả giữ được độ tươi ngon lâu hơn sau khi hái.",
                'variants'            => [
                    [
                        'size'         => 'Chai 250ml',
                        'price'        => null,
                        'water_volume' => '200 - 400 lít nước (1 - 2 phuy)',
                        'image'        => 'pesticides/amtech-100ew-250ml.jpg',
                    ],
                ],
            ]
        );
    }
}
