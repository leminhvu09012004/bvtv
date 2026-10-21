<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class BenhPhanTrangSeeder extends Seeder
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

        // 1. Sao chép ảnh người dùng vừa cung cấp (Bệnh phấn trắng trên chanh dây và quả non)
        $userMedia1 = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791688358477.jpg';
        $destFile1 = 'phan-trang-1.jpg';

        if (file_exists($userMedia1)) {
            copy($userMedia1, "$destDir/$destFile1");
            $savedImages[] = "diseases/$destFile1";
        }

        // 2. Dữ liệu hồ sơ bệnh học chuẩn cho Bệnh Phấn Trắng
        $diseaseData = [
            'name' => 'Bệnh Phấn Trắng (Powdery Mildew — Oidium spp. / Erysiphe spp.)',
            'pathogen_type' => 'nam_benh',
            'folder_code' => 'B-11',
            'folder_group' => 'nam_benh',
            'folder_name' => '11-Phấn trắng',
            'folder_number' => 11,
            'caunho' => 'Phấn trắng = Bột trắng như bột mì phủ lá non, nụ hoa & quả non; quả bị chai sượng biến dạng gồ ghề u cục. Đặc trị bằng nhóm Triazole (Hexaconazole, Difenoconazole, Tebuconazole), Strobilurin (Azoxystrobin, Pyraclostrobin) + Áo giáp kẽm Propineb.',
            'symptoms' => "• Trên lá non: Ban đầu là các chấm đốm nhỏ màu trắng mờ như rắc bột phấn ở mặt trên hoặc mặt dưới phiến lá non và bánh tẻ. Vết bệnh nhanh chóng lan rộng liên kết thành một lớp màng phấn trắng xóa như bột mì hoặc phấn rôm bao phủ toàn bộ bề mặt lá. Lá bị nhiễm nấm mép cuốn cong queo, gợn sóng biến dạng, chùn chọt, mô lá bị hút hết dinh dưỡng chuyển sang vàng úa rồi khô giòn và rụng sớm.\n• Trên đọt non & tua cuốn (chanh dây, bầu bí, nho): Các chồi non, búp hoa và tua cuốn bị bao phủ bởi lớp bụi phấn trắng dày đặc. Ngọn cây bị chùn đọt, teo tóp đốt ngắn lại, khô ngọn và ngừng sinh trưởng.\n• Trên hoa: Nụ hoa và cánh hoa bị nấm phấn trắng tấn công làm hoa bị thâm đen, teo tóp không bung nở được, hoặc nở ra bị khô héo rụng hàng loạt, làm giảm tỷ lệ đậu trái nghiêm trọng.\n• Trên quả non & quả già (rất điển hình trên chanh dây, nho, xoài, táo, dưa):\n- Giai đoạn quả non: Vỏ trái bị phủ một lớp phấn trắng mỏng như rắc bột mì.\n- Khi quả phát triển: Các tế bào biểu bì vỏ quả nơi nấm ký sinh bị hoại tử, mất tính đàn hồi và hóa bần chai sần. Khi quả lớn lên, phần vỏ lành phát triển bình thường còn phần vỏ bệnh bị co thắt, làm quả bị biến dạng méo mó dị dạng, vỏ sần sùi nổi u cục gồ ghề, da quả chai sượng, nứt nẻ, ruột ít dịch, mất hoàn toàn giá trị thương phẩm xuất khẩu.",
            'symptoms_detail' => [
                'la' => 'Lớp phấn trắng mịn như bột mì phủ kín mặt trên và mặt dưới lá non; phiến lá bị biến dạng quăn queo mép lá gợn sóng, mô lá chuyển vàng úa, khô giòn và rụng sớm.',
                'canh_than' => 'Đọt non, chồi hoa và tua cuốn bị phủ bụi phấn trắng mốc, chùn đọt, đốt ngắn còi cọc, khô chết ngọn non.',
                'goc_re' => 'Không gây hại trực tiếp dưới bộ rễ.',
                'qua' => 'Vỏ quả non bị bao phủ bởi lớp phấn trắng; khi lớn vỏ hóa bần chai sạn làm quả bị méo mó dị dạng, vỏ nổi u cục sần sùi ghồ ghề, chai sượng ruột ít nước, nứt trái mất giá trị xuất khẩu.',
            ],
            'prevention' => "1. Tỉa cành tạo tán thông thoáng: Định kỳ cắt tỉa cành tăm, chồi vượt, lá già rậm rạp bên dưới giàn để ánh sáng mặt trời chiếu sâu vào mọi ngóc ngách của tán cây. Bào tử nấm phấn trắng phát triển mạnh trong điều kiện râm mát, độ ẩm không khí cao nhưng rất nhạy cảm và dễ chết dưới ánh nắng mặt trời trực tiếp.\n2. Quản lý phân bón cân đối: Không bón thừa phân đạm (N) làm cây phát đọt quá non mềm, mọng nước dễ nhiễm bệnh. Bổ sung định kỳ Canxi, Silic, Lân và Kali (đặc biệt là MKP 0-52-34) để giúp bộ lá nhanh già, làm dày cứng vách tế bào biểu bì chống nấm xâm nhập.\n3. Vệ sinh vườn: Dọn sạch tàn dư lá, cành và quả bệnh rơi rụng quanh gốc đem tiêu hủy xa vườn để triệt tiêu nguồn bào tử nấm tái nhiễm.\n4. Tưới nước hợp lý: Hạn chế tưới phun mưa vào buổi chiều tối làm ẩm ướt đọng trên lá và quả non qua đêm tạo điều kiện cho bào tử phấn trắng nảy mầm.",
            'treatment' => "1. NGUYÊN TẮC ĐẶC TRỊ PHẤN TRẮNG:\n• Nấm phấn trắng (Oidium / Erysiphe) là loài nấm ngoại ký sinh, sợi nấm và cơ quan sinh sản chủ yếu phát triển trên bề mặt mô non của cây. Do đó các hoạt chất có tính tiếp xúc mạnh kết hợp nội hấp lưu dẫn cực kỳ hiệu quả dập dịch nhanh chóng.\n• Phun thuốc ngay khi lớp bụi phấn trắng chớm xuất hiện trên chồi non hoặc quả non.\n\n2. Phác đồ hóa học đặc trị luân phiên:\n• Nhóm DMI / Triazole (FRAC 3): Hexaconazole (Anvil 5SC, Japa Vil 110SC), Difenoconazole, Tebuconazole (Tebaz 400SC), Propiconazole (Tilt Super). Tác động nội hấp lưu dẫn mạnh mẽ, ức chế sinh tổng hợp ergosterol màng tế bào nấm, dập tắt sợi nấm đang phát triển.\n• Nhóm QoI / Strobilurin (FRAC 11): Azoxystrobin (Asmiltatop Super 400SC, Tebaz 400SC), Pyraclostrobin (Headline 250EC). Ức chế hô hấp ty thể của nấm, hiệu lực kéo dài, làm xanh mướt lá và sáng bóng da trái.\n• Nhóm Áo giáp Kẽm bảo vệ tiếp xúc (FRAC M03): Propineb (Antracol 70WP, Nofacol 700WP). Tạo màng bảo vệ bên ngoài, bổ sung vi lượng Kẽm tinh khiết (Zinc++) giúp lá cứng cáp, trái bóng đẹp.\n• Hãm nấm phấn trắng sinh lý: Phun MKP 0-52-34 giúp nhanh thuần thục cơi đọt, hạ độ ẩm bề mặt mô lá, ức chế bào tử phấn trắng nảy mầm.\n\n3. Phục hồi da quả và bộ lá sau khi dập dịch:\n• Phun bổ sung Phân bón lá hữu cơ Enzyme & Canxi Chelate (Weyzym-A Multiagro48), Tinh chất Tảo biển & Amino (Xanh Um Monyka) và Vi lượng Chelate (Tang Truong Panaxilus) để phục hồi tế bào vỏ trái, hạn chế tối đa hiện tượng méo trái và chai sượng.",
            'chemical_groups' => 'Hexaconazole (Triazole nội hấp - FRAC 3), Azoxystrobin / Difenoconazole (Strobilurin & Triazole đặc trị phổ rộng - FRAC 11 + FRAC 3), Tebuconazole (Triazole lưu dẫn - FRAC 3), Pyraclostrobin (Strobilurin thế hệ mới - FRAC 11), Propineb + Zinc++ (Áo giáp Kẽm bảo vệ tiếp xúc - FRAC M03), Propiconazole (Triazole diệt nấm nhanh - FRAC 3), Mono Potassium Phosphate MKP 0-52-34, Canxi Chelate & Enzyme sinh học',
            'notes' => "Lưu ý thực tế từ kỹ sư BVTV:\n• Bệnh phấn trắng gây hại nặng nề nhất trên: Chanh dây, Nho, Xoài, Cây có múi (cam, quýt, bưởi), Sầu riêng, Dưa leo, Dưa lưới, Cà chua, Ớt, Hoa hồng.\n• Điều kiện thời tiết thuận lợi: Thời tiết hanh khô ban ngày, sương mù hoặc ẩm độ cao ban đêm, biên độ nhiệt độ ngày đêm lớn.\n• Không phối hợp thuốc trừ nấm gốc Lưu huỳnh với dầu khoáng hoặc thuốc gốc Đồng trong thời tiết nắng nóng gay gắt để tránh làm cháy lá non và thui chùm hoa.\n• Tài liệu tham khảo: Viện Cây ăn quả Miền Nam (SOFRI), Trung tâm Bảo vệ Thực vật Phía Nam, Cục Bảo vệ Thực vật.",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Chanh dây, Sầu riêng, Cây có múi, Xoài, Bầu bí dưa',
            'treatment_plans' => [
                [
                    'title'        => 'Phác đồ 1: Đặc trị dập dịch Phấn Trắng trên hoa & quả non (Chống rụng hoa, ngừa méo chai trái)',
                    'badge'        => 'Đặc trị dứt điểm',
                    'badge_color'  => 'emerald',
                    'stage'        => 'Khi chớm thấy lớp phấn trắng bám trên cuống hoa, cánh hoa hoặc vỏ quả non',
                    'dosage_guide' => 'Pha 1 chai Asmiltatop Super 400SC (250ml) + 1 gói Antracol 70WP (1kg) cho 400 - 500 lít nước. Phun ướt đều chùm hoa, trái non và toàn bộ tán lá.',
                    'safety_note'  => 'Phối hợp Azoxystrobin + Difenoconazole lưu dẫn dập tắt sợi nấm kết hợp Propineb (Kẽm Zinc++) tạo áo giáp bảo vệ bên ngoài, giúp hoa sáng đẹp, quả non lớn nhanh không bị nám méo.',
                    'groups'       => [
                        [
                            'label'                => 'Thuốc trừ nấm phấn trắng nội hấp 2 chiều',
                            'primary_pesticide_id' => 10, // ASMILTATOP SUPER 400SC
                            'substitute_label'     => 'Hoặc thay thế bằng thuốc tương đương:',
                            'substitute_ids'       => [190], // TEBAZ 400SC
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Áo giáp Kẽm bảo vệ tiếp xúc & dưỡng xanh bóng trái',
                            'primary_pesticide_id' => 7, // Antracol 70WP Bayer
                            'substitute_label'     => 'Hoặc thay thế bằng:',
                            'substitute_ids'       => [27], // NOFACOL 700WP
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Dưỡng chất Enzyme & Canxi Chelate chống chai sạn, nứt méo quả',
                            'primary_pesticide_id' => 158, // WEYZYM-A MULTIAGRO48
                            'substitute_label'     => 'Hoặc dưỡng amino lá dày:',
                            'substitute_ids'       => [159], // Xanh Um Monyka
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 2: Trừ nấm phấn trắng chùn ngọn & cháy đọt non (Triazole nội hấp + Pyraclostrobin)',
                    'badge'        => 'Trừ nấm chùn đọt',
                    'badge_color'  => 'blue',
                    'stage'        => 'Khi đọt non, tua cuốn và chồi búp bị phấn trắng phủ mốc làm co rúm biến dạng',
                    'dosage_guide' => 'Pha 1 chai ANVIL 5SC (1 lít) + 1 chai HEADLINE 250EC (100ml) cho 400 lít nước. Phun xoáy ướt đẫm các cơi đọt non.',
                    'safety_note'  => 'Hexaconazole nội hấp lưu dẫn cực mạnh kết hợp Pyraclostrobin thế hệ mới tiêu diệt triệt để bào tử phấn trắng, kích hoạt tính kháng cây trồng, giúp đọt non bung tược mập khỏe.',
                    'groups'       => [
                        [
                            'label'                => 'Hexaconazole nội hấp trừ phấn trắng',
                            'primary_pesticide_id' => 9, // ANVIL SYNGENTA 5SC
                            'substitute_label'     => 'Hoặc thay thế bằng:',
                            'substitute_ids'       => [22, 37], // Japa Vil 110SC Monyka, TILT SUPER SYNGENTA
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Pyraclostrobin lưu dẫn diệt bào tử',
                            'primary_pesticide_id' => 21, // HEADLINE 250EC BASF
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Vi lượng Chelate hồi phục cơi đọt',
                            'primary_pesticide_id' => 152, // TANG TRUONG PANAXILUS
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 3: Quản lý sinh lý già lá & hãm bào tử phấn trắng nảy mầm',
                    'badge'        => 'Chặn đọt già lá',
                    'badge_color'  => 'amber',
                    'stage'        => 'Giai đoạn chuẩn bị làm bông hoặc thời tiết ẩm ướt nấm phấn trắng có nguy cơ bùng phát',
                    'dosage_guide' => 'Pha 1kg MKP 0-52-34 (Monyka / Chipbet) cho 400 lít nước. Phun ướt đều tán lá non để nhanh thuần thục cơi đọt.',
                    'safety_note'  => 'Hàm lượng Lân 52% và Kali 34% siêu cao giúp làm dày cứng lớp biểu bì lá, khô ráo mặt lá, triệt tiêu môi trường ẩm độ ưa thích của nấm phấn trắng.',
                    'groups'       => [
                        [
                            'label'                => 'MKP 0-52-34 hãm phấn trắng & già lá',
                            'primary_pesticide_id' => 114, // MKP MONYKA 1KG
                            'substitute_label'     => 'Hoặc thay thế bằng:',
                            'substitute_ids'       => [113], // MKP CHIPBET 1KG
                        ],
                    ],
                ],
            ],
        ];

        $disease = Disease::updateOrCreate(
            ['name' => $diseaseData['name']],
            $diseaseData
        );

        // 3. Gắn các cây trồng mẫn cảm: Chanh dây, Sầu riêng, Cây có múi, Xoài, Bầu bí dưa
        $targetCropNames = ['Chanh dây', 'Sầu riêng', 'Cây có múi'];
        $linkedCropIds = Crop::whereIn('name', $targetCropNames)->pluck('id')->toArray();
        if (!empty($linkedCropIds)) {
            $disease->crops()->sync($linkedCropIds);
        }

        // 4. Liên kết các thuốc BVTV có sẵn trong kho đặc trị phấn trắng (tuyệt đối không tạo mới thuốc)
        // Antracol (7), Anvil (9), Asmiltatop (10), Headline (21), Japa Vil (22), Nofacol (27), Tilt Super (37), MKP Chipbet (113), MKP Monyka (114), Tang Truong Panaxilus (152), Weyzym-A (158), Xanh Um Monyka (159), Tebaz (190)
        $targetPesticideIds = [7, 9, 10, 21, 22, 27, 37, 113, 114, 152, 158, 159, 190];
        $validPesticideIds = Pesticide::whereIn('id', $targetPesticideIds)->pluck('id')->toArray();

        if (!empty($validPesticideIds)) {
            $disease->pesticides()->sync($validPesticideIds);
        }
    }
}
