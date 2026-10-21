<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class BenhNamHongSeeder extends Seeder
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

        // 1. Sao chép 3 ảnh thực tế do người dùng vừa cung cấp
        $mediaMap = [
            'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791688823236.jpg' => 'nam-hong-1.jpg',
            'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791688823260.jpg' => 'nam-hong-2.jpg',
            'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791688823271.jpg' => 'nam-hong-3.jpg',
        ];

        foreach ($mediaMap as $src => $filename) {
            if (file_exists($src)) {
                copy($src, "$destDir/$filename");
                $savedImages[] = "diseases/$filename";
            }
        }

        // 2. Dữ liệu hồ sơ bệnh học chuẩn cho Bệnh Nấm Hồng
        $diseaseData = [
            'name' => 'Bệnh Nấm Hồng (Bệnh Thân Cành — Erythricium salmonicolor / Corticium salmonicolor)',
            'pathogen_type' => 'nam_benh',
            'folder_code' => 'B-10',
            'folder_group' => 'nam_benh',
            'folder_name' => '10-Nấm hồng - bệnh thân cành',
            'folder_number' => 10,
            'caunho' => 'Nấm hồng = MẢNG PHẤN HỒNG CAM BÁM VỎ CÀNH CHẠC BA, ăn sâu làm nứt toác vỏ cây hình mai rùa, tắc mạch dẫn nhựa, khô chết cành. Đặc trị bằng Hexaconazole (Anvil, Japa Vil), Azoxystrobin + Tebuconazole (Tebaz), và quét Gốc Đồng Đỏ (Norshield, Eddy, COC 85, Đồng Xanh).',
            'symptoms' => "• Giai đoạn chớm bệnh: Xuất hiện các sợi tơ nấm màu trắng bạc mỏng mịn như mạng nhện bò lan trên bề mặt vỏ cành ở các chảng ba, chảng hai hoặc mặt dưới của cành nơi râm mát ẩm thấp.\n• Giai đoạn phát triển rộ: Mạng tơ nấm phát triển dày cộm thành lớp màng phấn nhung màu hồng phấn, hồng tươi rồi chuyển sang màu cam gỉ sắt bao bọc quanh chu vi cành cây.\n• Giai đoạn gây hại nặng (đặc trưng như hình ảnh thực tế):\n- Lớp nấm ăn sâu phá hủy lớp vỏ biểu bì và tầng sinh mô dẫn nhựa (libe) bên dưới, làm vỏ cây bị thối khô và nứt toác chằng chịt hình mai rùa.\n- Mạch dẫn nhựa bị tắc nghẽn hoàn toàn, khiến nước và dinh dưỡng không thể vận chuyển lên ngọn nuôi cành. Toàn bộ lá phía trên cành bị héo vàng, rụng lá trơ trụi và cành bị khô chết dần từ ngoài ngọn vào trong thân (hiện tượng khô cành chết ngược).\n- Cành bị nấm hồng tấn công trở nên giòn mục, dễ gãy toác tại vị trí chạc ba khi mang trái nặng hoặc gặp gió bão lớn.",
            'symptoms_detail' => [
                'la' => 'Toàn bộ lá trên cành bị nấm hồng bao quanh ngả vàng úa, héo khô rũ xuống và rụng trơ trụi cành.',
                'canh_than' => 'Lớp phấn nhung màu hồng cam hoặc đỏ gỉ sắt bao quanh cành; vỏ cành bị ăn sâu nứt toác mai rùa, tắc mạch nhựa, cành khô chết đứng và gãy tét chạc ba.',
                'goc_re' => 'Không gây hại trực tiếp dưới bộ rễ.',
                'qua' => 'Trái trên cành bệnh bị teo tóp, rụng non hoặc méo mó do cành mẹ bị cắt đứt nguồn dinh dưỡng truyền nuôi trái.',
            ],
            'prevention' => "1. Tỉa cành tạo tán thông thoáng: Định kỳ cắt tỉa các cành tăm, chồi vượt rậm rạp bên trong tán, cành mọc sát mặt đất trước khi mùa mưa đến để ánh nắng mặt trời chiếu xuyên vào thân và các chạc ba cành (bào tử nấm hồng chỉ phát triển mạnh ở nơi râm mát, độ ẩm cao).\n2. Quét vôi hoặc thuốc gốc Đồng phòng ngừa: Hàng năm sau khi thu hoạch và trước mùa mưa dầm, dùng chổi quét dung dịch vôi hòa thuốc gốc Đồng đỏ (Norshield, Eddy, Boóc-đô) lên thân chính và các chạc ba cành cấp 1, cấp 2 để sát khuẩn và ngăn ngừa nấm bám dính.\n3. Cắt bỏ cành bệnh nặng: Cắt bỏ các cành nhỏ đã bị nấm ăn khô chết sâu dưới vết bệnh 10–15cm, gom ra xa vườn đốt tiêu hủy triệt để nguồn bào tử nấm phát tán theo gió mưa.",
            'treatment' => "1. NGUYÊN TẮC ĐẶC TRỊ NẤM HỒNG:\n• Nấm hồng là loài nấm sợi ký sinh trực tiếp trên lớp vỏ gỗ của cành cây thân gỗ. Khi nấm đã ăn sâu làm nứt vỏ thì việc phun sương ngoài lá không đủ hiệu quả, bắt buộc phải kết hợp: QUÉT ĐẬM ĐẶC VÀO VẾT NẤM CÀNH + PHUN RỬA PHỦ TOÀN TÁN.\n\n2. Phác đồ hóa học đặc trị luân phiên:\n• Thuốc đặc trị nấm hồng số 1 (FRAC 3 Triazole): Hexaconazole (Anvil 5SC Syngenta, Japa Vil 110SC Monyka), Tebuconazole (Tebaz 400SC). Tác động nội hấp cực mạnh, ngấm sâu vào mô vỏ cành, cắt đứt sự phát triển của hệ sợi nấm hồng.\n• Nhóm Hợp chất Đồng Đỏ (FRAC M01): Cuprous Oxide (Norshield 86.2WG, Eddy 72WP), Nano Đồng (Đồng Xanh Mekong Agro), Copper Oxychloride (COC 85). Tác dụng sát trùng, diệt màng nấm và làm khô vết nứt vỏ cực nhanh.\n• Phối hợp Azoxystrobin (Strobilurin - FRAC 11) trong Tebaz 400SC: Triệt tiêu bào tử nấm tái nhiễm và dập nấm thán thư ăn theo vết nứt.\n• Tẩy rửa mảng bám: Dùng RUA CANH MONYKA 550GR để bóc tróc lớp nhung nấm hồng và rêu mốc bám dai dẳng trên vỏ cành.\n\n3. Liền da vỏ cành & hồi phục cây:\n• Bổ sung Enzyme & Canxi Chelate (Weyzym-A Multiagro48) cùng Vi lượng Chelate (Tang Truong Panaxilus) để kích thích phân chia tế bào, giúp vết nứt vỏ mau kéo da non liền sẹo, phục hồi dẫn nhựa.",
            'chemical_groups' => 'Hexaconazole (Triazole đặc trị nấm hồng kinh điển - FRAC 3), Cuprous Oxide / Đồng đỏ Nordox (Đồng sát khuẩn quét thân cành - FRAC M01), Azoxystrobin / Tebuconazole (Strobilurin & Triazole nội hấp 2 chiều - FRAC 11 + FRAC 3), Copper Oxychloride (COC 85), Nano Đồng Chelate, Propineb (Áo giáp Kẽm bảo vệ vỏ - FRAC M03), Enzyme phục hồi tái tạo mô sẹo',
            'notes' => "Lưu ý thực tế từ kỹ sư BVTV:\n• Bệnh nấm hồng gây hại nguy hiểm nhất trên: Sầu riêng, Cà phê, Cây có múi (cam, bưởi, quýt, chanh), Cao su, Hồ tiêu, Xoài, Mít.\n• Bệnh thường bùng phát đỉnh điểm vào GIỮA VÀ CUỐI MÙA MƯA (tháng 7 - tháng 11 âm lịch) khi ẩm độ không khí bão hòa và vườn cây rậm rạp thiếu sáng.\n• Vị trí cành chịu lực mang trái (chạc ba cành cấp 1) là nơi nấm hồng thích tấn công nhất; nếu không phát hiện kịp cành sẽ chết khô hoặc gãy tét làm mất toàn bộ năng suất của cây.\n• Tài liệu tham khảo: Viện Khoa học Kỹ thuật Nông Lâm nghiệp Tây Nguyên (WASI), Viện Cây ăn quả Miền Nam (SOFRI), Cục Bảo vệ Thực vật.",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Sầu riêng, Cà phê, Cây có múi, Cao su, Hồ tiêu',
            'treatment_plans' => [
                [
                    'title'        => 'Phác đồ 1: Quét cọ đậm đặc vào vết nấm hồng chạc ba cành (Dập dịch triệt để)',
                    'badge'        => 'Quét cành trực tiếp',
                    'badge_color'  => 'red',
                    'stage'        => 'Khi mảng phấn nấm hồng cam bám chạc ba cành hoặc vỏ cành nứt nẻ mai rùa',
                    'dosage_guide' => 'Pha đậm đặc 50g NORSHIELD 86.2WG (hoặc 50ml Đồng Xanh Mekong Agro) + 50ml ANVIL 5SC (hoặc Japa Vil 110SC) với 1 lít nước (hoặc hòa nước vôi tôi). Dùng chổi cọ quét đẫm trực tiếp lên mảng nấm hồng và vết nứt vỏ cành.',
                    'safety_note'  => 'Đồng đỏ Cuprous Oxide sát khuẩn tiếp xúc cực mạnh kết hợp Hexaconazole thấm sâu vào lớp vỏ gỗ diệt tận gốc hệ sợi nấm hồng ăn sâu dưới mạch dẫn.',
                    'groups'       => [
                        [
                            'label'                => 'Đồng đỏ hoặc Nano Đồng sát khuẩn quét cành',
                            'primary_pesticide_id' => 28, // NORSHIED 86.2WG HOP TRI
                            'substitute_label'     => 'Hoặc thay thế bằng thuốc gốc Đồng đậm đặc:',
                            'substitute_ids'       => [18, 17, 12], // EDDY 72WP, Đồng Xanh Mekong Agro, COC 85
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Hexaconazole nội hấp thấm sâu diệt nấm hồng',
                            'primary_pesticide_id' => 9, // ANVIL SYNGENTA 5SC
                            'substitute_label'     => 'Hoặc thay thế bằng:',
                            'substitute_ids'       => [22, 190], // Japa Vil 110SC Monyka, TEBAZ 400SC
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 2: Phun phủ toàn tán & rửa cành chặn đứng lây lan (Hexaconazole + Tebaz lưu dẫn 2 chiều)',
                    'badge'        => 'Phun tán dập dịch',
                    'badge_color'  => 'emerald',
                    'stage'        => 'Khi nấm hồng lây lan nhiều cành trong vườn trong mùa mưa dầm',
                    'dosage_guide' => 'Pha 1 chai ANVIL 5SC (1 lít) + 1 chai TEBAZ 400SC (250ml) + 1 chai RUA CANH MONYKA (550g) cho 400 - 500 lít nước. Dùng cần xịt áp lực phun xoáy ướt đẫm các chạc ba cành và tán lá.',
                    'safety_note'  => 'Sự kết hợp giữa Hexaconazole + Azoxystrobin + Tebuconazole lưu dẫn 2 chiều chặn đứng bào tử nấm hồng lây lan sang cành khỏe, đồng thời bóc tróc mảng bám rêu mốc.',
                    'groups'       => [
                        [
                            'label'                => 'Thuốc trừ nấm nội hấp đặc trị nấm hồng',
                            'primary_pesticide_id' => 9, // ANVIL SYNGENTA 5SC
                            'substitute_label'     => 'Hoặc thay thế bằng:',
                            'substitute_ids'       => [22], // Japa Vil 110SC Monyka
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Azoxystrobin + Tebuconazole phổ rộng chặn bào tử',
                            'primary_pesticide_id' => 190, // TEBAZ 400SC
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Chất tẩy rửa mảng bám nấm hồng & rêu mốc',
                            'primary_pesticide_id' => 33, // RUA CANH MONYKA 550GR
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 3: Kéo da liền sẹo vỏ cành & hồi phục cành nhánh sau dập dịch',
                    'badge'        => 'Liền sẹo da cành',
                    'badge_color'  => 'blue',
                    'stage'        => 'Sau khi mảng nấm hồng đã khô giòn bong tróc, cần hàn gắn vết nứt vỏ',
                    'dosage_guide' => 'Pha 1 chai WEYZYM-A MULTIAGRO48 (500ml) + 1 chai TANG TRUONG PANAXILUS (500ml) cho 400 lít nước. Phun đẫm cành tán hoặc tưới gốc.',
                    'safety_note'  => 'Cung cấp Canxi Chelate, Enzyme sinh học và vi lượng Kẽm - Đồng giúp tầng sinh mô nhanh phân chia kéo da non liền vết nứt, chống thối vỏ xì mủ.',
                    'groups'       => [
                        [
                            'label'                => 'Enzyme sinh học & Canxi kích thích tái sinh mô sẹo',
                            'primary_pesticide_id' => 158, // WEYZYM-A MULTIAGRO48
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Vi lượng Chelate kích đọt phục hồi dinh dưỡng cành',
                            'primary_pesticide_id' => 152, // TANG TRUONG PANAXILUS
                            'substitute_label'     => 'Hoặc dưỡng lá amino:',
                            'substitute_ids'       => [159], // Xanh Um Monyka
                        ],
                    ],
                ],
            ],
        ];

        $disease = Disease::updateOrCreate(
            ['name' => $diseaseData['name']],
            $diseaseData
        );

        // 3. Gắn các cây trồng mẫn cảm: Sầu riêng, Cà phê, Cây có múi, Cao su, Hồ tiêu
        $targetCropNames = ['Sầu riêng', 'Cà phê', 'Cây có múi', 'Hồ tiêu'];
        $linkedCropIds = Crop::whereIn('name', $targetCropNames)->pluck('id')->toArray();
        if (!empty($linkedCropIds)) {
            $disease->crops()->sync($linkedCropIds);
        }

        // 4. Liên kết các thuốc BVTV có sẵn trong kho đặc trị nấm hồng (tuyệt đối không tạo thuốc mới)
        // Anvil 5SC (9), Japa Vil (22), Tebaz 400SC (190), Norshield (28), Eddy (18), Đồng Xanh (17), COC 85 (12), Rửa Cành Monyka (33), Antracol (7), Headline (21), Tang Truong Panaxilus (152), Weyzym-A (158), Xanh Um Monyka (159)
        $targetPesticideIds = [9, 22, 190, 28, 18, 17, 12, 33, 7, 21, 152, 158, 159];
        $validPesticideIds = Pesticide::whereIn('id', $targetPesticideIds)->pluck('id')->toArray();

        if (!empty($validPesticideIds)) {
            $disease->pesticides()->sync($validPesticideIds);
        }
    }
}
