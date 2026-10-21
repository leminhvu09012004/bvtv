<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class TuyenTrungSauDatSeeder extends Seeder
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

        // 1. Sao chép ảnh thực tế do người dùng vừa cung cấp (Rễ bị u sần nốt bướu chuỗi hạt do tuyến trùng)
        $src = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690207753.jpg';
        $filename = 'tuyen-trung-sau-dat-1.jpg';

        if (file_exists($src)) {
            copy($src, "$destDir/$filename");
            $savedImages[] = "diseases/$filename";
        }

        // 2. Dữ liệu hồ sơ bệnh học chuẩn cho Tuyến Trùng & Sâu Hại Đất
        $diseaseData = [
            'name' => 'Tuyến Trùng & Sâu Hại Đất — Meloidogyne spp. (Tuyến Trùng Nốt Sần Rễ, U Bướu Rễ, Sùng Đất & Sâu Đất Hại Rễ)',
            'pathogen_type' => 'tuyen_trung',
            'folder_code' => 'N-02',
            'folder_group' => 'nhen_tuyen_trung',
            'folder_name' => '07. TUYẾN TRÙNG – SÂU HẠI ĐẤT',
            'folder_number' => 2,
            'caunho' => 'Tuyến trùng = RỄ U SẦN NỐT BƯỚU CHUỖI HẠT (mở đường cho Phytophthora & Fusarium thối rễ chết cây). Dập dịch bằng Fluopyram (Velum Prime 400SC), rải gốc Cartap (Ledan 4GR) / Carbosulfan (Afudan) diệt sùng sâu đất, kết hợp Men vi sinh nấm bẫy Trichoderma Sơn Thuận và Phục hồi rễ Humic Amino.',
            'symptoms' => "• Dưới bộ rễ (Triệu chứng phá hại đặc trưng như hình ảnh thực tế):\n- Tuyến trùng nốt sần (Meloidogyne spp.) và tuyến trùng thương tổn (Pratylenchus spp.) dùng kim chích đâm thủng mô rễ tơ, chui vào trong mạch dẫn hút dịch dinh dưỡng và tiết ra độc tố kích thích tế bào rễ tăng sinh dị thường.\n- Trên toàn bộ hệ thống rễ cám và rễ tơ xuất hiện vô số các khối nốt sần u bướu phồng tròn liên tiếp nhau như chuỗi hạt ngọc (root-knot galls).\n- Rễ bị phình to, nghẽn tắc mạch dẫn lưu thông nước và dưỡng chất. Chóp rễ tơ bị thối mục đen, cùn đầu rễ không thể phát triển đâm sâu.\n- Vết chích hút của tuyến trùng cùng các vết cắn đứt rễ của sâu đất, sùng đất (ấu trùng bọ hung), dế dũi, rệp sáp gốc tạo thành vô số cửa ngõ vết thương hở cho nấm Phytophthora cactorum / palmivora và Fusarium solani xâm nhập phá hoại thứ cấp, gây thối toàn bộ rễ cái và cổ rễ (Hội chứng vàng lá thối rễ, chết chậm hồ tiêu, suy kiệt sầu riêng).\n• Trên tán lá & thân cành:\n- Cây sinh trưởng còi cọc, cơi đọt mới không phóng được hoặc phóng đọt rất ngắn, lá non nhỏ mỏng, đốt thân ngắn lại.\n- Lá chuyển sang màu vàng úa hoặc vàng nhạt từ đọt non xuống lá già; vào buổi trưa nắng gắt tán lá thường héo rũ cụp xuống dù đất vẫn đủ ẩm, phục hồi nhẹ vào chiều tối mát.\n- Thiếu hụt nghiêm trọng dinh dưỡng vi lượng (vàng kẽ lá, xoăn mép lá giả virus), cây kiệt quệ dần, rụng hoa và quả non hàng loạt, chết cành khô đọt từ trên đỉnh tán xuống.",
            'symptoms_detail' => [
                'la' => 'Lá vàng úa nhạt màu, phiến lá mỏng nhỏ, cụp rũ vào ban trưa nắng gắt; cây còi cọc chùn đọt, không phóng cơi mới dù bón phân đầy đủ.',
                'canh_than' => 'Cành khẳng khiu xơ xác, đốt thân ngắn; cây sinh trưởng đình trệ, suy kiệt dần từ tán trên xuống gốc.',
                'goc_re' => 'Hệ rễ tơ nổi chi chít nốt sần u bướu phồng to như chuỗi hạt ngọc; chóp rễ bị cụt đen thối mục; rễ bị sâu đất, sùng đất cắn đứt nham nhở.',
                'qua' => 'Hoa rụng nhiều, tỷ lệ đậu trái cực thấp; quả non chậm lớn, dị hình, dễ rụng non hàng loạt trước thu hoạch.',
            ],
            'prevention' => "1. Quản lý độ pH đất: Duy trì độ pH đất luôn đạt từ 5.5 - 6.5 bằng cách định kỳ rải vôi nông nghiệp hoặc bón Canxi/Silic hữu hiệu. Tuyệt đối không để đất bị chua phèn (pH < 5.0 là điều kiện bùng phát mạnh nhất của tuyến trùng và nấm đất).\n2. Cải tạo độ tơi xốp đất & hữu cơ: Tăng cường bón phân chuồng ủ hoai mục vi sinh, kết hợp tưới Axit Humic và Fulvic để tăng lượng mùn, kích thích rễ cám tự nhiên phục hồi.\n3. Trồng cây xua đuổi sinh học: Trồng xen cúc vạn thọ (Tagetes spp.) quanh bờ liếp hoặc rìa tán rễ cây để rễ tiết chất alpha-terthienyl xua đuổi và ức chế ấu trùng tuyến trùng.\n4. Bổ sung hệ vi sinh đối kháng định kỳ: Tưới định kỳ 2-3 tháng/lần chế phẩm nấm bẫy tuyến trùng Paecilomyces lilacinus, vi nấm đối kháng Trichoderma và Bacillus subtilis vào đầu và giữa mùa mưa.",
            'treatment' => "1. NGUYÊN TẮC ĐẶC TRỊ TUYẾN TRÙNG & SÂU HẠI ĐẤT:\n• Tuyến trùng và sâu đất ẩn sâu trong tầng đất ẩm từ 5 - 30cm, không thể trị bằng cách phun trên lá mà bắt buộc phải tưới đẫm vùng rễ hoặc rải thuốc hạt quanh hình chiếu tán cây khi đất ẩm.\n• Cần thực hiện quy trình 3 giai đoạn: (1) Dập dịch tuyến trùng + diệt sâu hại đất; (2) Sát trùng chống thối rễ do nấm xâm nhập cơ hội; (3) Phục hồi tái tạo hệ thống rễ cám mới.\n\n2. Xử lý hóa học dập dịch nhanh:\n• Fluopyram thế hệ mới (FRAC 7): Velum Prime 400SC Bayer — Ức chế hô hấp ty thể của tuyến trùng, làm tê liệt và dập tắt tuyến trùng cực nhanh mà không gây độc rễ non.\n• Hoạt chất trừ sâu đất, sùng đất, mối đất, rệp sáp rễ: Cartap Hydrochloride (Ledan 95SP tưới gốc, Ledan 4GR rải gốc), Carbosulfan (Afudan 20SC), Profenofos + Thiamethoxam/Cypermethrin (THPRO 550EC, Vovatox 600) diệt sạch côn trùng cắn phá rễ.\n• Hoạt chất sát khuẩn rễ: Metalaxyl M (Ridomil Gold 68WG, Binhtaxyl 25EC) hoặc Fosetyl-Aluminium (Alien An Nông 800WP) bảo vệ vết thương hở do tuyến trùng đục.\n\n3. Phục hồi sinh học sau diệt tuyến trùng 7-10 ngày:\n• Sau khi tuyến trùng bị tiêu diệt, bộ rễ bị tổn thương nặng nề cần được kích thích tái sinh bằng Axit Humic tinh khiết, Axit Fulvic, Amino Acid (Humic Amino Roots & Bio Humic F88, Xô Roots Humic) kết hợp Lân 2 chiều Phosphonate (Delta Fos) để bung lớp lông hút rễ tơ mới.",
            'chemical_groups' => 'Fluopyram (Velum Prime 400SC - FRAC 7 đặc trị tuyến trùng), Cartap Hydrochloride (Ledan 95SP / Ledan 4GR - IRAC 14 diệt sâu đất, sùng đất), Carbosulfan (Afudan 20SC - IRAC 1A), Profenofos + Thiamethoxam (THPRO 550EC), Metalaxyl M (Ridomil Gold 68WG - FRAC 4), Fosetyl-Aluminium (Alien 800WP - FRAC P07), Potassium Phosphonate (Delta Fos), Vi sinh đối kháng Trichoderma + Bacillus + Paecilomyces (BM02), Axit Humic & Fulvic + Amino Acid phục hồi rễ',
            'notes' => "Lưu ý thực tế từ kỹ sư BVTV:\n• Cây trồng mẫn cảm và chịu thiệt hại nặng nhất: Hồ tiêu (bệnh chết chậm), Sầu riêng (vàng lá thối rễ u sưng rễ), Cà phê (tuyến trùng tổn thương rễ), Chanh dây, Cây có múi.\n• Tuyến trùng không làm chết cây ngay lập tức mà làm suy kiệt từ từ; vết thương do tuyến trùng chích hút là 'cánh cửa rộng mở' cho nấm Phytophthora và Fusarium tấn công gây chết cây hàng loạt.\n• Không bón phân hóa học NPK hoặc phân chuồng tươi khi cây đang bị tuyến trùng tấn công nặng vì sẽ làm thối rễ nhanh hơn.\n• Tài liệu tham khảo: Viện KHKT Nông Lâm nghiệp Tây Nguyên (WASI), Cục Bảo vệ Thực vật, Viện Cây ăn quả Miền Nam (SOFRI).",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Sầu riêng, Hồ tiêu, Cà phê, Chanh dây, Cây có múi',
            'treatment_plans' => [
                [
                    'title'        => 'Phác đồ 1: Đặc trị dập dịch Tuyến trùng nốt sần & Diệt sạch sâu đất, sùng đất cắn rễ (Fluopyram + Cartap / Carbosulfan + Metalaxyl M)',
                    'badge'        => 'Dập dịch tuyến trùng',
                    'badge_color'  => 'emerald',
                    'stage'        => 'Khi đào rễ phát hiện nốt sần u bướu chuỗi hạt, sùng đất cắn rễ, cây vàng lá còi cọc',
                    'dosage_guide' => 'Pha 1 chai Velum Prime 400SC (250ml) + 1 chai Afudan 20SC (100ml) hoặc 1 gói Ledan 95SP (100g) + 1 gói Ridomil Gold 68WG (100g) cho 200 - 250 lít nước. Tưới ướt đẫm vùng đất quanh tán rễ (5 - 10 lít dung dịch/gốc tùy tuổi cây).',
                    'safety_note'  => 'Tưới khi đất đang có độ ẩm thích hợp (sau khi tưới nhẹ hoặc sau mưa). Xử lý nhắc lại lần 2 sau 15 - 20 ngày nếu mật độ tuyến trùng trong vườn cao.',
                    'groups'       => [
                        [
                            'label'                => 'Fluopyram thế hệ mới dập tắt tuyến trùng',
                            'primary_pesticide_id' => 41, // VELUM PRIME 400SC (CHAI)
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Carbosulfan / Cartap diệt sâu đất, sùng đất, mối đất',
                            'primary_pesticide_id' => 161, // AFUDAN 20SC 100MIL (CHAI)
                            'substitute_ids'       => [168, 169], // LEDAN 95SP 100G, LEDAN 4GR 1KG
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Metalaxyl M sát trùng rễ chống nấm thối cơ hội',
                            'primary_pesticide_id' => 32, // Ridomil Gold 68WG
                            'substitute_ids'       => [193], // BINHTAXYL 25EC
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 2: Phòng ngừa sinh học bền vững — Nấm bẫy tuyến trùng & Men đối kháng bảo vệ đất',
                    'badge'        => 'Sinh học bền vững',
                    'badge_color'  => 'sky',
                    'stage'        => 'Xử lý định kỳ đầu mùa mưa và giữa mùa mưa, cải tạo đất chua, ngăn chặn tuyến trùng tích lũy',
                    'dosage_guide' => 'Pha 1 gói Tuyến Trùng Nấm Hại Sơn Thuận (1kg) + 1 gói Trichoderma AC (1kg) + 1kg Đạm hữu cơ Humic cho 400 lít nước. Tưới đẫm vùng đất quanh gốc hoặc trộn rải cùng phân chuồng hoai mục.',
                    'safety_note'  => 'Không tưới chung với thuốc trừ nấm hóa học gốc Đồng hoặc thuốc diệt nấm phổ rộng trong vòng 7 ngày để bảo tồn vi sinh vật có ích.',
                    'groups'       => [
                        [
                            'label'                => 'Men vi sinh đối kháng & Nấm bẫy tuyến trùng',
                            'primary_pesticide_id' => 39, // Tuyến Trùng Nấm Hại Sơn Thuận
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Vi nấm đối kháng Trichoderma cải tạo đất',
                            'primary_pesticide_id' => 38, // TRICHODERMA AC 1KG (GOI)
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Axit Humic & Fulvic hạ phèn, tơi xốp đất',
                            'primary_pesticide_id' => 46, // ĐẠM HỮU CƠ HUMIC 25 KG (BAO)
                            'substitute_ids'       => [55], // Xô Roots Humic
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 3: Kích rễ tơ mới, làm lành mạch dẫn & Tái sinh cơi đọt khỏe mạnh',
                    'badge'        => 'Phục hồi bung rễ',
                    'badge_color'  => 'amber',
                    'stage'        => 'Sau khi xử lý diệt tuyến trùng 7 - 10 ngày, khi mầm rễ mới bắt đầu nhú ra',
                    'dosage_guide' => 'Pha 1 chai Humic Amino Roots (500ml) + 1 chai Delta Fos Lân 2 chiều (500ml) + 1 chai Hoptri Organo Forge (100ml) cho 400 lít nước. Tưới đều vùng rễ quanh tán cây.',
                    'safety_note'  => 'Giúp tái tạo hàng triệu lông hút rễ tơ mới thay thế rễ bị u sần, làm lành tổn thương mạch dẫn rễ, cây bung cơi đọt xanh dày mướt, hồi phục sinh lực hoàn toàn.',
                    'groups'       => [
                        [
                            'label'                => 'Humic tinh khiết, Fulvic & Tinh chất Amino Acid kích rễ',
                            'primary_pesticide_id' => 148, // Humic Amino Roots & Bio Humic F88
                            'substitute_ids'       => [55], // Xô Roots Humic
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Lân 2 chiều Phosphonate kích kháng mạch rễ',
                            'primary_pesticide_id' => 14, // Delta Fos Mekong Agro
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Chất điều hòa sinh trưởng vàng Kinetin + IBA + GA3',
                            'primary_pesticide_id' => 19, // Hoptri Organo Forge
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
            ],
        ];

        $disease = Disease::updateOrCreate(
            ['name' => $diseaseData['name']],
            $diseaseData
        );

        // 3. Gắn các cây trồng mẫn cảm: Sầu riêng, Hồ tiêu, Cà phê, Chanh dây, Cây có múi
        $targetCropNames = ['Sầu riêng', 'Hồ tiêu', 'Cà phê', 'Chanh dây', 'Cây có múi'];
        $linkedCropIds = Crop::whereIn('name', $targetCropNames)->pluck('id')->toArray();
        if (!empty($linkedCropIds)) {
            $disease->crops()->sync($linkedCropIds);
        }

        // 4. Liên kết các thuốc BVTV có sẵn trong kho đặc trị tuyến trùng & sâu hại đất
        $targetPesticideIds = [41, 161, 168, 169, 32, 193, 39, 38, 46, 55, 148, 14, 19, 185, 186];
        $validPesticideIds = Pesticide::whereIn('id', $targetPesticideIds)->pluck('id')->toArray();

        if (!empty($validPesticideIds)) {
            $disease->pesticides()->sync($validPesticideIds);
        }
    }
}
