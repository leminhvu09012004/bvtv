<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class DomRongTaoDoSeeder extends Seeder
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

        // 1. Sao chép 2 ảnh người dùng vừa cung cấp
        $userMedia1 = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791619508807.jpg';
        $userMedia2 = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791619508827.jpg';

        $destFile1 = 'dom-rong-1.jpg';
        $destFile2 = 'dom-rong-2.jpg';

        if (file_exists($userMedia1)) {
            copy($userMedia1, "$destDir/$destFile1");
            $savedImages[] = "diseases/$destFile1";
        }
        if (file_exists($userMedia2)) {
            copy($userMedia2, "$destDir/$destFile2");
            $savedImages[] = "diseases/$destFile2";
        }

        // Ảnh bổ sung số 3 nếu đã tải
        if (file_exists("$destDir/dom-rong-3.jpg") && filesize("$destDir/dom-rong-3.jpg") > 5000) {
            $savedImages[] = 'diseases/dom-rong-3.jpg';
        }

        // 2. Dữ liệu hồ sơ bệnh học chuẩn cho Đốm Rong / Tảo Đỏ
        $diseaseData = [
            'name' => 'Bệnh Đốm Rong (Tảo Đỏ / Rêu Rong Ký Sinh Thân & Lá — Cephaleuros virescens)',
            'pathogen_type' => 'vi_khuan', // Trong hệ thống, loại vi_khuan có label là "Vi khuẩn & Tảo" 🧪
            'folder_code' => 'B-12',
            'folder_group' => 'nam_benh',
            'folder_name' => '12-Đốm rong - tảo đỏ',
            'folder_number' => 12,
            'caunho' => 'Đốm Rong Tảo Đỏ = Đốm nhung lông mịn màu vàng cam đến gỉ sắt nổi gồ trên mặt lá & mảng xù xì nứt vỏ thân cành. Tảo Cephaleuros virescens ưa ẩm rậm rạp; dùng gốc Đồng (Copper) rửa vườn + quét vôi thân + tỉa cành thông thoáng.',
            'symptoms' => "• Trên lá: Vết bệnh ban đầu là những chấm tròn nhỏ (3–5 mm) màu xanh xám, sau đó nhô gồ ghề lên bề mặt lá như một lớp nhung lông mịn màu vàng cam hoặc đỏ nâu gỉ sắt đặc trưng. Vết đốm bám chặt dọc theo gân chính và phiến lá già hoặc bánh tẻ. Khi vết bệnh già đi chuyển sang màu nâu xám, ăn sâu làm thủng rách tế bào biểu bì, làm phiến lá khô giòn, giảm khả năng quang hợp nghiêm trọng và rụng sớm.\n• Trên thân và cành: Rất nguy hiểm trên các cành mang trái và thân chính sầu riêng, cây có múi, cà phê. Tảo ký sinh lan rộng thành từng mảng loang lổ sần sùi màu đỏ cam hoặc xanh rêu gỉ sắt. Lớp tảo ăn sâu vào vỏ làm vỏ cây nứt nẻ, chảy mủ, teo tóp mạch dẫn, cành khô giòn dễ gãy tét khi mang trái nặng hoặc gặp gió bão lớn.\n• Trên quả: Đôi khi các đốm nhung xám cam bám lên vỏ trái non và trái bánh tẻ làm vỏ sần sùi, nám trái, mất giá trị thương phẩm xuất khẩu.",
            'symptoms_detail' => [
                'la' => 'Đốm nhung tròn nổi cộm trên bề mặt lá màu cam sáng hoặc đỏ gỉ sắt; lông tơ mịn của sợi tảo; khi già chuyển màu xám đen, lá bị khô giòn từng đốm và rụng sớm.',
                'canh_than' => 'Mảng nhung xù xì màu cam đỏ bám quanh thân và cành nhánh; ăn sâu làm nứt toác vỏ cây, cành bị chai sần teo tóp, xì mủ và khô cành chết ngược.',
                'goc_re' => 'Gốc cây ẩm thấp rậm rạp bám đầy rêu mốc và rong tảo xanh đỏ, cản trở hô hấp qua vỏ gốc và tạo điều kiện cho nấm Phytophthora tấn công cổ rễ.',
                'qua' => 'Vỏ trái non bị đốm tảo xám gỉ sắt bám sần sùi, làm da trái chai nám, méo mó và mất phẩm cấp.',
            ],
            'prevention' => "1. Tỉa cành tạo tán thông thoáng: Thường xuyên cắt tỉa bỏ cành tăm, cành sâu bệnh, cành mọc sát mặt đất để ánh nắng chiếu xuyên vào thân và tán lá. Tảo Cephaleuros virescens chỉ phát triển mạnh ở những nơi thiếu ánh sáng và ẩm độ cao.\n2. Quét vôi hoặc quét thuốc gốc Đồng vào thân cành: Hàng năm sau khi thu hoạch quả, tiến hành cạo sạch lớp rêu mốc trên thân chính và các cành cấp 1, sau đó dùng chổi quét dung dịch vôi tôi + đồng (Boóc-đô) hoặc vôi hòa tinh thể đồng để sát khuẩn và ngăn tảo bám lại.\n3. Thoát nước & Quản lý vườn: Đào rãnh thoát nước không để ẩm đọng lâu ngày quanh gốc trong mùa mưa dầm ở Tây Nguyên và Nam Bộ.\n4. Bón phân cân đối: Tăng cường bón Phân hữu cơ hoai mục, bổ sung Canxi, Silic, Kali để làm cứng dày lớp cutin biểu bì lá và vỏ cây, hạn chế bón thừa đạm.",
            'treatment' => "1. NGUYÊN TẮC ĐẶC TRỊ ĐỐM RONG TẢO ĐỎ:\n• Tảo Cephaleuros virescens là một loài tảo lục ký sinh, KHÔNG PHẢI NẤM HẠI THÔNG THƯỜNG. Do đó các loại thuốc trừ nấm phổ thông (như Mancozeb đơn thuần, Validamycin...) ít có hiệu quả diệt tảo.\n• HOẠT CHẤT GỐC ĐỒNG (COPPER) LÀ KHẮC TINH SỐ 1 của tảo đỏ và rong rêu!\n\n2. Phác đồ hóa học đặc trị tảo đỏ & đốm rong:\n• Nhóm Hợp chất Đồng (FRAC M01): Copper Hydroxide, Copper Oxychloride, Nano Đồng, Cuprous Oxide, Bordeaux. Phun ướt đẫm hai mặt lá và các cành bị bám mảng tảo đỏ. Ion Cu2+ sẽ làm biến tính protein tế bào tảo, khiến lớp nhung cam khô cháy và tự bong tróc sau vài ngày.\n• Phun kết hợp Azoxystrobin + Tebuconazole (Tebaz 400SC): Vừa triệt tiêu nấm thán thư (Colletotrichum) bội nhiễm vào các vết nứt vỏ do tảo gây ra, vừa kích hoạt tính kháng cây trồng.\n• Sử dụng hoạt chất thảo mộc Anacardic Acid (Amtech 100EW): Tẩy sạch mảng bám rong rêu sinh học trên bề mặt lá và vỏ thân, an toàn cho hoa và quả non.\n\n3. Phục hồi cơi đọt và bộ lá sau khi tẩy sạch tảo:\n• Phun vi lượng Chelate Kẽm - Đồng (Tang Truong Panaxilus) và phân bón lá hữu cơ Rong biển/Amino (Xanh Um Monyka, Weyzym-A) giúp lá xanh dày bóng mượt, tái tạo tầng cutin mới.",
            'chemical_groups' => 'Copper Hydroxide / Copper Oxychloride / Cuprous Oxide (Đồng diệt tảo & nấm tiếp xúc - FRAC M01), Azoxystrobin / Tebuconazole (Strobilurin & Triazole trừ nấm bội nhiễm - FRAC 11 + FRAC 3), Anacardic Acid (Hoạt chất thảo mộc tẩy rong rêu & khuẩn - Amtech 100EW), Bordeaux mixture (Boóc-đô quét thân cành), Amino Acid & Vi lượng Chelate Đồng/Kẽm',
            'notes' => "Lưu ý thực tế từ kỹ sư BVTV:\n• Không phun thuốc gốc Đồng vào lúc trời nắng gắt hoặc đang giai đoạn xổ nhụy thụ phấn, tránh làm nóng bông và thui hoa.\n• Đối với các vết đốm rong trên cành già và thân chính: Pha thuốc gốc Đồng hoặc vôi quét ở nồng độ đậm đặc, dùng cọ quét trực tiếp lên các mảng tảo đỏ để đạt hiệu quả diệt triệt để nhất.\n• Tài liệu tham khảo: Viện Cây ăn quả Miền Nam (SOFRI), Trung tâm Bảo vệ Thực vật Phía Nam, Nông Nghiệp Tây Nguyên.",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Sầu riêng, Cây có múi, Cà phê, Hồ tiêu',
            'treatment_plans' => [
                [
                    'title'        => 'Phác đồ 1: Đặc trị Tảo Đỏ & Đốm Rong trên lá & cành non (Đồng Chelate + Trừ nấm bội nhiễm)',
                    'badge'        => 'Đặc trị dứt điểm',
                    'badge_color'  => 'emerald',
                    'stage'        => 'Khi vết đốm nhung màu cam/gỉ sắt xuất hiện trên phiến lá hoặc cành mang trái',
                    'dosage_guide' => 'Pha 1 chai Đồng Xanh Mekong Agro (500ml) + 1 chai Tebaz 400SC (250ml) cho 400 - 500 lít nước. Phun xoáy đều 2 mặt lá và cành tán.',
                    'safety_note'  => 'Ion Đồng Cu2+ chelate làm khô giòn tế bào tảo đỏ sau 3-5 ngày kết hợp Azoxystrobin + Tebuconazole dập nấm thán thư ăn theo vết nứt.',
                    'groups'       => [
                        [
                            'label'                => 'Gốc Đồng sát khuẩn & diệt tảo đỏ tiếp xúc cực mạnh',
                            'primary_pesticide_id' => 17, // Đồng Xanh Mekong Agro
                            'substitute_label'     => 'Hoặc thay thế bằng thuốc gốc Đồng tương đương:',
                            'substitute_ids'       => [12, 28], // COC 85, NORSHIELD 86.2WG
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Trừ nấm thán thư & bảo vệ mô vỏ cành',
                            'primary_pesticide_id' => 190, // TEBAZ 400SC
                            'substitute_label'     => 'Hoặc thay thế bằng:',
                            'substitute_ids'       => [193], // BINHTAXYL 25EC
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Dưỡng xanh dày bóng lá, tái tạo biểu bì cutin mới',
                            'primary_pesticide_id' => 159, // Xanh Um Monyka
                            'substitute_label'     => 'Hoặc vi lượng chelate phục hồi:',
                            'substitute_ids'       => [152, 158], // TANG TRUONG PANAXILUS, WEYZYM-A
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 2: Tẩy sạch rong rêu sinh học an toàn cho bông & quả non',
                    'badge'        => 'Sinh học an toàn',
                    'badge_color'  => 'blue',
                    'stage'        => 'Giai đoạn cây đang nhú mắt cua, làm bông, nuôi trái hoặc vườn canh tác an toàn',
                    'dosage_guide' => 'Pha 1 chai Amtech 100EW (500ml) + 1 chai RUA CANH MONYKA (550g) cho 400 lít nước. Phun ướt đẫm các cành bị mảng bám.',
                    'safety_note'  => 'Hoạt chất thảo mộc Anacardic Acid tẩy sạch mảng bám rong rêu mốc mà hoàn toàn không nóng bông, không gây nám trái non.',
                    'groups'       => [
                        [
                            'label'                => 'Thảo mộc tẩy rong rêu mảng bám sinh học',
                            'primary_pesticide_id' => 563, // Amtech 100EW
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Chất tẩy rong rêu chuyên dụng',
                            'primary_pesticide_id' => 33, // RUA CANH MONYKA 550GR
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 3: Quét cọ thân chính & cành già trị tảo đỏ nứt xù xì vỏ cây',
                    'badge'        => 'Quét thân trực tiếp',
                    'badge_color'  => 'amber',
                    'stage'        => 'Sau thu hoạch hoặc khi thân chính, chạc ba cành bị tảo đỏ ăn sâu nứt toác vỏ',
                    'dosage_guide' => 'Pha đậm đặc 100g NORSHIELD 86.2WG hoặc 100ml Đồng Xanh Mekong Agro với 1 - 2 lít nước (hoặc hòa nước vôi tôi). Dùng chổi quét trực tiếp lên các mảng tảo đỏ.',
                    'safety_note'  => 'Diệt triệt để chân tảo bám sâu dưới lớp biểu bì vỏ cây, ngăn nứt thân xì mủ Phytophthora xâm nhiễm.',
                    'groups'       => [
                        [
                            'label'                => 'Đồng Đỏ Norshield hoặc Đồng Nano quét trực tiếp',
                            'primary_pesticide_id' => 28, // NORSHIELD 86.2WG
                            'substitute_label'     => 'Hoặc thay thế bằng:',
                            'substitute_ids'       => [17, 12], // Đồng Xanh Mekong Agro, COC 85
                        ],
                    ],
                ],
            ],
        ];

        $disease = Disease::updateOrCreate(
            ['name' => $diseaseData['name']],
            $diseaseData
        );

        // 3. Gắn các cây trồng mẫn cảm: Sầu riêng, Cây có múi, Cà phê, Hồ tiêu
        $targetCropNames = ['Sầu riêng', 'Cây có múi', 'Cà phê', 'Hồ tiêu'];
        $linkedCropIds = Crop::whereIn('name', $targetCropNames)->pluck('id')->toArray();
        if (!empty($linkedCropIds)) {
            $disease->crops()->sync($linkedCropIds);
        }

        // 4. Liên kết các thuốc BVTV có sẵn trong kho (tuyệt đối không tạo thuốc mới)
        // Đồng Xanh (17), COC 85 (12), Norshield (28), Rửa cành Monyka (33), Amtech 100EW (563), Tebaz 400SC (190), Binhtaxyl 25EC (193), Tang Truong Panaxilus (152), Xanh Um Monyka (159), Weyzym-A (158), Resgant 5EC (180), Riegenf USA (187)
        $targetPesticideIds = [12, 17, 28, 33, 563, 190, 193, 152, 159, 158, 180, 187];
        $validPesticideIds = Pesticide::whereIn('id', $targetPesticideIds)->pluck('id')->toArray();

        if (!empty($validPesticideIds)) {
            $disease->pesticides()->sync($validPesticideIds);
        }
    }
}
