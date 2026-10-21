<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class BenhDomDauBaTrauSeeder extends Seeder
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

        // 1. Sao chép 2 ảnh thực tế quả chanh dây bị đốm dầu (bã trầu) do người dùng cung cấp
        $userMedia1 = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791616381680.jpg';
        $userMedia2 = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791616381653.jpg';

        $destFile1 = 'dom-dau-chanh-day-1.jpg';
        $destFile2 = 'dom-dau-chanh-day-2.jpg';

        if (file_exists($userMedia1)) {
            copy($userMedia1, "$destDir/$destFile1");
            $savedImages[] = "diseases/$destFile1";
        }
        if (file_exists($userMedia2)) {
            copy($userMedia2, "$destDir/$destFile2");
            $savedImages[] = "diseases/$destFile2";
        }

        // Kiểm tra ảnh 3 (đã tải về từ khuyến nông chanh dây)
        if (file_exists("$destDir/dom-dau-chanh-day-3.jpg")) {
            $savedImages[] = 'diseases/dom-dau-chanh-day-3.jpg';
        }

        // Thêm ảnh bổ sung nếu có
        $additionalUrls = [
            'https://nafoodskhuyennong.com/wp-content/uploads/2023/10/benh-ba-trau-tren-chanh-day-1-600x600.jpg',
            'https://nafoodskhuyennong.com/wp-content/uploads/2023/10/benh-ba-trau-tren-chanh-day-2-600x600.jpg',
        ];

        foreach ($additionalUrls as $idx => $url) {
            $num = $idx + 4;
            $destExtra = "dom-dau-chanh-day-{$num}.jpg";
            $destPath = "$destDir/$destExtra";
            if (!file_exists($destPath)) {
                @file_put_contents($destPath, @file_get_contents($url));
            }
            if (file_exists($destPath) && filesize($destPath) > 5000) {
                $savedImages[] = "diseases/$destExtra";
            }
        }

        // 2. Chuẩn bị hồ sơ bệnh học chi tiết cho Bệnh Đốm Dầu (Bã Trầu) Chanh Dây
        $diseaseData = [
            'name' => 'Bệnh Đốm Dầu (Bã Trầu / Loang Dầu Chanh Dây — Pseudomonas passiflorae / Phytophthora)',
            'pathogen_type' => 'vi_khuan',
            'folder_code' => 'B-13',
            'folder_group' => 'nam_benh',
            'folder_name' => '13-Bệnh đốm dầu (bã trầu)',
            'folder_number' => 13,
            'caunho' => 'Đốm Dầu Bã Trầu = Trái loang dầu sũng nước, thâm nâu như bã trầu nhai dập, rụng trái hàng loạt. Tác nhân vi khuẩn Pseudomonas phối hợp nấm Phytophthora mùa mưa; phòng trị bằng Đồng (Copper) + Kháng sinh (Kasugamycin) + sạch bọ trĩ.',
            'symptoms' => "• Trên quả: Vết bệnh ban đầu xuất hiện như các vệt thấm dầu tròn nhỏ hoặc giọt dầu loang sũng nước (water-soaked) trên bề mặt vỏ trái non và quả bánh tẻ. Vết bệnh phát triển rất nhanh làm nửa quả hoặc toàn bộ vỏ trái chuyển sang màu nâu sẫm, thâm nhớt trông loang lổ như bã trầu hoặc quả bị luộc chín; vỏ quả chai sần, méo mó, thịt quả thối chua bên trong và rụng quả non hàng loạt.\n• Trên lá: Xuất hiện các đốm nhỏ trong mờ, úng dầu ở mặt dưới lá non, sau lan rộng tạo thành các đốm góc cạnh màu nâu đỏ hoặc ô-liu, bao quanh bởi quầng vàng nhạt (yellow halo). Khi trời ẩm ướt mô lá bị nhũn nát; khi trời khô mô lá giòn rách vụn, lá vàng cháy từng mảng và rụng sớm làm trơ trụi cành dây.\n• Trên thân non & cành: Vết lõm úng nước màu xanh đen chạy dọc thân cành non, sau hóa nâu thẫm làm tóp teo đoạn thân, gây thối ngọn, héo rũ dây chanh leo phía trên.",
            'symptoms_detail' => [
                'la' => 'Đốm úng dầu trong mờ mặt dưới lá non; sau vết bệnh loang rộng màu nâu tối viền quầng vàng tươi đặc trưng; mô lá sũng nước khi mưa dầm và giòn rách khi nắng hanh; lá rụng hàng loạt.',
                'canh_than' => 'Vết bệnh mọng nước màu xanh đen hình thoi hoặc vệt dài trên thân cành non, làm teo thắt mạch dẫn, cành thâm đen, đoạn ngọn héo rũ chết dây.',
                'goc_re' => 'Gốc và cổ rễ dễ bị phụ nhiễm nấm Phytophthora trong điều kiện đất đọng nước, rễ tơ bị thối đen khiến cây hấp thu kém, suy kiệt nhanh chóng.',
                'qua' => 'Vết dầu loang hình tròn hơi lõm trên vỏ quả non; lan rộng thành mảng lớn sũng nước màu nâu đen bã trầu; vỏ trái chai nám sần sùi, ruột chua thối, trái non rụng la liệt dưới đất.',
            ],
            'prevention' => "1. Chọn giống sạch bệnh & Vệ sinh vườn định kỳ: Sử dụng cây giống chanh leo ghép kháng bệnh, nguồn gốc rõ ràng. Thu gom triệt để và tiêu hủy toàn bộ quả rụng, lá và cành bị bệnh đem ra xa vườn đốt hoặc chôn sâu rải vôi bột.\n2. Cắt tỉa cành tạo tán thông thoáng: Giữ độ cao giàn từ 1.8 - 2.0m; tỉa bỏ các cành tăm, cành khuất tán sát mặt đất để ánh nắng chiếu đều vào trong giàn, giảm tối đa độ ẩm ứ đọng.\n3. Quản lý phân bón cân đối: Tuyệt đối không bón thừa đạm (Urea) trong mùa mưa làm vách tế bào non mềm; tăng cường bón Phân hữu cơ hoai mục, Canxi - Silic, Magie và Kali để làm dày vách tế bào vỏ trái, tăng sức chống chịu trước sự xâm nhập của vi khuẩn.\n4. Thoát nước tốt: Đào rãnh thoát nước sâu giữa các liếp trồng, không để nước mưa ứ đọng quanh gốc chanh dây quá 2 giờ.",
            'treatment' => "1. NGUYÊN TẮC QUẢN LÝ DỊCH HẠI BÃ TRẦU ĐỐM DẦU:\n• Bệnh do vi khuẩn Pseudomonas syringae pv. passiflorae phối hợp phụ nhiễm nấm Phytophthora nicotianae trong điều kiện mưa dầm kéo dài. Cần kết hợp hoạt chất diệt khuẩn chuyên hiệu + diệt nấm phổ rộng + diệt sạch véc-tơ chích hút (bọ trĩ, nhện đỏ).\n\n2. Phác đồ hóa học đặc trị vi khuẩn & nấm loang dầu bã trầu:\n• Nhóm Hợp chất Đồng (FRAC M01): Copper Hydroxide, Copper Oxychloride, Nano Đồng. Tiếp xúc tạo lớp màng ion Cu2+ bảo vệ bề mặt quả và lá, ức chế enzyme và làm đông tụ protein vi khuẩn.\n• Nhóm Kháng sinh sinh học (FRAC 24 / 25): Kasugamycin, Streptomycin, Ningnanmycin, Polyoxin. Thấm sâu lưu dẫn trong mô cây, ức chế tổng hợp protein và tiêu diệt vi khuẩn trong dịch bào.\n• Nhóm Diệt khuẩn thế hệ mới: Anacardic Acid (Amtech 100EW), Bismerthiazol, Bronopol. Ngăn chặn sự lây lan của vết loang sũng nước trên vỏ quả.\n• Phối hợp nấm đối kháng & nấm Oomycetes: Metalaxyl (Binhtaxyl 25EC), Azoxystrobin + Tebuconazole (Tebaz 400SC) để chặn đứng nấm Phytophthora bội nhiễm.\n\n3. Kiểm soát véc-tơ chích hút truyền bệnh:\n• Bọ trĩ, nhện đỏ, bọ xít muỗi châm kim tạo hàng ngàn vết thương vi thể giúp vi khuẩn xâm nhập trực tiếp. Cần định kỳ luân phiên thuốc diệt chích hút: Abamectin (Resgant 5EC), Spirotetramat (Movento 150OD), Thiamethoxam (Nofara 35WG, Tegula 247SC).",
            'chemical_groups' => 'Copper Hydroxide / Copper Oxychloride (Đồng bảo vệ tiếp xúc - FRAC M01), Kasugamycin / Ningnanmycin / Streptomycin (Kháng sinh trừ khuẩn lưu dẫn - FRAC 24/25), Anacardic Acid (Hoạt chất thảo mộc trừ khuẩn nấm - Amtech 100EW), Metalaxyl / Mefenoxam (Trừ nấm Oomycetes lưu dẫn - FRAC 4), Azoxystrobin / Tebuconazole (Strobilurin & Triazole phổ rộng - FRAC 11 + FRAC 3), Abamectin / Thiamethoxam (Trừ côn trùng chích hút tạo vết thương)',
            'treatment_plans' => [
                [
                    'plan_name' => 'Phác đồ 1: Phun dập dịch vi khuẩn đốm dầu (Đồng hữu cơ + Kháng sinh thấm sâu)',
                    'action_type' => 'Phun ướt đẫm tán lá, ngọn dây non và bề mặt quả',
                    'stage' => 'Khi phát hiện các chấm sũng dầu loang đầu tiên trên lá non hoặc vỏ quả chanh leo',
                    'mixing_ratio' => '1 gói Kháng sinh diệt khuẩn + 1 chai/gói Đồng bảo vệ pha cho 400 lít nước',
                    'instructions' => 'Phun vào sáng sớm hoặc chiều râm mát; phun kỹ mặt dưới lá và quanh chùm quả chanh dây. Phun dập 2 lần cách nhau 4 - 5 ngày.',
                    'target_pests' => ['Vi khuẩn đốm dầu bã trầu', 'Nấm thán thư', 'Nấm lở loét vỏ trái'],
                    'products' => [
                        [
                            'role' => 'Kháng sinh diệt khuẩn lưu dẫn nội hấp',
                            'recommended_name' => 'Kasugamycin / Ningnanmycin (Kasu 2SL / Starner)',
                            'active_ingredient' => 'Kasugamycin',
                            'pesticide_id' => 190,
                            'dosage' => '250 - 300ml cho 400 lít nước',
                            'is_main' => true,
                            'substitute_ids' => [158],
                        ],
                    ],
                ],
                [
                    'plan_name' => 'Phác đồ 2: Chặn đứng thối nhũn bã trầu & Phytophthora mùa mưa kéo dài',
                    'action_type' => 'Phun phủ toàn bộ giàn chanh dây và quét cổ gốc',
                    'stage' => 'Mùa mưa dầm liên tục, độ ẩm cao, quả non và lá có dấu hiệu úng nước nhũn nát',
                    'mixing_ratio' => 'Amtech 100EW + Binhtaxyl 25EC pha cho 400 - 500 lít nước',
                    'instructions' => 'Phối hợp thuốc đặc trị khuẩn thảo mộc với hoạt chất trừ nấm Oomycetes để chặn đứng phức hợp nấm khuẩn gây thối bã trầu.',
                    'target_pests' => ['Pseudomonas passiflorae', 'Phytophthora nicotianae', 'Thối nhũn quả'],
                    'products' => [
                        [
                            'role' => 'Kháng khuẩn thảo mộc cô lập vết thối',
                            'recommended_name' => 'Amtech 100EW (Anacardic Acid)',
                            'active_ingredient' => 'Anacardic Acid',
                            'pesticide_id' => 563,
                            'dosage' => '240ml cho 400 lít nước',
                            'is_main' => true,
                            'substitute_ids' => [],
                        ],
                        [
                            'role' => 'Trừ nấm Oomycetes lưu dẫn mạnh',
                            'recommended_name' => 'Binhtaxyl 25EC / Mataxyl 500WP (Metalaxyl)',
                            'active_ingredient' => 'Metalaxyl',
                            'pesticide_id' => 193,
                            'dosage' => '300 - 400ml cho 400 lít nước',
                            'is_main' => false,
                            'substitute_ids' => [172],
                        ],
                    ],
                ],
                [
                    'plan_name' => 'Phác đồ 3: Diệt véc-tơ chích hút tạo vết thương & Tăng độ dày vỏ trái',
                    'action_type' => 'Phun kết hợp trừ côn trùng chích hút và vi lượng',
                    'stage' => 'Giai đoạn nuôi trái non và đâm tược chồi mới',
                    'mixing_ratio' => 'Thuốc trừ bọ trĩ/bọ xít muỗi + Phân bón lá Canxi Bo Silic',
                    'instructions' => 'Diệt bọ trĩ, bọ xít muỗi và nhện đỏ để ngăn tạo vết châm kim lây nhiễm khuẩn; kết hợp Canxi Bo làm dày vỏ quả.',
                    'target_pests' => ['Bọ trĩ', 'Bọ xít muỗi', 'Nhện đỏ'],
                    'products' => [
                        [
                            'role' => 'Đặc trị bọ trĩ bọ xít muỗi chích hút',
                            'recommended_name' => 'Tegula 247SC / Resgant 5EC (Thiamethoxam + Lambda / Abamectin)',
                            'active_ingredient' => 'Thiamethoxam + Lambda-cyhalothrin',
                            'pesticide_id' => 192,
                            'dosage' => '200ml cho 400 lít nước',
                            'is_main' => true,
                            'substitute_ids' => [180],
                        ],
                    ],
                ],
            ],
            'notes' => "Lưu ý nông học thực tế:\n• Không phun thuốc gốc Đồng chung với các loại phân bón lá chứa đạm cao hoặc các loại thuốc có tính kiềm mạnh, tránh hiện tượng cháy lá non hoặc kết tủa.\n• Khi phát hiện vết dầu loang chớm xuất hiện 1-2 quả trên giàn, phải phun dập dịch ngay lập tức bằng hỗn hợp thuốc trừ khuẩn + thuốc trừ nấm (ví dụ Amtech 100EW / Kasugamycin + Metalaxyl) 2 lần cách nhau 4-5 ngày.\n• Tài liệu tham khảo: Viện Khoa học Nông nghiệp Việt Nam (VAAS), Trung tâm Khuyến nông Quốc gia, Nafoods Group.",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Chanh dây',
        ];

        $disease = Disease::updateOrCreate(
            ['folder_code' => 'B-13'],
            $diseaseData
        );

        // 3. Gắn cây trồng mẫn cảm: Chanh dây
        $crop = Crop::where('name', 'Chanh dây')->first();
        if ($crop) {
            $disease->crops()->sync([$crop->id]);
        }

        // 4. Liên kết các thuốc BVTV đang có sẵn trong kho (tuyệt đối không tạo thuốc mới)
        // Amtech 100EW (563), Tebaz 400SC (190), Binhtaxyl 25EC (193), Resgant 5EC (180), Riegenf USA (187), Tegula 247SC (192), Movento 150OD (170), Weyzym-A (158)
        $targetPesticideIds = [563, 190, 193, 180, 187, 192, 170, 158];
        $validPesticideIds = Pesticide::whereIn('id', $targetPesticideIds)->pluck('id')->toArray();

        if (!empty($validPesticideIds)) {
            $disease->pesticides()->sync($validPesticideIds);
        }
    }
}
