<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class BenhPhytophthoraSeeder extends Seeder
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
        $imageSources = [
            'phytophthora-xi-mu-thoi-re-1.jpg' => 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690396497.jpg',
            'phytophthora-thoi-trai-cam-2.png'  => 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690396130.png',
            'phytophthora-thoi-trai-canh-3.png' => 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690396151.png',
            'phytophthora-thoi-trai-chanh-4.png' => 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690396178.png',
        ];

        foreach ($imageSources as $filename => $src) {
            if (file_exists($src)) {
                copy($src, "$destDir/$filename");
                $savedImages[] = "diseases/$filename";
            } elseif (file_exists("$destDir/$filename")) {
                $savedImages[] = "diseases/$filename";
            }
        }

        // 2. Dữ liệu hồ sơ bệnh học chuẩn cho Phytophthora — nứt thân xì mủ, thối lở cổ rễ, thối trái
        $diseaseData = [
            'name' => 'Bệnh Nứt Thân Xì Mủ, Thối Lở Cổ Rễ, Thối Trái — Phytophthora spp. (Phytophthora palmivora, Phytophthora nicotianae / citrophthora — Xì Mủ Sầu Riêng, Thối Nâu Trái Có Múi & Thối Rễ Cây Ăn Quả)',
            'pathogen_type' => 'nam_benh',
            'folder_code' => 'B-01',
            'folder_group' => 'nam_benh',
            'folder_name' => '1-Phytophthora - xì mủ, thối rễ, thối trái',
            'folder_number' => 1,
            'caunho' => 'Phytophthora = KẺ HỦY DIỆT SỐ 1: XÌ MỦ THÂN + THỐI ĐEN CỔ RỄ + THỐI NÂU ỦNG NƯỚC TRÊN TRÁI (bào tử bơi trong nước mưa ngập úng). QUY TẮC SỐNG CÒN: Cào sạch đất cổ rễ làm bồn nổi, cạo sạch vết thâm đen đến mô gỗ lành + quét thuốc đậm đặc Metalaxyl M (Ridomil Gold / Binhtaxyl) + Lân 2 chiều Phosphonate (Agri-Fos / Delta Fos) hoặc Fosetyl-Al (Alien 800WP), tưới đẫm vùng rễ và phun bảo vệ trái.',
            'symptoms' => "• Phân tích bệnh học chuyên sâu qua các ảnh thực tế bạn gửi:\n- Ảnh 1 & 5 — Thối lở cổ rễ & Xì mủ gốc sầu riêng (Phytophthora palmivora): Bào tử nấm Phytophthora từ đất bơi theo nước mưa tấn công vào vùng cổ rễ và gốc thân tiếp giáp mặt đất. Vỏ cây bị úng nước, thối rữa màu nâu đen, nứt toác và rỉ ra các giọt dịch mủ màu nâu đỏ dính nhớt mùi chua thối. Trong ảnh, nhà vườn đã cào bới lớp đất đỏ quanh gốc làm bồn nổi để hạ độ ẩm và dùng dụng cụ cạo sạch lớp vỏ thối bị hoại tử cho đến khi lộ lớp tầng sinh mô/mạch gỗ trắng sáng khỏe mạnh để chuẩn bị quét thuốc đặc trị.\n- Ảnh 2, 3 & 4 — Bệnh Thối nâu trái có múi (Citrus Brown Rot — Phytophthora nicotianae / citrophthora): Nước mưa bắn đất mang theo bào tử động zoospore lên các chùm trái ở tầng thấp. Trên vỏ trái xuất hiện các đốm sũng nước màu nâu ô-liu, lan rộng thành các mảng thối nâu sẫm ủng nước bao quanh quả. Trái bị bệnh vỏ dai không bị nhũn nát ngay nhưng có mùi chua nồng đặc trưng, sau đó trái chuyển màu vàng úa, rụng hàng loạt xuống gốc đất ẩm ướt như trong ảnh 4.\n• Triệu chứng trên toàn cây:\n- Cành lá: Tán lá vàng úa từ cành thấp lên cành cao, gân lá vàng trước rồi rụng lá hàng loạt; đọt non bị khô chết rụi (dieback).\n- Rễ cây: Toàn bộ hệ thống rễ cám và rễ cọc bị thối nhũn đen nhớt, tuột vỏ rễ, cây mất hoàn toàn khả năng hút nước khiến cây suy kiệt nhanh chóng.",
            'symptoms_detail' => [
                'la' => 'Lá vàng úa đồng loạt từ dưới gốc lên ngọn, rụng lá trơ cành; cơi đọt non bị chùn lại, khô đen đọt non.',
                'canh_than' => 'Vỏ thân cành nứt toác, ứa mủ nâu đỏ nhớt dính; cạo lớp vỏ ngoài thấy mô mạch rây bên trong bị thối nhũn nâu đen bốc mùi hôi chua.',
                'goc_re' => 'Cổ rễ thối lở từng mảng lớn quanh chu vi gốc; rễ cái và rễ tơ bị thối đen nhầy, tuột vỏ rễ rụng sạch lông hút.',
                'qua' => 'Vỏ trái xuất hiện mảng thối nâu xám ủng nước mùi chua nồng; trái sầu riêng và trái có múi bị thối đen rụng hàng loạt trước thu hoạch.',
            ],
            'prevention' => "1. Kỹ thuật lên mô cao & Đào rãnh thoát nước: Tuyệt đối không trồng cây sâu lấp đất ngập cổ rễ. Phải trồng nổi trên mô cao, xới cào đất quanh cổ rễ để hở phần gốc rễ cổ rễ tiếp xúc ánh sáng và không khí khô ráo (như kỹ thuật cào đất trong ảnh thực tế).\n2. Quản lý vườn cây mùa mưa: Cắt tỉa cành sát mặt đất (dưới 0.5m) để tránh đất bùn bắn bào tử nấm lên lá và quả non khi trời mưa lớn.\n3. Nâng cao pH đất: Bón vôi bột khử trùng định kỳ đầu và cuối mùa mưa (nâng pH lên 6.0 - 6.5) vì Phytophthora phát triển mạnh nhất ở môi trường đất chua pH < 5.0.\n4. Kích kháng tự nhiên & Vi sinh đối kháng: Định kỳ tưới Lân 2 chiều Phosphonate kích hoạt hệ miễn dịch cây trồng; bón phân hữu cơ ủ nấm đối kháng Trichoderma harzianum cạnh tranh tiêu diệt nấm hại trong đất.",
            'treatment' => "1. NGUYÊN TẮC VÀNG XỬ LÝ DỊCH HẠI PHYTOPHTHORA:\n• Phytophthora thuộc nhóm nấm giả Oomycetes có bào tử động bơi trong nước, các dòng thuốc trừ nấm thông thường (Hexaconazole, Carbendazim, Difenoconazole) KHÔNG CÓ HIỆU LỰC.\n• BẮT BUỘC PHẢI DÙNG NHÓM HOẠT CHẤT ĐẶC HIỆU OOMYCETES: Fosetyl-Aluminium, Potassium Phosphonate (Lân 2 chiều), Metalaxyl M, Dimethomorph, Fluopicolide.\n• Với cây bị xì mủ thân & thối cổ rễ: Bắt buộc phải CÀO ĐẤT PHƠI GỐC + DÙNG DAO CẠO SẠCH HẾT PHẦN VỎ NÂU ĐEN ĐẾN PHẦN GỖ KHỎE MẠNH TRẮNG SÁNG + QUÉT THUỐC ĐẬM ĐẶC SỆT.\n• Kết hợp đồng thời 3 mũi giáp công: Quét vết thương thân gốc + Tưới đẫm vùng rễ + Phun bảo vệ toàn bộ tầng lá và chùm trái.\n\n2. Phác đồ hóa học đặc trị luân phiên:\n• Nhóm Phosphonate kích kháng lưu dẫn 2 chiều (FRAC P07): AGRI-FOS DONA-TECHNO 1, Delta Fos (Mono & Di-potassium phosphite 400g/l), Alien An Nông 800WP / Aliette (Fosetyl-Aluminium 800g/kg). Thuốc lưu dẫn 2 chiều cực nhanh, di chuyển lên lá và xuống tận chóp rễ, kích thích cây tiết enzyme Phytoalexin tiêu diệt sợi nấm Phytophthora.\n• Nhóm Phenylamide ức chế tổng hợp RNA (FRAC 4): Ridomil Gold 68WG (Metalaxyl M + Mancozeb), BINHTAXYL 25EC (Metalaxyl 250g/l). Diệt sạch sợi nấm ẩn sâu trong mạch gỗ và sát trùng vết thương hở.\n• Nhóm Fluopicolide chống phân chia tế bào (FRAC 43 + P07): PROFILER 711.1WG Bayer (Fluopicolide + Fosetyl-Al). Hiệu lực dập dịch thối trái và xì mủ kéo dài bậc nhất hiện nay.\n• Nhóm Áo giáp Kẽm bảo vệ tiếp xúc (FRAC M03): Antracol 70WP Bayer (Propineb + Zinc++ kẽm). Phủ lớp áo giáp bảo vệ mặt ngoài vỏ quả và cổ rễ, làm khô se vết thương cực nhanh.\n• Phục hồi tái sinh rễ sau bệnh: Tưới dưỡng rễ bằng Axit Humic, Rong biển Seaweed (Xanh Um Monyka), CanxiBo EDTA và Weyzym-A giúp phục hồi bộ rễ và lành da cây sau khi quét thuốc.",
            'chemical_groups' => 'Fosetyl-Aluminium (Alien 800WP / Aliette - FRAC P07), Potassium Phosphonate (Agri-Fos / Delta Fos - Lân 2 chiều), Metalaxyl M (Ridomil Gold / Binhtaxyl - FRAC 4), Fluopicolide + Fosetyl-Al (Profiler 711.1WG - FRAC 43 + P07), Propineb + Kẽm Zinc++ (Antracol 70WP - FRAC M03), Mancozeb 80WP (FRAC M01), Canxi-Bo EDTA & Amino Acid',
            'notes' => "Lưu ý thực tế từ kỹ sư BVTV:\n• Phytophthora là dịch bệnh nguy hiểm số 1 đe dọa sinh mạng của cây sầu riêng và cây có múi tại Việt Nam.\n• Cạo vỏ trị xì mủ: Phải cạo rộng ra mép mô lành từ 1 - 2cm để đảm bảo không sót sợi nấm. Dao cạo phải khử trùng bằng cồn hoặc nước vôi trước khi cạo cây khác.\n• Không được lấp đất lại sau khi cạo quét thuốc; phải để hở cổ rễ cho khô ráo ít nhất 2 - 3 tuần cho đến khi vết sẹo cây đùn da non.\n• Tài liệu tham khảo: Viện Cây ăn quả Miền Nam (SOFRI), Cục Bảo vệ Thực vật, Trung tâm Khuyến nông Quốc gia.",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Sầu riêng, Cây có múi, Chanh dây, Cà phê, Hồ tiêu, Cà chua & Họ cà, Dưa leo & Bầu bí',
            'treatment_plans' => [
                [
                    'title'        => 'Phác đồ 1: Cạo sạch & Quét đậm đặc đặc trị nứt thân xì mủ, thối lở cổ rễ (Alien An Nông 800WP / Aliette + Ridomil Gold 68WG + Agri-Fos Lân 2 chiều)',
                    'badge'        => 'Quét đậm đặc diệt xì mủ',
                    'badge_color'  => 'rose',
                    'stage'        => 'Khi phát hiện thân cây xì mủ, cổ rễ thối đen úng nước, vỏ cây nứt toác',
                    'dosage_guide' => 'Cạo sạch vết vỏ thối đến phần gỗ trắng sáng. Pha 100g Alien An Nông 800WP (hoặc Aliette) + 100g Ridomil Gold 68WG + 100ml Agri-Fos Lân 2 chiều vào 1 lít nước (tạo thành dung dịch sệt). Dùng chổi sơn quét đẫm trực tiếp lên toàn bộ vết cạo và vùng cổ rễ.',
                    'safety_note'  => 'Fosetyl-Al và Metalaxyl M thấm sâu vào tế bào mạch dẫn chặn đứng dòng mủ xì và diệt sạch sợi nấm, Lân 2 chiều kích thích tế bào sẹo đùn mô vỏ non làm lành vết thương. Quét nhắc lại lần 2 sau 5 - 7 ngày nếu vết thương chưa khô ráo hoàn toàn.',
                    'groups'       => [
                        [
                            'label'                => 'Fosetyl-Aluminium kích kháng nội hấp lưu dẫn 2 chiều dập tắt xì mủ',
                            'primary_pesticide_id' => 4, // Alien An Nông 800WP
                            'substitute_ids'       => [2, 6], // ALIETTE 100g, ANLIEN ANNONG 400SC
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Metalaxyl M ức chế tổng hợp tế bào nấm Phytophthora, làm khô se vết thối',
                            'primary_pesticide_id' => 32, // Ridomil Gold 68WG
                            'substitute_ids'       => [193], // BINHTAXYL 25EC
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Lân 2 chiều Phosphonate kích kháng, tái tạo vỏ mô cây nhanh liền sẹo',
                            'primary_pesticide_id' => 1, // AGRI-FOS DONA-TECHNO 1
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 2: Tưới đẫm vùng rễ dập dịch nấm Oomycetes trong đất & Phục hồi rễ tơ chống vàng lá chết chậm',
                    'badge'        => 'Tưới đẫm dập dịch gốc rễ',
                    'badge_color'  => 'sky',
                    'stage'        => 'Tưới khi cây chớm vàng lá, rễ tơ bị thối đen nhũn nước hoặc sau khi đã cạo quét thuốc thân cành',
                    'dosage_guide' => 'Pha 1 chai Agri-Fos Dona-Techno (1 lít) hoặc Profiler 711.1WG (450g) + 1 chai Binhtaxyl 25EC (450ml) + 1 gói Antracol 70WP Bayer (300g) cho 400 lít nước (2 phuy). Tưới ướt đẫm từ 10 - 20 lít dung dịch quanh vùng rễ tán cây.',
                    'safety_note'  => 'Phosphonate và Metalaxyl len lỏi tiêu diệt bào tử động zoospore trong nước đất, Propineb Kẽm Zinc++ phủ lớp áo giáp bảo vệ chóp rễ tơ không bị thối nhũn. Sau khi tưới thuốc 5 - 7 ngày, tưới bổ sung Humic và Rong biển để tái sinh rễ non.',
                    'groups'       => [
                        [
                            'label'                => 'Phosphonate lưu dẫn 2 chiều hoặc Fluopicolide đặc trị nấm Oomycetes vùng rễ',
                            'primary_pesticide_id' => 1, // AGRI-FOS DONA-TECHNO 1
                            'substitute_ids'       => [30], // PROFILER 711,1WG
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Metalaxyl nội hấp cực mạnh tiêu diệt mầm nấm thối rễ trong tầng đất ẩm',
                            'primary_pesticide_id' => 193, // BINHTAXYL 25EC
                            'substitute_ids'       => [32], // Ridomil Gold 68WG
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Áo giáp Kẽm Propineb Zinc++ bảo vệ chóp rễ cám, kháng nấm đất',
                            'primary_pesticide_id' => 7, // Antracol 70WP Bayer
                            'substitute_ids'       => [27], // NOFACOL 700WP
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 3: Phun phòng ngừa & Dập dịch thối nâu quả sầu riêng, cam chanh mùa mưa bão (Profiler 711.1WG + Ridomil Gold + CanxiBo EDTA)',
                    'badge'        => 'Bảo vệ quả sáng đẹp',
                    'badge_color'  => 'amber',
                    'stage'        => 'Phun phòng ngừa định kỳ 10 - 15 ngày/lần vào mùa mưa bão, hoặc khi vườn chớm xuất hiện đốm thối nâu trên trái',
                    'dosage_guide' => 'Pha 1 gói Profiler 711.1WG (450g) hoặc Alien An Nông 800WP (200g) + 1 gói Ridomil Gold 68WG (100g) + 1 chai CanxiBo EDTA (250ml) cho 400 lít nước. Phun ướt đều khắp các chùm quả và tầng lá dưới.',
                    'safety_note'  => 'Fluopicolide + Fosetyl-Al bảo vệ bề mặt và thẩm thấu vào vỏ quả chặn đứng vết thối nâu; Canxi-Bo giúp vỏ quả dai chắc, cuống dai chống rụng quả non và quả sắp thu hoạch.',
                    'groups'       => [
                        [
                            'label'                => 'Fluopicolide + Fosetyl-Aluminium đặc trị thối nâu quả & bảo vệ kéo dài',
                            'primary_pesticide_id' => 30, // PROFILER 711,1WG BAYER
                            'substitute_ids'       => [4, 6], // Alien An Nông 800WP, ANLIEN ANNONG 400SC
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Metalaxyl M + Mancozeb sát trùng bề mặt vỏ quả, ngăn chặn nấm lây lan',
                            'primary_pesticide_id' => 32, // Ridomil Gold 68WG
                            'substitute_ids'       => [7], // Antracol 70WP Bayer
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Canxi-Bo hữu cơ dày vỏ, dai cuống chống nứt thối & rụng trái mùa mưa',
                            'primary_pesticide_id' => 80, // CanxiBo EDTA
                            'substitute_ids'       => [158], // WEYZYM-A MULTIAGRO48
                        ],
                    ],
                ],
            ],
        ];

        $disease = Disease::updateOrCreate(
            ['folder_code' => 'B-01'],
            $diseaseData
        );

        // 3. Gắn các cây trồng mẫn cảm: Sầu riêng, Cây có múi, Chanh dây, Cà phê, Hồ tiêu, Cà chua & Họ cà, Dưa leo & Bầu bí
        $targetCropNames = ['Sầu riêng', 'Cây có múi', 'Chanh dây', 'Cà phê', 'Hồ tiêu', 'Cà chua & Họ cà', 'Dưa leo & Bầu bí'];
        $linkedCropIds = Crop::whereIn('name', $targetCropNames)->pluck('id')->toArray();
        if (!empty($linkedCropIds)) {
            $disease->crops()->sync($linkedCropIds);
        }

        // 4. Liên kết các thuốc BVTV đặc trị trong kho dữ liệu
        // Alien 4, Aliette 2, Anlien 6, Profiler 30, Ridomil Gold 32, Binhtaxyl 193, Agri-Fos 1, Antracol 7, Nofacol 27, CanxiBo 80, Weyzym-A 158, Xanh Um Monyka 159
        $targetPesticideIds = [4, 2, 6, 30, 32, 193, 1, 7, 27, 80, 158, 159];
        $validPesticideIds = Pesticide::whereIn('id', $targetPesticideIds)->pluck('id')->toArray();

        if (!empty($validPesticideIds)) {
            $disease->pesticides()->sync($validPesticideIds);
        }
    }
}
