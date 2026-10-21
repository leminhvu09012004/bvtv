<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class BenhPhomopsisSeeder extends Seeder
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

        // 1. Sao chép các ảnh thực tế do người dùng cung cấp
        $mediaMap = [
            'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690169043.jpg' => 'phomopsis-1.jpg',
            'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690169071.jpg' => 'phomopsis-2.jpg',
            'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791703791406.jpg' => 'phomopsis-3.jpg',
        ];

        foreach ($mediaMap as $src => $filename) {
            if (file_exists($src)) {
                copy($src, "$destDir/$filename");
                $savedImages[] = "diseases/$filename";
            } elseif (file_exists("$destDir/$filename")) {
                $savedImages[] = "diseases/$filename";
            }
        }

        // 2. Dữ liệu hồ sơ bệnh học chuẩn cho Phomopsis
        $diseaseData = [
            'name' => 'Bệnh Đốm Lá, Đốm Mắt Cua — Phomopsis durionis (Bệnh Phomopsis Sầu Riêng)',
            'pathogen_type' => 'nam_benh',
            'folder_code' => 'B-08',
            'folder_group' => 'nam_benh',
            'folder_name' => '8-Phomopsis - đốm lá',
            'folder_number' => 8,
            'caunho' => 'Phomopsis = ĐỐM NÂU TRÒN QUẦNG VÀNG RÕ NÉT (Đốm mắt cua chi chít trên lá non & bánh tẻ, lá vàng rụng sớm). Trị bằng Difenoconazole + Azoxystrobin (Asmiltatop Super), Tebuconazole (Tebaz), Áo giáp Kẽm Propineb (Antracol) + Pyraclostrobin (Headline).',
            'symptoms' => "• Trên lá non & lá bánh tẻ (Triệu chứng mắt cua điển hình):\n- Ban đầu là những chấm nhỏ li ti màu vàng hoặc nâu nhạt như đầu kim xuất hiện rải rác trên bề mặt phiến lá non.\n- Vết bệnh nhanh chóng phát triển to dần thành các đốm tròn hoặc bầu dục (đường kính 1–3 mm), phần tâm ở giữa có màu nâu đen hoặc xám tro, và xung quanh viền vết bệnh luôn xuất hiện một quầng sáng màu vàng tươi rất rõ nét (quầng halo).\n- Khi thời tiết mưa ẩm hoặc sương mù kéo dài, hàng trăm vết đốm mắt cua liên kết lại với nhau làm lá bị thủng lỗ chỗ, biến dạng mép lá gợn sóng, mô lá chuyển sang màu vàng úa loang lổ.\n- Bệnh nặng làm lá non bị khô giòn, co rúm và rụng hàng loạt từ dưới cành lên trên, khiến cây bị trơ cành còi cọc, quang hợp kém và suy kiệt trước giai đoạn phân hóa mầm hoa.\n• Trên đọt non & chồi cành:\n- Vết đốm nấm có thể lan sang cuống lá và cành non gây hiện tượng thối cuống, cành non bị đốm nâu teo tóp, chùn ngọn.",
            'symptoms_detail' => [
                'la' => 'Vết đốm tròn màu nâu đen ở tâm, có quầng viền vàng sáng halo rất rõ nét bao quanh (đốm mắt cua); đốm xuất hiện chi chít làm lá vàng rực, thủng lỗ chỗ và rụng sớm hàng loạt.',
                'canh_than' => 'Nấm có thể lan sang cuống lá và cành non làm khô cuống, cành non teo tóp còi cọc.',
                'goc_re' => 'Không gây hại trực tiếp dưới bộ rễ.',
                'qua' => 'Đôi khi đốm mắt cua lấm tấm bám lên vỏ trái non làm vỏ sần sùi, giảm phẩm cấp xuất khẩu.',
            ],
            'prevention' => "1. Tỉa cành tạo tán thông thoáng: Dọn dẹp sạch cành tăm, cành sâu bệnh, cành mọc sát mặt đất để gió lưu thông và ánh nắng rọi đều vào tán lá. Bào tử nấm Phomopsis phát tán rất nhanh nhờ giọt nước mưa bắn tung tóe trong vườn rậm rạp.\n2. Vệ sinh tàn dư vườn: Thu gom toàn bộ lá bệnh rơi rụng dưới gốc mang ra xa vườn tiêu hủy để cắt đứt nguồn bào tử nấm tái nhiễm.\n3. Bón phân cân đối & dưỡng dày lá: Không bón thừa đạm (N) làm lá non mỏng mềm mọng nước. Tăng cường bổ sung Canxi, Silic, Kẽm và Kali (đặc biệt là MKP 0-52-34) để lá nhanh thuần thục, vách tế bào dày cứng chống kim nấm đâm thủng.\n4. Phun phòng định kỳ khi ra cơi đọt mới: Khi cơi đọt vừa nhú búp lá non (búp mũi giáo đến mở lá), tiến hành phun phòng ngừa bằng các dòng thuốc áo giáp tiếp xúc như Antracol 70WP hoặc Đồng Xanh.",
            'treatment' => "1. NGUYÊN TẮC ĐẶC TRỊ PHOMOPSIS:\n• Nấm Phomopsis durionis phát triển cực kỳ nhanh trên lá non. Cần xử lý ngay khi phát hiện những đốm mắt cua đầu tiên trên cơi đọt.\n• Bắt buộc dùng hoạt chất nội hấp lưu dẫn để tiêu diệt sợi nấm bên trong mô lá, kết hợp thuốc tiếp xúc tạo màng bảo vệ ngăn bào tử nảy mầm.\n\n2. Phác đồ hóa học đặc trị luân phiên:\n• Cặp đôi hoàn hảo Strobilurin + Triazole (FRAC 11 + FRAC 3): Azoxystrobin + Difenoconazole (Asmiltatop Super 400SC), Azoxystrobin + Tebuconazole (Tebaz 400SC). Nội hấp 2 chiều cực mạnh, chặn đứng sự phát triển của vết đốm, giúp vết bệnh khô giòn ngay sau 2–3 ngày.\n• Pyraclostrobin thế hệ mới (FRAC 11): Headline 250EC BASF. Hiệu lực diệt nấm phổ rộng, kích hoạt tính kháng cây trồng, giúp lá xanh dày bóng mượt.\n• Nhóm Áo giáp Kẽm bảo vệ tiếp xúc (FRAC M03): Propineb (Antracol 70WP, Nofacol 700WP). Bổ sung hàm lượng Kẽm tinh khiết (Zinc++) lên đến 300g/kg giúp lá cứng cáp, xanh khỏe, cô lập vết đốm không cho lan rộng.\n• Nhóm Đồng Nano sát trùng: Đồng Xanh Mekong Agro rửa sạch bề mặt lá, diệt khuẩn và bào tử nấm.\n\n3. Phục hồi bộ lá sau dập dịch:\n• Phun bổ sung Phân bón lá hữu cơ Rong biển & Axit Amin (Xanh Um Monyka), Canxi Chelate & Enzyme (Weyzym-A) và Vi lượng Chelate (Tang Truong Panaxilus) để tái tạo diệp lục tố, nuôi cơi đọt mới xanh dày mập mạp.",
            'chemical_groups' => 'Azoxystrobin / Difenoconazole (Strobilurin & Triazole đặc trị đốm lá mắt cua - FRAC 11 + FRAC 3), Azoxystrobin / Tebuconazole (Tebaz 400SC nội hấp lưu dẫn - FRAC 11 + FRAC 3), Pyraclostrobin (Headline 250EC - FRAC 11), Propineb + Kẽm Zinc++ (Áo giáp Kẽm bảo vệ phiến lá - FRAC M03), Hexaconazole (Anvil 5SC), Nano Đồng Chelate, Axit Amin & Canxi phục hồi lá',
            'notes' => "Lưu ý thực tế từ kỹ sư BVTV:\n• Bệnh đốm lá Phomopsis rất phổ biến trên tất cả các giống sầu riêng (Ri6, Monthong, Musang King, Black Thorn) và cây ăn trái nhiệt đới.\n• Nấm phát triển quanh năm nhưng bùng phát mạnh nhất vào mùa mưa dầm hoặc thời điểm giao mùa có sương mù ẩm ướt.\n• Nếu không dập dịch kịp thời, đốm lá Phomopsis sẽ làm rụng trơ trụi bộ lá cơi 2, cơi 3, khiến cây không đủ diện tích lá quang hợp nuôi hoa và quả.\n• Tài liệu tham khảo: Nghiên cứu Cục Đổi mới Công nghệ Việt Nam ghi nhận Phomopsis durionis trên sầu riêng; Viện Cây ăn quả Miền Nam (SOFRI).",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Sầu riêng, Cây có múi, Bơ, Mãng cầu',
            'treatment_plans' => [
                [
                    'title'        => 'Phác đồ 1: Đặc trị dập dịch Đốm lá Phomopsis & Đốm mắt cua (Azoxystrobin + Difenoconazole + Áo giáp Kẽm)',
                    'badge'        => 'Đặc trị dứt điểm',
                    'badge_color'  => 'emerald',
                    'stage'        => 'Khi phiến lá non và bánh tẻ chớm xuất hiện các chấm đốm tròn có quầng vàng',
                    'dosage_guide' => 'Pha 1 chai Asmiltatop Super 400SC (250ml) + 1 gói Antracol 70WP (1kg) cho 400 - 500 lít nước. Phun xoáy ướt đều 2 mặt lá.',
                    'safety_note'  => 'Azoxystrobin + Difenoconazole lưu dẫn dập tắt sợi nấm đốm mắt cua kết hợp Propineb (Zinc++) bổ sung áo giáp Kẽm làm xanh dày lá, vết đốm khô giòn sau 2-3 ngày.',
                    'groups'       => [
                        [
                            'label'                => 'Thuốc trừ nấm nội hấp 2 chiều dập đốm lá mắt cua',
                            'primary_pesticide_id' => 10, // ASMILTATOP SUPER 400SC
                            'substitute_label'     => 'Hoặc thay thế bằng thuốc tương đương:',
                            'substitute_ids'       => [190], // TEBAZ 400SC
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Áo giáp Kẽm bảo vệ tiếp xúc & dưỡng xanh dày lá',
                            'primary_pesticide_id' => 7, // Antracol 70WP Bayer
                            'substitute_label'     => 'Hoặc thay thế bằng:',
                            'substitute_ids'       => [27], // NOFACOL 700WP
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Enzyme sinh học & Canxi chelate bảo vệ tế bào lá',
                            'primary_pesticide_id' => 158, // WEYZYM-A MULTIAGRO48
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 2: Chặn đứng lây lan cơi đọt & làm khô nhanh vết đốm (Tebaz 400SC + Pyraclostrobin lưu dẫn)',
                    'badge'        => 'Lưu dẫn chặn lây lan',
                    'badge_color'  => 'blue',
                    'stage'        => 'Giai đoạn cơi đọt mở lá trong mùa mưa ẩm ướt nấm lây lan mạnh',
                    'dosage_guide' => 'Pha 1 chai TEBAZ 400SC (250ml) + 1 chai HEADLINE 250EC (100ml) cho 400 lít nước. Phun ướt đẫm các cơi đọt non.',
                    'safety_note'  => 'Sự kết hợp giữa Strobilurin + Triazole phổ rộng dập tắt hoàn toàn bào tử nấm Phomopsis, ngăn ngừa đốm lá chuyển thành cháy bìa lá.',
                    'groups'       => [
                        [
                            'label'                => 'Azoxystrobin + Tebuconazole lưu dẫn phổ rộng',
                            'primary_pesticide_id' => 190, // TEBAZ 400SC
                            'substitute_label'     => 'Hoặc thay thế bằng:',
                            'substitute_ids'       => [9, 37], // ANVIL 5SC, TILT SUPER
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Pyraclostrobin lưu dẫn kích kháng xanh lá',
                            'primary_pesticide_id' => 21, // HEADLINE 250EC BASF
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Nano Đồng Chelate sát trùng bề mặt lá',
                            'primary_pesticide_id' => 17, // Đồng Xanh Mekong Agro
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 3: Phục hồi dày lá, xanh mướt & tăng đề kháng cơi đọt mới',
                    'badge'        => 'Dày lá xanh mướt',
                    'badge_color'  => 'amber',
                    'stage'        => 'Sau khi dập dịch đốm mắt cua, cần nuôi bộ lá xanh dày bóng khỏe',
                    'dosage_guide' => 'Pha 1 chai Xanh Um Monyka (500ml) + 1 chai Tang Truong Panaxilus (500ml) cho 400 lít nước. Phun ướt đều tán lá.',
                    'safety_note'  => 'Cung cấp Axit Amin đạm cá hữu cơ, Tinh chất tảo biển Seaweed và vi lượng Kẽm - Bo Chelate giúp cơi đọt bung tược mập, phiến lá dày bóng, tăng sức đề kháng.',
                    'groups'       => [
                        [
                            'label'                => 'Axit Amin đạm cá & Tinh chất tảo biển Seaweed',
                            'primary_pesticide_id' => 159, // Xanh Um Monyka
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Vi lượng Chelate kích đọt mập khỏe',
                            'primary_pesticide_id' => 152, // TANG TRUONG PANAXILUS
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
            ],
        ];

        $disease = Disease::updateOrCreate(
            ['folder_code' => 'B-08'],
            $diseaseData
        );

        // 3. Gắn các cây trồng mẫn cảm: Sầu riêng, Cây có múi, Cà phê, Bơ
        $targetCropNames = ['Sầu riêng', 'Cây có múi', 'Cà phê', 'Bơ'];
        $linkedCropIds = Crop::whereIn('name', $targetCropNames)->pluck('id')->toArray();
        if (!empty($linkedCropIds)) {
            $disease->crops()->sync($linkedCropIds);
        }

        // 4. Liên kết các thuốc BVTV có sẵn trong kho đặc trị Phomopsis / đốm lá
        // Asmiltatop (10), Tebaz (190), Antracol (7), Nofacol (27), Headline (21), Anvil (9), Tilt Super (37), Đồng Xanh (17), Mancozeb (26), Weyzym-A (158), Xanh Um Monyka (159), Tang Truong Panaxilus (152)
        $targetPesticideIds = [10, 190, 7, 27, 21, 9, 37, 17, 26, 158, 159, 152];
        $validPesticideIds = Pesticide::whereIn('id', $targetPesticideIds)->pluck('id')->toArray();

        if (!empty($validPesticideIds)) {
            $disease->pesticides()->sync($validPesticideIds);
        }
    }
}
