<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class BenhThanThuSeeder extends Seeder
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

        // 1. Sao chép ảnh thực tế do người dùng vừa cung cấp (Lá sầu riêng cháy thán thư hình vân gợn sóng đồng tâm viền nâu sẫm quầng vàng)
        $src = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690281604.jpg';
        $filename = 'colletotrichum-than-thu-1.jpg';

        if (file_exists($src)) {
            copy($src, "$destDir/$filename");
            $savedImages[] = "diseases/$filename";
        }

        // 2. Dữ liệu hồ sơ bệnh học chuẩn cho Colletotrichum - Thán thư
        $diseaseData = [
            'name' => 'Bệnh Thán Thư — Colletotrichum spp. (Cháy Lá Vân Đồng Tâm, Thối Hoa & Thối Quả Non)',
            'pathogen_type' => 'nam_benh',
            'folder_code' => 'B-05',
            'folder_group' => 'nam_benh',
            'folder_name' => '5-Colletotrichum - thán thư',
            'folder_number' => 5,
            'caunho' => 'Thán thư = CHÁY TỪ CHÓP LÁ & MÉP LÁ VÀO, VÂN GỢN SÓNG ĐỒNG TÂM VIỀN NÂU SẪM (thối hoa rụng quả non). Dập dịch bằng Azoxystrobin + Difenoconazole (Asmiltatop Super), Tebuconazole (Tebaz), Áo giáp Kẽm Propineb (Antracol), Mancozeb 80WP và Pyraclostrobin (Headline).',
            'symptoms' => "• Trên phiến lá (Triệu chứng phá hại đặc trưng nhất như hình ảnh thực tế bạn gửi):\n- Vết bệnh bắt đầu xuất hiện từ chóp lá hoặc men theo mép phiến lá (nơi đọng nước mưa và sương sớm lâu nhất), sau đó lan rộng dần vào trong phiến lá hướng về gân chính.\n- Vết cháy lá có dạng hình bán nguyệt hoặc bất định với các ĐƯỜNG VÂN GỢN SÓNG ĐỒNG TÂM (Concentric Zones) rất rõ nét.\n- Mô bệnh bị khô giòn màu nâu xám hoặc xám tro; ranh giới giữa phần mô bệnh chết khô và phần mô lá khỏe mạnh là một ĐƯỜNG VIỀN NÂU SẪM LƯỢN SÓNG kèm theo một QUẦNG VÀNG tươi bao bọc xung quanh.\n- Vào thời tiết ẩm ướt hoặc mưa dầm, trên vết bệnh hình thành các chấm đen li ti (ổ bào tử vô tính acervuli) xếp thành vòng đồng tâm; khi độ ẩm bão hòa có thể tiết ra giọt nhầy màu hồng nhạt chứa hàng triệu bào tử nấm lây lan theo nước mưa.\n- Bệnh nặng làm lá khô cháy cong queo từng mảng lớn và rụng sớm hàng loạt, cành cây bị trơ trụi cành trơ lá.\n• Trên chùm hoa & nụ hoa non:\n- Vết bệnh màu nâu đen xuất hiện ở cánh hoa và cuống hoa, làm nụ hoa thâm đen, teo tóp và rụng hoa non hàng loạt (thán thư rụng bông sầu riêng, cà phê, xoài, điều).\n• Trên quả non & quả bánh tẻ:\n- Vết đốm hình tròn màu nâu sẫm hơi lõm sâu xuống vỏ quả, làm quả non bị rụng sớm; quả lớn bị thối đen cục bộ, sượng nứt vỏ, giảm phẩm cấp nghiêm trọng.\n• Trên cành non & đọt non:\n- Vết bệnh làm teo thắt cành non, khô chết ngược từ ngoài ngọn vào trong thân (hiện tượng khô đọt dieback).",
            'symptoms_detail' => [
                'la' => 'Cháy từ chóp lá và mép lá vào; vết cháy có đường vân gợn sóng đồng tâm, ranh giới viền nâu sẫm quầng vàng rõ nét; lá khô giòn và rụng hàng loạt.',
                'canh_than' => 'Vết đốm thâm đen lõm làm teo thắt cành non, gây hiện tượng khô chết ngọn cành (chết ngược dieback).',
                'goc_re' => 'Không gây hại trực tiếp dưới bộ rễ.',
                'qua' => 'Hoa thâm đen rụng bông hàng loạt; quả non xuất hiện đốm nâu tròn hơi lõm, gây rụng quả non và nứt thối vỏ trái.',
            ],
            'prevention' => "1. Cắt tỉa tạo tán thông thoáng: Định kỳ tỉa bỏ cành la, cành vượt rậm rạp, cành tăm bên trong tán để đón ánh sáng mặt trời chiếu xuyên vào tán lá (bào tử nấm Colletotrichum phát tán cực mạnh trong điều kiện tán lá rậm rạp, ẩm ướt, thiếu sáng).\n2. Vệ sinh tàn dư vườn triệt để: Thu gom toàn bộ lá bệnh rụng, cành khô và hoa quả bị thối thán thư rơi rụng dưới gốc mang ra xa vườn tiêu hủy để dập tắt nguồn lây lan bào tử nấm.\n3. Bón phân cân đối, tăng độ dày vách tế bào: Không bón thừa phân đạm (N) làm mô lá mỏng mềm dễ nhiễm nấm. Tăng cường bón Kali, Canxi, Silic và Kẽm để tăng độ dày lớp cutin biểu bì lá và vỏ trái.\n4. Phun phòng định kỳ trong các giai đoạn mẫn cảm: Phun ngừa thán thư vào các thời điểm cây bung cơi đọt non, giai đoạn phân hóa mầm hoa, trước khi hoa nở và sau khi đậu quả non bằng các dòng tiếp xúc bảo vệ như Antracol 70WP, Mancozeb 80WP hoặc Đồng Xanh Mekong Agro.",
            'treatment' => "1. NGUYÊN TẮC ĐẶC TRỊ THÁN THƯ:\n• Xử lý dập dịch ngay khi phát hiện những đốm cháy mép lá hoặc chóp lá đầu tiên.\n• Phối hợp thuốc nội hấp lưu dẫn mạnh để tiêu diệt sợi nấm bên trong mô lá + thuốc tiếp xúc bám dính để bao phủ bề mặt, tiêu diệt các ổ bào tử đen li ti, ngăn chặn lây lan sang các lá lành.\n\n2. Phác đồ hóa học đặc trị luân phiên:\n• Cặp đôi Triazole + Strobilurin đặc trị thán thư (FRAC 3 + FRAC 11): Asmiltatop Super 400SC (Azoxystrobin + Difenoconazole), Tebaz 400SC (Azoxystrobin + Tebuconazole). Hiệu lực lưu dẫn 2 chiều dập tắt sợi nấm, chặn đứng vết cháy loang rộng sau 48h, giúp vết bệnh khô giòn miệng.\n• Pyraclostrobin thế hệ mới (FRAC 11): Headline 250EC BASF. Hiệu lực dập bào tử phổ rộng, bảo vệ toàn diện bộ lá và chùm hoa quả non, giúp lá xanh dày bóng khỏe.\n• Nhóm Áo giáp Kẽm bảo vệ tiếp xúc (FRAC M03): Propineb (Antracol 70WP, Nofacol 700WP), Mancozeb 80WP. Bổ sung Kẽm Zinc++ tinh khiết giúp vách lá cứng cáp, bảo vệ cuống hoa quả non dai khỏe.\n• Nhóm Triazole đơn: Anvil 5SC (Hexaconazole), Tilt Super 300EC làm khô và cô lập nhanh các vết cháy thán thư cũ.\n\n3. Dưỡng lá, dai cuống hoa quả sau bệnh:\n• Phun bổ sung Axit Amin đạm cá hữu cơ và Tinh chất Tảo biển Seaweed (Xanh Um Monyka, Tang Truong Panaxilus) kết hợp Canxi-Bo và Enzyme (Weyzym-A) để dai cuống hoa, chống rụng quả non và phục hồi tán lá xanh dày.",
            'chemical_groups' => 'Azoxystrobin / Difenoconazole (Asmiltatop Super - FRAC 11 + FRAC 3), Azoxystrobin / Tebuconazole (Tebaz 400SC - FRAC 11 + FRAC 3), Pyraclostrobin (Headline 250EC - FRAC 11), Propineb + Kẽm Zinc++ (Antracol 70WP / Nofacol 700WP - FRAC M03), Hexaconazole (Anvil 5SC - FRAC 3), Difenoconazole + Propiconazole (Tilt Super - FRAC 3), Mancozeb 80WP, Đồng Chelate, Amino Acid & Tinh chất Tảo biển Seaweed',
            'notes' => "Lưu ý thực tế từ kỹ sư BVTV:\n• Bệnh thán thư Colletotrichum là dịch hại số 1 phá hoại trên hầu hết các cây trồng: Sầu riêng (cháy lá thán thư, rụng bông thối quả non), Cà phê (thán thư khô cành quả), Hồ tiêu, Chanh dây, Cây có múi, Xoài, Điều, Bơ.\n• Nấm thán thư thường xâm nhập cơ hội qua các vết châm chích của bọ xít muỗi, bọ trĩ hoặc các tổn thương cơ học sau mưa bão.\n• Vết cháy thán thư dễ nhầm với cháy lá do thiếu Kali hoặc cháy nắng; điểm phân biệt chính xác là THÁN THƯ LUÔN CÓ ĐƯỜNG VÂN GỢN SÓNG ĐỒNG TÂM VÀ VIỀN NÂU SẪM RÕ RỆT.\n• Tài liệu tham khảo: Viện Cây ăn quả Miền Nam (SOFRI), Cục Bảo vệ Thực vật, Viện KHKT Nông Lâm nghiệp Tây Nguyên (WASI).",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Sầu riêng, Cà phê, Hồ tiêu, Chanh dây, Cây có múi',
            'treatment_plans' => [
                [
                    'title'        => 'Phác đồ 1: Đặc trị dập dịch Thán thư cháy lá & Rụng hoa thối quả non (Azoxystrobin + Difenoconazole + Áo giáp Kẽm Propineb)',
                    'badge'        => 'Đặc trị dập dịch',
                    'badge_color'  => 'emerald',
                    'stage'        => 'Khi phát hiện các vết cháy lá hình vân gợn sóng đồng tâm xuất hiện ở chóp và mép lá, hoặc hoa non bị thâm đen',
                    'dosage_guide' => 'Pha 1 chai Asmiltatop Super 400SC (200ml) hoặc Tebaz 400SC (200ml) + 1 gói Antracol 70WP (300g) hoặc Nofacol 700WP (300g) + 1 chai Weyzym-A (100ml) cho 200 lít nước (1 phuy). Phun ướt đẫm đều 2 mặt lá, chùm hoa và quả non.',
                    'safety_note'  => 'Lưu dẫn 2 chiều dập tắt sợi nấm, cô lập vết cháy khô miệng sau 48h. Phun nhắc lại lần 2 sau 5 - 7 ngày nếu trời mưa ẩm kéo dài.',
                    'groups'       => [
                        [
                            'label'                => 'Azoxystrobin + Difenoconazole / Tebuconazole lưu dẫn dập dịch',
                            'primary_pesticide_id' => 10, // Asmiltatop Super 400SC
                            'substitute_ids'       => [190], // TEBAZ 400SC
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Áo giáp Kẽm Propineb bảo vệ biểu bì lá & cuống hoa',
                            'primary_pesticide_id' => 7, // Antracol 70WP Bayer
                            'substitute_ids'       => [27], // NOFACOL 700WP
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Enzyme & Canxi-Bo chống rụng lá, chống rụng hoa quả non',
                            'primary_pesticide_id' => 158, // Weyzym-A Multiagro48
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 2: Luân phiên Triazole dập sợi nấm & Pyraclostrobin bảo vệ toàn diện, chống kháng thuốc',
                    'badge'        => 'Dập bào tử phổ rộng',
                    'badge_color'  => 'sky',
                    'stage'        => 'Phun luân phiên chống kháng thuốc, giai đoạn lá chuyển lụa hoặc sau các đợt mưa to gió lớn',
                    'dosage_guide' => 'Pha 1 chai Headline 250EC (200ml) + 1 chai Anvil 5SC (250ml) hoặc Tilt Super (200ml) + 1 gói Mancozeb 80WP (300g) cho 200 lít nước. Phun ướt đều tán lá.',
                    'safety_note'  => 'Pyraclostrobin thế hệ mới dập tắt mầm bào tử nấm lây lan trong không khí, giúp lá xanh dày bóng, ngăn nấm thâm nhập vào chùm hoa quả non.',
                    'groups'       => [
                        [
                            'label'                => 'Pyraclostrobin thế hệ mới dập sạch bào tử nấm',
                            'primary_pesticide_id' => 21, // HEADLINE 250EC BASF
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Hexaconazole / Tilt Super thẩm thấu sâu làm khô vết bệnh',
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
                    'title'        => 'Phác đồ 3: Phục hồi bộ lá sau thán thư, dưỡng đọt mập & tăng đậu quả non',
                    'badge'        => 'Phục hồi xanh lá',
                    'badge_color'  => 'amber',
                    'stage'        => 'Sau khi dập sạch thán thư, cần phục hồi quang hợp cho tán lá và dưỡng hoa đậu quả',
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

        // 3. Gắn các cây trồng mẫn cảm: Sầu riêng, Cà phê, Hồ tiêu, Chanh dây, Cây có múi
        $targetCropNames = ['Sầu riêng', 'Cà phê', 'Hồ tiêu', 'Chanh dây', 'Cây có múi'];
        $linkedCropIds = Crop::whereIn('name', $targetCropNames)->pluck('id')->toArray();
        if (!empty($linkedCropIds)) {
            $disease->crops()->sync($linkedCropIds);
        }

        // 4. Liên kết các thuốc BVTV có sẵn trong kho đặc trị Colletotrichum / thán thư
        // Asmiltatop (10), Tebaz (190), Antracol (7), Nofacol (27), Headline (21), Anvil (9), Tilt Super (37), Mancozeb (26), Đồng Xanh (17), Weyzym-A (158), Xanh Um Monyka (159), Tang Truong Panaxilus (152), MgO - Kẽm EDTA (111)
        $targetPesticideIds = [10, 190, 7, 27, 21, 9, 37, 26, 17, 158, 159, 152, 111];
        $validPesticideIds = Pesticide::whereIn('id', $targetPesticideIds)->pluck('id')->toArray();

        if (!empty($validPesticideIds)) {
            $disease->pesticides()->sync($validPesticideIds);
        }
    }
}
