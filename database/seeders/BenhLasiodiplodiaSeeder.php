<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class BenhLasiodiplodiaSeeder extends Seeder
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
        $mediaMap = [
            'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690126989.jpg' => 'lasiodiplodia-1.jpg',
            'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690127011.jpg' => 'lasiodiplodia-2.jpg',
        ];

        foreach ($mediaMap as $src => $filename) {
            if (file_exists($src)) {
                copy($src, "$destDir/$filename");
                $savedImages[] = "diseases/$filename";
            }
        }

        // 2. Dữ liệu hồ sơ bệnh học chuẩn cho Lasiodiplodia
        $diseaseData = [
            'name' => 'Bệnh Khô Cành, Hoại Tử Mô — Lasiodiplodia theobromae (Bệnh Chết Ngọn Dieback)',
            'pathogen_type' => 'nam_benh',
            'folder_code' => 'B-09',
            'folder_group' => 'nam_benh',
            'folder_name' => '9-Lasiodiplodia - khô cành, hoại tử mô',
            'folder_number' => 9,
            'caunho' => 'Lasiodiplodia = VẾT THƯƠNG + CÂY SUY KIỆT → CHÁY BÌA LÁ, HOẠI TỬ MÔ → KHÔ CÀNH CHẾT NGỌN (Cắt bỏ sâu dưới đoạn gỗ chết + sát trùng Đồng đỏ / Difenoconazole + Azoxystrobin, thuốc lá không chữa được cành gỗ đã chết khô).',
            'symptoms' => "• Trên lá non & lá bánh tẻ:\n- Vết bệnh bắt đầu từ mép lá hoặc chóp lá lan dần vào bên trong phiến lá tạo thành các vệt hoại tử khô giòn hình chữ V hoặc dải cháy xám loang lổ.\n- Vùng mô lá bị nấm tấn công chuyển sang màu nâu đen, nâu xám rồi bạc trắng, có ranh giới rõ rệt giữa phần mô bệnh khô chết và phần mô lá còn xanh.\n- Mép lá quăn queo, co rúm, lá bị khô cháy từ ngoài rìa vào trong và rụng hàng loạt từ chóp cành trở vào trong thân, làm cành bị trơ trụi lá.\n• Trên cành & chồi ngọn (Hiện tượng Khô cành chết ngược - Dieback):\n- Nấm xâm nhập qua các vết cắt tỉa cành, vết trầy xước cơ học, hoặc sau các đợt cây bị sốc thời tiết (hạn mặn, sốc nhiệt, sau thu hoạch mang trái quá sức kiệt quệ).\n- Nấm phá hủy mạch dẫn gỗ bên trong cành làm mô gỗ chuyển màu nâu sẫm, thâm đen. Lớp vỏ cành bên ngoài bị teo tóp xơ xác, mạch dẫn nhựa bị cắt đứt hoàn toàn khiến cành bị khô chết dần từ ngoài ngọn vào trong thân chính.\n• Trên cuống và quả (Thối cuống, thối trái sầu riêng, xoài, bơ, đu đủ):\n- Nấm xâm nhập qua vết cắt cuống trái khi thu hoạch, gây hiện tượng thối đen cuống, vết thối ăn sâu vào thịt trái làm thịt nhũn chảy nước chua.",
            'symptoms_detail' => [
                'la' => 'Cháy khô mép lá và chóp lá lan vào giữa phiến lá; mô lá bị hoại tử khô giòn màu nâu đen chuyển sang xám bạc, mép lá co rúm và rụng lá hàng loạt trơ cành.',
                'canh_than' => 'Mô mạch gỗ bên trong cành bị nấm phá hủy chuyển màu nâu đen; vỏ cành teo tóp xơ xác, cành khô chết dần từ ngoài ngọn vào thân chính (hiện tượng khô cành chết ngược - Dieback).',
                'goc_re' => 'Cây có bộ rễ bị nghẹt hoặc suy kiệt sau mùa mưa/mùa khô là đối tượng dễ bùng phát bệnh khô cành trên tán nhất.',
                'qua' => 'Vết thối nâu đen xuất phát từ cuống trái lan rộng xuống đít trái, làm thối nhũn thịt trái sau thu hoạch.',
            ],
            'prevention' => "1. Khử trùng dụng cụ tỉa cành: Dùng cồn hoặc nước sát trùng lau sạch kéo bấm, cưa cành trước khi cắt tỉa giữa các cây trong vườn. Ngay sau khi cắt tỉa cành, lập tức quét keo liền sẹo hoặc phun thuốc gốc Đồng (Norshield, Đồng Xanh) phủ kín vết cắt để bịt kín cửa ngõ xâm nhập của nấm.\n2. Tránh để cây bị suy kiệt & stress: Sau thu hoạch cần bón phục hồi bộ rễ và tán lá ngay lập tức (bón phân hữu cơ vi sinh, tưới Humic, trung vi lượng Canxi - Magie - Kẽm); duy trì độ ẩm đất ổn định trong mùa nắng, không để cây bị khô hạn kiệt sức.\n3. Cắt bỏ đoạn cành đã chết khô: Đối với các cành đã bị nấm ăn chết khô, bắt buộc phải dùng kéo cắt bỏ sâu vào phần cành gỗ còn tươi xanh khỏe mạnh ít nhất 10–15cm, gom cành bệnh ra xa vườn tiêu hủy để cắt đứt nguồn lây lan.",
            'treatment' => "1. NGUYÊN TẮC ĐẶC TRỊ LASIODIPLODIA:\n• Lưu ý cốt lõi: Thuốc trừ bệnh phun qua lá KHÔNG THỂ HỒI SINH ĐOẠN GỖ CÀNH ĐÃ CHẾT KHÔ. Do đó bắt buộc phải: CẮT BỎ ĐOẠN CÀNH CHẾT + PHUN THUỐC LƯU DẪN CHẶN ĐỨNG NẤM LAN SANG CÀNH KHỎE + SÁT TRÙNG VẾT CẮT.\n\n2. Phác đồ hóa học đặc trị luân phiên:\n• Nhóm Triazole + Strobilurin phổ rộng (FRAC 3 + FRAC 11): Azoxystrobin + Difenoconazole (Asmiltatop Super 400SC), Azoxystrobin + Tebuconazole (Tebaz 400SC), Pyraclostrobin (Headline 250EC BASF). Tính nội hấp lưu dẫn cực mạnh 2 chiều, ngấm sâu vào mô lá và mạch dẫn gỗ, dập tắt sợi nấm Lasiodiplodia đang phát triển.\n• Nhóm Hợp chất Đồng Đỏ sát khuẩn vết cắt & bảo vệ mô (FRAC M01): Cuprous Oxide (NORSHIELD 86.2WG, EDDY 72WP), Nano Đồng (Đồng Xanh Mekong Agro). Tạo lớp màng bảo vệ bền vững, diệt sạch bào tử nấm bên ngoài mô cây.\n• Nhóm Áo giáp Kẽm bảo vệ tiếp xúc (FRAC M03): Propineb (Antracol 70WP, Nofacol 700WP). Bổ sung Kẽm tinh khiết (Zinc++) giúp lá dày cứng, chống rách mô biểu bì.\n\n3. Dinh dưỡng phục hồi cơi đọt mới:\n• Bổ sung Enzyme thực vật & Canxi Chelate (Weyzym-A Multiagro48) kết hợp Tinh chất Tảo biển Seaweed & Amino Acid (Xanh Um Monyka, Tang Truong Panaxilus) để cây nhanh chóng giải độc, bung cơi đọt mới mập khỏe thay thế cành lá đã rụng.",
            'chemical_groups' => 'Azoxystrobin / Difenoconazole (Strobilurin & Triazole đặc trị thán thư hoại tử mô - FRAC 11 + FRAC 3), Azoxystrobin / Tebuconazole (Tebaz 400SC nội hấp lưu dẫn - FRAC 11 + FRAC 3), Cuprous Oxide / Đồng đỏ Nordox (Sát trùng vết cắt tỉa cành - FRAC M01), Pyraclostrobin (Headline thế hệ mới - FRAC 11), Propineb + Kẽm Zinc++ (Áo giáp bảo vệ mô lá - FRAC M03), Nano Đồng Chelate, Axit Amin & Canxi phục hồi cành',
            'notes' => "Lưu ý thực tế từ kỹ sư BVTV:\n• Bệnh khô cành Lasiodiplodia thường bị nhầm lẫn với bệnh Thán thư (Colletotrichum) hoặc Cháy lá chết ngọn (Rhizoctonia); tuy nhiên Lasiodiplodia tấn công sâu vào mạch gỗ cành, làm cành bị khô chết ngược (Dieback) rất đặc trưng.\n• Các cây trồng mẫn cảm nhất: Sầu riêng, Xoài, Cây có múi (cam, bưởi, quýt), Bơ, Ca cao, Chanh dây.\n• Thời điểm bùng phát mạnh: Sau các đợt mưa bão gió lớn làm gãy dập cành, hoặc giai đoạn sau thu hoạch khi cây bị rút cạn dinh dưỡng.\n• Tài liệu tham khảo: Báo cáo Cục Đổi mới Công nghệ Việt Nam (Bộ KH&CN) ghi nhận Lasiodiplodia theobromae trên sầu riêng; Viện Cây ăn quả Miền Nam (SOFRI).",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Sầu riêng, Xoài, Cây có múi, Bơ, Ca cao',
            'treatment_plans' => [
                [
                    'title'        => 'Phác đồ 1: Dập dịch Cháy bìa lá, Hoại tử mô & Chặn đứng khô cành (Azoxystrobin + Difenoconazole + Áo giáp Kẽm)',
                    'badge'        => 'Dập dịch cháy lá',
                    'badge_color'  => 'emerald',
                    'stage'        => 'Khi chóp lá và mép lá xuất hiện các vệt cháy hoại tử màu nâu đen lan rộng',
                    'dosage_guide' => 'Pha 1 chai Asmiltatop Super 400SC (250ml) + 1 gói Antracol 70WP (1kg) cho 400 - 500 lít nước. Phun ướt đều 2 mặt lá và các cành nhánh.',
                    'safety_note'  => 'Phối hợp Azoxystrobin + Difenoconazole lưu dẫn dập tắt sợi nấm hoại tử mô kết hợp Propineb (Zinc++) làm dày lá, ngăn nấm ăn sâu vào cuống cành.',
                    'groups'       => [
                        [
                            'label'                => 'Thuốc trừ nấm nội hấp 2 chiều dập hoại tử mô',
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
                            'label'                => 'Enzyme sinh học & Canxi chelate chống stress hoại tử',
                            'primary_pesticide_id' => 158, // WEYZYM-A MULTIAGRO48
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 2: Sát trùng vết cắt tỉa & chặn đứng khô cành chết ngược (Đồng Đỏ Norshield + Tebaz lưu dẫn)',
                    'badge'        => 'Sát trùng vết cắt',
                    'badge_color'  => 'red',
                    'stage'        => 'Sau khi cắt tỉa cành hoặc khi cành chóp bị khô chết ngược lan vào thân',
                    'dosage_guide' => 'Pha 1 gói NORSHIELD 86.2WG (100g) + 1 chai TEBAZ 400SC (250ml) cho 400 lít nước. Phun ướt đẫm các vết cắt tỉa và chạc cành. Với cành lớn có thể pha đậm đặc quét trực tiếp lên vết cắt.',
                    'safety_note'  => 'Đồng đỏ tinh khiết Cuprous Oxide bịt kín vết thương cơ giới chống nhiễm khuẩn, phối hợp Tebaz lưu dẫn bảo vệ mô gỗ bên trong.',
                    'groups'       => [
                        [
                            'label'                => 'Đồng đỏ hoặc Nano Đồng sát khuẩn vết cắt cành',
                            'primary_pesticide_id' => 28, // NORSHIED 86.2WG HOP TRI
                            'substitute_label'     => 'Hoặc thay thế bằng:',
                            'substitute_ids'       => [17, 18, 12], // Đồng Xanh Mekong Agro, EDDY 72WP, COC 85
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Azoxystrobin + Tebuconazole lưu dẫn chặn nấm mạch gỗ',
                            'primary_pesticide_id' => 190, // TEBAZ 400SC
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Pyraclostrobin lưu dẫn diệt bào tử',
                            'primary_pesticide_id' => 21, // HEADLINE 250EC BASF
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 3: Kích rễ giải độc & phục hồi cơi đọt sau sốc suy kiệt',
                    'badge'        => 'Phục hồi sau sốc',
                    'badge_color'  => 'blue',
                    'stage'        => 'Sau khi dập dịch nấm khô cành, cây cần tái tạo bộ rễ và đọt lá mới',
                    'dosage_guide' => 'Pha 1 chai Xanh Um Monyka (500ml) + 1 chai Tang Truong Panaxilus (500ml) cho 400 lít nước. Phun ướt đều tán lá để bung cơi đọt mới.',
                    'safety_note'  => 'Cung cấp Axit Amin đạm cá hữu cơ, Tảo biển Seaweed và vi lượng Kẽm - Đồng Chelate giúp cây phục hồi nhanh, đọt mập, lá xanh dày bóng.',
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
            ['name' => $diseaseData['name']],
            $diseaseData
        );

        // 3. Gắn các cây trồng mẫn cảm: Sầu riêng, Xoài, Cây có múi, Bơ, Ca cao
        $targetCropNames = ['Sầu riêng', 'Cây có múi'];
        $linkedCropIds = Crop::whereIn('name', $targetCropNames)->pluck('id')->toArray();
        if (!empty($linkedCropIds)) {
            $disease->crops()->sync($linkedCropIds);
        }

        // 4. Liên kết các thuốc BVTV có sẵn trong kho đặc trị Lasiodiplodia / khô cành
        // Asmiltatop (10), Tebaz (190), Norshield (28), Đồng Xanh (17), Eddy (18), COC 85 (12), Antracol (7), Nofacol (27), Headline (21), Tilt Super (37), Weyzym-A (158), Xanh Um Monyka (159), Tang Truong Panaxilus (152)
        $targetPesticideIds = [10, 190, 28, 17, 18, 12, 7, 27, 21, 37, 158, 159, 152];
        $validPesticideIds = Pesticide::whereIn('id', $targetPesticideIds)->pluck('id')->toArray();

        if (!empty($validPesticideIds)) {
            $disease->pesticides()->sync($validPesticideIds);
        }
    }
}
