<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class BenhPythiumSeeder extends Seeder
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

        // 1. Sao chép ảnh thực tế do người dùng vừa cung cấp (Bệnh học Pythium gồm 3 khung hình A, B, C)
        $src = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690365877.jpg';
        $filename = 'pythium-thoi-re-1.jpg';

        if (file_exists($src)) {
            copy($src, "$destDir/$filename");
            $savedImages[] = "diseases/$filename";
        } elseif (file_exists("$destDir/$filename")) {
            $savedImages[] = "diseases/$filename";
        }

        // 2. Dữ liệu hồ sơ bệnh học chuẩn cho Pythium — thối rễ
        $diseaseData = [
            'name' => 'Bệnh Thối Rễ Non, Thối Rũ Cổ Rễ — Pythium spp. (Pythium aphanidermatum / Pythium ultimum — Thối Rễ Cám Sầu Riêng, Chết Rạp Cây Con & Nghẹt Rễ)',
            'pathogen_type' => 'nam_benh',
            'folder_code' => 'B-02',
            'folder_group' => 'nam_benh',
            'folder_name' => '2-Pythium - thối rễ',
            'folder_number' => 2,
            'caunho' => 'Pythium = NẤM GIẢ OOMYCETES THÍCH ĐẤT ẨM ÚNG + THỐI ĐẦU RỄ TƠ + TUỘT VỎ RỄ CÁM (cắt cành thấy lõi gỗ vẫn trắng, không sọc nâu như Fusarium). Trị bằng Fosetyl-Aluminium (Alien), Metalaxyl M (Ridomil Gold / Binhtaxyl), Dimethomorph, Lân 2 chiều Phosphonate (Delta Fos) và nâng pH đất.',
            'symptoms' => "• Phân tích bệnh học chuyên sâu qua 3 khung hình (A, B, C) thực tế bạn gửi:\n- Khung A — Bộ rễ bị thối nhũn úng nước: Toàn bộ chùm rễ cám và rễ cọc non bị nấm Pythium tấn công gây thối đen nhầy, các đầu chóp rễ tơ non bị thối cụt (cùn rễ), lông hút bị rụng sạch. Khi nhổ cây lên kiểm tra và dùng tay vuốt nhẹ, lớp vỏ ngoài của rễ tơ dễ dàng bị tuột khỏi lõi rễ (hiện tượng tuột vỏ rễ nhũn nước root rot).\n- Khung B — Cạo vỏ thân cành & cổ rễ (DẤU HIỆU CHẨN ĐOÁN PHÂN BIỆT SỐ 1 VỚI FUSARIUM): Khi dùng dao cạo lớp vỏ ngoài của cành hoặc cổ rễ, lớp mô mạch gỗ bên trong VẪN SÁNG TRẮNG HOẶC HƠI XANH NHẠT HOÀN TOÀN KHỎE MẠNH (nhìn rất rõ trên ngón tay đeo găng tím trong ảnh). Hoàn toàn KHÔNG CÓ CÁC VỆT SỌC NÂU ĐEN TẮC MẠCH DẪN như nấm Fusarium. Điều này chứng minh nấm Pythium chỉ khu trú hủy diệt hệ thống chóp rễ tơ dưới đất mà không gây tắc mạch dẫn trong cành thân.\n- Khung C — Bầu ươm & đất giá thể bị thối rễ non: Trong bầu ươm đất đỏ hoặc bầu giá thể bị đọng nước ẩm ướt thoát nước kém, nấm Pythium (thuộc nhóm nấm giả Oomycetes có bào tử động zoospore bơi trong nước) lây lan với tốc độ bùng nổ, phá hủy toàn bộ hệ thống rễ con trong bầu, cây giống không bén rễ mới, đọt non bị chùn, lá vàng rụng và cây con bị chết rạp.\n• Triệu chứng trên cành lá:\n- Do hệ thống chóp rễ tơ và lông hút bị hư hoại hoàn toàn, cây mất khả năng hút nước và dinh dưỡng. Cơi đọt non bị chùn lại không phóng đọt được; lá già bị vàng úa đồng loạt từ gân lá lan ra; vào buổi trưa nắng gắt tán lá thường héo rũ mềm xẹp xuống dù đất quanh gốc vẫn ướt đẫm.",
            'symptoms_detail' => [
                'la' => 'Lá chuyển màu xanh tái rồi vàng úa từ cành thấp lên cao, trưa nắng héo rũ mềm xẹp dù đất đủ ẩm; đọt non bị chùn lại không phát triển.',
                'canh_than' => 'Cành thân không có vết loét xì mủ; cạo lớp vỏ cành thấy mô mạch gỗ bên trong vẫn sáng trắng (không bị sọc nâu đen như Fusarium).',
                'goc_re' => 'Chóp rễ tơ bị thối nhũn đen nhớt, cùn đầu rễ; vỏ rễ cám tuột khỏi lõi gỗ khi vuốt nhẹ; rễ tơ rụng sạch lông hút.',
                'qua' => 'Cây bị suy kiệt rụng trái non hàng loạt; quả chậm lớn, méo mó do bộ rễ không hút được dinh dưỡng.',
            ],
            'prevention' => "1. Thiết kế hệ thống thoát nước hoàn hảo: Lên luống cao, khơi rãnh thoát nước sâu giữa các hàng liếp (sâu 0.6 - 1.0m) để nước mưa thoát nhanh, tuyệt đối không để nước đọng vũng quanh vùng rễ (bào tử nấm Pythium có đuôi bơi cực nhanh trong môi trường nước đọng).\n2. Quản lý độ ẩm bầu ươm và cây giống: Giá thể ươm cây giống phải tơi xốp, thoát nước tốt (phối trộn tro trấu, xơ dừa đã xử lý chát, phân trùn quế); không tưới quá đẫm nước làm nghẹt rễ con.\n3. Nâng cao pH đất và khử trùng đất định kỳ: Nấm Pythium phát triển bùng nổ trong đất chua ẩm ướt. Cần rải vôi bột khử trùng và nâng pH đất đạt 5.5 - 6.5.\n4. Cạnh tranh sinh học bằng nấm đối kháng Trichoderma: Định kỳ bổ sung nấm đối kháng Trichoderma harzianum và vi khuẩn Bacillus subtilis tưới vùng rễ để cạnh tranh dinh dưỡng và tiêu diệt bào tử Pythium.",
            'treatment' => "1. NGUYÊN TẮC ĐẶC TRỊ NẤM GIẢ OOMYCETES (PYTHIUM SPP.):\n• Nấm Pythium thuộc nhóm Oomycetes (tương tự Phytophthora), các thuốc trị nấm thật thông thường (như Carbendazim, Hexaconazole đơn lẻ) hầu như KHÔNG CÓ HIỆU LỰC.\n• Bắt buộc phải sử dụng CÁC HOẠT CHẤT ĐẶC HIỆU CHO NHÓM OOMYCETES: Fosetyl-Aluminium (Alien, Aliette), Lân 2 chiều Phosphonate (Delta Fos), Metalaxyl M (Ridomil Gold, Binhtaxyl), Dimethomorph (Dimethor, Phytocide).\n• Ngừng ngay việc bón phân đạm vô cơ và phân hóa học khi rễ đang thối.\n\n2. Phác đồ hóa học đặc trị luân phiên:\n• Nhóm Phosphonate kích kháng lưu dẫn 2 chiều (FRAC P07): Alien An Nông 800WP / Aliette (Fosetyl-Aluminium 800g/kg), Delta Fos (Mono & Di-potassium phosphite 400g/l). Kích thích cơ chế miễn dịch tự nhiên của cây, di chuyển 2 chiều lên lá và xuống tận chóp rễ non dập tắt bào tử nấm Pythium.\n• Nhóm Phenylamide nội hấp mạnh (FRAC 4): Ridomil Gold 68WG (Metalaxyl M + Mancozeb), Binhtaxyl 25EC (Metalaxyl). Ngăn cản quá trình tổng hợp RNA của nấm, bảo vệ chóp rễ tơ non không bị thối nhũn.\n• Nhóm CAA ức chế thành tế bào nấm (FRAC 40): Dimethor 500SC, TD - Lumordie 500WP (Dimethomorph 500g/l), Profiler 711.1WG (Fluopicolide + Fosetyl-Al). Hiệu lực dập dịch cực mạnh trong điều kiện đất ngập úng.\n• Nhóm Áo giáp Kẽm bảo vệ tiếp xúc (FRAC M03): Antracol 70WP Bayer (Propineb + Zinc++). Bao phủ bảo vệ chóp rễ non mới nhú, bổ sung Kẽm giúp rễ khỏe mạnh.\n\n3. Kích thích tái sinh hệ rễ cám mới sau bệnh:\n• Sau khi xử lý thuốc diệt nấm 5–7 ngày, khi các đầu rễ cám đã khô se và ngừng thối, bắt buộc phải tưới kích rễ mới bằng Axit Humic tinh khiết, Axit Fulvic, Đạm cá hữu cơ và Tảo biển Seaweed (Xanh Um Monyka, Tang Truong Panaxilus) kết hợp MgO - Kẽm EDTA để kích thích lớp lông hút rễ tơ mới bung nở mạnh mẽ.",
            'chemical_groups' => 'Fosetyl-Aluminium (Alien 800WP / Aliette - FRAC P07), Potassium Phosphonate (Delta Fos - Lân 2 chiều), Metalaxyl M (Ridomil Gold / Binhtaxyl - FRAC 4), Dimethomorph (Dimethor 500SC / Phytocide 50WP - FRAC 40), Fluopicolide + Fosetyl-Al (Profiler 711.1WG - FRAC 43 + FRAC P07), Propineb + Kẽm Zinc++ (Antracol 70WP - FRAC M03), Mancozeb 80WP (FRAC M01), Axit Humic & Amino Acid',
            'notes' => "Lưu ý thực tế từ kỹ sư BVTV:\n• Nấm Pythium là thủ phạm số 1 gây chết rạp cây con trong vườn ươm sầu riêng và thối rễ cám trên vườn cây kinh doanh vào đầu mùa mưa dầm.\n• PHÂN BIỆT RÕ RÀNG: Bệnh thối rễ Pythium chỉ làm thối rễ cám và cạo vỏ cành thấy gỗ bên trong vẫn TRẮNG TINH. Khác hẳn với Fusarium (cắt cành thấy có vệt sọc NÂU ĐEN trong lõi gỗ).\n• Việc nâng cao pH đất và cải tạo rãnh thoát nước là điều kiện tiên quyết; nếu đất vẫn úng nước ngập rễ thì dùng bất kỳ loại thuốc nào cũng không thể cứu được cây.\n• Tài liệu tham khảo: Viện Cây ăn quả Miền Nam (SOFRI), Cục Bảo vệ Thực vật, Trung tâm Khuyến nông Quốc gia.",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Sầu riêng, Cây có múi, Chanh dây, Cà phê, Hồ tiêu, Dưa leo & Bầu bí, Cây giống vườn ươm',
            'treatment_plans' => [
                [
                    'title'        => 'Phác đồ 1: Tưới đẫm vùng rễ đặc trị nấm Oomycetes thối rễ cám (Alien An Nông 800WP + Delta Fos Lân 2 chiều + Antracol 70WP)',
                    'badge'        => 'Đặc trị nấm Oomycetes',
                    'badge_color'  => 'emerald',
                    'stage'        => 'Khi phát hiện cây sầu riêng có biểu hiện vàng lá, chóp rễ tơ bị thối nhũn đen, cạo thân vỏ cành thấy lõi gỗ vẫn trắng',
                    'dosage_guide' => 'Pha 1 gói Alien An Nông 800WP (250g) hoặc Aliette (250g) + 1 chai Delta Fos (500ml) + 1 gói Antracol 70WP (300g) cho 200 lít nước (1 phuy). Tưới đẫm đều quanh vùng rễ (15 - 25 lít/gốc tùy tuổi cây) khi đất ẩm. Đồng thời phun ướt đều tán lá.',
                    'safety_note'  => 'Fosetyl-Aluminium và Phosphonate lưu dẫn 2 chiều thẩm thấu xuống tận chóp rễ tiêu diệt bào tử nấm Pythium; Propineb bổ sung Kẽm Zinc++ bảo vệ chóp rễ non. Tưới nhắc lại lần 2 sau 7 ngày nếu mưa dầm kéo dài.',
                    'groups'       => [
                        [
                            'label'                => 'Fosetyl-Aluminium đặc hiệu Oomycetes lưu dẫn 2 chiều dập dịch',
                            'primary_pesticide_id' => 4,  // Alien An Nông 800WP
                            'substitute_ids'       => [2, 6], // ALIETTE 100 GRAM, ANLIEN ANNONG 400SC
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Lân 2 chiều Phosphonate kích kháng rễ & cô lập nấm bệnh',
                            'primary_pesticide_id' => 14, // Delta Fos Mekong Agro
                            'substitute_ids'       => [30], // PROFILER 711,1WG
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Áo giáp Kẽm Propineb bảo vệ chóp rễ non mới nhú',
                            'primary_pesticide_id' => 7,  // Antracol 70WP Bayer
                            'substitute_ids'       => [27], // NOFACOL 700WP
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 2: Dập dịch khẩn cấp đất ngập úng & Vườn ươm cây con (Ridomil Gold 68WG + Dimethor 500SC + Mancozeb 80WP)',
                    'badge'        => 'Dập dịch vườn ươm',
                    'badge_color'  => 'sky',
                    'stage'        => 'Khi vườn ươm hoặc cây mới trồng bị úng nước làm thối rụi rễ con hàng loạt, chết rạp cây con',
                    'dosage_guide' => 'Pha 1 gói Ridomil Gold 68WG (100g) hoặc Binhtaxyl 25EC (100ml) + 1 chai Dimethor 500SC (100ml) + 1 gói Mancozeb 80WP (300g) cho 200 lít nước. Tưới ướt đẫm khay ươm, bầu đất hoặc quanh gốc cây con.',
                    'safety_note'  => 'Metalaxyl M nội hấp mạnh kết hợp Dimethomorph ức chế tức thì sự phát triển của màng tế bào nấm Pythium, chặn đứng hiện tượng thối nhũn tuột vỏ rễ.',
                    'groups'       => [
                        [
                            'label'                => 'Metalaxyl M nội hấp mạnh bảo vệ mô rễ tơ non',
                            'primary_pesticide_id' => 32,  // Ridomil Gold 68WG
                            'substitute_ids'       => [193], // BINHTAXYL 25EC
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Dimethomorph ức chế màng tế bào nấm giả Oomycetes',
                            'primary_pesticide_id' => 15,  // Dimethor 500SC
                            'substitute_ids'       => [29, 34], // Phytocide 50WP, TD - Lumordie 500WP
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Mancozeb tiếp xúc sát trùng bề mặt giá thể đất ươm',
                            'primary_pesticide_id' => 26,  // MANCOZEB 80WP
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 3: Kích thích tái tạo rễ cám mới, dưỡng đọt xanh dày sau bệnh thối rễ',
                    'badge'        => 'Phục hồi rễ cám',
                    'badge_color'  => 'amber',
                    'stage'        => 'Sau khi xử lý thuốc diệt nấm 5–7 ngày, các chóp rễ đã khô se ngừng thối, cần kích rễ tơ mới bung nở',
                    'dosage_guide' => 'Pha 1 chai Xanh Um Monyka (500ml) + 1 chai Tang Truong Panaxilus (500ml) + 1 chai MgO - Kẽm EDTA (250ml) cho 400 lít nước (2 phuy). Tưới đều quanh vùng rễ (15–20 lít/gốc) và phun đều tán lá.',
                    'safety_note'  => 'Cung cấp Axit Amin đạm cá hữu cơ, Tảo biển Seaweed và vi lượng Chelate EDTA kích thích các chóp rễ non đâm chồi, phục hồi khả năng hút dinh dưỡng nuôi cơi đọt.',
                    'groups'       => [
                        [
                            'label'                => 'Axit Amin đạm cá & Tinh chất tảo biển Seaweed kích bung rễ non',
                            'primary_pesticide_id' => 159, // Xanh Um Monyka
                            'substitute_ids'       => [152], // TANG TRUONG PANAXILUS
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Vi lượng Chelate & NPK cân đối nuôi rễ mập',
                            'primary_pesticide_id' => 152, // TANG TRUONG PANAXILUS
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Magie & Kẽm Chelate giúp cơi đọt xanh dày, chống cháy lá',
                            'primary_pesticide_id' => 111, // MgO - Kẽm EDTA
                            'substitute_ids'       => [158], // WEYZYM-A MULTIAGRO48
                        ],
                    ],
                ],
            ],
        ];

        // 3. Tạo hoặc cập nhật bệnh trong database
        $disease = Disease::updateOrCreate(
            ['folder_code' => 'B-02'],
            $diseaseData
        );

        // 4. Gắn quan hệ với cây trồng (Crops)
        $crops = Crop::whereIn('name', [
            'Sầu riêng',
            'Cây có múi',
            'Chanh dây',
            'Cà phê',
            'Hồ tiêu',
        ])->get();

        if ($crops->isNotEmpty()) {
            $disease->crops()->sync($crops->pluck('id')->toArray());
        }

        // 5. Gắn danh sách thuốc BVTV liên quan (Pesticides)
        $pesticideIds = [4, 2, 6, 14, 30, 32, 193, 15, 29, 34, 7, 27, 26, 159, 152, 111, 158];
        $existingPesticides = Pesticide::whereIn('id', $pesticideIds)->pluck('id')->toArray();
        if (!empty($existingPesticides)) {
            $disease->pesticides()->sync($existingPesticides);
        }

        $this->command->info("Đã tạo / cập nhật thành công hồ sơ bệnh học: {$disease->name} (ID: {$disease->id})");
    }
}
