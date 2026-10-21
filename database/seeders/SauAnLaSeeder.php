<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class SauAnLaSeeder extends Seeder
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

        // 1. Sao chép ảnh thực tế do người dùng vừa cung cấp
        // Ảnh 1: Sâu non ăn lá cắn khuyết phiến lá, trơ gân lá
        // Ảnh 2: Lá sầu riêng bị sâu cắn thủng lỗ chỗ, nhả tơ kéo dính mép lá làm tổ
        $src1 = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690358843.jpg';
        $filename1 = 'sau-an-la-1.jpg';
        if (file_exists($src1)) {
            copy($src1, "$destDir/$filename1");
            $savedImages[] = "diseases/$filename1";
        } elseif (file_exists("$destDir/$filename1")) {
            $savedImages[] = "diseases/$filename1";
        }

        $src2 = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690358874.jpg';
        $filename2 = 'sau-an-la-2.jpg';
        if (file_exists($src2)) {
            copy($src2, "$destDir/$filename2");
            $savedImages[] = "diseases/$filename2";
        } elseif (file_exists("$destDir/$filename2")) {
            $savedImages[] = "diseases/$filename2";
        }

        // 2. Dữ liệu hồ sơ dịch hại chuẩn cho Sâu Ăn Lá & Sâu Cuốn Lá
        $diseaseData = [
            'name' => 'Sâu Ăn Lá & Sâu Cuốn Lá — Lepidoptera spp. (Sâu Ăn Đọt Non, Sâu Đo, Sâu Róm & Sâu Bao Hại Sầu Riêng, Cây Ăn Quả)',
            'pathogen_type' => 'sau_hai',
            'folder_code' => 'S-03',
            'folder_group' => 'sau_hai',
            'folder_name' => '3 Sâu ăn lá',
            'folder_number' => 3,
            'caunho' => 'Sâu ăn lá = LÁ THỦNG LỖ CHỖ + NHẢ TƠ CUỐN LÁ LÀM TỔ + ĂN TRƠ GÂN LÁ. Trị dập dịch bằng Chlorfenapyr + Emamectin (Emaproza 10SC), Profenofos + Cypermethrin (Dragon 999 / Vovatox 600) và Lambda-cyhalothrin (Tegula 247SC / Riegenf USA).',
            'symptoms' => "• Triệu chứng phá hại đặc trưng qua 2 ảnh thực tế bạn gửi:\n- Ảnh 1 — Sâu ăn lá cắn khuyết phiến lá: Sâu non màu xanh lục, xanh vàng có sọc đen dọc lưng, đầu tròn màu nâu đen cắn phá dữ dội từ rìa phiến lá vào trong hoặc gặm khoét từng mảng lớn giữa phiến lá, chỉ chừa lại gân chính và các gân phụ trơ trụi như hình bộ xương lá.\n- Ảnh 2 — Sâu cuốn lá nhả tơ làm tổ: Sâu non nhả các sợi tơ trắng kết dính 2 mép phiến lá lại với nhau hoặc kéo dính 2–3 lá non lại tạo thành một cái kén tổ hình ống (nhìn rất rõ trong ảnh lá sầu riêng có mạng tơ và các lỗ thủng). Sâu ẩn nấp an toàn bên trong kén tổ gặm nhấm mô diệp lục, thải các viên phân đen li ti ở đáy tổ. Khi ăn hết mô lá bên trong, sâu bò sang các lá non lân cận tiếp tục cuốn tổ mới.\n• Hậu quả phá hại trên cơi đọt:\n- Sâu non cắn phá cực kỳ phàm ăn vào giai đoạn cơi đọt sầu riêng bung lá lụa. Mật độ sâu cao có thể cắn trụi sạch bộ lá non chỉ sau 2–3 đêm, để lại cành đọt trơ trụi cuống lá chổi chà.\n- Vết cắn rách nát của sâu tạo điều kiện cho nấm Thán thư (Colletotrichum) và nấm Cháy lá (Rhizoctonia) xâm nhập hoại tử phần mô lá còn lại, làm cơi đọt bị hỏng hoàn toàn.",
            'symptoms_detail' => [
                'la' => 'Phiến lá bị cắn thủng lỗ chỗ hoặc khuyết từng mảng lớn trơ gân lá; mép lá bị nhả tơ kết dính cuốn tròn lại thành tổ kén; sâu thải phân đen li ti bên trong tổ.',
                'canh_than' => 'Chồi non và đọt non bị cắn cụt đỉnh sinh trưởng; cành trơ trụi cuống lá do lá non bị ăn sạch.',
                'goc_re' => 'Không gây hại dưới vùng rễ.',
                'qua' => 'Một số loài sâu ăn lá có thể gặm nhấm vỏ quả non gây sẹo lồi lõm xấu mã quả.',
            ],
            'prevention' => "1. Thường xuyên thăm vườn vào giai đoạn cơi đọt non: Kiểm tra kỹ mặt dưới lá và các lá có dấu hiệu bị gấp mép hoặc dính tơ để phát hiện sớm ổ trứng và sâu non tuổi 1–2.\n2. Thu gom và bóp nát các tổ lá cuốn: Khi mật độ sâu còn thấp rải rác, dùng tay bóp chết sâu bên trong kén lá cuộn hoặc ngắt bỏ lá bị cuốn tiêu hủy để ngăn sâu phát triển sang tuổi lớn.\n3. Rung cây bắt sâu hoặc dùng bẫy đèn: Bướm trưởng thành có tính xu quang mạnh với ánh sáng đèn; giăng bẫy đèn bẫy bắt bướm vào đầu mùa cơi đọt để giảm mật độ đẻ trứng.\n4. Bảo tồn thiên địch có ích: Bọ ngựa, bọ xít bắt mồi, kiến vàng, nhện ăn thịt và ong ký sinh kén trắng là những thiên địch tự nhiên tiêu diệt sâu non và nhộng sâu ăn lá rất hiệu quả.",
            'treatment' => "1. NGUYÊN TẮC VÀNG ĐẶC TRỊ SÂU ĂN LÁ & SÂU CUỐN LÁ:\n• Sâu cuốn lá ẩn nấp bên trong kén lá cuộn dính tơ nên thuốc tiếp xúc thông thường khó chạm tới cơ thể sâu; BẮT BUỘC PHẢI DÙNG THUỐC CÓ TÍNH XÔNG HƠI (Profenofos) hoặc THẤM SÂU NỘI HẤP (Chlorfenapyr, Emamectin) kết hợp chất loang trải siêu thấm để hơi thuốc luồn vào trong kén diệt sâu tức thì.\n• Phun thuốc dập dịch tốt nhất khi sâu non ở tuổi 1–2 (khi sâu mới nở, còn nhỏ và chưa cuộn tổ chặt).\n• Phun vào sáng sớm hoặc chiều mát khi sâu bò ra khỏi tổ gặm lá.\n\n2. Phác đồ hóa học đặc trị luân phiên:\n• Nhóm Pyrrole + Avermectin kháng thuốc (IRAC 13 + IRAC 6): Emaproza 10SC Nano (Chlorfenapyr + Emamectin benzoate). Cơ chế tác động 4 trong 1: tiếp xúc, vị độc, nội hấp và xông hơi; ức chế hô hấp ty thể làm sâu tê liệt ngừng ăn sau 15 phút và chết khô sau vài giờ, bẻ gãy tính kháng của sâu cuốn lá.\n• Nhóm Lân hữu cơ xông hơi cực mạnh (IRAC 1B + IRAC 3A): DRAGON 999, VOVATOX 600, DRAGON 440 (Profenofos + Cypermethrin), THPRO 550EC. Hơi thuốc đậm đặc xông vào bên trong kén cuốn lá làm sâu ngạt thở, đồng thời hạ gục chớp nhoáng sâu đang bò ngoài tán.\n• Nhóm Cúc tổng hợp thế hệ mới: TEGULA 247SC, Riegenf USA (Lambda-cyhalothrin + Thiamethoxam). Hạ gục nhanh sâu non và duy trì màng bảo vệ đọt non.\n• Trợ lực loang trải: Loang Trải Siêu Thấm Monyka. Thấm sâu xuyên qua lớp tơ kén lá cuộn.\n\n3. Phục hồi và tái tạo cơi đọt sau sâu bệnh:\n• Phun bổ sung Axit Amin đạm cá hữu cơ (Xanh Um Monyka), Tang Truong Panaxilus và MgO - Kẽm EDTA để kích thích các mắt ngủ bung tược mới bù đắp lượng lá bị sâu ăn mất, giúp phiến lá dày bóng nhanh chóng.",
            'chemical_groups' => 'Chlorfenapyr + Emamectin benzoate (Emaproza 10SC - IRAC 13 + IRAC 6), Profenofos + Cypermethrin (DRAGON 999 / VOVATOX 600 / DRAGON 440 - IRAC 1B + IRAC 3A), Profenofos + Thiamethoxam (THPRO 550EC - IRAC 1B + IRAC 4A), Lambda-cyhalothrin + Thiamethoxam (TEGULA 247SC / Riegenf USA - IRAC 3A + IRAC 4A), Chất trợ lực loang trải siêu thấm',
            'notes' => "Lưu ý thực tế từ kỹ sư BVTV:\n• Giai đoạn sầu riêng xổ nhụy và mang trái non, sâu ăn lá có thể chuyển sang cắn phá cánh hoa, nhụy hoa và gặm vỏ trái non làm rụng trái sinh lý.\n• Khi cơi đọt bị sâu cắn rách tả tơi, cần kết hợp thêm thuốc trừ nấm (Mancozeb 80WP hoặc Antracol 70WP) để sát trùng các vết thương hở, không cho nấm thán thư xâm nhiễm thứ cấp.\n• Luân phiên hoạt chất để tránh hiện tượng sâu lờn thuốc.\n• Tài liệu tham khảo: Viện Cây ăn quả Miền Nam (SOFRI), Cục Bảo vệ Thực vật.",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Sầu riêng, Cây có múi, Chanh dây, Xoài, Cà phê, Tiêu, Bơ, Mít',
            'treatment_plans' => [
                [
                    'title'        => 'Phác đồ 1: Đặc trị dập dịch Sâu ăn lá & Sâu cuốn lá kháng thuốc (Emaproza 10SC + Tegula 247SC + Loang trải)',
                    'badge'        => 'Đặc trị dập dịch',
                    'badge_color'  => 'emerald',
                    'stage'        => 'Khi phát hiện cơi đọt non bị sâu cắn thủng lỗ chỗ, mép lá bị dính tơ cuốn tổ hoặc sâu non bò ngoài tán',
                    'dosage_guide' => 'Pha 1 chai Emaproza 10SC (160ml) + 1 chai Tegula 247SC (250ml) hoặc Riegenf USA (250ml) + 1 chai Loang Trải Siêu Thấm (100ml) cho 400 lít nước (2 phuy). Phun ướt đẫm đều 2 mặt tán lá và các cơi đọt non vào sáng sớm hoặc chiều mát.',
                    'safety_note'  => 'Tegula hạ gục tức thì sâu đang bò cắn phá; Chlorfenapyr + Emamectin thấm sâu vào trong kén lá cuộn làm sâu ngừng ăn và chết khô sau 24h. An toàn cho đọt non.',
                    'groups'       => [
                        [
                            'label'                => 'Chlorfenapyr + Emamectin benzoate cơ chế 4 trong 1 diệt sâu kháng',
                            'primary_pesticide_id' => 172, // Emaproza 10SC Nano Sâu Rầy Rệp 160
                            'substitute_ids'       => [171], // Emaproza 130
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Lambda-cyhalothrin + Thiamethoxam hạ gục chớp nhoáng sâu non',
                            'primary_pesticide_id' => 192, // TEGULA ẤN ĐỘ 247SC
                            'substitute_ids'       => [187], // Riegenf USA
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Trợ lực loang trải siêu thấm đưa thuốc ngấm qua kén tơ lá',
                            'primary_pesticide_id' => 25,  // Loang Trải Siêu Thấm
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 2: Xông hơi cực mạnh len lỏi kén lá cuốn & Sát trùng vết thương (Dragon 999 + Mancozeb 80WP + Loang trải)',
                    'badge'        => 'Xông hơi kén lá',
                    'badge_color'  => 'sky',
                    'stage'        => 'Khi sâu đã cuộn tổ kín trong lá già và lá non, mật độ sâu cao ăn trụi từng mảng tán',
                    'dosage_guide' => 'Pha 1 chai Dragon 999 (450ml) hoặc Vovatox 600 (450ml) / THPRO 550EC (450ml) + 1 gói Mancozeb 80WP (1kg) + 1 chai Loang Trải Siêu Thấm (100ml) cho 400 lít nước (2 phuy). Phun ướt đẫm tán lá.',
                    'safety_note'  => 'Độc tính xông hơi Profenofos len lỏi vào tận đáy kén lá cuốn tiêu diệt sâu ẩn nấp; Mancozeb sát trùng vết cắn rách nát của sâu ngăn nấm thán thư xâm nhập.',
                    'groups'       => [
                        [
                            'label'                => 'Profenofos + Cypermethrin xông hơi & tiếp xúc cực mạnh',
                            'primary_pesticide_id' => 165, // DRAGON 999 (450ML)
                            'substitute_ids'       => [186, 185], // VOVATOX 600, THPRO 550EC
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Mancozeb tiếp xúc sát trùng vết thương lá, chống nấm thâm nhập',
                            'primary_pesticide_id' => 26,  // MANCOZEB 80WP
                            'substitute_ids'       => [7],   // Antracol 70WP Bayer
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Trợ lực loang trải siêu thấm xuyên qua màng tơ',
                            'primary_pesticide_id' => 25,  // Loang Trải Siêu Thấm
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 3: Kích cơi đọt mới, dày phiến lá & phục hồi tán lá sau khi sạch sâu',
                    'badge'        => 'Phục hồi đọt lá',
                    'badge_color'  => 'amber',
                    'stage'        => 'Sau khi đã diệt sạch sâu, cần kích thích các chồi nách bung đọt mới để bù đắp bộ lá bị cắn phá',
                    'dosage_guide' => 'Pha 1 chai Xanh Um Monyka (500ml) + 1 chai Tang Truong Panaxilus (500ml) + 1 chai MgO - Kẽm EDTA (240ml) cho 400 lít nước (2 phuy). Phun đều 2 mặt tán lá vào buổi sáng sớm hoặc chiều mát.',
                    'safety_note'  => 'Axit Amin đạm cá hữu cơ và Tảo biển Seaweed giúp kích thích bung đọt non nhanh mập; Kẽm và Magie Chelate giúp lá dày cứng, chống sâu non cắn phá.',
                    'groups'       => [
                        [
                            'label'                => 'Axit Amin đạm cá & Tảo biển Seaweed tái tạo cơi lá',
                            'primary_pesticide_id' => 159, // Xanh Um Monyka
                            'substitute_ids'       => [152], // TANG TRUONG PANAXILUS
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Magie & Kẽm Chelate giúp lá dày cứng chắc, xanh mướt',
                            'primary_pesticide_id' => 111, // MgO - Kẽm EDTA
                            'substitute_ids'       => [158], // WEYZYM-A MULTIAGRO48
                        ],
                    ],
                ],
            ],
        ];

        // 3. Tạo hoặc cập nhật bệnh trong database
        $disease = Disease::updateOrCreate(
            ['folder_code' => 'S-03'],
            $diseaseData
        );

        // 4. Gắn quan hệ với cây trồng (Crops)
        $crops = Crop::whereIn('name', [
            'Sầu riêng',
            'Cây có múi',
            'Chanh dây',
            'Xoài',
            'Cà phê',
            'Hồ tiêu',
        ])->get();

        if ($crops->isNotEmpty()) {
            $disease->crops()->sync($crops->pluck('id')->toArray());
        }

        // 5. Gắn danh sách thuốc BVTV liên quan (Pesticides)
        $pesticideIds = [172, 171, 192, 187, 165, 186, 185, 25, 26, 7, 159, 152, 111, 158];
        $existingPesticides = Pesticide::whereIn('id', $pesticideIds)->pluck('id')->toArray();
        if (!empty($existingPesticides)) {
            $disease->pesticides()->sync($existingPesticides);
        }

        $this->command->info("Đã tạo / cập nhật thành công hồ sơ dịch hại: {$disease->name} (ID: {$disease->id})");
    }
}
