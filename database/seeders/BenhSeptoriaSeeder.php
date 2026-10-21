<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class BenhSeptoriaSeeder extends Seeder
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

        // 1. Sao chép ảnh thực tế do người dùng vừa cung cấp (Đốm xám thối trái chanh dây)
        $src = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690415288.jpg';
        $filename = 'septoria-1.jpg';

        if (file_exists($src)) {
            copy($src, "$destDir/$filename");
            $savedImages[] = "diseases/$filename";
        }

        // 2. Dữ liệu hồ sơ bệnh học chuẩn cho Septoria
        $diseaseData = [
            'name' => 'Bệnh Đốm Xám — Septoria passiflorae (Bệnh Đốm Xám Chanh Dây & Cây Ăn Trái)',
            'pathogen_type' => 'nam_benh',
            'folder_code' => 'B-07',
            'folder_group' => 'nam_benh',
            'folder_name' => '7-Septoria - đốm xám',
            'folder_number' => 7,
            'caunho' => 'Septoria = ĐỐM TRÒN ĐỒNG TÂM TÂM XÁM VIỀN NÂU SẪM CHẤM ĐEN LI TI (Đốm xám thối quả chanh dây, lá vàng rụng nhanh). Trị bằng Difenoconazole + Azoxystrobin (Asmiltatop Super), Tebuconazole (Tebaz), Áo giáp Kẽm Propineb (Antracol), Mancozeb + Nano Đồng.',
            'symptoms' => "• Trên quả (Triệu chứng phá hại nghiêm trọng nhất như hình ảnh thực tế):\n- Ban đầu là những chấm đốm nhỏ màu nâu xám úng nước xuất hiện trên bề mặt vỏ quả chanh dây non hoặc quả già.\n- Vết bệnh mở rộng nhanh thành các vòng tròn đồng tâm rõ rệt; phần tâm ở giữa có màu xám tro hoặc nâu nhạt hơi lõm xuống, xung quanh có quầng viền màu nâu đậm sẫm viền rõ.\n- Bề mặt vết đốm xuất hiện vô số các hạt chấm đen li ti (ổ bào tử nấm Septoria). Khi thời tiết mưa dầm hoặc ẩm ướt kéo dài, các đốm liên kết lại làm vỏ quả bị thâm đen loang lổ, úng thối nhũn, vỏ quả nhăn nheo, quả bị rụng non hàng loạt hoặc thối hỏng hoàn toàn trước thu hoạch.\n• Trên lá:\n- Xuất hiện các vết đốm hình tròn hoặc bất định màu xám tro, viền màu nâu sẫm, giữa có các chấm đen li ti.\n- Bệnh lan nhanh làm phiến lá vàng úa và rụng rất sớm (rụng lá hàng loạt), giàn chanh dây bị trơ cành xơ xác, giảm quang hợp và suy kiệt kiệt sức.\n• Trên thân cành & tua cuốn:\n- Vết bệnh hình bầu dục dài màu nâu xám lõm nhẹ, làm teo tóp và khô chết cành giàn.",
            'symptoms_detail' => [
                'la' => 'Vết đốm tròn màu xám tro ở giữa, viền nâu sẫm có chấm đen li ti; lá vàng úa và rụng rất nhanh làm trơ giàn chanh dây.',
                'canh_than' => 'Vết đốm bầu dục màu nâu xám hơi lõm, làm teo tóp cành giàn, khô đọt non.',
                'goc_re' => 'Không gây hại trực tiếp dưới bộ rễ.',
                'qua' => 'Vỏ quả xuất hiện các đốm tròn đồng tâm tâm xám viền nâu sẫm có chấm đen li ti; vết bệnh lan rộng làm quả thâm đen, úng thối nhũn và rụng non hàng loạt.',
            ],
            'prevention' => "1. Cắt tỉa tạo giàn thông thoáng: Thường xuyên cắt tỉa lá già, cành tăm, cành sâu bệnh bên dưới giàn để ánh sáng mặt trời chiếu xuyên vào trong tán (bào tử nấm Septoria lây lan cực nhanh nhờ giọt mưa bắn trong điều kiện rậm rạp ẩm ướt).\n2. Vệ sinh tàn dư vườn: Thu gom sạch sẽ toàn bộ quả thối và lá bệnh rơi rụng quanh gốc mang ra xa vườn tiêu hủy để cắt đứt nguồn lây lan bào tử.\n3. Bón phân cân đối & làm dày vỏ quả: Không bón thừa phân đạm (N) làm vỏ quả mỏng mềm dễ nhiễm nấm. Tăng cường bổ sung Canxi, Silic, Kẽm và Kali để làm dày cứng lớp biểu bì vỏ quả và phiến lá.\n4. Phun phòng định kỳ trong mùa mưa: Phun luân phiên các dòng tiếp xúc bảo vệ như Antracol 70WP, Mancozeb 80WP hoặc Đồng Xanh Mekong Agro.",
            'treatment' => "1. NGUYÊN TẮC ĐẶC TRỊ SEPTORIA:\n• Nấm Septoria phát triển cực nhanh trong mùa mưa. Cần xử lý ngay khi phát hiện những đốm tròn tâm xám đầu tiên trên vỏ quả hoặc phiến lá.\n• Kết hợp hoạt chất nội hấp lưu dẫn để diệt sợi nấm bên trong mô vỏ quả + hoạt chất tiếp xúc bám dính để tiêu diệt các ổ bào tử đen li ti bên ngoài.\n\n2. Phác đồ hóa học đặc trị luân phiên:\n• Cặp đôi Strobilurin + Triazole đặc trị đốm xám (FRAC 11 + FRAC 3): Azoxystrobin + Difenoconazole (Asmiltatop Super 400SC), Azoxystrobin + Tebuconazole (Tebaz 400SC). Lưu dẫn 2 chiều mạnh mẽ, dập tắt sợi nấm, giúp vết đốm khô miệng và ngừng lây lan sau 2-3 ngày.\n• Pyraclostrobin thế hệ mới (FRAC 11): Headline 250EC BASF. Hiệu lực dập bào tử phổ rộng, giúp da trái sáng bóng, làm xanh dày lá.\n• Nhóm Áo giáp Kẽm bảo vệ tiếp xúc (FRAC M03): Propineb (Antracol 70WP, Nofacol 700WP), Mancozeb 80WP. Bổ sung Kẽm Zinc++ giúp tăng sức đề kháng biểu bì vỏ trái, ngăn nấm chọc thủng da quả.\n• Nhóm Nano Đồng: Đồng Xanh Mekong Agro sát trùng vết bệnh, chống bội nhiễm vi khuẩn gây thối nhũn quả.\n\n3. Dưỡng trái & chống rụng quả non:\n• Phun bổ sung Enzyme & Canxi Chelate (Weyzym-A Multiagro48) kết hợp Tinh chất Tảo biển Seaweed & Amino Acid (Xanh Um Monyka, Tang Truong Panaxilus) để cuống trái dai khỏe, vỏ trái bóng đẹp, hạn chế tối đa rụng quả non.",
            'chemical_groups' => 'Azoxystrobin / Difenoconazole (Strobilurin & Triazole đặc trị đốm xám thối trái - FRAC 11 + FRAC 3), Azoxystrobin / Tebuconazole (Tebaz 400SC lưu dẫn - FRAC 11 + FRAC 3), Pyraclostrobin (Headline 250EC - FRAC 11), Propineb + Kẽm Zinc++ (Áo giáp Kẽm bảo vệ da trái - FRAC M03), Mancozeb 80WP, Nano Đồng Chelate, Canxi Chelate chống rụng trái',
            'notes' => "Lưu ý thực tế từ kỹ sư BVTV:\n• Bệnh đốm xám Septoria gây thiệt hại kinh tế nặng nề nhất trên: Chanh dây (bệnh thối quả đốm xám), Cà chua, Sầu riêng, Cây có múi.\n• Thời điểm bùng phát mạnh: Trong mùa mưa dầm hoặc giai đoạn quả non đến bánh tẻ khi độ ẩm không khí bão hòa.\n• Vết bệnh Septoria dễ bị vi khuẩn xâm nhập thứ cấp gây thối nhũn chảy nước; cần kết hợp thuốc gốc Đồng để vừa trừ nấm vừa sát khuẩn.\n• Tài liệu tham khảo: Viện Nghiên cứu Rau quả (FAVRI), Cục Bảo vệ Thực vật, Viện Cây ăn quả Miền Nam (SOFRI).",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Chanh dây, Sầu riêng, Cây có múi, Cà chua',
            'treatment_plans' => [
                [
                    'title'        => 'Phác đồ 1: Đặc trị dập dịch Đốm xám, Đốm vòng thối trái chanh dây (Azoxystrobin + Difenoconazole + Áo giáp Kẽm)',
                    'badge'        => 'Đặc trị dứt điểm',
                    'badge_color'  => 'emerald',
                    'stage'        => 'Khi vỏ trái chanh dây hoặc phiến lá chớm xuất hiện đốm tròn đồng tâm xám viền nâu',
                    'dosage_guide' => 'Pha 1 chai Asmiltatop Super 400SC (250ml) + 1 gói Antracol 70WP (1kg) cho 400 - 500 lít nước. Phun ướt đều các chùm trái và giàn lá.',
                    'safety_note'  => 'Azoxystrobin + Difenoconazole nội hấp 2 chiều dập tắt sợi nấm đốm xám kết hợp Propineb (Zinc++) làm dày cứng vỏ trái, vết đốm khô giòn không loang thối.',
                    'groups'       => [
                        [
                            'label'                => 'Thuốc trừ nấm nội hấp 2 chiều dập đốm xám thối trái',
                            'primary_pesticide_id' => 10, // ASMILTATOP SUPER 400SC
                            'substitute_label'     => 'Hoặc thay thế bằng thuốc tương đương:',
                            'substitute_ids'       => [190], // TEBAZ 400SC
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Áo giáp Kẽm bảo vệ tiếp xúc & dưỡng da trái bóng đẹp',
                            'primary_pesticide_id' => 7, // Antracol 70WP Bayer
                            'substitute_label'     => 'Hoặc thay thế bằng:',
                            'substitute_ids'       => [27, 26], // NOFACOL 700WP, MANCOZEB 80WP
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Enzyme sinh học & Canxi chelate chống thối rụng quả',
                            'primary_pesticide_id' => 158, // WEYZYM-A MULTIAGRO48
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 2: Chặn đứng thâm đen thối quả & làm khô nhanh vết đốm (Tebaz 400SC + Nano Đồng Chelate)',
                    'badge'        => 'Chống thối quả loang',
                    'badge_color'  => 'blue',
                    'stage'        => 'Giai đoạn mùa mưa dầm nấm đốm xám lây lan mạnh làm quả thâm đen',
                    'dosage_guide' => 'Pha 1 chai TEBAZ 400SC (250ml) + 1 chai Đồng Xanh Mekong Agro (500ml) cho 400 lít nước. Phun ướt đẫm chùm trái và giàn lá.',
                    'safety_note'  => 'Azoxystrobin + Tebuconazole lưu dẫn phổ rộng kết hợp Nano Đồng Chelate sát trùng da trái, triệt tiêu ổ bào tử đen, chống thối nhũn quả.',
                    'groups'       => [
                        [
                            'label'                => 'Azoxystrobin + Tebuconazole lưu dẫn chặn nấm thối quả',
                            'primary_pesticide_id' => 190, // TEBAZ 400SC
                            'substitute_label'     => 'Hoặc thay thế bằng:',
                            'substitute_ids'       => [9, 37], // ANVIL 5SC, TILT SUPER
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Nano Đồng Chelate sát trùng bề mặt quả',
                            'primary_pesticide_id' => 17, // Đồng Xanh Mekong Agro
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
                    'title'        => 'Phác đồ 3: Phục hồi da quả bóng đẹp, dai cuống & dưỡng giàn lá khỏe',
                    'badge'        => 'Dai cuống bóng trái',
                    'badge_color'  => 'amber',
                    'stage'        => 'Sau khi dập dịch đốm xám, cần nuôi quả lớn nhanh, da bóng không nám',
                    'dosage_guide' => 'Pha 1 chai Xanh Um Monyka (500ml) + 1 chai Tang Truong Panaxilus (500ml) cho 400 lít nước. Phun ướt đều giàn lá và chùm quả.',
                    'safety_note'  => 'Cung cấp Axit Amin đạm cá hữu cơ, Tinh chất Tảo biển Seaweed và Bo, Kẽm Chelate giúp dai cuống quả, hạn chế tối đa rụng quả non, da quả bóng mướt.',
                    'groups'       => [
                        [
                            'label'                => 'Axit Amin đạm cá & Tinh chất tảo biển Seaweed',
                            'primary_pesticide_id' => 159, // Xanh Um Monyka
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Vi lượng Chelate dai cuống nuôi trái',
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

        // 3. Gắn các cây trồng mẫn cảm: Chanh dây, Sầu riêng, Cây có múi
        $targetCropNames = ['Chanh dây', 'Sầu riêng', 'Cây có múi'];
        $linkedCropIds = Crop::whereIn('name', $targetCropNames)->pluck('id')->toArray();
        if (!empty($linkedCropIds)) {
            $disease->crops()->sync($linkedCropIds);
        }

        // 4. Liên kết các thuốc BVTV có sẵn trong kho đặc trị Septoria / đốm xám
        // Asmiltatop (10), Tebaz (190), Antracol (7), Nofacol (27), Headline (21), Anvil (9), Tilt Super (37), Đồng Xanh (17), Mancozeb (26), Weyzym-A (158), Xanh Um Monyka (159), Tang Truong Panaxilus (152)
        $targetPesticideIds = [10, 190, 7, 27, 21, 9, 37, 17, 26, 158, 159, 152];
        $validPesticideIds = Pesticide::whereIn('id', $targetPesticideIds)->pluck('id')->toArray();

        if (!empty($validPesticideIds)) {
            $disease->pesticides()->sync($validPesticideIds);
        }
    }
}
