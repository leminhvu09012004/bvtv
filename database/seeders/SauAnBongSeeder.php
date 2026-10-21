<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class SauAnBongSeeder extends Seeder
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

        // 1. Sao chép ảnh thực tế do người dùng cung cấp
        // Ảnh 1: Chùm hoa sầu riêng non bị sâu đục khoét nụ hoa và cuống hoa, đùn phân đen, sâu non màu nâu khoanh đỏ
        // Ảnh 2: Sâu róm nhiều lông (Lymantriidae) đang bò gặm nhấm đài hoa trên ngón tay
        $src1 = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690386123.jpg';
        $filename1 = 'sau-an-bong-1.jpg';
        if (file_exists($src1)) {
            copy($src1, "$destDir/$filename1");
            $savedImages[] = "diseases/$filename1";
        } elseif (file_exists("$destDir/$filename1")) {
            $savedImages[] = "diseases/$filename1";
        }

        $src2 = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690386156.jpg';
        $filename2 = 'sau-an-bong-2.jpg';
        if (file_exists($src2)) {
            copy($src2, "$destDir/$filename2");
            $savedImages[] = "diseases/$filename2";
        } elseif (file_exists("$destDir/$filename2")) {
            $savedImages[] = "diseases/$filename2";
        }

        // 2. Dữ liệu hồ sơ dịch hại chuẩn cho Sâu ăn bông (Sâu ăn hoa & Sâu đục nụ sầu riêng)
        $diseaseData = [
            'name' => 'Sâu Ăn Bông, Sâu Đo & Sâu Róm Ăn Hoa — Thalassodes quadraria & Lymantriidae spp. (Sâu Ăn Hoa Sầu Riêng, Sâu Đục Nụ Hoa & Sâu Đo Cắn Chùm Hoa)',
            'pathogen_type' => 'sau_hai',
            'folder_code' => 'S-02',
            'folder_group' => 'sau_hai',
            'folder_name' => '2 Sâu ăn bông',
            'folder_number' => 2,
            'caunho' => 'Sâu ăn bông = SÂU ĐỤC NỤ ĐÙN PHÂN ĐEN + SÂU RÓM CẮN CÁNH HOA + RỤNG CHÙM BÔNG HÀNG LOẠT. QUY TẮC SỐNG CÒN: Chỉ dùng thuốc dạng SC sữa hoặc WG cốm cực mát hoa, tuyệt đối KHÔNG dùng thuốc EC nóng làm cháy nụ, háp bông, rụng phấn hoa. Trị bằng Chlorfenapyr nano (Emaproza 10SC), Tegula 247SC / Tề Thiên USA (SC sữa) + Áo giáp Kẽm Antracol 70WP + Canxi-Bo CanxiBo EDTA / Weyzym-A dai cuống chống rụng.',
            'symptoms' => "• Phân tích dịch hại chuyên sâu qua 2 ảnh thực tế bạn gửi:\n- Ảnh 1 — Sâu đục nụ & đục cuống bông (Conogethes / Euproctis spp.): Sâu non màu nâu hồng có các chấm khoanh đỏ dọc sống lưng đang ẩn nấp ngay lõi trung tâm của chùm hoa sầu riêng non. Sâu dùng tơ kết dính các cuống nụ hoa lại với nhau để làm tổ, đùn ra từng đống phân đen nhầy nhớt dính chặt vào cuống hoa. Sâu khoét rỗng phần gốc cuống nụ và ăn thủng đáy đài hoa, làm cuống hoa bị tổn thương cơ giới, chuyển sang màu thâm đen, teo tóp và rụng trơ cuống hoa non hàng loạt. Vết thương đùn phân ẩm ướt là cửa ngõ số 1 cho nấm Thán thư (Colletotrichum) và nấm Thối cuống (Phytophthora) xâm nhập gây thối đen toàn bộ chùm bông.\n- Ảnh 2 — Sâu róm ăn hoa (Họ Lymantriidae / Dasychira spp.): Sâu róm có thân hình vằn sọc nâu đen, phủ đầy các chùm lông gai dài tua tủa màu đen trắng. Sâu bò khắp chùm bông gặm nhấm đài hoa, cắn trụi cánh hoa non và cắn cụt các chùm bao phấn, nhụy hoa non. Hoa bị sâu róm cắn phá sẽ bị cụt nhụy, héo khô đài hoa và rụng sạch trước khi đến giai đoạn nở hoa xổ nhụy.\n• Triệu chứng trên toàn tán cây:\n- Vào ban đêm bướm mẹ bay rộ đẻ trứng li ti vào các kẽ cuống hoa; ban ngày sâu non nở ra ẩn nấp kỹ trong kẽ chùm hoa rậm rạp.\n- Dưới gốc bồn cây xuất hiện các hạt phân sâu đen li ti rụng rải rác cùng hàng loạt nụ hoa non bị rụng trơ cuống.",
            'symptoms_detail' => [
                'la' => 'Lá non gần chùm hoa có thể bị sâu cắn thủng lỗ hoặc khuyết mép lá; sâu non có thể ăn lan sang các chồi hoa và cơi đọt non mới nhú.',
                'canh_than' => 'Cuống chùm hoa gắn vào dạ cành bị cắn nham nhở, xì nhựa thâm đen; bướm mẹ thường tìm các kẽ nứt của vỏ cành gần chùm bông để đẻ trứng.',
                'goc_re' => 'Gốc rễ cây bình thường; dưới mặt bồn rụng đầy xác nụ hoa thâm đen và phân sâu đen li ti.',
                'qua' => 'Hoa bị sâu cắn đứt cuống và cụt nhụy rụng hàng loạt làm giảm 70 - 90% tỷ lệ đậu trái non; nếu đậu trái thì trái non bị dị hình, méo mó, sẹo gai sâu.',
            ],
            'prevention' => "1. Tỉa thưa chùm bông thông thoáng: Không để chùm bông quá dày đặc. Tỉa bỏ các chùm hoa đầu cành nhỏ, hoa sát thân chính, chỉ giữ lại các chùm bông mập khỏe phân bố đều ở vị trí dạ cành mang quả lý tưởng (cách gốc cành 0.5 - 1m). Chùm bông thông thoáng sâu không có nơi ẩn nấp.\n2. Bẫy đèn & bẫy bả chua ngọt: Treo đèn bẫy côn trùng vào ban đêm giai đoạn hoa phát triển để bắt bướm đêm trước khi chúng đẻ trứng vào cuống hoa.\n3. Thăm vườn định kỳ 2 - 3 ngày/lần: Kiểm tra kỹ các kẽ hở giữa các cuống hoa trong chùm vào buổi sáng sớm; nếu phát hiện có mạng tơ và phân sâu li ti phải xử lý dập dịch ngay trước khi sâu ăn sâu vào lõi nụ.\n4. Bảo tồn thiên địch & dùng chế phẩm sinh học: Bảo vệ ong ký sinh, bọ rùa; định kỳ phun nấm ký sinh vi sinh BT (Bacillus thuringiensis) giai đoạn hoa chuẩn bị xổ nhụy.",
            'treatment' => "1. NGUYÊN TẮC BẢO VỆ HOA SẦU RIÊNG — ĐIỀU KIỆN SỐNG CÒN:\n• TUYỆT ĐỐI KHÔNG DÙNG THUỐC NÓNG DẠNG EC (nhũ dầu đậm đặc dung môi thơm) hoặc thuốc có tính xông hơi cay nồng cực mạnh trong giai đoạn nuôi hoa và xổ nhụy! Thuốc EC làm háp bông, cháy cánh hoa, khô hạt phấn, rụng hoa hàng loạt và xua đuổi ong thụ phấn.\n• BẮT BUỘC PHẢI DÙNG DẠNG SC (huyền phù sữa mát hoa), WG (hạt cốm tan hoàn toàn mát hoa), SP hoặc thuốc sinh học.\n• THỜI ĐIỂM PHUN: Phun ướt đều chùm hoa vào sáng sớm (trước 8 giờ) hoặc chiều mát (sau 16 giờ). TUYỆT ĐỐI TRÁNH PHUN lúc hoa đang phơi màu xổ nhụy (từ 18h đến 22h đêm).\n• KẾT HỢP 3 TRONG 1 (TANK-MIX): Thuốc trừ sâu mát hoa + Thuốc trừ nấm thán thư thối bông (không nóng) + Dinh dưỡng Canxi-Bo hữu cơ dẻo dai cuống hoa.\n\n2. Phác đồ hóa học đặc trị luân phiên:\n• Nhóm Pyrrole + Avermectin cực mát hoa (IRAC 13 + IRAC 6): Emaproza 10SC Nano Sâu Rầy Rệp (Chlorfenapyr + Emamectin benzoate). Dạng SC nano cực mát hoa, thấm sâu nhanh vào kẽ cuống nụ, phá vỡ quá trình tạo năng lượng ty thể của sâu, sâu trúng thuốc ngưng ăn lập tức và chết sau vài giờ.\n• Nhóm Pyrethroid + Neonicotinoid dạng SC sữa mát cây (IRAC 3A + IRAC 4A): Tegula Ấn Độ 247SC (Lambda-cyhalothrin + Thiamethoxam), Tề Thiên USA (Dinotefuran + Spirotetramat). Dạng SC sữa không gây nóng hoa, tác động tiếp xúc vị độc cực nhanh, hạ gục sâu đo, sâu róm và xua đuổi bướm mẹ.\n• Nhóm Nereistoxin lưu dẫn vị độc (IRAC 14): Ledan 95SP (Cartap Hydrochloride). Thấm sâu mạnh, diệt triệt để ấu trùng sâu đục nụ ẩn nấp bên trong kẽ hoa.\n• Phòng trừ nấm thán thư & thối bông kết hợp: Antracol 70WP Bayer (Propineb + Zinc++ kẽm tinh khiết tạo áo giáp mát hoa, làm lành vết sâu cắn), Alien An Nông 800WP (Fosetyl-Aluminium 800g/kg lưu dẫn 2 chiều mát bông).\n• Dinh dưỡng dẻo dai cuống hoa & tăng sức sống hạt phấn: CanxiBo EDTA, Weyzym-A Multiagro48, Tăng Trưởng Panaxilus giúp cuống hoa dẻo dai chống rụng hoa sinh lý và rụng hoa do vết thương sâu cắn.",
            'chemical_groups' => 'Chlorfenapyr + Emamectin (Emaproza 10SC Nano - IRAC 13 + IRAC 6), Thiamethoxam + Lambda-cyhalothrin (Tegula 247SC - IRAC 4A + IRAC 3A), Dinotefuran + Spirotetramat (Tề Thiên USA SC - IRAC 4A + IRAC 23), Cartap Hydrochloride (Ledan 95SP - IRAC 14), Propineb + Kẽm Zinc++ (Antracol 70WP - FRAC M03), Fosetyl-Aluminium (Alien 800WP / Aliette - FRAC P07), Canxi-Bo EDTA & Enzyme hữu cơ',
            'notes' => "Lưu ý thực tế từ kỹ sư BVTV:\n• Sâu ăn bông sầu riêng xuất hiện nhiều nhất vào các đợt cơi hoa phát triển gặp thời tiết hanh khô ban ngày, se lạnh ban đêm.\n• Giai đoạn hoa nhú mắt cua đến hoa dài 3-5cm là thời điểm vàng để dập dịch sâu ăn bông hiệu quả nhất, trước khi chùm hoa khép kín.\n• Khi hoa bắt đầu nứt nanh chuẩn bị xổ nhụy (trước khi nở 2-3 ngày), phải phun dọn vườn sạch sâu rầy bằng thuốc sữa mát hoa, sau đó NGỪNG TOÀN BỘ PHUN XỊT trong suốt 7-10 ngày hoa xổ nhụy rộ để côn trùng và gió thụ phấn tự nhiên cho hoa.\n• Tài liệu tham khảo: Viện Cây ăn quả Miền Nam (SOFRI), Cục Bảo vệ Thực vật, Trung tâm Khuyến nông Quốc gia.",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Sầu riêng, Cây có múi, Chanh dây, Cà phê, Xoài, Bơ, Nhãn, Vải',
            'treatment_plans' => [
                [
                    'title'        => 'Phác đồ 1: Dập dịch Sâu đục nụ & Sâu róm ăn hoa — Dạng SC sữa cực mát bông, sát trùng vết cắn & Dai cuống chống rụng (Emaproza 10SC Nano + Antracol 70WP + CanxiBo EDTA)',
                    'badge'        => 'Dập dịch mát hoa số 1',
                    'badge_color'  => 'rose',
                    'stage'        => 'Giai đoạn nụ hoa sầu riêng phát triển (từ mắt cua đến nụ hoa 3 - 5cm), phát hiện có tơ sâu đùn phân đen hoặc sâu róm cắn phá cánh hoa',
                    'dosage_guide' => 'Pha 1 chai Emaproza 10SC Nano (240ml) + 1 gói Antracol 70WP Bayer (300g) + 1 chai CanxiBo EDTA (250ml) cho 400 lít nước (2 phuy). Phun chùm đều trực tiếp vào các chùm bông và mặt dưới dạ cành.',
                    'safety_note'  => 'Chlorfenapyr nano dạng SC cực mát bông không gây nóng rụng nụ, Propineb Kẽm Zinc++ tạo lớp áo giáp sát trùng vết sâu cắn ngừa nấm thán thư thối bông, Canxi-Bo giúp cuống hoa dẻo dai chống rụng hoa non. Phun vào sáng sớm hoặc chiều mát.',
                    'groups'       => [
                        [
                            'label'                => 'Chlorfenapyr + Emamectin dạng SC nano siêu mát hoa, thấm sâu diệt sâu đục nụ',
                            'primary_pesticide_id' => 171, // Emaproza 10SC Nano Sâu Rầy Rệp 130
                            'substitute_ids'       => [172, 168], // Emaproza 10SC 160, LEDAN 95SP
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Áo giáp Kẽm Propineb Zinc++ bảo vệ nụ hoa, sát khuẩn chống thán thư thối bông',
                            'primary_pesticide_id' => 7, // Antracol 70WP Bayer
                            'substitute_ids'       => [27, 32], // NOFACOL 700WP, Ridomil Gold 68WG
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Canxi-Bo hữu cơ dẻo dai cuống hoa, chống rụng hoa non & tăng sức sống hạt phấn',
                            'primary_pesticide_id' => 80, // CanxiBo EDTA
                            'substitute_ids'       => [158], // WEYZYM-A MULTIAGRO48
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 2: Hạ gục sâu đo, sâu róm & Xua đuổi bướm mẹ đẻ trứng — Dạng SC sữa mát chùm nụ (Tegula Ấn Độ 247SC / Tề Thiên USA + Alien An Nông 800WP + Weyzym-A Multiagro48)',
                    'badge'        => 'Hạ gục bướm & Sâu đo',
                    'badge_color'  => 'sky',
                    'stage'        => 'Phun luân phiên cách lần 1 từ 5 - 7 ngày, hoặc giai đoạn chùm hoa chuẩn bị phân hóa tiểu nhụy khi thấy nhiều bướm đêm bay trong vườn',
                    'dosage_guide' => 'Pha 1 chai Tegula Ấn Độ 247SC (240ml) hoặc Tề Thiên USA (450ml) + 1 gói Alien An Nông 800WP (100g) + 1 chai Weyzym-A Multiagro48 (100ml) cho 400 lít nước. Phun ướt đẫm các chùm bông và tán lá quanh chùm hoa.',
                    'safety_note'  => 'Huyền phù SC sữa tiếp xúc vị độc hạ gục tức thì sâu róm và sâu đo ngụy trang, xua đuổi bướm mẹ; Fosetyl-Al lưu dẫn 2 chiều phòng ngừa thối khô nụ hoa; Weyzym-A cung cấp Enzyme và vi lượng chống teo nụ.',
                    'groups'       => [
                        [
                            'label'                => 'Lambda-cyhalothrin + Thiamethoxam dạng SC sữa hạ gục nhanh sâu róm, xua đuổi bướm đêm',
                            'primary_pesticide_id' => 192, // TEGULA ẤN ĐỘ 247SC
                            'substitute_ids'       => [188, 187], // Tề Thiên USA, Riegenf USA
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Fosetyl-Aluminium kích kháng lưu dẫn 2 chiều đặc trị nấm thán thư & thối cuống bông',
                            'primary_pesticide_id' => 4, // Alien An Nông 800WP
                            'substitute_ids'       => [2, 6], // ALIETTE 100g, ANLIEN ANNONG 400SC
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Enzyme hữu cơ & Vi lượng chống teo nụ, nuôi bông mập khỏe',
                            'primary_pesticide_id' => 158, // WEYZYM-A MULTIAGRO48
                            'substitute_ids'       => [111], // MgO - Kẽm EDTA
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 3: Dưỡng hoa mập nụ, sáng bông, tăng hạt phấn & Rửa chùm hoa trước xổ nhụy đồng loạt',
                    'badge'        => 'Dưỡng bông sáng nụ',
                    'badge_color'  => 'amber',
                    'stage'        => 'Phun trước khi hoa sầu riêng bung nở xổ nhụy 3 - 5 ngày để dọn sạch nấm sâu, chuẩn bị bước vào giai đoạn thụ phấn nở hoa hoàn toàn',
                    'dosage_guide' => 'Pha 1 chai Xanh Um Monyka (500ml) + 1 chai CanxiBo EDTA (250ml) + 1 gói Antracol 70WP Bayer (300g) cho 400 lít nước. Phun sương nhẹ đều chùm hoa vào buổi chiều mát.',
                    'safety_note'  => 'Axit Amin đạm cá và Rong biển Seaweed giúp cuống hoa xanh mướt, hạt phấn khỏe mạnh thụ phấn đậu trái cực cao; Áo giáp kẽm làm sạch rong rêu nấm mốc trên đài hoa. Tuyệt đối KHÔNG phun thuốc hóa học khi hoa đang nở rộ.',
                    'groups'       => [
                        [
                            'label'                => 'Amino Acid đạm cá & Tinh chất rong biển mát hoa, kích hoạt hạt phấn dồi dào',
                            'primary_pesticide_id' => 159, // Xanh Um Monyka
                            'substitute_ids'       => [152], // TANG TRUONG PANAXILUS
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Canxi-Bo tinh khiết chống rụng đài hoa, tăng độ bám dính hạt phấn khi xổ nhụy',
                            'primary_pesticide_id' => 80, // CanxiBo EDTA
                            'substitute_ids'       => [158], // WEYZYM-A MULTIAGRO48
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Áo giáp Kẽm làm sạch chùm hoa, chống đen cuống nụ trước xổ nhụy',
                            'primary_pesticide_id' => 7, // Antracol 70WP Bayer
                            'substitute_ids'       => [27], // NOFACOL 700WP
                        ],
                    ],
                ],
            ],
        ];

        $disease = Disease::updateOrCreate(
            ['folder_code' => 'S-02'],
            $diseaseData
        );

        // 3. Gắn các cây trồng mẫn cảm: Sầu riêng, Cây có múi, Chanh dây, Cà phê
        $targetCropNames = ['Sầu riêng', 'Cây có múi', 'Chanh dây', 'Cà phê'];
        $linkedCropIds = Crop::whereIn('name', $targetCropNames)->pluck('id')->toArray();
        if (!empty($linkedCropIds)) {
            $disease->crops()->sync($linkedCropIds);
        }

        // 4. Liên kết các thuốc BVTV đặc hiệu trong kho dữ liệu
        // Emaproza 171, 172, Ledan 168, Tegula 192, Te Thien 188, Riegenf 187, Antracol 7, Nofacol 27, Alien 4, Aliette 2, CanxiBo 80, Weyzym-A 158, Xanh Um Monyka 159, Panaxilus 152
        $targetPesticideIds = [171, 172, 168, 192, 188, 187, 7, 27, 4, 2, 6, 80, 158, 159, 152, 111, 32];
        $validPesticideIds = Pesticide::whereIn('id', $targetPesticideIds)->pluck('id')->toArray();

        if (!empty($validPesticideIds)) {
            $disease->pesticides()->sync($validPesticideIds);
        }
    }
}
