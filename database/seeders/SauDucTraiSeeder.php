<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class SauDucTraiSeeder extends Seeder
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
        // Ảnh 1: Vòng đời bướm, sâu non và vết đục kẽ gai quả sầu riêng
        $src1 = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690298539.jpg';
        $filename1 = 'sau-duc-trai-1.jpg';
        if (file_exists($src1)) {
            copy($src1, "$destDir/$filename1");
            $savedImages[] = "diseases/$filename1";
        }

        // Ảnh 2: Cận cảnh sâu non đục sâu vào trong cơm và hạt sầu riêng, phân đùn ra miệng lỗ
        $src2 = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690298581.jpg';
        $filename2 = 'sau-duc-trai-2.jpg';
        if (file_exists($src2)) {
            copy($src2, "$destDir/$filename2");
            $savedImages[] = "diseases/$filename2";
        }

        // 2. Dữ liệu hồ sơ bệnh học chuẩn cho Sâu đục trái
        $diseaseData = [
            'name' => 'Sâu Đục Trái Sầu Riêng & Cây Ăn Quả — Conogethes punctiferalis / Mudaria magniplaga (Sâu Đục Vỏ & Đục Hạt Quả)',
            'pathogen_type' => 'sau_hai',
            'folder_code' => 'S-05',
            'folder_group' => 'sau_hai',
            'folder_name' => '5 Sâu đục trái',
            'folder_number' => 5,
            'caunho' => 'Sâu đục trái = PHÂN ĐÙN RA KẼ GAI, ĐỤC THỦNG VÀO HẠT CƠM (mở đường nấm thối trái rụng quả). Diệt bằng Chlorfenapyr + Emamectin (Emaproza 10SC), Cartap (Ledan 95SP), Profenofos + Thiamethoxam (THPRO 550EC / Vovatox) kết hợp Lambda-cyhalothrin (Tegula 247SC).',
            'symptoms' => "• Đặc điểm hình thái & Tập tính gây hại (như 2 hình ảnh thực tế bạn gửi):\n- Gồm 2 loài chính phá hoại nghiêm trọng nhất: Sâu đục vỏ trái (Conogethes punctiferalis - bướm màu vàng cam có nhiều đốm đen) và Sâu đục hạt / ăn hạt (Mudaria magniplaga - bướm đêm màu xám tro, sâu non màu hồng tím sọc đậm).\n- Bướm cái hoạt động đẻ trứng vào ban đêm; trứng được đẻ rải rác ở các khe kẽ giữa các gai quả non, nơi tiếp giáp giữa 2 quả trong cùng một chùm hoặc quanh cuống quả.\n- Sau khi trứng nở, sâu non tuổi nhỏ gặm biểu bì vỏ gai; từ tuổi 3 trở đi, sâu bắt đầu đục một lỗ sâu xuyên qua lớp vỏ gai cứng vào bên trong phần thịt (cơm) quả và khoét rỗng hạt.\n• Dấu hiệu nhận diện đặc trưng không thể nhầm lẫn:\n- Tại miệng lỗ đục luôn có một KHỐI PHÂN SÂU MÀU NÂU ĐEN HOẶC TRẮNG ĐÙN RA NGOÀI KẼ GAI, thường có màng tơ mỏng kết dính các hạt phân lại với nhau quanh miệng lỗ.\n- Vết đục làm quả non bị biến dạng, méo mó, chảy nhựa và rụng non hàng loạt.\n- Lỗ đục là cửa ngõ để nước mưa và nấm bệnh Phytophthora palmivora xâm nhập thứ cấp gây thối nhũn toàn bộ quả (thối quả sầu riêng), thịt quả bị chua thối bốc mùi nồng nặc.\n- Quả lớn chuẩn bị thu hoạch nếu bị đục sẽ mất hoàn toàn giá trị thương phẩm xuất khẩu, gây thiệt hại kinh tế lên đến 50 - 70% sản lượng vườn.",
            'symptoms_detail' => [
                'la' => 'Không gây hại trực tiếp trên phiến lá (thành trùng bướm đậu nghỉ dưới mặt lá).',
                'canh_than' => 'Sâu non có thể cắn phá cuống quả làm cuống teo thắt, khô nứt và rụng quả sớm.',
                'goc_re' => 'Không gây hại dưới bộ rễ.',
                'qua' => 'Vỏ quả xuất hiện các lỗ đục kẽ gai đùn phân sâu ra ngoài; sâu ăn rỗng cơm và hạt quả; quả non rụng hàng loạt, quả lớn bị thối nhũn và chua thịt.',
            ],
            'prevention' => "1. Tỉa quả định chùm thông thoáng: Sau khi xổ nhụy 20 - 30 ngày, tiến hành tỉa bỏ các quả méo mó, quả dị hình, chùm quả quá dày. Tốt nhất chỉ để 1 quả/chùm hoặc dùng miếng xốp chèn giữa các quả để tránh 2 quả chạm vào nhau (khe tiếp giáp giữa 2 quả là nơi bướm ưa thích đẻ trứng nhất).\n2. Vệ sinh tàn dư vườn: Thường xuyên kiểm tra vườn, thu gom toàn bộ những quả bị sâu đục rơi rụng mang ra xa vườn tiêu hủy hoặc đào hố chôn vôi bột để diệt nhộng sâu ẩn nấp trong đất.\n3. Bao trái (nếu có điều kiện): Sử dụng túi lưới chuyên dụng bao trái sau khi tỉa định quả (khoảng 45 - 50 ngày sau xổ nhụy) để ngăn chặn bướm đẻ trứng hoàn toàn.\n4. Bẫy đèn sinh học: Treo bẫy đèn vào ban đêm trong giai đoạn quả non để thu hút và tiêu diệt bướm thành trùng trước khi chúng giao phối đẻ trứng.",
            'treatment' => "1. NGUYÊN TẮC ĐẶC TRỊ SÂU ĐỤC TRÁI:\n• Phải xử lý thuốc sớm khi SÂU NON VỪA MỚI NỞ (tuổi 1-2) còn ở ngoài vỏ gai trước khi sâu kịp đục sâu vào trong cơm quả (khi sâu đã chui vào trong hạt cơm thì thuốc tiếp xúc khó chạm tới).\n• Bắt buộc kết hợp thuốc có tính THẤM SÂU NỘI HẤP MẠNH (Chlorfenapyr, Cartap, Emamectin) để thuốc ngấm qua lớp vỏ gai tiêu diệt sâu bên trong + thuốc XÔNG HƠI TIẾP XÚC (Profenofos, Lambda-cyhalothrin) để hạ gục bướm và sâu ngoài vỏ kẽ gai.\n• Luôn pha kèm thuốc trừ nấm (Metalaxyl M / Propineb) để sát trùng vết đục, ngăn chặn nấm Phytophthora xâm nhập gây thối quả.\n\n2. Phác đồ hóa học đặc trị luân phiên:\n• Nhóm phá vỡ ty thể & Thấm sâu cực mạnh: Chlorfenapyr 9.5% + Emamectin 0.5% (Emaproza 10SC Nano). Thuốc ngấm cực nhanh qua lớp vỏ gai, làm tê liệt hô hấp tế bào, sâu trúng thuốc ngừng ăn và chết khô trong lỗ đục.\n• Nhóm Cartap Hydrochloride (IRAC 14): Ledan 95SP 100g. Tính lưu dẫn vị độc cực mạnh, diệt sạch sâu đục hạt và sâu đã kháng thuốc.\n• Nhóm Lân hữu cơ xông hơi cực mạnh (IRAC 1B): Profenofos 450g/l + Thiamethoxam 100g/l (THPRO 550EC, Vovatox 600, Dragon 999). Hơi thuốc xông sâu vào từng kẽ gai tiêu diệt bướm và sâu ẩn nấp.\n• Nhóm Cúc tổng hợp hạ gục nhanh (IRAC 3A): Lambda-cyhalothrin 10.6% + Thiamethoxam 14.1% (Tegula 247SC, Riegenf USA). Hạ gục lập tức thành trùng bướm đẻ trứng.\n\n3. Lịch phun định kỳ bảo vệ quả:\n• Phun lần 1: Sau khi xổ nhụy dứt điểm 15 - 20 ngày (quả non bằng quả trứng cút).\n• Phun lần 2: Giai đoạn quả non 40 - 50 ngày tuổi (bằng nắm tay).\n• Phun lần 3: Giai đoạn quả phát triển nhanh 70 - 80 ngày tuổi.",
            'chemical_groups' => 'Chlorfenapyr + Emamectin (Emaproza 10SC - Thấm sâu cực mạnh diệt sâu trong quả), Cartap Hydrochloride (Ledan 95SP - IRAC 14 vị độc lưu dẫn), Profenofos + Thiamethoxam (THPRO 550EC / Vovatox 600 - IRAC 1B xông hơi mạnh), Lambda-cyhalothrin (Tegula 247SC / Riegenf USA - IRAC 3A hạ gục bướm), Metalaxyl M (Ridomil Gold 68WG - Chống thối quả do nấm), Propineb (Antracol 70WP - Áo giáp Kẽm bảo vệ da trái), Amino Acid & Canxi-Bo nuôi trái lớn nhanh',
            'notes' => "Lưu ý thực tế từ kỹ sư BVTV:\n• Cây trồng bị hại nặng nhất: Sầu riêng, Bưởi, Cam, Chanh dây, Mít, Xoài, Mãng cầu, Bơ.\n• Thời điểm bùng phát mạnh: Trong mùa mưa ẩm hoặc các tháng quả non phát triển mạnh (tháng 4 - tháng 8 ở Tây Nguyên và Nam Bộ).\n• Cần phun tập trung xoáy thẳng béc phun vào TỪNG CHÙM QUẢ và KẼ GAI QUẢ, không chỉ phun phớt ngoài tán lá.\n• Tài liệu tham khảo: Viện Cây ăn quả Miền Nam (SOFRI), Cục Bảo vệ Thực vật, Viện KHKT Nông Lâm nghiệp Tây Nguyên (WASI).",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Sầu riêng, Cây có múi, Chanh dây, Cà phê, Xoài, Mít',
            'treatment_plans' => [
                [
                    'title'        => 'Phác đồ 1: Đặc trị dập dịch Sâu đục trái thấm sâu cực mạnh & Diệt sâu tận trong lỗ đục (Chlorfenapyr + Emamectin + Cartap Ledan 95SP + Sát trùng Ridomil Gold)',
                    'badge'        => 'Thấm sâu dập dịch',
                    'badge_color'  => 'rose',
                    'stage'        => 'Khi phát hiện lỗ đục kẽ gai có phân sâu đùn ra ngoài, sâu cắn phá quả non và quả bánh tẻ',
                    'dosage_guide' => 'Pha 1 chai Emaproza 10SC Nano (240ml) + 1 gói Ledan 95SP (100g) + 1 gói Ridomil Gold 68WG (100g) cho 400 lít nước (2 phuy). Phun xoáy ướt đẫm các chùm quả và kẽ gai.',
                    'safety_note'  => 'Chlorfenapyr và Cartap thấm sâu vào vỏ quả diệt sâu bên trong lỗ đục, Ridomil Gold sát trùng vết thương hở chống nấm Phytophthora gây thối quả. Phun nhắc lại lần 2 sau 5 - 7 ngày.',
                    'groups'       => [
                        [
                            'label'                => 'Chlorfenapyr + Emamectin thấm sâu phá vỡ ty thể',
                            'primary_pesticide_id' => 171, // Emaproza 10SC Nano Sâu Rầy Rệp 130
                            'substitute_ids'       => [172], // Emaproza 10SC 160
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Cartap Hydrochloride lưu dẫn vị độc cực mạnh',
                            'primary_pesticide_id' => 168, // LEDAN 95SP 100 GRAM (GOI)
                            'substitute_ids'       => [161], // AFUDAN 20SC 100MIL
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Metalaxyl M sát trùng lỗ đục chống nấm thối quả',
                            'primary_pesticide_id' => 32, // Ridomil Gold 68WG
                            'substitute_ids'       => [193], // BINHTAXYL 25EC
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 2: Xông hơi hạ gục nhanh bướm & Diệt sạch sâu non mới nở ở kẽ gai (Profenofos THPRO 550EC / Vovatox + Tegula 247SC + Áo giáp Kẽm Antracol)',
                    'badge'        => 'Xông hơi hạ gục',
                    'badge_color'  => 'sky',
                    'stage'        => 'Phun phòng ngừa định kỳ giai đoạn quả non 20 - 45 ngày tuổi, hoặc khi thấy bướm bay nhiều vào ban đêm',
                    'dosage_guide' => 'Pha 1 chai THPRO 550EC (450ml) hoặc Vovatox 600 (450ml) + 1 chai Tegula Ấn Độ 247SC (240ml) hoặc Riegenf USA (240ml) + 1 gói Antracol 70WP (300g) cho 400 lít nước. Phun ướt đều các chùm quả.',
                    'safety_note'  => 'Hơi thuốc xông sâu vào kẽ gai tiêu diệt bướm và ấu trùng sâu non mới nở, Propineb Kẽm Zinc++ giúp da trái xanh bóng, cứng gai chống nấm.',
                    'groups'       => [
                        [
                            'label'                => 'Profenofos xông hơi cực mạnh len lỏi kẽ gai',
                            'primary_pesticide_id' => 185, // THPRO 550EC 450ML (CHAI)
                            'substitute_ids'       => [186, 165], // VOVATOX 600, DRAGON 999
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Lambda-cyhalothrin + Thiamethoxam hạ gục bướm đẻ trứng',
                            'primary_pesticide_id' => 192, // TEGULA ẤN ĐỘ 247SC
                            'substitute_ids'       => [187], // Riegenf USA
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Áo giáp Kẽm Propineb bảo vệ da quả, cứng gai',
                            'primary_pesticide_id' => 7, // Antracol 70WP Bayer
                            'substitute_ids'       => [27], // NOFACOL 700WP
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 3: Phục hồi da trái sáng bóng, làm lành sẹo gai & nuôi quả lớn nhanh không sượng',
                    'badge'        => 'Dưỡng trái bóng gai',
                    'badge_color'  => 'amber',
                    'stage'        => 'Sau khi dập sạch sâu, giai đoạn nuôi quả lớn nhanh, phì trái, chắc múi',
                    'dosage_guide' => 'Pha 1 chai Xanh Um Monyka (500ml) + 1 chai Weyzym-A (100ml) + 1 gói Bự Tổ NPK 21-21-21 TE (1kg) cho 400 lít nước. Phun ướt đều chùm quả và tán lá.',
                    'safety_note'  => 'Cung cấp Axit Amin hữu cơ đạm cá, Tinh chất Rong biển Seaweed, Canxi-Bo chống rụng trái, làm lành sẹo vết chích trên gai, giúp cơm dày béo ngậy.',
                    'groups'       => [
                        [
                            'label'                => 'Axit Amin đạm cá & Tinh chất tảo biển Seaweed',
                            'primary_pesticide_id' => 159, // Xanh Um Monyka
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Enzyme & Canxi-Bo dai cuống, làm lành sẹo gai',
                            'primary_pesticide_id' => 158, // Weyzym-A Multiagro48
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'NPK 21-21-21 + TE nuôi quả lớn nhanh, chắc múi',
                            'primary_pesticide_id' => 564, // BỰ TỔ - NPK 21-21-21 PREMIUM TE
                            'substitute_ids'       => [152], // TANG TRUONG PANAXILUS
                        ],
                    ],
                ],
            ],
        ];

        $disease = Disease::updateOrCreate(
            ['name' => $diseaseData['name']],
            $diseaseData
        );

        // 3. Gắn các cây trồng mẫn cảm: Sầu riêng, Cây có múi, Chanh dây, Cà phê
        $targetCropNames = ['Sầu riêng', 'Cây có múi', 'Chanh dây', 'Cà phê'];
        $linkedCropIds = Crop::whereIn('name', $targetCropNames)->pluck('id')->toArray();
        if (!empty($linkedCropIds)) {
            $disease->crops()->sync($linkedCropIds);
        }

        // 4. Liên kết các thuốc BVTV có sẵn trong kho đặc trị sâu đục trái
        // Emaproza (171, 172), Ledan 95SP (168), Afudan (161), THPRO (185), Vovatox (186), Dragon 999 (165), Tegula (192), Riegenf (187), Ridomil Gold (32), Antracol (7), Xanh Um Monyka (159), Weyzym-A (158), Bu To 21-21-21 (564), Tang Truong Panaxilus (152)
        $targetPesticideIds = [171, 172, 168, 161, 185, 186, 165, 192, 187, 32, 7, 159, 158, 564, 152];
        $validPesticideIds = Pesticide::whereIn('id', $targetPesticideIds)->pluck('id')->toArray();

        if (!empty($validPesticideIds)) {
            $disease->pesticides()->sync($validPesticideIds);
        }
    }
}
