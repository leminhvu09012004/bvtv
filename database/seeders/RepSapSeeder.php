<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class RepSapSeeder extends Seeder
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

        // 1. Sao chép ảnh thực tế do người dùng vừa cung cấp (Rệp sáp bông trắng phủ dày đặc dọc gân lá và cành non)
        $src = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690415288.jpg';
        $filename = 'rep-sap-1.jpg';

        if (file_exists($src)) {
            copy($src, "$destDir/$filename");
            $savedImages[] = "diseases/$filename";
        } else {
            if (file_exists("$destDir/$filename")) {
                $savedImages[] = "diseases/$filename";
            }
        }

        // 2. Dữ liệu hồ sơ bệnh học chuẩn cho Rệp sáp & Kiến cộng sinh
        $diseaseData = [
            'name' => 'Rệp Sáp & Kiến Cộng Sinh — Pseudococcidae (Planococcus citri / Pseudococcus spp. — Rệp Sáp Bông, Rệp Sáp Trái & Rệp Sáp Rễ)',
            'pathogen_type' => 'chich_hut',
            'folder_code' => 'CH-05',
            'folder_group' => 'chich_hut',
            'folder_name' => '5-Rệp sáp',
            'folder_number' => 5,
            'caunho' => 'Rệp sáp = LỚP SÁP TRẮNG BÔNG + ĐI CÙNG KIẾN + MUỘI ĐEN BỒ HÓNG (phải phá lớp sáp + diệt kiến + lưu dẫn 2 chiều Spirotetramat Movento / Tề Thiên USA, xông hơi Profenofos THPRO 550EC / Sheba 50EW).',
            'symptoms' => "• Trên phiến lá & cành non (Triệu chứng phá hại đặc trưng nhất như hình ảnh thực tế bạn gửi):\n- Từng đàn rệp sáp hình bầu dục bọc một lớp phấn sáp trắng xốp dày như bông gòn tụ tập bám dày đặc dọc theo gân chính của phiến lá, mặt dưới lá và quanh nách cuống lá.\n- Rệp dùng vòi chích hút châm sâu vào mô mạch dẫn hút cạn dịch nhựa nuôi cây, làm phiến lá biến dạng cong queo, vàng úa, đọt non chùn đọt không phát triển được, lá cằn cỗi và rụng sớm.\n• Trên chùm hoa & nụ hoa non:\n- Rệp bu kín cuống hoa và bầu nhụy hoa non, hút dịch làm hoa bị teo thóp, khô đen và rụng hoa non hàng loạt.\n• Trên chùm quả (Đặc biệt sầu riêng, cà phê, cây có múi, chanh dây, mãng cầu):\n- Rệp sáp chui sâu vào các kẽ gai sầu riêng hoặc kẽ cuống quả non chích hút nhựa, làm quả non bị biến dạng, rụng trái sớm; quả lớn bị sượng méo mó, gai quả bị vàng ố và nứt nẻ.\n• Hiện tượng Nấm muội đen bồ hóng (Capnodium spp.) & Kiến cộng sinh:\n- Trong quá trình chích hút, rệp sáp bài tiết ra chất dịch mật ngọt (honeydew). Dịch ngọt này thu hút đàn kiến (kiến đen, kiến hôi, kiến vàng, kiến lửa) kéo đến ăn mật và tha rệp sáp phát tán khắp các cành nhánh.\n- Dịch ngọt cũng tạo môi trường lý tưởng cho nấm bồ hóng phát triển đen sì bề mặt lá và vỏ trái, ngăn cản hoàn toàn sự quang hợp của lá và làm đen lem luốc vỏ trái sầu riêng, mất giá trị thương phẩm.\n• Dưới vùng cổ rễ (Rệp sáp hại rễ):\n- Rệp sáp chui xuống đất bám quanh cổ rễ và chóp rễ tơ hút nhựa, kết hợp nấm thối rễ làm cây bị vàng lá suy kiệt, chết chậm.",
            'symptoms_detail' => [
                'la' => 'Rệp sáp phủ phấn trắng xốp như bông bám dày đặc dọc gân lá và mặt dưới lá; lá bị chích hút cong queo, vàng úa, dính muội đen bồ hóng.',
                'canh_than' => 'Đám rệp sáp trắng bám dày đặc ở nách cành, kẽ nứt thân cành non, làm teo tóp chồi non và chùn ngọn.',
                'goc_re' => 'Rệp sáp rễ bám quanh cổ rễ và rễ tơ hút dịch tạo vết thương, gây thối rễ và vàng lá suy kiệt.',
                'qua' => 'Rệp bu kín kẽ gai sầu riêng và cuống trái non; tiết dịch ngọt làm nấm bồ hóng bao phủ đen sì vỏ trái, gây rụng trái non và sượng méo trái.',
            ],
            'prevention' => "1. Cắt tỉa tạo tán thông thoáng: Định kỳ tỉa bỏ cành vượt, cành tăm rậm rạp che khuất ánh sáng bên trong tán. Rệp sáp phát triển cực mạnh ở các ngóc ngách ẩm ướt, thiếu ánh sáng và sợ nắng trực tiếp.\n2. Diệt trừ triệt để kiến cộng sinh: Kiến là 'phương tiện vận chuyển' tha rệp sáp từ gốc lên tán lá. Cần rải thuốc trừ sâu hạt hoặc phun chân gốc cây để dẹp sạch các đàn kiến quanh gốc.\n3. Rửa vườn bằng tia nước áp lực cao: Định kỳ dùng máy xịt nước áp lực cao phun mạnh vào các nách cành và kẽ gai sầu riêng để đánh bật các ổ rệp sáp và rửa trôi lớp phấn sáp cùng nấm muội đen bồ hóng.\n4. Bảo tồn thiên địch: Bọ rùa, ong ký sinh, bọ cánh gân là những thiên địch tự nhiên ăn thịt rệp sáp rất hiệu quả; tránh lạm dụng thuốc hóa học độc hại khi mật độ rệp còn thấp.",
            'treatment' => "1. NGUYÊN TẮC VÀNG ĐẶC TRỊ RỆP SÁP:\n• Bắt buộc phải pha thêm CHẤT TRỢ LỰC LOANG TRẢI SIÊU THẤM (hoặc dầu khoáng) để phá vỡ lớp phấn sáp trắng bảo vệ bên ngoài, giúp thuốc ngấm sâu vào cơ thể rệp.\n• Kết hợp thuốc lưu dẫn 2 chiều (Spirotetramat) để luồn lách vào tận kẽ gai quả non và chóp rễ + thuốc xông hơi, tiếp xúc cực mạnh (Profenofos, Prothiofos) để hạ gục chớp nhoáng rệp trưởng thành và diệt luôn kiến cộng sinh.\n\n2. Phác đồ hóa học đặc trị luân phiên:\n• Thuốc lưu dẫn 2 chiều số 1 thế giới (IRAC 23): Movento 150OD Bayer (Spirotetramat), Tề Thiên USA (Dinotefuran + Spirotetramat). Vận chuyển theo cả mạch gỗ và mạch rây đến mọi ngóc ngách, hiệu lực bảo vệ kéo dài 3 - 4 tuần, diệt cả rệp sáp rễ và rệp sáp kẽ gai.\n• Thuốc Lân hữu cơ xông hơi cực mạnh (IRAC 1B): THPRO 550EC (Profenofos + Thiamethoxam), Sheba 50EW Hợp Trí (Prothiofos), Vovatox 600, Dragon 999 (Profenofos + Cypermethrin). Cơ chế xông hơi làm ngạt thở và tiếp xúc hạ gục tức thì các ổ rệp sáp đang bám dày, diệt sạch kiến tha rệp.\n• Chất trợ lực loang trải phá sáp: Loang Trải Siêu Thấm Monyka (Polyether Polymethylsiloxane Copolymer). Phá tan màng sáp bao bọc của rệp chỉ sau 10 giây, tăng hiệu lực thuốc lên gấp 3 lần.\n\n3. Rửa sạch nấm muội đen & dưỡng sáng vỏ trái sau bệnh:\n• Phối hợp phun Mancozeb 80WP hoặc Antracol 70WP để tẩy sạch lớp nấm muội đen bồ hóng trên vỏ trái và mặt lá, sau đó phun Xanh Um Monyka và MgO - Kẽm EDTA để dưỡng xanh gai, sáng vỏ quả và phục hồi tán lá.",
            'chemical_groups' => 'Spirotetramat (Movento 150OD / Tề Thiên USA - IRAC 23), Dinotefuran (Neonicotinoid - IRAC 4A), Profenofos + Thiamethoxam (THPRO 550EC - IRAC 1B + IRAC 4A), Prothiofos (Sheba 50EW - IRAC 1B), Profenofos + Cypermethrin (VOVATOX 600 / DRAGON 999 - IRAC 1B + IRAC 3A), Carbosulfan (Afudan 20SC - IRAC 1A), Chất trợ lực loang trải phá sáp (Polyether Polymethylsiloxane Copolymer)',
            'notes' => "Lưu ý thực tế từ kỹ sư BVTV:\n• Rệp sáp là dịch hại dai dẳng và khó trị bậc nhất do lớp phấn sáp bảo vệ bên ngoài chống thấm nước cực kỳ tốt. Phun thuốc nếu không có chất phá sáp thì thuốc chỉ trôi tuột ra ngoài mà không làm rệp chết.\n• Phải diệt đồng thời cả Rệp sáp và Kiến cộng sinh; nếu chỉ diệt rệp mà còn kiến thì chỉ sau 1 tuần kiến sẽ tha rệp con từ dưới đất hoặc từ cây khác lên tái nhiễm.\n• Giai đoạn sầu riêng xổ nhụy đến trái non (trứng gà, nắm tay) là thời điểm rệp sáp tấn công mãnh liệt nhất; cần ưu tiên các dòng thuốc mát bông mát trái như Movento hoặc Tề Thiên USA dạng SC sữa.\n• Tài liệu tham khảo: Viện Cây ăn quả Miền Nam (SOFRI), Cục Bảo vệ Thực vật, Viện KHKT Nông Lâm nghiệp Tây Nguyên (WASI).",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Sầu riêng, Cà phê, Hồ tiêu, Cây có múi, Chanh dây, Mãng cầu',
            'treatment_plans' => [
                [
                    'title'        => 'Phác đồ 1: Đặc trị dập dịch Rệp sáp & Kiến cộng sinh (Lưu dẫn 2 chiều Movento + Xông hơi THPRO 550EC + Phá sáp)',
                    'badge'        => 'Đặc trị dập dịch',
                    'badge_color'  => 'emerald',
                    'stage'        => 'Khi phát hiện các đám rệp sáp trắng bám dày đặc trên gân lá, nách cành, cuống hoa hoặc kẽ gai quả sầu riêng',
                    'dosage_guide' => 'Pha 1 chai Movento 150OD (100ml - 240ml) hoặc Tề Thiên USA (240ml) + 1 chai THPRO 550EC (450ml) hoặc Vovatox 600 (450ml) + 1 chai Loang Trải Siêu Thấm (100ml) cho 400 lít nước (2 phuy). Phun ướt đẫm kỹ 2 mặt lá, cuống hoa, chùm quả và thân gốc.',
                    'safety_note'  => 'Movento lưu dẫn 2 chiều diệt rệp ẩn nấp trong kẽ gai và rễ; THPRO 550EC xông hơi hạ gục nhanh rệp trưởng thành và diệt sạch đàn kiến cộng sinh. Phun nhắc lại lần 2 sau 5 - 7 ngày nếu mật độ rệp quá dày.',
                    'groups'       => [
                        [
                            'label'                => 'Spirotetramat lưu dẫn 2 chiều diệt triệt để rệp kẽ gai & rễ',
                            'primary_pesticide_id' => 170, // MOVENTO 150OD BYER 240
                            'substitute_ids'       => [188], // Tề Thiên USA
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Profenofos + Thiamethoxam xông hơi cực mạnh diệt rệp & kiến',
                            'primary_pesticide_id' => 185, // THPRO 550EC 450ML
                            'substitute_ids'       => [186, 165], // VOVATOX 600, DRAGON 999
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Trợ lực loang trải siêu thấm phá tan lớp màng phấn sáp',
                            'primary_pesticide_id' => 25,  // Loang Trải Siêu Thấm
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 2: Đặc trị rệp sáp kháng thuốc & Mát bông, mát trái non (Tề Thiên USA + Sheba 50EW Hợp Trí + Phá sáp)',
                    'badge'        => 'Mát bông mát trái',
                    'badge_color'  => 'sky',
                    'stage'        => 'Giai đoạn hoa đang chuẩn bị nở hoặc quả non mới đậu (trái trứng gà), cần thuốc cực mát chống sốc nhiệt rụng bông quả',
                    'dosage_guide' => 'Pha 1 chai Tề Thiên USA dạng sữa (240ml) + 1 chai Sheba 50EW (250ml) + 1 chai Loang Trải Siêu Thấm (100ml) cho 400 lít nước (2 phuy). Phun chùm đều tán lá và chùm hoa quả non vào sáng sớm hoặc chiều mát.',
                    'safety_note'  => 'Công thức dạng SC sữa và nhũ tương EW siêu mát cây, không gây nóng hoa, không sượng gai trái non. Sheba phá vỡ lớp sáp nhanh, Tề Thiên hạ gục và duy trì hiệu lực kéo dài 20 ngày.',
                    'groups'       => [
                        [
                            'label'                => 'Dinotefuran + Spirotetramat dạng sữa SC mát hoa mát trái',
                            'primary_pesticide_id' => 188, // Tề Thiên USA
                            'substitute_ids'       => [170], // MOVENTO 150OD
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Prothiofos đặc trị rệp sáp nhũ tương EW dịu mát',
                            'primary_pesticide_id' => 181, // Sheba 50EW Hợp Trí
                            'substitute_ids'       => [176, 192], // NOFARA 35WG, TEGULA 247SC
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Trợ lực loang trải siêu thấm phá vỡ phấn sáp bảo vệ',
                            'primary_pesticide_id' => 25,  // Loang Trải Siêu Thấm
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 3: Rửa sạch nấm muội đen bồ hóng, sáng gai quả & phục hồi quang hợp cho lá',
                    'badge'        => 'Tẩy sạch muội đen',
                    'badge_color'  => 'amber',
                    'stage'        => 'Sau khi đã tiêu diệt sạch rệp sáp, cần tẩy rửa lớp nấm bồ hóng đen xì trên mặt lá và vỏ quả sầu riêng',
                    'dosage_guide' => 'Pha 1 gói Mancozeb 80WP (1kg) hoặc Antracol 70WP (1kg) + 1 chai Xanh Um Monyka (500ml) + 1 chai MgO - Kẽm EDTA (240ml) cho 400 lít nước. Phun rửa ướt đều khắp tán lá và vỏ trái.',
                    'safety_note'  => 'Mancozeb tiếp xúc rửa sạch các mảng nấm muội đen bồ hóng; Axit amin và Kẽm, Magie EDTA giúp gai quả xanh sáng bóng, phục hồi khả năng quang hợp cho bộ lá.',
                    'groups'       => [
                        [
                            'label'                => 'Mancozeb / Propineb tiếp xúc rửa sạch nấm bồ hóng muội đen',
                            'primary_pesticide_id' => 26,  // MANCOZEB 80WP
                            'substitute_ids'       => [7, 27], // Antracol 70WP, NOFACOL 700WP
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Axit Amin đạm cá & Tảo biển Seaweed dưỡng xanh gai bóng quả',
                            'primary_pesticide_id' => 159, // Xanh Um Monyka
                            'substitute_ids'       => [152], // TANG TRUONG PANAXILUS
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Magie & Kẽm Chelate giúp phục hồi diệp lục tố cho lá',
                            'primary_pesticide_id' => 111, // MgO - Kẽm EDTA
                            'substitute_ids'       => [158], // WEYZYM-A MULTIAGRO48
                        ],
                    ],
                ],
            ],
        ];

        // 3. Tạo hoặc cập nhật bệnh trong database
        $disease = Disease::updateOrCreate(
            ['folder_code' => 'CH-05'],
            $diseaseData
        );

        // 4. Gắn quan hệ với cây trồng (Crops)
        $crops = Crop::whereIn('name', [
            'Sầu riêng',
            'Cà phê',
            'Hồ tiêu',
            'Cây có múi',
            'Chanh dây',
        ])->get();

        if ($crops->isNotEmpty()) {
            $disease->crops()->sync($crops->pluck('id')->toArray());
        }

        // 5. Gắn danh sách thuốc BVTV liên quan (Pesticides)
        $pesticideIds = [170, 188, 185, 186, 165, 181, 176, 192, 25, 26, 7, 27, 159, 152, 111, 158, 161];
        $existingPesticides = Pesticide::whereIn('id', $pesticideIds)->pluck('id')->toArray();
        if (!empty($existingPesticides)) {
            $disease->pesticides()->sync($existingPesticides);
        }

        $this->command->info("Đã tạo / cập nhật thành công hồ sơ dịch hại: {$disease->name} (ID: {$disease->id})");
    }
}
