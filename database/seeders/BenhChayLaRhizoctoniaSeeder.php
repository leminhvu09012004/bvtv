<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class BenhChayLaRhizoctoniaSeeder extends Seeder
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

        // 1. Sao chép ảnh thực tế do người dùng vừa cung cấp (Lá sầu riêng cháy loang lổ úng nước, khô xám và dính chùm vào nhau do nấm Rhizoctonia solani)
        $src = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690309893.jpg';
        $filename = 'rhizoctonia-chay-la-1.jpg';

        if (file_exists($src)) {
            copy($src, "$destDir/$filename");
            $savedImages[] = "diseases/$filename";
        } else {
            // Trường hợp file đã được copy trước đó vào storage
            if (file_exists("$destDir/$filename")) {
                $savedImages[] = "diseases/$filename";
            }
        }

        // 2. Dữ liệu hồ sơ bệnh học chuẩn cho Rhizoctonia — Cháy lá, Chết ngọn
        $diseaseData = [
            'name' => 'Bệnh Cháy Lá, Chết Ngọn — Rhizoctonia solani (Cháy Lá Sầu Riêng, Thối Rũ Cây Con & Khô Vằn)',
            'pathogen_type' => 'nam_benh',
            'folder_code' => 'B-04',
            'folder_group' => 'nam_benh',
            'folder_name' => '4-Rhizoctonia - cháy lá, chết ngọn',
            'folder_number' => 4,
            'caunho' => 'Rhizoctonia = LÁ DÍNH CHÙM NHƯ TỔ SÂU, CHÁY LOANG LỔ KHÔ XÁM RỤNG TRƠ CÀNH. Trị bằng Validamycin (Validacin Sumitomo), Hexaconazole (Anvil 5SC / Japa Vil), Azoxystrobin + Tebuconazole (Tebaz 400SC) và Áo giáp Kẽm Propineb (Antracol).',
            'symptoms' => "• Trên phiến lá (Triệu chứng phá hại đặc trưng nhất như hình ảnh thực tế bạn gửi):\n- Ban đầu vết bệnh xuất hiện dạng các chấm hoặc mảng úng nước (water-soaked) màu xám xanh hoặc nâu nhạt như bị luộc nước sôi, thường xuất hiện ở phần gốc lá hoặc rìa phiến lá nơi đọng nước ẩm.\n- Vết bệnh lan rộng rất nhanh ra khắp phiến lá không theo hình dạng cố định, mô lá chuyển sang màu nâu sẫm rồi khô rạc màu xám tro hoặc màu rơm rạ khô giòn.\n- ĐẶC ĐIỂM NHẬN BIẾT ĐỘC NHẤT: Sợi tơ nấm phát triển dày đặc màu trắng ngà hoặc nâu nhạt đan xen liên kết các lá lân cận lại với nhau, kéo các lá non và lá bánh tẻ DÍNH CHÙM LẠI VỚI NHAU NHƯ TỔ SÂU / MẠNG NHỆN.\n- Các lá dính chùm này bị nấm ăn chết khô giòn nhưng chưa rụng ngay mà treo lơ lửng trên cành; khi gặp mưa gió lớn hoặc nấm ăn đứt cuống lá, toàn bộ chùm lá khô rụng xuống để lại cành trơ trụi.\n• Trên chồi non & ngọn cành:\n- Tơ nấm từ cuống lá lan sang đọt non và ngọn non làm ngọn bị thối đen ủng nước, teo thắt cành non, gây hiện tượng CHẾT NGƯỢC TỪ NGỌN VÀO THÂN (chết ngọn dieback).\n• Trên cây con & vườn ươm:\n- Trong điều kiện vườn ươm ẩm thấp rậm rạp, nấm Rhizoctonia solani làm thối rụi hàng loạt lá non của cây giống sầu riêng và gây thối cổ rễ, chết rạp cây con.",
            'symptoms_detail' => [
                'la' => 'Vết cháy loang lổ dạng úng nước chuyển sang nâu xám khô rơm; sợi nấm kéo các lá non dính chùm lại với nhau như tổ sâu; lá chết khô giòn rồi rụng trơ cành.',
                'canh_than' => 'Nấm ăn lan vào đọt non làm teo thắt cành non, gây thối ngọn và chết ngược từ đọt vào thân cây (chết ngọn).',
                'goc_re' => 'Ở giai đoạn cây giống vườn ươm, nấm Rhizoctonia còn gây thối cổ rễ, thối rũ cây con sát mặt đất.',
                'qua' => 'Chủ yếu phá hại bộ lá và cơi đọt non; quả non sát mặt đất có thể bị đốm thối ủng nước trong mùa mưa dầm.',
            ],
            'prevention' => "1. Cắt tỉa tạo tán thông thoáng: Định kỳ tỉa bỏ cành vượt, cành la sà mặt đất và các cành tăm rậm rạp bên trong tán để ánh nắng chiếu sâu vào thân gốc, giúp tán lá nhanh khô ráo sau mưa (nấm Rhizoctonia phát triển bùng nổ khi độ ẩm tán lá đạt trên 85%).\n2. Thu gom tiêu hủy ổ bệnh triệt để: Dùng kéo cắt bỏ toàn bộ các chùm lá dính chùm bị khô cháy và cành ngọn non bị chết khô gom vào bao kín mang ra xa vườn tiêu hủy để dập tắt nguồn tơ nấm và hạch nấm (sclerotia) lây lan.\n3. Bón phân cân đối, hạn chế thừa Đạm: Tuyệt đối không bón thừa phân đạm trong mùa mưa dầm làm mô lá mỏng mềm non yếu. Tăng cường bón Kali, Canxi, Magie và Silic giúp vách tế bào lá dày cứng cáp, tăng sức đề kháng chống nấm xâm nhiễm.\n4. Phun phòng định kỳ trong mùa mưa: Khi cây sầu riêng bung cơi đọt non gặp mùa mưa dầm, chủ động phun phòng ngừa bằng các dòng tiếp xúc có bổ sung vi lượng Kẽm như Antracol 70WP, Nofacol 700WP hoặc Đồng chelate.",
            'treatment' => "1. NGUYÊN TẮC ĐẶC TRỊ RHIZOCTONIA SOLANI:\n• Dập dịch ngay khi phát hiện những chùm lá đầu tiên bị dính chùm hoặc vết loang úng nước xuất hiện trên tán lá.\n• Kết hợp kháng sinh sinh học đặc hiệu ức chế nấm Rhizoctonia (Validamycin) + thuốc nội hấp lưu dẫn thẩm thấu sâu nhóm Triazole (Hexaconazole, Tebuconazole) hoặc Strobilurin (Azoxystrobin) + thuốc bảo vệ tiếp xúc (Propineb, Mancozeb).\n\n2. Phác đồ hóa học đặc trị luân phiên:\n• Kháng sinh sinh học đặc hiệu (FRAC 26): Validamycin A (Validacin 5SL Sumitomo). Ức chế cực mạnh sự kéo dài của sợi nấm và tiêu diệt hạch nấm Rhizoctonia solani, làm teo khô tơ nấm sau 24-48h, an toàn cho đọt non và không gây sượng trái.\n• Nhóm Triazole nội hấp mạnh (FRAC 3): Hexaconazole (Anvil 5SC Syngenta, Japa Vil 110SC Monyka), Tebuconazole (Tebaz 400SC). Lưu dẫn 2 chiều thẩm thấu nhanh vào mô lá, làm khô se vết loang cháy lá và cô lập ổ nấm.\n• Cặp đôi Triazole + Strobilurin (FRAC 3 + FRAC 11): Tebaz 400SC (Azoxystrobin + Tebuconazole), Asmiltatop Super 400SC (Azoxystrobin + Difenoconazole). Dập tắt cả sợi nấm và bào tử, bảo vệ cơi đọt non mới nhú không bị thối ngọn.\n• Nhóm Áo giáp Kẽm bảo vệ tiếp xúc (FRAC M03): Propineb (Antracol 70WP, Nofacol 700WP), Mancozeb 80WP. Tạo màng bảo vệ bề mặt phiến lá, bổ sung vi lượng Kẽm Zinc++ giúp lá dày bóng khỏe.\n\n3. Phục hồi bộ lá và cơi đọt sau bệnh:\n• Sau khi vết bệnh khô se hoàn toàn, phun bổ sung Axit Amin đạm cá hữu cơ, Tinh chất Rong biển Seaweed (Xanh Um Monyka, Tang Truong Panaxilus) kết hợp MgO - Kẽm EDTA để kích thích cơi đọt mới phát triển mập khỏe, bù đắp lượng lá bị rụng do cháy lá.",
            'chemical_groups' => 'Validamycin A (Validacin 5SL - FRAC 26), Hexaconazole (Anvil 5SC / Japa Vil 110SC - FRAC 3), Azoxystrobin + Tebuconazole (Tebaz 400SC - FRAC 11 + FRAC 3), Azoxystrobin + Difenoconazole (Asmiltatop Super - FRAC 11 + FRAC 3), Propineb + Kẽm Zinc++ (Antracol 70WP / Nofacol 700WP - FRAC M03), Mancozeb 80WP (FRAC M01), Pyraclostrobin (Headline 250EC - FRAC 11), Amino Acid & Vi lượng Chelate',
            'notes' => "Lưu ý thực tế từ kỹ sư BVTV:\n• Bệnh cháy lá chết ngọn do nấm Rhizoctonia solani là một trong 3 dịch hại nguy hiểm nhất trên sầu riêng trong mùa mưa (bên cạnh Phytophthora và Thán thư).\n• DẤU HIỆU ĐẶC TRƯNG PHÂN BIỆT: Khác với Thán thư (cháy viền có vân gợn sóng đồng tâm) và Khô cành Lasiodiplodia (khô thâm cành nứt vỏ), bệnh Rhizoctonia LUÔN CÓ TƠ NẤM KÉO DÍNH CÁC LÁ LẠI VỚI NHAU NHƯ TỔ SÂU.\n• Bệnh lây lan cực kỳ nhanh chóng qua nước mưa bắn và gió cuốn tơ nấm; nếu không dập dịch kịp thời có thể làm trơ trụi toàn bộ tán lá chỉ sau 1 - 2 tuần mưa dầm.\n• Tài liệu tham khảo: Viện Cây ăn quả Miền Nam (SOFRI), Trung tâm Khuyến nông Quốc gia, Cục Bảo vệ Thực vật.",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Sầu riêng, Cây có múi, Cà phê, Hồ tiêu, Chanh dây',
            'treatment_plans' => [
                [
                    'title'        => 'Phác đồ 1: Đặc trị dập dịch Cháy lá & Dính chùm Rhizoctonia (Validamycin + Hexaconazole + Áo giáp Kẽm Propineb)',
                    'badge'        => 'Đặc trị dập dịch',
                    'badge_color'  => 'emerald',
                    'stage'        => 'Khi phát hiện các vết cháy loang lổ úng nước và các chùm lá bị dính chùm vào nhau trên tán lá sầu riêng',
                    'dosage_guide' => 'Pha 1 chai Validacin 5SL Sumitomo (450ml) + 1 chai Anvil 5SC (250ml - 400ml) hoặc Japa Vil 110SC (250ml) + 1 gói Antracol 70WP (300g) hoặc Nofacol 700WP (300g) cho 200 lít nước (1 phuy). Phun ướt đẫm đều 2 mặt tán lá, tập trung phun kỹ vào các chùm lá bị dính tơ nấm và cành ngọn.',
                    'safety_note'  => 'Validamycin ức chế tức thì tơ nấm Rhizoctonia, Hexaconazole nội hấp làm khô se vết loang cháy lá sau 24-48h. Phun nhắc lại lần 2 sau 5 - 7 ngày nếu mưa dầm kéo dài.',
                    'groups'       => [
                        [
                            'label'                => 'Validamycin kháng sinh sinh học đặc trị nấm Rhizoctonia',
                            'primary_pesticide_id' => 40, // VALIDACIN SUMITOMO VI (CHAI)
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Hexaconazole nội hấp lưu dẫn làm khô miệng vết cháy',
                            'primary_pesticide_id' => 9,  // ANVIL SYNGENTA 5SC
                            'substitute_ids'       => [22], // Japa Vil 110SC Monyka
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Áo giáp Kẽm Propineb bảo vệ biểu bì lá & cuống lá',
                            'primary_pesticide_id' => 7,  // Antracol 70WP Bayer
                            'substitute_ids'       => [27], // NOFACOL 700WP
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 2: Dập dịch lưu dẫn 2 chiều & Chặn đứng hiện tượng Chết ngọn (Azoxystrobin + Tebuconazole + Validamycin + Mancozeb)',
                    'badge'        => 'Chống chết ngọn',
                    'badge_color'  => 'sky',
                    'stage'        => 'Khi nấm ăn lan lên cơi đọt non gây thối ngọn, chết ngược đọt cành hoặc thời tiết mưa dầm âm u liên tục',
                    'dosage_guide' => 'Pha 1 chai TEBAZ 400SC (200ml) hoặc Asmiltatop Super 400SC (200ml) + 1 chai Validacin 5SL (450ml) + 1 gói Mancozeb 80WP (300g) cho 200 lít nước. Phun ướt đẫm toàn bộ tán lá và cơi đọt non.',
                    'safety_note'  => 'Cặp đôi hoạt chất Azoxystrobin + Tebuconazole lưu dẫn 2 chiều dập tắt sợi nấm bên trong mô mạch dẫn, bảo vệ ngọn non không bị teo thối chết ngược.',
                    'groups'       => [
                        [
                            'label'                => 'Azoxystrobin + Tebuconazole lưu dẫn chặn đứng chết ngọn',
                            'primary_pesticide_id' => 190, // TEBAZ 400SC
                            'substitute_ids'       => [10],  // ASMILTATOP SUPER 400SC
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Validamycin đặc hiệu tiêu diệt hạch nấm & tơ nấm',
                            'primary_pesticide_id' => 40,  // VALIDACIN SUMITOMO VI
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Mancozeb tiếp xúc bảo vệ phổ rộng mặt lá',
                            'primary_pesticide_id' => 26,  // MANCOZEB 80WP
                            'substitute_ids'       => [21], // HEADLINE 250EC
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 3: Phục hồi tán lá, dưỡng cơi đọt mới mập khỏe sau bệnh Cháy lá',
                    'badge'        => 'Phục hồi xanh lá',
                    'badge_color'  => 'amber',
                    'stage'        => 'Sau khi dập tắt ổ nấm Rhizoctonia, cành cây bị rụng lá trơ cành cần phục hồi quang hợp và kích đọt mới',
                    'dosage_guide' => 'Pha 1 chai Xanh Um Monyka (500ml) + 1 chai Tang Truong Panaxilus (500ml) + 1 chai MgO - Kẽm EDTA (250ml) hoặc Weyzym-A (100ml) cho 400 lít nước. Phun ướt đều 2 mặt tán lá vào buổi sáng sớm hoặc chiều mát.',
                    'safety_note'  => 'Bổ sung Đạm cá hữu cơ, Tảo biển Seaweed và Kẽm, Magie Chelate giúp tái tạo tầng diệp lục tố, dày phiến lá, giúp cơi đọt mới bung đều và mập khỏe.',
                    'groups'       => [
                        [
                            'label'                => 'Axit Amin đạm cá & Tinh chất tảo biển Seaweed dưỡng lá dày',
                            'primary_pesticide_id' => 159, // Xanh Um Monyka
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Vi lượng Chelate & NPK cân đối kích đọt mập',
                            'primary_pesticide_id' => 152, // TANG TRUONG PANAXILUS
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Magie & Kẽm Chelate chống cháy chóp lá non, xanh mướt lá',
                            'primary_pesticide_id' => 111, // MgO - Kẽm EDTA
                            'substitute_ids'       => [158], // WEYZYM-A MULTIAGRO48
                        ],
                    ],
                ],
            ],
        ];

        // 3. Tạo hoặc cập nhật bệnh trong database
        $disease = Disease::updateOrCreate(
            ['folder_code' => 'B-04'],
            $diseaseData
        );

        // 4. Gắn quan hệ với cây trồng (Crops)
        $crops = Crop::whereIn('name', [
            'Sầu riêng',
            'Cây có múi',
            'Cà phê',
            'Hồ tiêu',
            'Chanh dây',
        ])->get();

        if ($crops->isNotEmpty()) {
            $disease->crops()->sync($crops->pluck('id')->toArray());
        }

        // 5. Gắn danh sách thuốc BVTV liên quan (Pesticides)
        $pesticideIds = [40, 9, 22, 190, 10, 7, 27, 26, 21, 159, 158, 152, 111];
        $existingPesticides = Pesticide::whereIn('id', $pesticideIds)->pluck('id')->toArray();
        if (!empty($existingPesticides)) {
            $disease->pesticides()->sync($existingPesticides);
        }

        $this->command->info("Đã tạo / cập nhật thành công hồ sơ bệnh học: {$disease->name} (ID: {$disease->id})");
    }
}
