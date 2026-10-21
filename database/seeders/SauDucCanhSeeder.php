<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class SauDucCanhSeeder extends Seeder
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
        // Ảnh 1: Ấu trùng sâu xén tóc đục thân cành trên tay & vết đục khoanh vỏ cành
        // Ảnh 2: Cành sầu riêng bám rêu xanh có các lỗ mọt đục đùn mạt mùn cưa và xì mủ
        $src1 = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690386156.jpg';
        $filename1 = 'sau-duc-canh-1.jpg';
        if (file_exists($src1)) {
            copy($src1, "$destDir/$filename1");
            $savedImages[] = "diseases/$filename1";
        } elseif (file_exists("$destDir/$filename1")) {
            $savedImages[] = "diseases/$filename1";
        }

        $src2 = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690386123.jpg';
        $filename2 = 'sau-duc-canh-2.jpg';
        if (file_exists($src2)) {
            copy($src2, "$destDir/$filename2");
            $savedImages[] = "diseases/$filename2";
        } elseif (file_exists("$destDir/$filename2")) {
            $savedImages[] = "diseases/$filename2";
        }

        // 2. Dữ liệu hồ sơ dịch hại chuẩn cho Sâu đục cành, đục thân & Mọt đục cành
        $diseaseData = [
            'name' => 'Sâu Đục Cành, Sâu Đục Thân & Mọt Đục Cành — Cerambycidae, Cossidae & Xyleborus spp. (Xén Tóc Đục Cành, Sâu Đục Thân Mình Đỏ & Mọt Đục Cành Sầu Riêng)',
            'pathogen_type' => 'sau_hai',
            'folder_code' => 'S-04',
            'folder_group' => 'sau_hai',
            'folder_name' => '4-Sâu đục cành, đục thân & mọt đục cành',
            'folder_number' => 4,
            'caunho' => 'Sâu đục cành = LỖ ĐÙN MẠT CƯA + XÌ NHỰA VỎ + CÀNH HÉO KHÔ GÃY ĐỔ (xén tóc & mọt đục cành). Trị bằng xịt đẫm thân cành + bơm tiêm vào lỗ đục thuốc xông hơi Profenofos (THPRO 550EC / Dragon 999), Chlorfenapyr (Emaproza) và quét thuốc trừ nấm ngừa xì mủ thối thân.',
            'symptoms' => "• Trên cành cây & thân chính (Dấu hiệu phá hại đặc trưng qua 2 ảnh thực tế bạn gửi):\n- Ảnh 1 — Ấu trùng Xén tóc (Cerambycidae) đục khoanh vỏ cành: Ấu trùng có màu trắng sữa hoặc vàng ngà, đầu màu nâu đen với cặp hàm cứng cáp gặm nhấm rất khỏe. Chúng đục khoét những đường hầm ngoằn ngoèo phá hủy lớp tượng tầng mạch rây và ăn sâu vào lõi gỗ thân cành. Chỗ bị đục lớp vỏ bị nứt toác, bong tróc từng mảng lớn, đùn ra từng đống mạt mùn cưa to màu nâu đỏ và ứa các giọt dịch nhựa cây dính nhớt. Cành bị cắt đứt mạch dẫn dinh dưỡng sẽ héo rũ, khô lá và chết khô cành.\n- Ảnh 2 — Mọt đục cành (Xyleborus spp.) cắn thủng li ti: Trên vỏ cành (ngay cả cành bám rêu xanh) xuất hiện hàng chục đến hàng trăm lỗ đục tròn nhỏ li ti như đầu que tăm. Tại mỗi lỗ đục, mọt đùn ra các cọc mạt mùn cưa trắng ngà và rỉ ra các giọt nhựa cây thâm nâu. Mọt đục thành mạng lưới hang hốc rỗng ruột bên trong mạch gỗ cành, đồng thời lây truyền nấm Fusarium và Phytophthora làm tắc nghẽn hoàn toàn mạch dẫn, khiến cành bị khô rụi nhanh chóng.\n• Trên bộ lá & đọt non:\n- Toàn bộ tán lá trên cành bị sâu/mọt đục chuyển sang màu vàng úa, trưa nắng héo rũ cụp xuống (dù gốc rễ vẫn đủ ẩm), sau đó lá khô cháy vàng giòn nhưng vẫn dính trên cành hoặc rụng trơ cành.\n- Cành bị rỗng ruột mất khả năng chịu lực, khi mang trái nặng hoặc gặp mưa bão gió lớn cành rất dễ bị gãy toác ngang vị trí lỗ đục.",
            'symptoms_detail' => [
                'la' => 'Lá trên cành bị sâu đục héo rũ từ từ, chuyển sang màu vàng úa rồi khô cháy; cành suy kiệt trơ trụi lá.',
                'canh_than' => 'Xuất hiện các lỗ đục đùn mạt mùn cưa và xì nhựa ứa ra ngoài; bóc lớp vỏ thấy đường hầm ngoằn ngoèo trong lõi gỗ chứa ấu trùng xén tóc màu trắng ngà hoặc lỗ mọt li ti.',
                'goc_re' => 'Ở phần gốc thân sát mặt đất, xén tóc đục khoét cổ rễ làm cây bị suy kiệt, nứt thân xì mủ thối gốc.',
                'qua' => 'Cành bị sâu đục làm trái non bị teo tóp, rụng sớm hàng loạt; cành mang quả lớn dễ gãy đổ hoàn toàn khi gặp gió lớn.',
            ],
            'prevention' => "1. Thường xuyên thăm vườn quan sát thân cành: Kiểm tra kỹ các nách cành, vị trí phân nhánh và vỏ thân cây để phát hiện sớm các lỗ đục mới xuất hiện (có vết mạt cưa đùn ra hoặc vết xì mủ ướt).\n2. Vệ sinh vườn và cạo sạch rêu mốc thân cành: Quét vôi hoặc dung dịch gốc Đồng pha loãng quét quanh thân gốc từ mặt đất lên 1.2m để ngăn xén tóc trưởng thành đẻ trứng vào kẽ nứt vỏ cây và xua đuổi mọt đục cành.\n3. Cắt bỏ và tiêu hủy cành sâu bệnh: Dùng cưa cắt bỏ các cành tăm, cành bị rỗng ruột đã chết khô đem ra xa vườn đốt tiêu hủy để diệt sạch nhộng và ấu trùng bên trong, tránh lây lan sang cành khác.\n4. Quét keo liền sẹo sau khi cắt tỉa: Bôi keo liền sẹo hoặc thuốc gốc Đồng/Mancozeb vào tất cả các vết cắt cành để tránh thu hút bọ xén tóc và mọt đến đẻ trứng.",
            'treatment' => "1. NGUYÊN TẮC VÀNG ĐẶC TRỊ SÂU & MỌT ĐỤC CÀNH:\n• Sâu xén tóc và mọt nằm sâu bên trong lõi gỗ thân cành, lớp mạt mùn cưa bịt kín miệng lỗ đục nên phun phớt trên bề mặt lá hoàn toàn không có tác dụng.\n• Bắt buộc phải dùng THUỐC CÓ TÍNH XÔNG HƠI CỰC MẠNH (Lân hữu cơ Profenofos) hoặc THẤM SÂU NỘI HẤP (Chlorfenapyr, Carbosulfan) phun ướt đẫm thân cành để hơi thuốc len lỏi vào các hang đục làm ngạt thở và tiêu diệt sâu non.\n• Đối với các lỗ đục lớn của xén tóc: Dùng que kẽm soi thông lỗ đục, sau đó dùng ống tiêm bơm trực tiếp thuốc đậm đặc vào trong lỗ rồi dùng đất sét hoặc bông gòn tẩm thuốc bịt kín miệng lỗ.\n• Luôn kết hợp thuốc trừ nấm (Mancozeb / Metalaxyl / Fosetyl-Al) quét vào vết thương để ngăn nấm Phytophthora xâm nhập gây thối thân xì mủ.\n\n2. Phác đồ hóa học đặc trị luân phiên:\n• Nhóm Lân hữu cơ xông hơi cực mạnh (IRAC 1B + IRAC 3A/4A): THPRO 550EC (Profenofos + Thiamethoxam), DRAGON 999 (Profenofos + Cypermethrin), VOVATOX 600. Độc tố xông hơi cực mạnh thâm nhập sâu vào các ngóc ngách hang hốc đục khoét trong thân gỗ, tiêu diệt cả sâu đục cành và bọ mọt.\n• Nhóm Pyrrole + Avermectin kháng thuốc (IRAC 13 + IRAC 6): Emaproza 10SC Nano (Chlorfenapyr + Emamectin benzoate). Cơ chế tác động 4 trong 1: tiếp xúc, vị độc, nội hấp, xông hơi; bẻ gãy tính kháng của sâu đục cành đục thân.\n• Quét sát trùng vết thương hở & chống xì mủ: Mancozeb 80WP kết hợp Antracol 70WP pha sệt đậm đặc quét trực tiếp lên vết nứt vỏ thân cành sau khi nạo sạch sâu bệnh.",
            'chemical_groups' => 'Profenofos + Thiamethoxam (THPRO 550EC - IRAC 1B + IRAC 4A), Profenofos + Cypermethrin (DRAGON 999 / DRAGON 440 / VOVATOX 600 - IRAC 1B + IRAC 3A), Chlorfenapyr + Emamectin benzoate (Emaproza 10SC - IRAC 13 + IRAC 6), Carbosulfan (Afudan 20SC - IRAC 1A), Mancozeb 80WP (FRAC M01), Propineb (Antracol 70WP - FRAC M03)',
            'notes' => "Lưu ý thực tế từ kỹ sư BVTV:\n• Xén tóc trưởng thành thường đẻ trứng vào các kẽ nứt vỏ cây hoặc nách phân cành vào đầu mùa mưa. Sau khi nở, sâu non cắn khoét dưới lớp vỏ rồi đục sâu vào tâm cành.\n• Mọt đục cành thường tấn công các cây suy yếu, cành bám rêu ẩm ướt hoặc cành mang quá nhiều trái; chúng là vector lây truyền nấm thối thân cực kỳ nguy hiểm.\n• Khi phát hiện cành có dấu hiệu xì mủ đùn mạt cưa, cần xử lý dập dịch ngay; nếu để chậm 1–2 tuần sâu sẽ ăn đứt vòng tượng tầng làm chết hẳn cả cành mang trái lớn.\n• Tài liệu tham khảo: Viện Cây ăn quả Miền Nam (SOFRI), Cục Bảo vệ Thực vật, Viện KHKT Nông Lâm nghiệp Tây Nguyên (WASI).",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Sầu riêng, Cà phê, Cây có múi, Xoài, Mít, Bơ, Điều, Hồ tiêu',
            'treatment_plans' => [
                [
                    'title'        => 'Phác đồ 1: Xông hơi cực mạnh dập dịch Sâu xén tóc & Mọt đục cành (THPRO 550EC + Emaproza 10SC + Loang trải)',
                    'badge'        => 'Xông hơi dập dịch',
                    'badge_color'  => 'emerald',
                    'stage'        => 'Khi phát hiện trên thân cành có vết đùn mạt mùn cưa tươi, vết xì nhựa ướt hoặc lỗ mọt li ti',
                    'dosage_guide' => 'Pha 1 chai THPRO 550EC (450ml) hoặc Dragon 999 (450ml) + 1 chai Emaproza 10SC (160ml) + 1 chai Loang Trải Siêu Thấm (100ml) cho 400 lít nước (2 phuy). Phun ướt đẫm vỏ thân cành, tập trung xịt kỹ vào các nách cành và vị trí có lỗ đùn mạt cưa. Đồng thời dùng xi-lanh bơm trực tiếp nước thuốc đậm đặc vào các lỗ sâu lớn.',
                    'safety_note'  => 'Hơi thuốc Profenofos xông hơi len lỏi vào các hang hốc lõi gỗ làm ngạt thở và tiêu diệt sâu non; Chlorfenapyr thẩm thấu bẻ gãy tính kháng của sâu xén tóc.',
                    'groups'       => [
                        [
                            'label'                => 'Profenofos + Thiamethoxam xông hơi cực mạnh luồn sâu lõi gỗ',
                            'primary_pesticide_id' => 185, // THPRO 550EC 450ML
                            'substitute_ids'       => [165, 186], // DRAGON 999, VOVATOX 600
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Chlorfenapyr + Emamectin cơ chế 4 trong 1 diệt sâu kháng thuốc',
                            'primary_pesticide_id' => 172, // Emaproza 10SC Nano Sâu Rầy Rệp 160
                            'substitute_ids'       => [171, 161], // Emaproza 130, AFUDAN 20SC
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Trợ lực loang trải siêu thấm đưa thuốc ngấm sâu vào kẽ nứt vỏ',
                            'primary_pesticide_id' => 25,  // Loang Trải Siêu Thấm
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 2: Bơm tiêm trực tiếp vào lỗ đục & Quét gốc sát trùng chống nấm thối thân xì mủ',
                    'badge'        => 'Bơm tiêm & Quét sệt',
                    'badge_color'  => 'sky',
                    'stage'        => 'Xử lý các lỗ đục lớn của xén tóc hoặc sau khi cạo sạch vỏ cành bị mọt cắn khoanh',
                    'dosage_guide' => '1. Dùng dây thép/que kẽm soi thông lỗ đục, dùng xi-lanh hút dung dịch Dragon 999 (pha tỷ lệ 10ml thuốc / 100ml nước) bơm trực tiếp vào lỗ sâu rồi nhét bông gòn bịt kín miệng lỗ.\n2. Quét vỏ: Pha 500g Mancozeb 80WP + 300g Antracol 70WP + 100ml Dragon 999 vào 5 lít nước thành dạng hồ sệt, dùng chổi quét trực tiếp lên vết nứt vỏ thân cành.',
                    'safety_note'  => 'Tiêu diệt ấu trùng xén tóc nằm sâu trong tâm lõi cành, đồng thời sát trùng nấm Phytophthora / Fusarium không cho cơ hội xâm nhập gây xì mủ thối thân.',
                    'groups'       => [
                        [
                            'label'                => 'Profenofos + Cypermethrin độc tính tiếp xúc & xông hơi diệt sâu',
                            'primary_pesticide_id' => 165, // DRAGON 999 (450ML)
                            'substitute_ids'       => [164, 186], // DRAGON 440, VOVATOX 600
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Mancozeb tiếp xúc sát trùng vết thương, chống nấm thâm nhập',
                            'primary_pesticide_id' => 26,  // MANCOZEB 80WP
                            'substitute_ids'       => [7, 27], // Antracol 70WP, NOFACOL 700WP
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 3: Phục hồi mạch dẫn thân cành, liền sẹo vỏ cây & dưỡng cơi lá',
                    'badge'        => 'Phục hồi liền sẹo',
                    'badge_color'  => 'amber',
                    'stage'        => 'Sau khi đã diệt sạch sâu và mọt, cành cây bị tổn thương mạch dẫn cần phục hồi để nuôi trái',
                    'dosage_guide' => 'Pha 1 chai Xanh Um Monyka (500ml) + 1 chai Tang Truong Panaxilus (500ml) + 1 chai MgO - Kẽm EDTA (240ml) cho 400 lít nước (2 phuy). Phun đều tán lá và ướt dọc thân cành.',
                    'safety_note'  => 'Cung cấp Đạm cá hữu cơ, Tảo biển Seaweed và vi lượng Kẽm, Magie Chelate giúp kích thích mô sẹo vỏ cây nhanh liền da, lưu thông mạch dẫn nuôi quả.',
                    'groups'       => [
                        [
                            'label'                => 'Axit Amin đạm cá & Tảo biển Seaweed tái tạo mô tế bào',
                            'primary_pesticide_id' => 159, // Xanh Um Monyka
                            'substitute_ids'       => [152], // TANG TRUONG PANAXILUS
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Magie & Kẽm Chelate giúp lá xanh dày, chống rụng lá suy cành',
                            'primary_pesticide_id' => 111, // MgO - Kẽm EDTA
                            'substitute_ids'       => [158], // WEYZYM-A MULTIAGRO48
                        ],
                    ],
                ],
            ],
        ];

        // 3. Tạo hoặc cập nhật bệnh trong database
        $disease = Disease::updateOrCreate(
            ['folder_code' => 'S-02'],
            $diseaseData
        );

        // 4. Gắn quan hệ với cây trồng (Crops)
        $crops = Crop::whereIn('name', [
            'Sầu riêng',
            'Cà phê',
            'Cây có múi',
            'Hồ tiêu',
        ])->get();

        if ($crops->isNotEmpty()) {
            $disease->crops()->sync($crops->pluck('id')->toArray());
        }

        // 5. Gắn danh sách thuốc BVTV liên quan (Pesticides)
        $pesticideIds = [185, 165, 186, 164, 172, 171, 161, 25, 26, 7, 27, 159, 152, 111, 158];
        $existingPesticides = Pesticide::whereIn('id', $pesticideIds)->pluck('id')->toArray();
        if (!empty($existingPesticides)) {
            $disease->pesticides()->sync($existingPesticides);
        }

        $this->command->info("Đã tạo / cập nhật thành công hồ sơ dịch hại: {$disease->name} (ID: {$disease->id})");
    }
}
