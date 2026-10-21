<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class BenhAlternariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destDir = storage_path('app/public/diseases');
        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        $savedImages = [];

        // 1. Sao chép 2 ảnh thực tế do người dùng vừa cung cấp
        // Ảnh 1: Vết đốm nâu có quầng vàng rõ nét bao quanh (Alternaria)
        $src1 = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690214831.jpg';
        $filename1 = 'alternaria-1.jpg';
        if (file_exists($src1)) {
            copy($src1, "$destDir/$filename1");
            $savedImages[] = "diseases/$filename1";
        }

        // Ảnh 2: Đốm nâu tròn trên lá sầu riêng (Alternaria trên sầu riêng)
        $src2 = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690214855.jpg';
        $filename2 = 'alternaria-2.jpg';
        if (file_exists($src2)) {
            copy($src2, "$destDir/$filename2");
            $savedImages[] = "diseases/$filename2";
        }

        // 2. Dữ liệu hồ sơ bệnh học chuẩn cho Alternaria - Đốm nâu
        $diseaseData = [
            'name' => 'Bệnh Đốm Nâu — Alternaria spp. (Đốm Nâu Lá, Đốm Vòng Sầu Riêng, Chanh Dây & Cây Có Múi)',
            'pathogen_type' => 'nam_benh',
            'folder_code' => 'B-06',
            'folder_group' => 'nam_benh',
            'folder_name' => '6-Alternaria - đốm nâu',
            'folder_number' => 6,
            'caunho' => 'Alternaria = ĐỐM NÂU ĐỒNG TÂM QUẦNG VÀNG RÕ NÉT (tâm khô giòn rách thủng). Trị bằng Difenoconazole, Tebuconazole (Tebaz), Azoxystrobin (Asmiltatop), Propineb (Antracol) và Pyraclostrobin (Headline).',
            'symptoms' => "• Trên phiến lá (Triệu chứng phá hại đặc trưng nhất như 2 hình ảnh thực tế):\n- Ban đầu xuất hiện những chấm nhỏ màu nâu nhạt hoặc nâu đỏ rải rác trên bề mặt lá non lẫn lá bánh tẻ.\n- Vết bệnh mở rộng nhanh thành các đốm hình tròn hoặc hình bầu dục bất định màu nâu sẫm đến nâu đen, thường có các đường vân vòng tròn đồng tâm.\n- Dấu hiệu nhận diện quan trọng nhất: XUNG QUANH MỖI VẾT ĐỐM NÂU LUÔN CÓ MỘT QUẦNG MÀU VÀNG TƯƠI (Yellow Halo) VIỀN RẤT RÕ NÉT.\n- Khi thời tiết khô hanh, phần tâm vết bệnh bị khô giòn, chuyển sang màu xám nâu và dễ bị rách thủng lỗ chỗ (dạng mắt cua / thủng lá). Khi thời tiết mưa ẩm kéo dài, các đốm liên kết lại làm phiến lá vàng úa từng mảng lớn, cháy khô từ chóp lá vào và rụng sớm hàng loạt, giàn cây bị trơ cành xơ xác.\n• Trên quả non & quả bánh tẻ:\n- Vết đốm màu nâu hơi lõm nhẹ xuống bề mặt vỏ quả, xung quanh có quầng úng nước hoặc viền vàng.\n- Vết bệnh làm quả bị nám xỉn màu, da sần sùi biến dạng, quả non dễ bị rụng hoặc thối khô cục bộ trước thu hoạch.\n• Trên cành non & cuống lá:\n- Vết bệnh hình bầu dục dài màu nâu đen lõm xuống, làm teo tóp cuống lá khiến lá rụng hàng loạt, cành non bị khô chết dần.",
            'symptoms_detail' => [
                'la' => 'Vết đốm nâu tròn có vân đồng tâm, xung quanh có quầng vàng rõ nét viền bao quanh; tâm khô giòn dễ rách thủng; lá vàng úa và rụng sớm hàng loạt.',
                'canh_than' => 'Vết đốm bầu dục màu nâu đen lõm xuống làm teo thắt cuống lá, khô chết cành non.',
                'goc_re' => 'Không gây hại trực tiếp dưới bộ rễ.',
                'qua' => 'Vỏ quả xuất hiện các đốm nâu tròn hơi lõm có quầng vàng; vỏ quả bị nám xỉn, sần sùi và dễ rụng non.',
            ],
            'prevention' => "1. Cắt tỉa tạo tán thông thoáng: Định kỳ cắt tỉa cành la, cành sâu bệnh bên trong tán để ánh nắng chiếu sâu vào thân cây (bào tử nấm Alternaria lây lan cực mạnh nhờ gió và giọt mưa trong điều kiện tán rậm rạp ẩm ướt).\n2. Vệ sinh tàn dư vườn: Thu gom toàn bộ lá bệnh rụng dưới gốc mang ra xa vườn tiêu hủy để triệt tiêu nguồn lây lan bào tử nấm tồn dư.\n3. Bón phân cân đối, làm dày vách tế bào: Không bón thừa phân đạm (N) làm lá mỏng mềm dễ nhiễm bệnh. Tăng cường bón Kali, Canxi, Silic và Kẽm để làm dày cứng lớp biểu bì sáp trên mặt lá.\n4. Phun phòng bảo vệ định kỳ: Phun phòng ngừa trong giai đoạn cây bung cơi đọt non và mùa mưa bằng các dòng tiếp xúc bảo vệ như Antracol 70WP, Mancozeb 80WP hoặc Đồng Xanh Mekong Agro.",
            'treatment' => "1. NGUYÊN TẮC ĐẶC TRỊ ALTERNARIA (ĐỐM NÂU):\n• Xử lý ngay khi phát hiện những đốm nâu quầng vàng đầu tiên trên cơi đọt non hoặc lá bánh tẻ.\n• Kết hợp thuốc nội hấp lưu dẫn mạnh để dập tắt sợi nấm bên trong mô lá + thuốc tiếp xúc bám dính bảo vệ để tiêu diệt màng bào tử bên ngoài, ngăn ngừa lây lan sang các lá lành.\n\n2. Phác đồ hóa học đặc trị luân phiên:\n• Cặp đôi Triazole + Strobilurin (FRAC 3 + FRAC 11): Tebuconazole + Azoxystrobin (Tebaz 400SC), Difenoconazole + Azoxystrobin (Asmiltatop Super 400SC). Lưu dẫn 2 chiều cực mạnh, dập tắt sợi nấm, giúp vết đốm khô miệng và chặn đứng quầng vàng lan rộng sau 2-3 ngày.\n• Pyraclostrobin thế hệ mới (FRAC 11): Headline 250EC BASF. Hiệu lực dập bào tử phổ rộng, giúp bộ lá xanh dày, bóng mướt, tăng quang hợp.\n• Nhóm Áo giáp Kẽm bảo vệ tiếp xúc (FRAC M03): Propineb (Antracol 70WP, Nofacol 700WP), Mancozeb 80WP. Bổ sung vi lượng Kẽm tinh khiết giúp vách lá cứng cáp, ngăn nấm chọc thủng biểu bì.\n• Nhóm Triazole đơn: Anvil 5SC (Hexaconazole), Tilt Super 300EC cô lập và làm khô nhanh các vết đốm nâu cũ.\n\n3. Dưỡng lá & phục hồi cơi đọt sau bệnh:\n• Phun bổ sung Axit Amin hữu cơ, Tinh chất Rong biển Seaweed (Xanh Um Monyka, Tang Truong Panaxilus) kết hợp MgO - Kẽm EDTA để phục hồi diệp lục tố, dưỡng tán lá xanh dày bóng khỏe trở lại.",
            'chemical_groups' => 'Azoxystrobin / Tebuconazole (Tebaz 400SC - FRAC 11 + FRAC 3), Azoxystrobin / Difenoconazole (Asmiltatop Super - FRAC 11 + FRAC 3), Pyraclostrobin (Headline 250EC - FRAC 11), Propineb + Kẽm Zinc++ (Antracol 70WP / Nofacol 700WP - FRAC M03), Hexaconazole (Anvil 5SC - FRAC 3), Difenoconazole + Propiconazole (Tilt Super - FRAC 3), Mancozeb 80WP, Đồng Chelate, Amino Acid & Tinh chất Tảo biển phục hồi lá',
            'notes' => "Lưu ý thực tế từ kỹ sư BVTV:\n• Bệnh đốm nâu Alternaria phá hại nghiêm trọng trên: Sầu riêng (đốm lá, rụng lá non), Chanh dây (đốm nâu chanh dây), Cây có múi (đốm nâu cam quýt Alternaria citri), Cà chua / Khoai tây (bệnh đốm vòng / sớm Alternaria solani).\n• Nấm Alternaria sinh sản vô số bào tử phân sinh phát tán cực xa theo gió; vào mùa mưa bão độ ẩm cao bệnh có thể bùng phát thành dịch làm rụng trơ trụi cành chỉ trong 7 - 10 ngày nếu không phun phòng kịp thời.\n• Tài liệu tham khảo: Viện Cây ăn quả Miền Nam (SOFRI), Cục Bảo vệ Thực vật, Viện Nghiên cứu Rau quả (FAVRI).",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Sầu riêng, Chanh dây, Cây có múi, Cà phê',
            'treatment_plans' => [
                [
                    'title'        => 'Phác đồ 1: Đặc trị dập dịch Đốm nâu Alternaria & Vàng lá quầng vàng (Tebuconazole + Azoxystrobin + Áo giáp Kẽm Propineb)',
                    'badge'        => 'Đặc trị dứt điểm',
                    'badge_color'  => 'emerald',
                    'stage'        => 'Khi phát hiện các đốm nâu quầng vàng xuất hiện rải rác trên lá non và lá bánh tẻ',
                    'dosage_guide' => 'Pha 1 chai Tebaz 400SC (200ml) hoặc Asmiltatop Super 400SC (200ml) + 1 gói Antracol 70WP (300g) hoặc Nofacol 700WP (300g) + 1 chai Weyzym-A (100ml) cho 200 lít nước (1 phuy). Phun ướt đẫm đều 2 mặt lá và cành non.',
                    'safety_note'  => 'Lưu dẫn 2 chiều dập tắt sợi nấm, cô lập vết đốm khô miệng sau 48h. Phun nhắc lại lần 2 sau 5 - 7 ngày nếu trời mưa ẩm dầm dề.',
                    'groups'       => [
                        [
                            'label'                => 'Azoxystrobin + Tebuconazole / Difenoconazole lưu dẫn dập dịch',
                            'primary_pesticide_id' => 190, // TEBAZ 400SC
                            'substitute_ids'       => [10], // Asmiltatop Super 400SC
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Áo giáp Kẽm Propineb bảo vệ biểu bì lá',
                            'primary_pesticide_id' => 7, // Antracol 70WP Bayer
                            'substitute_ids'       => [27], // NOFACOL 700WP
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Enzyme & Canxi-Bo chống rụng lá, dày vách tế bào',
                            'primary_pesticide_id' => 158, // Weyzym-A Multiagro48
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 2: Luân phiên dập bào tử phổ rộng, bảo vệ cơi đọt & sáng bóng da quả',
                    'badge'        => 'Dập bào tử phổ rộng',
                    'badge_color'  => 'sky',
                    'stage'        => 'Phun luân phiên chống kháng thuốc, giai đoạn lá chuyển lụa hoặc sau các đợt mưa to',
                    'dosage_guide' => 'Pha 1 chai Headline 250EC (200ml) + 1 chai Anvil 5SC (250ml) hoặc Tilt Super (200ml) + 1 gói Mancozeb 80WP (300g) cho 200 lít nước. Phun ướt đều tán lá.',
                    'safety_note'  => 'Pyraclostrobin thế hệ mới dập tắt mầm bào tử nấm lây lan trong không khí, giúp lá xanh dày bóng, ngăn nấm chọc thủng da quả.',
                    'groups'       => [
                        [
                            'label'                => 'Pyraclostrobin thế hệ mới dập sạch bào tử nấm',
                            'primary_pesticide_id' => 21, // HEADLINE 250EC BASF
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Hexaconazole / Tilt Super thẩm thấu sâu làm khô vết đốm',
                            'primary_pesticide_id' => 9, // Anvil 5SC Syngenta
                            'substitute_ids'       => [37], // Tilt Super
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Mancozeb tiếp xúc bám dính bề mặt lá',
                            'primary_pesticide_id' => 26, // MANCOZEB 80WP
                            'substitute_ids'       => [17], // Đồng Xanh Mekong Agro
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 3: Phục hồi tán lá xanh dày, chống cháy chóp & tái tạo cơi đọt khỏe',
                    'badge'        => 'Xanh lá dày đọt',
                    'badge_color'  => 'amber',
                    'stage'        => 'Sau khi dập sạch bệnh đốm nâu, cần phục hồi quang hợp và nuôi cơi đọt mới mập khỏe',
                    'dosage_guide' => 'Pha 1 chai Xanh Um Monyka (500ml) + 1 chai Tang Truong Panaxilus (500ml) + 1 chai MgO - Kẽm EDTA (250ml) cho 400 lít nước. Phun ướt đều 2 mặt lá.',
                    'safety_note'  => 'Cung cấp Axit Amin đạm cá hữu cơ, Tinh chất Rong biển Seaweed và Kẽm, Magie Chelate giúp tái tạo diệp lục tố, dày phiến lá, chống cháy chóp lá non.',
                    'groups'       => [
                        [
                            'label'                => 'Axit Amin đạm cá & Tinh chất tảo biển Seaweed',
                            'primary_pesticide_id' => 159, // Xanh Um Monyka
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Vi lượng Chelate kích thích bung đọt mập cành',
                            'primary_pesticide_id' => 152, // TANG TRUONG PANAXILUS
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Magie & Kẽm Chelate chống cháy chóp lá',
                            'primary_pesticide_id' => 111, // MgO - Kẽm EDTA
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
            ],
        ];

        $disease = Disease::updateOrCreate(
            ['name' => $diseaseData['name']],
            $diseaseData
        );

        // 3. Gắn các cây trồng mẫn cảm: Sầu riêng, Chanh dây, Cây có múi, Cà phê
        $targetCropNames = ['Sầu riêng', 'Chanh dây', 'Cây có múi', 'Cà phê'];
        $linkedCropIds = Crop::whereIn('name', $targetCropNames)->pluck('id')->toArray();
        if (!empty($linkedCropIds)) {
            $disease->crops()->sync($linkedCropIds);
        }

        // 4. Liên kết các thuốc BVTV có sẵn trong kho đặc trị Alternaria / đốm nâu
        // Tebaz (190), Asmiltatop (10), Antracol (7), Nofacol (27), Headline (21), Anvil (9), Tilt Super (37), Mancozeb (26), Đồng Xanh (17), Weyzym-A (158), Xanh Um Monyka (159), Tang Truong Panaxilus (152), MgO - Kẽm EDTA (111)
        $targetPesticideIds = [190, 10, 7, 27, 21, 9, 37, 26, 17, 158, 159, 152, 111];
        $validPesticideIds = Pesticide::whereIn('id', $targetPesticideIds)->pluck('id')->toArray();

        if (!empty($validPesticideIds)) {
            $disease->pesticides()->sync($validPesticideIds);
        }
    }
}
