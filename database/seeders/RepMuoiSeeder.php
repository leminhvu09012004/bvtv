<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class RepMuoiSeeder extends Seeder
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
        // Nếu có ảnh trong hệ thống
        if (file_exists("$destDir/rep-muoi-1.jpg")) {
            $savedImages[] = 'diseases/rep-muoi-1.jpg';
        } elseif (file_exists("$destDir/rep-sap-1.jpg")) {
            $savedImages[] = 'diseases/rep-sap-1.jpg';
        }

        // 2. Dữ liệu hồ sơ dịch hại chuẩn cho Rệp muội, rệp mềm (Aphids)
        $diseaseData = [
            'name' => 'Rệp Muội, Rệp Mềm & Rệp Chích Hút — Aphididae spp. (Aphis gossypii & Toxoptera aurantii — Rệp Muội Đen, Rệp Muội Vàng Hại Đọt Non & Chùm Bông)',
            'pathogen_type' => 'chich_hut',
            'folder_code' => 'CH-03',
            'folder_group' => 'chich_hut',
            'folder_name' => '3-Rệp muội, rệp mềm (rệp chích hút khác)',
            'folder_number' => 3,
            'caunho' => 'RỆP MUỘI (RỆP MỀM) = BÁM DÀY ĐẶC ĐỌT NON + TIẾT MẬT NGỌT ĐEN BỒ HÓNG + XOĂN TÍT LÁ NON (môi giới truyền virus khảm lá). Trị bằng Dinotefuran + Spirotetramat (Tề Thiên USA dạng sữa), Thiamethoxam + Lambda (Tegula 247SC / Riegenf USA), Chlorfenapyr nano (Emaproza) + Rửa lá sạch muội bồ hóng bằng Antracol 70WP.',
            'symptoms' => "• Đặc điểm hình thái: Cơ thể rệp muội hình quả lê nhỏ (1.5 - 2.5mm), mềm yếu, có màu xanh đen, nâu đen hoặc vàng nhạt. Đuôi có 2 ống sáp nhỏ nhô ra phía sau. Rệp thường sống thành từng cụm bầy đàn đông đúc hàng trăm đến hàng ngàn con bám dày đặc ở mặt dưới lá non, cơi đọt, nụ hoa và cuống quả non.\n• Triệu chứng gây hại:\n- Cả rệp non và rệp trưởng thành đều dùng vòi chích hút dịch nhựa cây làm đọt non bị chùn lại, lá non bị cong queo biến dạng, phiến lá nhăn nheo co rút gân lá.\n- Rệp muội bài tiết ra chất mật ngọt dính ướt, thu hút đàn kiến đen / kiến lửa đến cộng sinh và tạo môi trường lý tưởng cho nấm bồ hóng (Capnodium) phát triển phủ một lớp muội đen xì trên mặt lá và quả, làm giảm nghiêm trọng khả năng quang hợp của cây.\n- Nguy hiểm nhất: Rệp muội là vector môi giới số 1 truyền các loại virus nguy hiểm như virus khảm lá, virus vàng lùn, virus cứng trái chanh dây (PWV) và bệnh Tristeza trên cây có múi.",
            'symptoms_detail' => [
                'la' => 'Mặt dưới lá non bám dày đặc rệp muội màu xanh đen hoặc vàng nâu; mép lá quăn queo co rúm; bề mặt lá phủ lớp muội đen bồ hóng như nhọ nồi.',
                'canh_than' => 'Ngọn non và chồi vượt bị chùn đọt, teo tóp đốt ngắn lại, đàn kiến bò lên xuống liên tục trên thân cành.',
                'goc_re' => 'Không gây hại trực tiếp dưới bộ rễ.',
                'qua' => 'Chùm hoa và quả non bị chích hút teo tóp, dễ rụng non; vỏ quả bị phủ muội đen bồ hóng làm quả lem luốc mất giá trị thương phẩm.',
            ],
            'prevention' => "1. Tiêu diệt đàn kiến cộng sinh quanh gốc cây (dùng bả kiến hoặc rải thuốc hạt gốc Cartap/Fipronil).\n2. Cắt tỉa cành thông thoáng, tiêu hủy các cơi đọt non bị nhiễm rệp nặng.\n3. Bảo tồn thiên địch tự nhiên: Bọ rùa, nhện bắt mồi, ruồi ăn rệp (Syrphidae) ăn rệp muội cực mạnh.\n4. Phun nước áp lực cao vào buổi sáng rửa trôi đàn rệp trên các chồi non.",
            'treatment' => "1. Nguyên tắc: Sử dụng thuốc trừ chích hút lưu dẫn mạnh dạng SC sữa hoặc WG cốm mát cây, kết hợp diệt nấm muội đen bồ hóng.\n2. Hoạt chất đặc trị: Thiamethoxam, Dinotefuran, Spirotetramat, Lambda-cyhalothrin, Chlorfenapyr.\n3. Kết hợp áo giáp Kẽm Propineb (Antracol 70WP) để rửa sạch lớp muội đen bồ hóng trên lá và quả non.",
            'chemical_groups' => 'Thiamethoxam + Lambda-cyhalothrin (Tegula 247SC / Riegenf USA), Dinotefuran + Spirotetramat (Tề Thiên USA), Chlorfenapyr (Emaproza 10SC), Cartap (Ledan 95SP), Propineb + Kẽm (Antracol 70WP)',
            'notes' => "Lưu ý chuyên môn:\n• Rệp muội sinh sản đơn tính vô tính cực nhanh trong điều kiện mát mẻ, khô ráo.\n• Khi mật độ quá cao, rệp sẽ sinh ra thế hệ có cánh để bay phát tán sang các cây khỏe mạnh khác.\n• Tài liệu tham khảo: Cục Bảo vệ Thực vật, SOFRI.",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Cây có múi, Chanh dây, Sầu riêng, Cà chua & Họ cà, Dưa leo & Bầu bí, Cà phê',
            'treatment_plans' => [
                [
                    'title'        => 'Phác đồ 1: Hạ gục tức thì đàn rệp muội & Lưu dẫn 2 chiều bảo vệ cơi đọt non (Tề Thiên USA + Tegula 247SC + CanxiBo EDTA)',
                    'badge'        => 'Dập dịch rệp muội',
                    'badge_color'  => 'rose',
                    'stage'        => 'Khi phát hiện đàn rệp muội bám dày đặc ở ngọn đọt non hoặc chùm hoa non',
                    'dosage_guide' => 'Pha 1 chai Tề Thiên USA (450ml) + 1 chai Tegula Ấn Độ 247SC (240ml) + 1 chai CanxiBo EDTA (250ml) cho 400 lít nước. Phun ướt đẫm mặt dưới lá non và các chùm ngọn.',
                    'safety_note'  => 'Dạng SC sữa mát cây hạ gục nhanh đàn rệp, lưu dẫn 2 chiều diệt rệp ẩn sâu trong kẽ búp và làm ung trứng rệp.',
                    'groups'       => [
                        [
                            'label'                => 'Dinotefuran + Spirotetramat lưu dẫn 2 chiều đặc trị rệp chích hút',
                            'primary_pesticide_id' => 188, // Tề Thiên USA
                            'substitute_ids'       => [187], // Riegenf USA
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Lambda + Thiamethoxam hạ gục nhanh đàn rệp muội',
                            'primary_pesticide_id' => 192, // TEGULA ẤN ĐỘ 247SC
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Canxi-Bo giúp đọt non dẻo dai vươn dài, chống xoăn mép lá',
                            'primary_pesticide_id' => 80, // CanxiBo EDTA
                            'substitute_ids'       => [158], // WEYZYM-A MULTIAGRO48
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 2: Dập rệp kháng thuốc & Rửa sạch muội đen bồ hóng trên phiến lá và quả non (Emaproza 10SC + Antracol 70WP)',
                    'badge'        => 'Rửa sạch bồ hóng',
                    'badge_color'  => 'sky',
                    'stage'        => 'Sau khi dập rệp 4 - 6 ngày hoặc khi tán lá bị đen bẩn muội than bồ hóng',
                    'dosage_guide' => 'Pha 1 chai Emaproza 10SC Nano (240ml) + 1 gói Antracol 70WP Bayer (300g) cho 400 lít nước. Phun xoáy đều tán lá và chùm quả non.',
                    'safety_note'  => 'Chlorfenapyr nano diệt sạch các ổ rệp muội sót lại; Kẽm Zinc++ làm sạch lớp nấm muội đen bồ hóng, giúp lá sáng bóng quang hợp khỏe.',
                    'groups'       => [
                        [
                            'label'                => 'Chlorfenapyr + Emamectin nano diệt sạch rệp muội kháng thuốc',
                            'primary_pesticide_id' => 171, // Emaproza 10SC Nano
                            'substitute_ids'       => [172, 168], // Emaproza 160, LEDAN 95SP
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Áo giáp Kẽm Propineb tẩy sạch muội đen bồ hóng, làm sáng bóng lá quả',
                            'primary_pesticide_id' => 7, // Antracol 70WP Bayer
                            'substitute_ids'       => [27], // NOFACOL 700WP
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 3: Phục hồi đọt non xanh dày & Kích hoạt phiến lá bung xòe trở lại sau dịch hại',
                    'badge'        => 'Phục hồi đọt xanh dày',
                    'badge_color'  => 'amber',
                    'stage'        => 'Khi vườn đã sạch rệp và nấm muội đen, giai đoạn lá non mở phiến',
                    'dosage_guide' => 'Pha 1 chai Xanh Um Monyka (500ml) + 1 chai Weyzym-A Multiagro48 (100ml) cho 400 lít nước. Phun ướt đều tán lá.',
                    'safety_note'  => 'Axit Amin đạm cá và Rong biển giải độc cho cây, kích thích cơi đọt phát triển nhanh, lá xanh dày bóng mượt.',
                    'groups'       => [
                        [
                            'label'                => 'Amino Acid đạm cá & Tinh chất rong biển giải độc, nuôi đọt mập khỏe',
                            'primary_pesticide_id' => 159, // Xanh Um Monyka
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Enzyme sinh học & Canxi-Bo dẻo dai tế bào lá, chống chùn ngọn',
                            'primary_pesticide_id' => 158, // WEYZYM-A MULTIAGRO48
                            'substitute_ids'       => [80], // CanxiBo EDTA
                        ],
                    ],
                ],
            ],
        ];

        $disease = Disease::updateOrCreate(
            ['folder_code' => 'CH-03'],
            $diseaseData
        );

        $targetCropNames = ['Cây có múi', 'Chanh dây', 'Sầu riêng', 'Cà chua & Họ cà', 'Dưa leo & Bầu bí', 'Cà phê'];
        $linkedCropIds = Crop::whereIn('name', $targetCropNames)->pluck('id')->toArray();
        if (!empty($linkedCropIds)) {
            $disease->crops()->sync($linkedCropIds);
        }

        $targetPesticideIds = [188, 187, 192, 171, 172, 168, 7, 27, 80, 158, 159];
        $validPesticideIds = Pesticide::whereIn('id', $targetPesticideIds)->pluck('id')->toArray();
        if (!empty($validPesticideIds)) {
            $disease->pesticides()->sync($validPesticideIds);
        }
    }
}
