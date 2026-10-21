<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class BoTriSeeder extends Seeder
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

        // 1. Sao chép ảnh thực tế do người dùng cung cấp (Hình ảnh bọ trĩ vàng cam phóng to hiển vi trên lá non)
        $src = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690415288.jpg';
        $filename = 'bo-tri-1.jpg';
        if (file_exists($src)) {
            copy($src, "$destDir/$filename");
            $savedImages[] = "diseases/$filename";
        } elseif (file_exists("$destDir/$filename")) {
            $savedImages[] = "diseases/$filename";
        }

        // 2. Dữ liệu hồ sơ dịch hại chuẩn cho Bọ trĩ (Bù lạch / Rầy lửa)
        $diseaseData = [
            'name' => 'Bọ Trĩ (Bù Lạch, Rầy Lửa) — Scirtothrips dorsalis & Thrips palmi (Bọ Trĩ Hại Đọt Non, Gây Da Cám Trái Có Múi, Thối Hoa & Quăn Đọt Sầu Riêng, Chanh Dây)',
            'pathogen_type' => 'chich_hut',
            'folder_code' => 'CH-01',
            'folder_group' => 'chich_hut',
            'folder_name' => '1-Bọ trĩ',
            'folder_number' => 1,
            'caunho' => 'BỌ TRĨ (BÙ LẠCH) = ĐỌT NON QUĂN QUEO HÌNH CHIẾC THUYỀN + MẶT DƯỚI LÁ ÁNH ĐỒNG THIẾC + DA CÁM DA LU VÀNH KHĂN QUANH CUỐNG TRÁI (ưa khô hạn nắng gắt, kháng thuốc cực nhanh). TRỊ BẰNG LUÂN PHIÊN THUỐC MÁT CÂY: Thiamethoxam + Lambda (Riegenf USA / Tegula 247SC), Dinotefuran + Spirotetramat (Tề Thiên USA SC sữa), Chlorfenapyr nano (Emaproza) + Axit Amin bung đọt (Xanh Um Monyka), PHUN VÀO SÁNG SỚM HOẶC CHIỀU MÁT.',
            'symptoms' => "• Phân tích dịch hại chuyên sâu qua hình ảnh thực tế bạn gửi:\n- Hình ảnh phóng đại dưới kính hiển vi: Hai cá thể bọ trĩ non và trưởng thành (Thrips spp.) có kích thước nhỏ li ti (chỉ khoảng 0.8 - 1.2mm), cơ thể thon dài hình con thoi, màu vàng cam sáng đến nâu cánh gián. Bọ trĩ có đôi mắt kép màu đen sẫm nổi bật, râu đầu ngắn và các đốt cơ thể rất linh hoạt. Chúng sở hữu đôi cánh hẹp dài với mép cánh phủ đầy các sợi lông tơ mịn đặc trưng (bộ Cánh tơ - Thysanoptera), giúp chúng bay lượn và lướt gió rất xa khi có gió nhẹ.\n• Triệu chứng phá hại đặc trưng trên các bộ phận cây trồng:\n- Trên cơi đọt non & lá non: Bọ trĩ dùng phần miệng giũa hút cào rách lớp biểu bì mặt dưới lá rồi hút cạn dịch nhựa non. Mặt dưới phiến lá xuất hiện 2 dải màu xám bạc hoặc ánh màu đồng thiếc song song chạy dọc theo gân chính. Mép lá non bị co rút, quăn queo cuộn ngược lên trên như chiếc thuyền (hiện tượng 'lá thuyền' hoặc 'bồ cào'). Đọt non bị chùn lại, lá non giòn dễ gãy, khô cháy đọt và rụng sớm, cây không thể phát triển tán lá mới.\n- Trên chùm hoa & nụ hoa: Bọ trĩ chui rúc vào bên trong cánh hoa và đài hoa non chích hút mật hoa và nhụy hoa. Hoa bị thâm đen, cánh hoa khô cháy, hạt phấn bị khô teo khiến hoa không thụ phấn được, rụng hoa non hàng loạt.\n- Trên quả non & quả lớn: Bọ trĩ thường tập trung chích hút ở phần cuống quả và kẽ đáy đài hoa nơi tiếp giáp vỏ quả. Khi quả lớn lên, các tế bào bị chích hút chết khô để lại các vết sẹo sần sùi màu xám nâu (vết sẹo 'vành khăn' quanh cuống quả cam, bưởi, quýt hoặc vết 'da cám', 'da lu', nám gai sầu riêng, làm giảm 60 - 80% giá trị thương phẩm).",
            'symptoms_detail' => [
                'la' => 'Lá non cong queo hình chiếc thuyền, mép lá cuộn ngược lên; mặt dưới lá có vệt sọc xám bạc ánh màu đồng thiếc; đọt non chùn đọt khô cháy.',
                'canh_than' => 'Chồi non và cành tơ bị sần sùi, chùn đốt, các cành vượt không phát triển được do ngọn bị chích hút liên tục.',
                'goc_re' => 'Gốc rễ cây bình thường; bọ trĩ thường rơi xuống đất hóa nhộng trong các kẽ đất khô ráo quanh tán cây.',
                'qua' => 'Vỏ quả bị sẹo xám tro hình vành khăn quanh cuống quả (da cám, da lu); gai sầu riêng bị thâm nám; quả chanh dây sần sùi méo mó.',
            ],
            'prevention' => "1. Giữ ẩm vườn mùa khô bằng hệ thống tưới phun mưa: Bọ trĩ cực kỳ ghét ẩm ướt. Duy trì tưới phun mưa trên ngọn cây (tưới béc phun sương) vào buổi trưa nắng gắt làm ướt tán lá sẽ rửa trôi và dập tắt môi trường sinh sản của bọ trĩ.\n2. Bẫy dính màu vàng: Bọ trĩ có tính hướng quang mạnh với màu vàng tươi. Treo các tấm bẫy keo dính màu vàng xung quanh vườn (cách mặt đất 1 - 1.5m) để bẫy bọ trĩ trưởng thành và theo dõi mật độ dịch hại.\n3. Cắt tỉa cành thông thoáng & Vệ sinh vườn: Tỉa bỏ cành vượt, cành tăm bên trong tán, tiêu hủy các cơi đọt và chùm hoa bị bọ trĩ cắn phá nặng để cắt đứt nguồn thức ăn.\n4. Bảo tồn thiên địch: Bọ rùa, bọ xít bắt mồi, bọ trĩ bắt mồi (Aeolothrips) và bọ mắt vàng ăn bọ trĩ rất khỏe; hạn chế phun thuốc trừ sâu phổ rộng gốc lân hữu cơ gây chết thiên địch.",
            'treatment' => "1. NGUYÊN TẮC VÀNG ĐẶC TRỊ BỌ TRĨ:\n• Bọ trĩ sinh sản cực nhanh (vòng đời chỉ 10 - 15 ngày), có tập tính trốn sâu trong kẽ búp lá non, nụ hoa và kẽ gai quả; đặc biệt CHÚNG CÓ KHẢ NĂNG KHÁNG THUỐC BẬC NHẤT trong giới côn trùng chích hút.\n• BẮT BUỘC PHẢI LUÂN PHIÊN HOẠT CHẤT: Không dùng 1 loại thuốc liên tiếp 2 lần. Phải luân phiên giữa các nhóm IRAC khác nhau (Neonicotinoid, Pyrethroid, Pyrrole, Nereistoxin, Quaternary Ammonium).\n• ƯU TIÊN DÙNG THUỐC DẠNG SC SỮA / WG MÁT CÂY: Vì bọ trĩ thường cắn phá đọt non và hoa quả non, thuốc dạng sữa mát (SC) hoặc cốm (WG) sẽ không gây cháy đọt non, không làm nóng hoa rụng nụ.\n• THỜI ĐIỂM PHUN: Phun ướt đẫm mặt dưới lá và chùm búp non vào SÁNG SỚM (khi sương vừa tan, bọ trĩ bò ra ngoài phơi nắng) hoặc CHIỀU MÁT.\n\n2. Phác đồ hóa học đặc trị luân phiên:\n• Nhóm Pyrethroid + Neonicotinoid nội hấp hạ gục kép (IRAC 3A + IRAC 4A): Riegenf USA (Lambda-Cyhalothrin 11% + Thiamethoxam 20% - X2 sức mạnh bọ trĩ), Tegula Ấn Độ 247SC (Lambda-cyhalothrin 10.6% + Thiamethoxam 14.1%). Thuốc thấm sâu lưu dẫn cực nhanh, hạ gục ngay tức thì bọ trĩ non và bọ trĩ trưởng thành.\n• Nhóm Neonicotinoid + Tetramic acid thế hệ mới lưu dẫn 2 chiều (IRAC 4A + IRAC 23): Tề Thiên USA (Dinotefuran + Spirotetramat dạng sữa mát cây). Lưu dẫn 2 chiều lên ngọn và xuống rễ, diệt cả bọ trĩ ẩn sâu trong kẽ búp và làm ung trứng bọ trĩ, bảo vệ cơi đọt kéo dài suốt 15 - 20 ngày.\n• Nhóm Pyrrole nano thấm sâu phá vỡ ty thể (IRAC 13 + IRAC 6): Emaproza 10SC Nano Sâu Rầy Rệp (Chlorfenapyr + Emamectin benzoate). Dạng SC nano cực mát đọt, đặc trị bọ trĩ kháng thuốc nhóm cúc và lân.\n• Nhóm Nereistoxin vị độc tiếp xúc (IRAC 14): LEDAN 95SP (Cartap Hydrochloride 95%). Thấm sâu cực mạnh, dập dịch tức thì khi mật độ bọ trĩ bùng phát cao.\n• Phục hồi cơi đọt sau bọ trĩ: Sau khi phun thuốc diệt bọ trĩ 3 - 5 ngày, phun phục hồi đọt bằng Amino Acid đạm cá, Rong biển Seaweed (Xanh Um Monyka) kết hợp CanxiBo EDTA và Kẽm sữa (MgO - Kẽm EDTA) để kích thích tế bào lá non bung xòe trở lại, lá xanh dày bóng mượt.",
            'chemical_groups' => 'Lambda-Cyhalothrin + Thiamethoxam (Riegenf USA / Tegula 247SC - IRAC 3A + IRAC 4A), Dinotefuran + Spirotetramat (Tề Thiên USA SC - IRAC 4A + IRAC 23), Chlorfenapyr + Emamectin (Emaproza 10SC Nano - IRAC 13 + IRAC 6), Cartap Hydrochloride (Ledan 95SP - IRAC 14), Amino Acid đạm cá, Canxi-Bo EDTA & MgO - Kẽm EDTA',
            'notes' => "Lưu ý thực tế từ kỹ sư BVTV:\n• Bọ trĩ xuất hiện ngay từ khi cơi đọt vừa nhú mũi giáo (hạt gạo) và nụ hoa vừa hé mở. Nếu để lá mở rộng rồi mới phun thì đọt đã bị quăn queo và hoa đã rụng (phun muộn không có tác dụng cứu lá).\n• Thời điểm vàng phun phòng trị bọ trĩ: Khi đọt non vừa nhú cựa gà / mũi giáo dài 1 - 2cm, và khi hoa chuẩn bị nở.\n• Cần chỉnh béc phun thật tơi xốp, phun xoáy từ dưới dạ lá lên trên và tập trung vào ngọn búp non.\n• Tài liệu tham khảo: Viện Cây ăn quả Miền Nam (SOFRI), Trung tâm BVTV phía Nam, Cục Bảo vệ Thực vật.",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Sầu riêng, Cây có múi, Chanh dây, Cà phê, Hồ tiêu, Cà chua & Họ cà, Dưa leo & Bầu bí, Nho',
            'treatment_plans' => [
                [
                    'title'        => 'Phác đồ 1: Hạ gục nhanh bọ trĩ kháng thuốc & Bảo vệ cơi đọt non mới nhú (Riegenf USA + Tề Thiên USA SC Sữa + CanxiBo EDTA)',
                    'badge'        => 'Hạ gục nhanh bọ trĩ số 1',
                    'badge_color'  => 'rose',
                    'stage'        => 'Giai đoạn cơi đọt non vừa nhú mũi giáo (1 - 3cm) hoặc chùm nụ hoa non vừa phân hóa, phát hiện thấy bọ trĩ bò trong kẽ búp',
                    'dosage_guide' => 'Pha 1 chai Riegenf USA (240ml) + 1 chai Tề Thiên USA (450ml) + 1 chai CanxiBo EDTA (250ml) cho 400 lít nước (2 phuy). Phun chùm đều toàn bộ các đọt non và mặt dưới phiến lá.',
                    'safety_note'  => 'Thuốc dạng SC huyền phù sữa mát cây không làm cháy đọt non, Lambda + Thiamethoxam hạ gục tức thì bọ trĩ trưởng thành, Dinotefuran + Spirotetramat lưu dẫn 2 chiều làm ung trứng và diệt ấu trùng non, Canxi-Bo giúp đọt non dẻo dai vươn dài.',
                    'groups'       => [
                        [
                            'label'                => 'Lambda-Cyhalothrin + Thiamethoxam hạ gục cực nhanh bọ trĩ trưởng thành',
                            'primary_pesticide_id' => 187, // Riegenf USA
                            'substitute_ids'       => [192], // TEGULA ẤN ĐỘ 247SC
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Dinotefuran + Spirotetramat dạng sữa lưu dẫn 2 chiều, diệt bọ trĩ non & ung trứng',
                            'primary_pesticide_id' => 188, // Tề Thiên USA
                            'substitute_ids'       => [171], // Emaproza 10SC Nano
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Canxi-Bo dẻo dai đọt non, chống quăn queo biến dạng mép lá',
                            'primary_pesticide_id' => 80, // CanxiBo EDTA
                            'substitute_ids'       => [158], // WEYZYM-A MULTIAGRO48
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 2: Dập dịch bọ trĩ cứng đầu, bọ trĩ kháng thuốc nhóm cúc & lân (Emaproza 10SC Nano + Ledan 95SP + MgO - Kẽm EDTA)',
                    'badge'        => 'Dập bọ trĩ kháng thuốc',
                    'badge_color'  => 'sky',
                    'stage'        => 'Phun luân phiên cách lần 1 từ 4 - 6 ngày khi áp lực bọ trĩ cao vào mùa nắng nóng hanh khô',
                    'dosage_guide' => 'Pha 1 chai Emaproza 10SC Nano (240ml) + 1 gói Ledan 95SP (100g) + 1 chai MgO - Kẽm EDTA (250ml) cho 400 lít nước. Phun ướt đẫm chùm ngọn và mặt dưới lá vào sáng sớm hoặc chiều mát.',
                    'safety_note'  => 'Chlorfenapyr nano phá vỡ hô hấp ty thể của bọ trĩ kháng thuốc, Cartap lưu dẫn vị độc cực mạnh; Kẽm và Magie dạng sữa giúp phiến lá non dày bóng xanh, tăng độ cứng biểu bì chống bọ trĩ cắn rách.',
                    'groups'       => [
                        [
                            'label'                => 'Chlorfenapyr + Emamectin nano thấm sâu phá vỡ ty thể bọ trĩ kháng thuốc',
                            'primary_pesticide_id' => 171, // Emaproza 10SC Nano Sâu Rầy Rệp 130
                            'substitute_ids'       => [172], // Emaproza 10SC Nano 160
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Cartap Hydrochloride vị độc thấm sâu, dập tắt ổ bọ trĩ ẩn nấp trong kẽ nụ',
                            'primary_pesticide_id' => 168, // LEDAN 95SP
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Kẽm & Magie sữa làm dày lá, chống cháy chóp lá non do bọ trĩ chích hút',
                            'primary_pesticide_id' => 111, // MgO - Kẽm EDTA
                            'substitute_ids'       => [7], // Antracol 70WP Bayer
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 3: Phục hồi cơi đọt xanh dày, bung xòe lá non & Chống da cám da lu trên quả',
                    'badge'        => 'Phục hồi đọt xanh dày',
                    'badge_color'  => 'amber',
                    'stage'        => 'Sau khi đã sạch bọ trĩ, giai đoạn lá non bắt đầu mở phiến và quả non vào giai đoạn phát triển nhanh',
                    'dosage_guide' => 'Pha 1 chai Xanh Um Monyka (500ml) + 1 chai Weyzym-A Multiagro48 (100ml) + 1 gói Antracol 70WP Bayer (300g) cho 400 lít nước. Phun ướt đều tán lá và chùm quả non.',
                    'safety_note'  => 'Axit Amin đạm cá và Tinh chất rong biển giải độc cho cây, kích hoạt phiến lá bung rộng xanh mướt; Canxi-Bo và Áo giáp Kẽm giúp da quả sáng bóng, ngăn ngừa sẹo da cám da lu trên quả có múi.',
                    'groups'       => [
                        [
                            'label'                => 'Amino Acid đạm cá & Tảo biển Seaweed kích thích bung xòe lá non',
                            'primary_pesticide_id' => 159, // Xanh Um Monyka
                            'substitute_ids'       => [152], // TANG TRUONG PANAXILUS
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Enzyme sinh học & Canxi-Bo làm lành vết thương, chống rụng quả non',
                            'primary_pesticide_id' => 158, // WEYZYM-A MULTIAGRO48
                            'substitute_ids'       => [80], // CanxiBo EDTA
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Áo giáp Kẽm Propineb Zinc++ bảo vệ da quả sáng bóng, chống sẹo thẹo',
                            'primary_pesticide_id' => 7, // Antracol 70WP Bayer
                            'substitute_ids'       => [27], // NOFACOL 700WP
                        ],
                    ],
                ],
            ],
        ];

        $disease = Disease::updateOrCreate(
            ['folder_code' => 'CH-01'],
            $diseaseData
        );

        // 3. Gắn các cây trồng mẫn cảm: Sầu riêng, Cây có múi, Chanh dây, Cà phê, Hồ tiêu, Cà chua & Họ cà, Dưa leo & Bầu bí, Nho
        $targetCropNames = ['Sầu riêng', 'Cây có múi', 'Chanh dây', 'Cà phê', 'Hồ tiêu', 'Cà chua & Họ cà', 'Dưa leo & Bầu bí', 'Nho'];
        $linkedCropIds = Crop::whereIn('name', $targetCropNames)->pluck('id')->toArray();
        if (!empty($linkedCropIds)) {
            $disease->crops()->sync($linkedCropIds);
        }

        // 4. Liên kết các thuốc BVTV đặc trị trong kho dữ liệu
        // Riegenf 187, Tegula 192, Te Thien 188, Emaproza 171, 172, Ledan 168, Antracol 7, Nofacol 27, CanxiBo 80, Weyzym-A 158, Xanh Um Monyka 159, Panaxilus 152, MgO Kem 111
        $targetPesticideIds = [187, 192, 188, 171, 172, 168, 7, 27, 80, 158, 159, 152, 111];
        $validPesticideIds = Pesticide::whereIn('id', $targetPesticideIds)->pluck('id')->toArray();

        if (!empty($validPesticideIds)) {
            $disease->pesticides()->sync($validPesticideIds);
        }
    }
}
