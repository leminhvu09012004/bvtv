<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class RayXanhRayNhaySeeder extends Seeder
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
        // Ảnh 1: Con Rầy Xanh (Amrasca devastans / Empoasca spp.) màu xanh lá mạ trên phiến lá
        // Ảnh 2: Ấu trùng Rầy Nhảy Sầu Riêng (Allocaridara malayensis) có các sợi tua sáp trắng ngoằn ngoèo bám mặt dưới lá
        $src1 = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690340189.jpg';
        $filename1 = 'ray-xanh-ray-nhay-1.jpg';
        if (file_exists($src1)) {
            copy($src1, "$destDir/$filename1");
            $savedImages[] = "diseases/$filename1";
        } elseif (file_exists("$destDir/$filename1")) {
            $savedImages[] = "diseases/$filename1";
        }

        $src2 = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690340209.jpg';
        $filename2 = 'ray-xanh-ray-nhay-2.jpg';
        if (file_exists($src2)) {
            copy($src2, "$destDir/$filename2");
            $savedImages[] = "diseases/$filename2";
        } elseif (file_exists("$destDir/$filename2")) {
            $savedImages[] = "diseases/$filename2";
        }

        // 2. Dữ liệu hồ sơ dịch hại chuẩn cho Rầy Xanh & Rầy Nhảy Sầu Riêng
        $diseaseData = [
            'name' => 'Rầy Xanh & Rầy Nhảy Sầu Riêng — Amrasca devastans & Allocaridara malayensis (Rầy Xanh Đọt Non, Rầy Phấn, Rầy Bông Sầu Riêng & Cây Ăn Quả)',
            'pathogen_type' => 'chich_hut',
            'folder_code' => 'CH-04',
            'folder_group' => 'chich_hut',
            'folder_name' => '4-Rầy',
            'folder_number' => 4,
            'caunho' => 'Rầy hại sầu riêng = RẦY XANH CHÁY MÉP LÁ VÀNG + RẦY NHẢY ĐUÔI TUA SÁP TRẮNG RỤNG ĐỌT CHỔI CHÀ. Phun đón đọt non hình mũi giáo bằng Thiamethoxam (Nofara 35WG), Dinotefuran + Spirotetramat (Tề Thiên USA), Lambda-cyhalothrin (Tegula 247SC) và Profenofos (THPRO 550EC).',
            'symptoms' => "• Triệu chứng phá hại đặc trưng qua 2 ảnh thực tế bạn gửi:\n- Ảnh 1 — Rầy Xanh (Amrasca devastans / Empoasca spp.): Thành trùng có màu xanh lá mạ hoặc xanh lục non, thân thon dài 2.5 - 3mm, mắt kép to, di chuyển rất nhanh bằng cách bò xiên hoặc nhảy búng bay khi bị động. Cả ấu trùng và thành trùng tập trung ở mặt dưới lá non, cuống đọt chích hút nhựa; mép phiến lá bị cháy khô màu vàng nâu, cong queo gợn sóng (hiện tượng cháy mép lá hopperburn), đọt non bị chùn lại không bung mở được.\n- Ảnh 2 — Rầy Nhảy Sầu Riêng (Allocaridara malayensis / Rầy Bông Phấn): Dịch hại số 1 nguy hiểm bậc nhất trên đọt sầu riêng. Ấu trùng rầy có màu vàng xanh nhưng phần đuôi tiết ra các SỢI TUA SÁP TRẮNG DÀI NGOẰN NGOÈO NHƯ RÂU TƠ HOẶC SỢI BÔNG GÒN bám dày đặc thành từng cụm ở mặt dưới phiến lá non (nhìn rất rõ trong ảnh thực tế). Khi bị động rầy nhảy tanh tách.\n• Hậu quả phá hại trên cơi đọt & chùm hoa:\n- Rầy chích hút làm lá non bị teo tóp, cháy khô mép lá rồi rụng hàng loạt chỉ còn lại cuống cành trơ trụi (hiện tượng đọt chổi chà, chết ngọn cơi đọt).\n- Rầy bài tiết dịch mật ngọt dính ướt kích thích nấm muội đen bồ hóng phát triển làm đen bề mặt lá, giảm quang hợp nghiêm trọng.\n- Cây sầu riêng bị rầy đánh mất cơi đọt sẽ suy kiệt, không đủ bộ lá nuôi trái, trái bị méo mó, sượng cơm hoặc rụng trái non hàng loạt.",
            'symptoms_detail' => [
                'la' => 'Mép lá bị cháy khô cong queo vàng nâu; mặt dưới lá bám dày đặc rầy xanh hoặc ấu trùng rầy nhảy có đuôi tua sáp trắng ngoằn ngoèo; lá non rụng sớm để lại cành trơ chổi chà.',
                'canh_than' => 'Cơi đọt non bị chùn đọt, teo tóp cuống lá non, không phóng đọt được; thân cành non bị dính dịch mật ngọt và muội đen bồ hóng.',
                'goc_re' => 'Không gây hại trực tiếp dưới vùng rễ, nhưng cây mất bộ lá quang hợp khiến rễ cám bị suy kiệt, ngừng phát triển.',
                'qua' => 'Cây bị mất lá không quang hợp nuôi trái được, làm rụng hoa, rụng trái non và sượng méo trái.',
            ],
            'prevention' => "1. Thăm vườn thường xuyên khi cây chuẩn bị bung cơi đọt: Thời điểm quyết định thành bại là khi cây vừa nhú đọt 'mũi giáo' (cựa gà dài 1 - 2cm). Phải kiểm tra mặt dưới lá và chồi non mỗi 2 - 3 ngày/lần.\n2. Phun phòng đón đọt đúng thời điểm vàng: Cần phun 2 lần cho mỗi cơi đọt:\n   • Lần 1: Khi cơi đọt vừa nhú mũi giáo (ngăn rầy đẻ trứng và chích hút đọt non).\n   • Lần 2: Sau lần một 5 - 7 ngày khi lá non bắt đầu mở hình đuôi tôm (dập sạch lứa rầy non mới nở).\n3. Tưới nước và bón phân tập trung giúp cơi đọt ra đồng loạt: Tránh để cây ra đọt lọt sọt rải rác quanh năm khiến rầy có nguồn thức ăn liên tục và tích lũy mật độ dịch hại.\n4. Bảo tồn thiên địch: Bọ rùa, bọ xít bắt mồi, nhện ăn thịt và ong ký sinh là những thiên địch tự nhiên tiêu diệt rầy rất mạnh; tránh phun thuốc hóa học độc hại khi không cần thiết.",
            'treatment' => "1. NGUYÊN TẮC VÀNG ĐẶC TRỊ RẦY XANH & RẦY NHẢY:\n• Phải phun đúng thời điểm (khi đọt vừa nhú mũi giáo đến mở lá non), phun trễ khi lá đã cháy xoăn mép thì đọt non đã bị hỏng.\n• Phải kết hợp hoạt chất hạ gục nhanh tiếp xúc/vị độc + hoạt chất lưu dẫn 2 chiều thẩm thấu vào búp đọt non + chất loang trải siêu thấm để phá tan lớp tua sáp trắng của rầy nhảy.\n• Luân phiên các nhóm thuốc khác nhau (Neonicotinoid, Pyrethroid, Ketoenol, Pyrrole) để tránh rầy kháng thuốc.\n\n2. Phác đồ hóa học đặc trị luân phiên:\n• Nhóm Neonicotinoid lưu dẫn cực mạnh (IRAC 4A): Nofara 35WG (Thiamethoxam 35%), Tegula 247SC (Lambda-cyhalothrin + Thiamethoxam), Riegenf USA. Thuốc ngấm sâu vào mô mạch dẫn, làm tê liệt hệ thần kinh rầy non ngay khi vừa chích hút, bảo vệ đọt non suốt 10 - 15 ngày.\n• Nhóm Ketoenol + Neonicotinoid dạng sữa SC mát cây (IRAC 23 + IRAC 4A): Tề Thiên USA (Dinotefuran + Spirotetramat), Movento 150OD. Dạng sữa SC siêu mát không nóng búp đọt, lưu dẫn 2 chiều di chuyển theo đọt non đang lớn, diệt cả trứng và ấu trùng rầy.\n• Nhóm Lân hữu cơ xông hơi & Pyrrole diệt rầy kháng thuốc: THPRO 550EC (Profenofos + Thiamethoxam), Emaproza 10SC (Chlorfenapyr + Emamectin). Độc tính xông hơi và tiếp xúc cực mạnh hạ gục chớp nhoáng mật độ rầy trưởng thành đang bay nhảy rộ.\n• Trợ lực loang trải phá sáp: Loang Trải Siêu Thấm Monyka (Polyether Polymethylsiloxane Copolymer). Giúp giọt thuốc bám dính loang đều 2 mặt lá, đánh tan các sợi tua sáp trắng của rầy nhảy sầu riêng.\n\n3. Dưỡng cơi đọt mập & dày lá sau khi dập rầy:\n• Kết hợp bón phân lá giàu Axit Amin hữu cơ, Tảo biển Seaweed (Xanh Um Monyka, Tang Truong Panaxilus) và MgO - Kẽm EDTA để kéo đọt vọt nhanh, phiến lá dày bóng, nhanh chuyển lụa để vượt qua giai đoạn mẫn cảm với rầy.",
            'chemical_groups' => 'Thiamethoxam (Nofara 35WG - IRAC 4A), Dinotefuran + Spirotetramat (Tề Thiên USA - IRAC 4A + IRAC 23), Lambda-cyhalothrin + Thiamethoxam (Tegula 247SC / Riegenf USA - IRAC 3A + IRAC 4A), Profenofos + Thiamethoxam (THPRO 550EC - IRAC 1B + IRAC 4A), Chlorfenapyr + Emamectin (Emaproza 10SC - IRAC 13 + IRAC 6), Chất trợ lực phá màng sáp (Polyether Polymethylsiloxane Copolymer)',
            'notes' => "Lưu ý thực tế từ kỹ sư BVTV:\n• Rầy xanh và rầy nhảy là 'kẻ thù số 1' của nhà vườn sầu riêng; nếu để mất cơi đọt thì cây sẽ mất ít nhất 2 - 3 tháng mới tạo lại được cơi đọt mới, làm trễ vụ nghịch hoặc suy kiệt cây mang trái.\n• Rầy thường trốn ở mặt dưới lá và đọt non, ban ngày nắng gắt trốn vào trong tán, chiều mát và sáng sớm bò ra chích hút; thời điểm phun thuốc hiệu quả nhất là sáng sớm (6h - 8h) hoặc chiều mát (16h - 18h).\n• Luôn phun phủ đều 2 mặt lá và chụp đỉnh tán cây, đồng thời xịt phớt mặt cỏ dưới đất để diệt các cá thể rầy nhảy xuống trốn.\n• Tài liệu tham khảo: Viện Cây ăn quả Miền Nam (SOFRI), Cục Bảo vệ Thực vật, Trung tâm Khuyến nông Quốc gia.",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Sầu riêng, Cây có múi, Chanh dây, Xoài, Cà phê, Chè (Trà)',
            'treatment_plans' => [
                [
                    'title'        => 'Phác đồ 1: Đặc trị dập dịch Rầy xanh & Rầy nhảy cơi đọt (Nofara 35WG + Tegula 247SC + Loang trải)',
                    'badge'        => 'Đặc trị dập dịch',
                    'badge_color'  => 'emerald',
                    'stage'        => 'Giai đoạn cơi đọt sầu riêng nhú mũi giáo đến mở lá đuôi tôm, hoặc khi phát hiện rầy xanh, rầy nhảy bám mặt dưới lá',
                    'dosage_guide' => 'Pha 2 gói Nofara 35WG (100g x 2 = 200g) + 1 chai Tegula 247SC (250ml) hoặc Riegenf USA (250ml) + 1 chai Loang Trải Siêu Thấm (100ml) cho 400 lít nước (2 phuy). Phun ướt đẫm đều 2 mặt tán lá, chụp vòi xịt kỹ từ đỉnh đọt xuống.',
                    'safety_note'  => 'Tegula hạ gục chớp nhoáng rầy trưởng thành bay nhảy; Thiamethoxam lưu dẫn 2 chiều bảo vệ cơi đọt non mới bung không bị chích hút suốt 12–15 ngày. Phun nhắc lại lần 2 sau 5–7 ngày khi lá mở hoàn toàn.',
                    'groups'       => [
                        [
                            'label'                => 'Thiamethoxam lưu dẫn 2 chiều cực mạnh bảo vệ đọt non',
                            'primary_pesticide_id' => 176, // NOFARA 35WG 100 GRAM
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Lambda-cyhalothrin + Thiamethoxam hạ gục chớp nhoáng 3 đời sâu rầy',
                            'primary_pesticide_id' => 192, // TEGULA ẤN ĐỘ 247SC
                            'substitute_ids'       => [187], // Riegenf USA
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Trợ lực loang trải siêu thấm phá tan tua sáp của rầy nhảy',
                            'primary_pesticide_id' => 25,  // Loang Trải Siêu Thấm
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 2: Đặc trị rầy kháng thuốc & Dạng sữa SC siêu mát đọt non (Tề Thiên USA + THPRO 550EC + Loang trải)',
                    'badge'        => 'Mát đọt non',
                    'badge_color'  => 'sky',
                    'stage'        => 'Khi rầy có hiện tượng lờn thuốc, hoặc giai đoạn đọt non lá lụa mỏng manh cần thuốc cực mát không gây cháy đọt',
                    'dosage_guide' => 'Pha 1 chai Tề Thiên USA dạng sữa (240ml) + 1 chai THPRO 550EC (450ml) hoặc Emaproza 10SC (160ml) + 1 chai Loang Trải Siêu Thấm (100ml) cho 400 lít nước (2 phuy). Phun chùm đều tán lá và đỉnh cơi đọt.',
                    'safety_note'  => 'Dinotefuran + Spirotetramat dạng sữa SC siêu êm mát, THPRO xông hơi làm ngạt rầy trong các kẽ búp lá, bẻ gãy tính kháng thuốc hoàn toàn.',
                    'groups'       => [
                        [
                            'label'                => 'Dinotefuran + Spirotetramat dạng sữa SC lưu dẫn 2 chiều mát cây',
                            'primary_pesticide_id' => 188, // Tề Thiên USA
                            'substitute_ids'       => [170], // MOVENTO 150OD
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Profenofos + Thiamethoxam xông hơi & tiếp xúc diệt rầy kháng',
                            'primary_pesticide_id' => 185, // THPRO 550EC 450ML
                            'substitute_ids'       => [172], // Emaproza 10SC Nano
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Trợ lực loang trải siêu thấm bám dính sâu vào mặt dưới lá',
                            'primary_pesticide_id' => 25,  // Loang Trải Siêu Thấm
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 3: Kéo cơi đọt mập, dày bóng lá & nhanh chuyển lụa vượt qua giai đoạn rầy',
                    'badge'        => 'Dưỡng đọt mập',
                    'badge_color'  => 'amber',
                    'stage'        => 'Sau khi đã kiểm soát sạch rầy, cần thúc cơi đọt phát triển nhanh, lá dày cứng cáp để chống tái nhiễm',
                    'dosage_guide' => 'Pha 1 chai Xanh Um Monyka (500ml) + 1 chai Tang Truong Panaxilus (500ml) + 1 chai MgO - Kẽm EDTA (240ml) cho 400 lít nước (2 phuy). Phun đều 2 mặt tán lá vào buổi sáng sớm hoặc chiều mát.',
                    'safety_note'  => 'Axit Amin đạm cá và Rong biển giúp cơi đọt vọt nhanh mập mạp; Kẽm, Magie EDTA giúp phiến lá dày cứng, biểu bì lá dày làm rầy không thể chích hút.',
                    'groups'       => [
                        [
                            'label'                => 'Axit Amin đạm cá & Tảo biển Seaweed kéo đọt mập mạp',
                            'primary_pesticide_id' => 159, // Xanh Um Monyka
                            'substitute_ids'       => [152], // TANG TRUONG PANAXILUS
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Magie & Kẽm Chelate giúp lá dày cứng, chống cháy mép lá',
                            'primary_pesticide_id' => 111, // MgO - Kẽm EDTA
                            'substitute_ids'       => [158], // WEYZYM-A MULTIAGRO48
                        ],
                    ],
                ],
            ],
        ];

        // 3. Tạo hoặc cập nhật bệnh trong database
        $disease = Disease::updateOrCreate(
            ['folder_code' => 'CH-04'],
            $diseaseData
        );

        // 4. Gắn quan hệ với cây trồng (Crops)
        $crops = Crop::whereIn('name', [
            'Sầu riêng',
            'Cây có múi',
            'Chanh dây',
            'Cà phê',
        ])->get();

        if ($crops->isNotEmpty()) {
            $disease->crops()->sync($crops->pluck('id')->toArray());
        }

        // 5. Gắn danh sách thuốc BVTV liên quan (Pesticides)
        $pesticideIds = [176, 192, 187, 188, 170, 185, 172, 25, 159, 152, 111, 158];
        $existingPesticides = Pesticide::whereIn('id', $pesticideIds)->pluck('id')->toArray();
        if (!empty($existingPesticides)) {
            $disease->pesticides()->sync($existingPesticides);
        }

        $this->command->info("Đã tạo / cập nhật thành công hồ sơ dịch hại: {$disease->name} (ID: {$disease->id})");
    }
}
