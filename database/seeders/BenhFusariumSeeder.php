<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class BenhFusariumSeeder extends Seeder
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

        // 1. Sao chép ảnh thực tế do người dùng vừa cung cấp (Nghiên cứu bệnh học tổng hợp Fusarium gồm 4 khung A, B, C, D)
        $src = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690347151.jpg';
        $filename = 'fusarium-heo-cay-1.jpg';

        if (file_exists($src)) {
            copy($src, "$destDir/$filename");
            $savedImages[] = "diseases/$filename";
        } elseif (file_exists("$destDir/$filename")) {
            $savedImages[] = "diseases/$filename";
        }

        // 2. Dữ liệu hồ sơ bệnh học chuẩn cho Fusarium — bệnh rễ, héo cây
        $diseaseData = [
            'name' => 'Bệnh Héo Cây, Khô Cành, Thối Rễ & Tắc Mạch Dẫn — Fusarium spp. (Fusarium solani / Fusarium oxysporum — Vàng Lá Héo Rũ, Chết Chậm & Thối Rễ Sầu Riêng)',
            'pathogen_type' => 'nam_benh',
            'folder_code' => 'B-03',
            'folder_group' => 'nam_benh',
            'folder_name' => '3-Fusarium - bệnh rễ, héo cây',
            'folder_number' => 3,
            'caunho' => 'Fusarium = TẮC MẠCH DẪN NÂU ĐEN + VÀNG LÁ HÉO RŨ + RỤNG TRƠ CÀNH TOÀN CÂY (cắt cành/gốc thấy mạch xylem hóa nâu). Dập dịch tưới gốc bằng Triazole (Tebaz 400SC, Anvil 5SC / Japa Vil), Difenoconazole, Mancozeb 80WP và cấy nấm đối kháng Trichoderma + Humic tái tạo rễ.',
            'symptoms' => "• Phân tích bệnh học chuyên sâu qua 4 khung hình (A, B, C, D) thực tế bạn gửi:\n- Khung A — Toàn cây sầu riêng bị héo rũ, rụng trơ trụi lá: Tán cây bị rụng lá hàng loạt từ đỉnh ngọn xuống các cành tầng dưới, lá khô rụng phủ kín mặt đất quanh hình chiếu tán; cành cây trơ trụi khô khốc không còn một lá (hiện tượng cây chết đứng / héo rũ toàn diện do hệ thống mạch dẫn xylem bị nấm Fusarium phong tỏa 100%).\n- Khung B — Triệu chứng trên phiến lá: Các lá già và lá bánh tẻ chuyển màu vàng úa rải rác từng cành hoặc một phía tán cây; phiến lá mất độ bóng, trưa nắng gắt lá héo rũ cụp xuống dù đất vẫn đủ ẩm, chiều tối hồi phục nhẹ trong vài ngày đầu rồi sau đó khô giòn và rụng sớm.\n- Khung C — Mặt cắt dọc mô cành & rễ (DẤU HIỆU CHẨN ĐOÁN XÁC ĐỊNH SỐ 1 CỦA FUSARIUM): Dùng dao sắc chẻ dọc thân cành hoặc rễ cái thấy rõ lớp mạch gỗ (xylem) bên trong bị HÓA NÂU ĐEN / NÂU SẪM KÉO DÀI THÀNH TỪNG VỆT SỌC LIÊN TỤC (Vascular Browning). Độc tố Fusaric acid cùng sợi nấm làm hoại tử và tắc nghẽn hoàn toàn đường vận chuyển nước và khoáng chất từ rễ lên tán lá.\n- Khung D — Mặt cắt ngang thân cành: Vòng mạch dẫn bên trong bị thâm đen hóa nâu tạo thành một vòng tròn bao quanh lõi gỗ, mô mạch bị thối mục làm mất hoàn toàn khả năng dẫn truyền sinh học.\n• Dưới hệ thống bộ rễ:\n- Rễ cám và rễ cọc bị nấm Fusarium xâm nhập qua các vết thương cơ học hoặc vết châm chích của tuyến trùng, gây hiện tượng THỐI KHÔ RỄ (rễ thâm đen khô rạc, khác với thối nhũn ướt sũng của Phytophthora). Lớp vỏ rễ bị mục nát, lõi rễ chuyển sang màu nâu sẫm.",
            'symptoms_detail' => [
                'la' => 'Lá vàng rải rác từ lá già lên lá non, trưa nắng héo rũ cụp xuống, sau đó khô cháy và rụng hàng loạt để lại cây trơ cành chổi chà.',
                'canh_than' => 'Chẻ dọc cành hoặc thân thấy mạch dẫn xylem bên trong bị hóa nâu đen; cắt ngang thấy vòng thâm đen quanh lõi gỗ; vỏ ngoài khô nứt teo tóp.',
                'goc_re' => 'Hệ rễ cám và cổ rễ bị thối khô thâm đen; lõi rễ bị hóa nâu tắc mạch dẫn; cây mất hoàn toàn khả năng hút nước.',
                'qua' => 'Trái non bị teo tóp vàng cuống rụng hàng loạt; cây mang trái lớn sẽ bị rụng trái non, cơm trái sượng méo mó, cây kiệt quệ chết đứng.',
            ],
            'prevention' => "1. Nâng cao pH đất và kiểm soát tuyến trùng: Nấm Fusarium phát triển cực mạnh trong đất chua (pH < 5.0) và đất có mật độ tuyến trùng cao (tuyến trùng chích thủng rễ tạo cửa ngõ cho nấm chui vào). Cần định kỳ bón vôi nông nghiệp hoặc tưới tinh vôi để nâng pH đất đạt 5.5 - 6.5.\n2. Cải thiện thoát nước tầng rễ: Tuyệt đối không để đọng nước ngập úng quanh vùng gốc sầu riêng trong mùa mưa; đào rãnh thoát nước sâu giữa các hàng liếp để đất luôn thông thoáng khí oxy.\n3. Cắt tỉa cành chết và vệ sinh triệt để: Dùng cưa cắt bỏ các cành đã bị khô chết (chẻ cành thấy lõi nâu) đem tiêu hủy xa vườn; khử trùng dụng cụ cắt tỉa bằng cồn hoặc nước vôi đặc sau mỗi lần cắt cành bệnh.\n4. Bón lót phân chuồng hoai mục kết hợp nấm đối kháng Trichoderma: Định kỳ 2 - 3 lần/năm tưới bổ sung chế phẩm vi sinh đối kháng Trichoderma spp. và Bacillus subtilis để cạnh tranh sinh học, cô lập và tiêu diệt bào tử nấm Fusarium trong đất.",
            'treatment' => "1. NGUYÊN TẮC VÀNG ĐẶC TRỊ FUSARIUM SOLANI / OXYSPORUM:\n• Nấm Fusarium cư trú bên trong mạch dẫn lõi gỗ và dưới tầng đất sâu, phun thuốc qua lá chỉ bảo vệ tạm thời, BẮT BUỘC PHẢI TƯỚI ĐẪM VÙNG RỄ bằng thuốc nội hấp lưu dẫn mạnh để rễ hút thuốc dẫn truyền ngược lên dập tắt sợi nấm trong mạch dẫn.\n• Quy trình điều trị 3 bước chuẩn kỹ sư BVTV:\n   - Bước 1: Tưới thuốc hóa học dập dịch dập tắt sợi nấm Fusarium trong đất và mạch rễ (Triazole + Mancozeb).\n   - Bước 2: Quét dung dịch thuốc đậm đặc vào các vết loét nứt thân cành.\n   - Bước 3: Sau khi dập sạch nấm 7 - 10 ngày, phục hồi kích thích tái sinh hệ rễ cám mới bằng Humic, Amino acid và vi sinh đối kháng Trichoderma.\n\n2. Phác đồ hóa học đặc trị luân phiên:\n• Cặp đôi Triazole + Strobilurin lưu dẫn 2 chiều (FRAC 3 + FRAC 11): Tebaz 400SC (Azoxystrobin + Tebuconazole), Asmiltatop Super 400SC (Azoxystrobin + Difenoconazole). Tebuconazole và Difenoconazole là những hoạt chất có hiệu lực ức chế nấm Fusarium mạnh nhất, thẩm thấu nhanh vào mô mạch dẫn làm khô se vết bệnh.\n• Hoạt chất Triazole chuyên nội hấp (FRAC 3): Anvil 5SC Syngenta (Hexaconazole), Japa Vil 110SC Monyka. Khả năng lưu dẫn hướng ngọn cực mạnh, dập tắt sợi nấm Fusarium trong cành thân.\n• Thuốc bảo vệ tiếp xúc phổ rộng (FRAC M01 / FRAC M03): Mancozeb 80WP, Antracol 70WP Bayer (Propineb + Zinc++). Sát trùng toàn bộ vùng đất quanh rễ, tiêu diệt màng bào tử nấm lơ lửng trong đất.\n\n3. Phục hồi bộ rễ cám & kích cơi đọt sau bệnh:\n• Sau khi xử lý thuốc hóa học dập dịch 7–10 ngày, bắt buộc phải tưới kích rễ mới bằng Axit Humic tinh khiết, Axit Fulvic, Axit Amin đạm cá (Xanh Um Monyka, Tang Truong Panaxilus) kết hợp MgO - Kẽm EDTA để cây bung lớp lông hút rễ tơ mới, khôi phục khả năng hút nước nuôi tán lá.",
            'chemical_groups' => 'Azoxystrobin + Tebuconazole (Tebaz 400SC - FRAC 11 + FRAC 3), Azoxystrobin + Difenoconazole (Asmiltatop Super - FRAC 11 + FRAC 3), Hexaconazole (Anvil 5SC / Japa Vil 110SC - FRAC 3), Mancozeb 80WP (FRAC M01), Propineb + Kẽm Zinc++ (Antracol 70WP / Nofacol 700WP - FRAC M03), Pyraclostrobin (Headline 250EC - FRAC 11), Vi sinh đối kháng Trichoderma spp., Axit Humic & Amino Acid',
            'notes' => "Lưu ý thực tế từ kỹ sư BVTV:\n• Bệnh Fusarium là nguyên nhân cốt lõi gây ra hội chứng 'Vàng lá thối rễ' và 'Chết chậm' trên cây ăn trái (Sầu riêng, Cây có múi) và cây công nghiệp (Cà phê, Hồ tiêu, Chanh dây).\n• ĐIỂM PHÂN BIỆT SỐ 1: Vàng lá Fusarium luôn đi kèm với TRIỆU CHỨNG HÓA NÂU ĐEN LÕI MẠCH DẪN (Xylem Browning). Nếu cắt cành hoặc rễ mà mạch dẫn vẫn trắng tinh thì cây bị vàng lá do úng nước nghẹt rễ hoặc thiếu vi lượng chứ không phải do Fusarium.\n• Cây bị Fusarium nặng (đã khô rụng trên 60% tán lá) cần cắt tỉa bớt 40-50% cành khô để giảm thoát hơi nước, tưới thuốc dập dịch ngay trước khi mạch dẫn bị tắc tử hoàn toàn.\n• Tài liệu tham khảo: Viện Cây ăn quả Miền Nam (SOFRI), Cục Bảo vệ Thực vật, Viện KHKT Nông Lâm nghiệp Tây Nguyên (WASI).",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Sầu riêng, Cà phê, Hồ tiêu, Chanh dây, Cây có múi, Chuối, Cây họ cà',
            'treatment_plans' => [
                [
                    'title'        => 'Phác đồ 1: Tưới đẫm vùng rễ đặc trị dập dịch Nấm Fusarium tắc mạch dẫn (Tebaz 400SC + Anvil 5SC + Mancozeb 80WP)',
                    'badge'        => 'Đặc trị tưới gốc',
                    'badge_color'  => 'emerald',
                    'stage'        => 'Khi phát hiện cây sầu riêng có biểu hiện vàng lá rải rác từng cành, trưa nắng héo rũ, chẻ cành/rễ thấy vệt nâu sẫm trong mạch dẫn',
                    'dosage_guide' => 'Pha 1 chai Tebaz 400SC (200ml) + 1 chai Anvil 5SC (1 lít) hoặc Japa Vil 110SC (1 lít) + 1 gói Mancozeb 80WP (1kg) cho 400 lít nước (2 phuy). Tưới đẫm đều quanh hình chiếu tán cây từ 15 - 30 lít dung dịch thuốc/gốc (tùy tuổi cây). Đồng thời phun ướt đều tán lá.',
                    'safety_note'  => 'Tebuconazole và Hexaconazole thẩm thấu sâu vào mạch rễ lưu dẫn ngược lên thân dập tắt sợi nấm Fusarium; Mancozeb sát trùng bề mặt đất. Tưới nhắc lại lần 2 sau 7–10 ngày.',
                    'groups'       => [
                        [
                            'label'                => 'Azoxystrobin + Tebuconazole lưu dẫn 2 chiều đặc trị nấm Fusarium',
                            'primary_pesticide_id' => 190, // TEBAZ 400SC
                            'substitute_ids'       => [10],  // ASMILTATOP SUPER 400SC
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Hexaconazole nội hấp hướng ngọn dập tắt sợi nấm trong mạch dẫn',
                            'primary_pesticide_id' => 9,   // ANVIL SYNGENTA 5SC
                            'substitute_ids'       => [22],  // Japa Vil 110SC Monyka
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Mancozeb tiếp xúc sát trùng mầm nấm trong đất quanh rễ',
                            'primary_pesticide_id' => 26,  // MANCOZEB 80WP
                            'substitute_ids'       => [7],   // Antracol 70WP Bayer
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 2: Phun tán & Quét vết loét cành thân, chặn đứng nấm Fusarium lây lan',
                    'badge'        => 'Quét thân & Dập dịch',
                    'badge_color'  => 'sky',
                    'stage'        => 'Khi nấm Fusarium ăn lan lên thân cành làm khô nứt vỏ cành, hoặc sau các đợt mưa to gió bão cây bị tổn thương rễ cành',
                    'dosage_guide' => '1. Phun tán: Pha 1 chai Asmiltatop Super 400SC (200ml) + 1 gói Antracol 70WP (300g) + 1 chai Headline 250EC (100ml) cho 200 lít nước, phun ướt đẫm cành lá.\n2. Quét cành: Pha 200g Antracol 70WP + 100ml Tebaz 400SC vào 2 lít nước thành dạng hồ sệt, dùng chổi quét trực tiếp lên vỏ thân cành bị nứt nâu.',
                    'safety_note'  => 'Pyraclostrobin thế hệ mới dập sạch bào tử nấm trong không khí; Propineb bổ sung Kẽm Zinc++ tạo màng bảo vệ biểu bì cành lá, giúp cây nhanh phục hồi.',
                    'groups'       => [
                        [
                            'label'                => 'Azoxystrobin + Difenoconazole lưu dẫn làm lành mạch dẫn',
                            'primary_pesticide_id' => 10,  // ASMILTATOP SUPER 400SC
                            'substitute_ids'       => [190], // TEBAZ 400SC
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Áo giáp Kẽm Propineb bảo vệ biểu bì vỏ cành & cuống lá',
                            'primary_pesticide_id' => 7,   // Antracol 70WP Bayer
                            'substitute_ids'       => [27],  // NOFACOL 700WP
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Pyraclostrobin thế hệ mới dập tắt mầm bào tử nấm phổ rộng',
                            'primary_pesticide_id' => 21,  // HEADLINE 250EC BASF
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 3: Phục hồi tái sinh rễ cám mới, nuôi cơi lá xanh dày sau khi khỏi bệnh Fusarium',
                    'badge'        => 'Tái sinh bộ rễ',
                    'badge_color'  => 'amber',
                    'stage'        => 'Sau khi tưới thuốc dập dịch 7–10 ngày, cây đã ngừng rụng lá và mạch dẫn khô ráo, cần kích rễ cám mới tái sinh',
                    'dosage_guide' => 'Pha 1 chai Xanh Um Monyka (500ml) + 1 chai Tang Truong Panaxilus (500ml) + 1 chai MgO - Kẽm EDTA (250ml) cho 400 lít nước (2 phuy). Tưới đều quanh vùng rễ (15–20 lít/gốc) và phun ướt đều tán lá.',
                    'safety_note'  => 'Cung cấp Axit Amin đạm cá hữu cơ, Tảo biển Seaweed và Kẽm, Magie Chelate giúp kích thích chóp rễ tơ bung mạnh, khôi phục lại khả năng hấp thu dinh dưỡng và tái tạo cơi đọt mới.',
                    'groups'       => [
                        [
                            'label'                => 'Axit Amin đạm cá & Tinh chất tảo biển Seaweed kích rễ cám',
                            'primary_pesticide_id' => 159, // Xanh Um Monyka
                            'substitute_ids'       => [152], // TANG TRUONG PANAXILUS
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Vi lượng Chelate & NPK cân đối phục hồi tán lá',
                            'primary_pesticide_id' => 152, // TANG TRUONG PANAXILUS
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Magie & Kẽm Chelate chống cháy chóp lá non, quang hợp khỏe',
                            'primary_pesticide_id' => 111, // MgO - Kẽm EDTA
                            'substitute_ids'       => [158], // WEYZYM-A MULTIAGRO48
                        ],
                    ],
                ],
            ],
        ];

        // 3. Tạo hoặc cập nhật bệnh trong database
        $disease = Disease::updateOrCreate(
            ['folder_code' => 'B-03'],
            $diseaseData
        );

        // 4. Gắn quan hệ với cây trồng (Crops)
        $crops = Crop::whereIn('name', [
            'Sầu riêng',
            'Cà phê',
            'Hồ tiêu',
            'Chanh dây',
            'Cây có múi',
        ])->get();

        if ($crops->isNotEmpty()) {
            $disease->crops()->sync($crops->pluck('id')->toArray());
        }

        // 5. Gắn danh sách thuốc BVTV liên quan (Pesticides)
        $pesticideIds = [190, 10, 9, 22, 26, 7, 27, 21, 159, 152, 111, 158];
        $existingPesticides = Pesticide::whereIn('id', $pesticideIds)->pluck('id')->toArray();
        if (!empty($existingPesticides)) {
            $disease->pesticides()->sync($existingPesticides);
        }

        $this->command->info("Đã tạo / cập nhật thành công hồ sơ bệnh học: {$disease->name} (ID: {$disease->id})");
    }
}
