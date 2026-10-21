<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConsolidateDiseasesAndLinkCropsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Gộp các bệnh trùng lặp và thiết lập quan hệ Nhiều - Nhiều giữa Cây trồng (Crops) và Bệnh hại (Diseases).
     * Chuẩn hóa theo "Sổ tay 13 bệnh sầu riêng — hình thật, nguyên nhân và cách xử lý" (trừ phần 13 thối trái được gộp vào Phytophthora)
     * và Bệnh Đốm Dầu / Bã Trầu trên Cây Chanh Dây.
     */
    public function run(): void
    {
        // 1. Đảm bảo bảng crops có đầy đủ các cây trồng
        $this->call(CropsSeeder::class);

        $cropsMap = Crop::all()->keyBy('name');
        $sauRiengId = $cropsMap['Sầu riêng']->id ?? null;
        $chanhDayId = $cropsMap['Chanh dây']->id ?? null;
        $caPheId    = $cropsMap['Cà phê']->id ?? null;
        $hoTieuId   = $cropsMap['Hồ tiêu']->id ?? null;
        $coMuiId    = $cropsMap['Cây có múi']->id ?? null;

        // 2. Danh sách các bệnh chuẩn hóa
        $consolidatedList = [
            // =========================================================================
            // 1. PHYTOPHTHORA — XÌ MỦ, THỐI RỄ, THỐI TRÁI (Oomycetes)
            // Tích hợp toàn bộ triệu chứng thối trái từ mục 13 cũ (không tách riêng mục 13)
            // =========================================================================
            [
                'match_keys' => ['Phytophthora', 'Xì Mủ', 'Thối Trái Sầu Riêng'],
                'data' => [
                    'name' => 'Bệnh Xì Mủ / Thối Gốc / Thối Rễ / Thối Trái — Phytophthora palmivora',
                    'pathogen_type' => 'nam',
                    'caunho' => 'Phytophthora = NẤM GIẢ OOMYCETES + THOÁT NƯỚC + XÌ MỦ VỎ + THỐI TRÁI (xử lý đúng vị trí + phục hồi rễ).',
                    'symptoms' => "Nguyên nhân: Phytophthora palmivora, thuộc nhóm nấm giả Oomycetes.\nĐiều kiện phát sinh: Mưa kéo dài, đất úng, thoát nước kém; mầm bệnh lan qua nước chảy tràn và đất nhiễm bệnh.\nDấu hiệu: Vỏ thân có vết nâu và chảy nhựa xì mủ; rễ nâu đen, thối; trái có vết nâu sẫm lan rộng, nhũn thối bốc mùi chua.",
                    'symptoms_detail' => [
                        'la' => 'Lá vàng úa rụng từ cành thấp lên ngọn, rụng một phía hoặc toàn cây do hệ rễ bị hư hoại.',
                        'canh_than' => 'Vỏ thân có vết nâu ướt và chảy nhựa xì mủ nâu đỏ (sầu riêng) hoặc thối đen teo tóp cổ rễ (chanh dây, tiêu, cây có múi).',
                        'goc_re' => 'Hệ rễ tơ và cổ rễ ủng nước, thối đen mục, vỏ rễ tuột khỏi lõi gỗ.',
                        'qua' => 'Vết nâu sẫm lan rộng trên vỏ trái sầu riêng và quả chanh dây, mô mềm thối nhũn, bốc mùi chua, phủ tơ nấm trắng khi ẩm ướt.',
                    ],
                    'prevention' => "Bước 1 — Canh tác & Thoát nước:\n• Tháo nước khẩn cấp, khơi rãnh thoát nước sâu giữa các hàng liếp, không để đọng vũng quanh gốc.\n• Tỉa cành thông thoáng tầng chân từ 0.8 - 1m so với mặt đất, hạn chế nước bắn từ đất lên trái.\n• Loại bỏ triệt để trái bệnh, thu gom tiêu hủy xa vườn, vệ sinh vùng bệnh.\n• Nâng pH đất đạt 5.5 - 6.5 bằng vôi bột; bón phân hữu cơ hoai mục ủ Trichoderma/Bacillus.",
                    'treatment' => "Bước 2 — Xử lý thuốc đúng vị trí:\n• Vùng rễ: Tưới đẫm hoạt chất Oomycetes như Phosphonate/Phosphorous acid, Fosetyl-Al, Metalaxyl-M, Dimethomorph.\n• Thân xì mủ: Cạo sạch mô vỏ bệnh đến phần gỗ lành, quét dung dịch thuốc đậm đặc (Phosphonate / Fosetyl-Al / Metalaxyl).\n• Trái: Phun phòng ngừa sớm trước khi mưa dầm kéo dài.\nBước 3 — Phục hồi rễ:\n• Sau khi bệnh được kiểm soát 10-15 ngày, tưới dưỡng rễ Humic/Fulvic + Amino Acid kết hợp vi sinh đối kháng.",
                    'chemical_groups' => 'Phosphonate / Phosphorous acid, Fosetyl-Aluminium, Metalaxyl-M, Dimethomorph, Fluopicolide (FRAC P07, FRAC 4, FRAC 40, FRAC 43).',
                    'notes' => "Cây có thể bị bệnh: Sầu riêng, chanh dây, hồ tiêu, cây có múi, ca cao, đu đủ.\n⚠️ Chẩn đoán phân biệt & phối trộn: Thối trái cũng có thể do tác nhân khác hoặc vết thương cơ học, không mặc định các thuốc này pha chung được. Luôn kiểm tra nhãn đăng ký.\nTham khảo: [Hình bệnh xì mủ, thối rễ](https://www.laplastic.biz/durian-disease.html) | [Nghiên cứu quản lý Phytophthora trên sầu riêng](https://www.sciencedirect.com/science/article/pii/S0261219424005143?utm_source=chatgpt.com)",
                ],
                'crop_ids' => array_filter([$sauRiengId, $chanhDayId, $hoTieuId, $coMuiId]),
                'pesticide_keywords' => ['Agri-Fos', 'Alien', 'Delta Fos', 'Dimethor', 'Ridomil', 'Profiler'],
            ],

            // =========================================================================
            // 2. PYTHIUM — THỐI RỄ NON (Oomycetes)
            // =========================================================================
            [
                'match_keys' => ['Pythium'],
                'data' => [
                    'name' => 'Bệnh Thối Rễ Non — Pythium spp.',
                    'pathogen_type' => 'nam',
                    'caunho' => 'Pythium = NẤM GIẢ + ĐẤT ẨM KÉO DÀI + RỄ THIẾU OXY (ưu tiên thoát nước, kiểm tra rễ và cổ rễ).',
                    'symptoms' => "Nguyên nhân: Pythium spp. hoặc tác nhân nấm giả gần nhóm Oomycetes (cần xét nghiệm nếu muốn xác định chính xác).\nĐiều kiện phát sinh: Đất ẩm kéo dài, ngập úng, rễ thiếu oxy.\nDấu hiệu: Rễ tơ nâu, mềm hoặc thối mục; cây vàng lá, chậm lớn, suy yếu dần.",
                    'symptoms_detail' => [
                        'la' => 'Lá vàng nhạt, mất sức căng, cây chậm lớn còi cọc, chóp đọt non bị chùn.',
                        'canh_than' => 'Không có vết chảy nhựa xì mủ trực tiếp trên thân cành, cành khẳng khiu.',
                        'goc_re' => 'Rễ tơ màu nâu, mềm nhũn hoặc thối mục, tuột biểu bì ngoài; rễ cọc bị hoại tử nhẹ.',
                        'qua' => 'Trái chậm lớn, méo mó, dễ rụng non do rễ mất chức năng hút nước/dinh dưỡng.',
                    ],
                    'prevention' => "Ưu tiên thoát nước tuyệt đối, xới nhẹ phá váng mặt đất, hạ mực nước ngầm, không tưới thuốc khi bồn gốc đang ngập úng.",
                    'treatment' => "Kiểm tra rễ và cổ rễ; xử lý vùng rễ bằng sản phẩm phù hợp tác nhân đã xác định (Fosetyl-Al, Phosphonate hoặc Metalaxyl-M, Dimethomorph). Phục hồi rễ bằng Humic + Trichoderma khi điều kiện đất ổn định.",
                    'chemical_groups' => 'Phosphonate, Fosetyl-Aluminium, Metalaxyl-M, Dimethomorph (FRAC P07, FRAC 4, FRAC 40).',
                    'notes' => "Cây có thể bị bệnh: Sầu riêng, chanh dây, cây ăn quả, rau màu và cây con trong vườn ươm.\n⚠️ Phân biệt quan trọng: Pythium và Phytophthora đều có thể làm thối rễ, nhưng không thể phân biệt chắc chắn chỉ bằng màu rễ. Không phải mọi sản phẩm đều có hiệu lực ngang nhau.",
                ],
                'crop_ids' => array_filter([$sauRiengId, $chanhDayId]),
                'pesticide_keywords' => ['Dimethor', 'Ridomil', 'Alien', 'Delta Fos'],
            ],

            // =========================================================================
            // 3. FUSARIUM — BỆNH RỄ, HÉO CÂY, KHÔ CÀNH (Nấm thật)
            // =========================================================================
            [
                'match_keys' => ['Fusarium'],
                'data' => [
                    'name' => 'Bệnh Héo Cây, Khô Cành, Thối Rễ — Fusarium spp.',
                    'pathogen_type' => 'nam',
                    'caunho' => 'Fusarium = NẤM THẬT + TẮC MẠCH DẪN NÂU (vàng lá chưa đủ kết luận, loại trừ úng rễ + Phyto + tuyến trùng).',
                    'symptoms' => "Nguyên nhân: Các loài Fusarium (Fusarium solani, Fusarium oxysporum); gây bệnh rễ, héo hoặc chết cành.\nĐiều kiện phát sinh: Rễ bị tổn thương cơ học/tuyến trùng, cây suy yếu, đất và cây giống nhiễm mầm bệnh.\nDấu hiệu: Vàng lá, héo, khô cành hoặc suy cây; cắt mô cành/gốc thấy mô mạch dẫn bên trong bị hóa nâu.",
                    'symptoms_detail' => [
                        'la' => 'Lá vàng rải rác từ cành thấp lên, trưa nắng héo rũ, ban đêm hồi nhẹ rồi khô và rụng.',
                        'canh_than' => 'Cắt ngang mô cành hoặc gốc thấy mạch dẫn hóa nâu thâm đen; gốc chanh dây phình to nứt dọc.',
                        'goc_re' => 'Rễ bị tổn thương thâm đen khô, không sũng nước nhầy nhớt như Phytophthora.',
                        'qua' => 'Trái nhỏ, teo tóp, méo lệch, cơm quả sượng hoặc rụng sớm.',
                    ],
                    'prevention' => "Kiểm tra rễ và mô cành; cải thiện thoát nước; cắt bỏ cành chết; vệ sinh dụng cụ tỉa; tránh chuyển đất hoặc cây giống nhiễm bệnh.",
                    'treatment' => "Tưới hoặc xử lý nhóm Triazole: Tebuconazole, Difenoconazole, Hexaconazole hoặc Mancozeb theo đăng ký phù hợp. Định kỳ bổ sung nấm đối kháng Trichoderma/Bacillus cạnh tranh sinh học.",
                    'chemical_groups' => 'Tebuconazole, Difenoconazole, Hexaconazole, Mancozeb (FRAC 3, FRAC M03, Sinh học BM02).',
                    'notes' => "Cây có thể bị bệnh: Sầu riêng, chanh dây, cà phê, hồ tiêu, chuối, cà chua, ớt, dưa, cây họ đậu.\n⚠️ Lưu ý chẩn đoán phân biệt: Vàng lá chưa đủ để kết luận Fusarium; phải loại trừ úng rễ, Phytophthora và tuyến trùng. Triazole có tác dụng với một số nấm gây bệnh, không được coi là thuốc trị mọi loài Fusarium.",
                ],
                'crop_ids' => array_filter([$sauRiengId, $chanhDayId, $caPheId, $hoTieuId]),
                'pesticide_keywords' => ['Anvil', 'Mancozeb', 'Japa Vil', 'Tebaz'],
            ],

            // =========================================================================
            // 4. RHIZOCTONIA — CHÁY LÁ, CHẾT NGỌN (Nấm thật)
            // =========================================================================
            [
                'match_keys' => ['Rhizoctonia', 'Cháy Lá, Chết Ngọn'],
                'data' => [
                    'name' => 'Bệnh Cháy Lá, Chết Ngọn — Rhizoctonia solani',
                    'pathogen_type' => 'nam',
                    'caunho' => 'Rhizoctonia = NẤM THẬT + VẾT LOANG NHƯ NƯỚC SÔI + DÍNH LÁ CHÙM (tỉa tán, giảm ẩm, đúng nhãn sầu riêng).',
                    'symptoms' => "Nguyên nhân: Rhizoctonia spp., thường gặp nhất là Rhizoctonia solani.\nĐiều kiện phát sinh: Độ ẩm cao, tán rậm rạp, mô cây tiếp xúc nguồn bệnh hoặc nước mưa bắn.\nDấu hiệu: Vết nâu loang trên lá lan rộng như luộc nước sôi, lá cháy khô; các lá dính chùm vào nhau bằng tơ nấm; mô non hoặc ngọn non bị thối chết.",
                    'symptoms_detail' => [
                        'la' => 'Vết bệnh ban đầu úng nước màu xám xanh, lan rộng thành mảng cháy nâu lớn, lá khô giòn và dính chùm vào nhau.',
                        'canh_than' => 'Vết bệnh lan lên ngọn non làm ngọn bị thối đen rồi khô chết ngọn.',
                        'goc_re' => 'Không gây hại vùng rễ.',
                        'qua' => 'Chủ yếu phá hại bộ lá và cơi đọt non.',
                    ],
                    'prevention' => "Tỉa tán thông thoáng, loại bỏ triệt để lá/cành bệnh đem tiêu hủy ra xa vườn, giảm ẩm độ kéo dài trong tán cây.",
                    'treatment' => "Chọn thuốc dựa trên đúng tác nhân và vị trí nhiễm bệnh: Validamycin, một số Triazole (Hexaconazole, Tebuconazole) hoặc thuốc tiếp xúc Mancozeb/Azoxystrobin có đăng ký trên sầu riêng.",
                    'chemical_groups' => 'Validamycin, Hexaconazole, Tebuconazole, Mancozeb, Azoxystrobin (FRAC 26, FRAC 3, FRAC M03, FRAC 11).',
                    'notes' => "Cây có thể bị bệnh: Sầu riêng, lúa, rau màu, đậu, cây con và một số cây ăn quả.\nTham khảo: [Cháy lá, chết ngọn sầu riêng do Rhizoctonia](https://nongduockobeta.com/blogs/news/benh-chay-la-chet-ngon-tren-cay-sau-rieng-nguyen-nhan-va-bien-phap-ph?srsltid=AfmBOorZYGIYPc3B-kGEGlnxF5bpFCK8kxupxd_4-awwmN255m8J9dyx)",
                ],
                'crop_ids' => array_filter([$sauRiengId]),
                'pesticide_keywords' => ['Validamycin', 'Anvil', 'Mancozeb', 'Asmiltatop', 'Tebaz'],
            ],

            // =========================================================================
            // 5. COLLETOTRICHUM — THÁN THƯ (Nấm thật)
            // =========================================================================
            [
                'match_keys' => ['Colletotrichum', 'Thán Thư'],
                'data' => [
                    'name' => 'Bệnh Thán Thư — Colletotrichum spp.',
                    'pathogen_type' => 'nam',
                    'caunho' => 'Colletotrichum = THÁN THƯ = ĐỐM NÂU/ĐEN MÉP LÁ + VÂN ĐỒNG TÂM (luân phiên nhóm FRAC hạn chế kháng thuốc).',
                    'symptoms' => "Nguyên nhân: Nấm Colletotrichum spp.\nĐiều kiện phát sinh: Mưa nhiều, ẩm độ cao, tán rậm và mô cây bị tổn thương.\nDấu hiệu: Đốm nâu hoặc đen, thường bắt đầu ở mép hoặc chóp lá; vết bệnh lan rộng có vân vòng đồng tâm rõ nét; có thể xuất hiện trên chùm hoa và quả.",
                    'symptoms_detail' => [
                        'la' => 'Đốm nâu hoại tử bắt đầu từ mép/chóp lá lan vào, có viền vàng nhạt, vân vòng đồng tâm, lá khô rách thủng.',
                        'canh_than' => 'Vết nâu đen hơi lõm chạy dọc cành non, làm teo thắt cành và khô ngọn mang hoa.',
                        'goc_re' => 'Không gây hại vùng rễ.',
                        'qua' => 'Bông hoa thối khô đen rụng cuống; trên quả xuất hiện vết đốm tròn lõm sẫm màu, tiết dịch bào tử hồng khi ẩm.',
                    ],
                    'prevention' => "Thu gom bộ phận bệnh nặng tiêu hủy, làm thông thoáng tán; hạn chế nước bắn từ cây bệnh sang cây khỏe; bón phân cân đối tăng Silic, Canxi-Bo.",
                    'treatment' => "Xử lý sớm khi bệnh mới xuất hiện: Mancozeb, Copper oxychloride (Đồng Oxyclorua), Azoxystrobin, Difenoconazole hoặc Tebuconazole. Luân phiên nhóm FRAC phù hợp để hạn chế kháng thuốc.",
                    'chemical_groups' => 'Mancozeb, Copper oxychloride, Azoxystrobin, Difenoconazole, Tebuconazole, Propiconazole (FRAC M03, FRAC M01, FRAC 11, FRAC 3).',
                    'notes' => "Cây có thể bị bệnh: Sầu riêng, xoài, ớt, cà phê, cam quýt, chanh dây và nhiều cây ăn quả khác.\nTham khảo: [Thán thư trên sầu riêng](https://kimnonggoldstar.vn/benh-than-thu-tren-sau-rieng-va-bien-phap-phong-tru/)",
                ],
                'crop_ids' => array_filter([$sauRiengId, $chanhDayId, $caPheId, $coMuiId]),
                'pesticide_keywords' => ['Mancozeb', 'Asmiltatop', 'Tebaz', 'Tilt Super'],
            ],

            // =========================================================================
            // 6. ALTERNARIA — ĐỐM NÂU (Nấm thật) — Bổ sung sầu riêng + chanh dây
            // =========================================================================
            [
                'match_keys' => ['Alternaria', 'Đốm Nâu'],
                'data' => [
                    'name' => 'Bệnh Đốm Nâu — Alternaria spp.',
                    'pathogen_type' => 'nam',
                    'caunho' => 'Alternaria = ĐỐM NÂU CÓ QUẦNG VÀNG/VÒNG ĐỒNG TÂM (không gộp đốm nâu với thán thư chỉ dựa vào màu vết bệnh).',
                    'symptoms' => "Nguyên nhân: Nấm Alternaria spp. nếu đã xác định được tác nhân; tên 'đốm nâu' đơn thuần chưa đủ để kết luận.\nĐiều kiện phát sinh: Độ ẩm cao, lá ướt lâu, tán rậm và tàn dư cây bệnh tồn tại trong vườn.\nDấu hiệu: Đốm nâu, có thể có vòng đồng tâm hoặc quầng vàng; nhiều bệnh khác cũng tạo đốm tương tự.",
                    'symptoms_detail' => [
                        'la' => 'Đốm nâu xuất hiện trên phiến lá, có vân vòng đồng tâm và quầng vàng bao quanh; nhiều vết liên kết làm lá rách thủng và rụng.',
                        'canh_than' => 'Vết sọc sẫm màu trên cuống lá và nhánh non.',
                        'goc_re' => 'Không gây hại vùng rễ.',
                        'qua' => 'Vết đốm nâu lõm nhẹ trên vỏ quả sầu riêng/chanh dây, vỏ chai nhăn nheo.',
                    ],
                    'prevention' => "Thu gom lá bệnh, tỉa cành thông thoáng, cải thiện đối lưu không khí trong vườn; nếu bệnh tăng thì xác định chính xác tác nhân trước khi chọn thuốc.",
                    'treatment' => "Phun thuốc bảo vệ khi bệnh chớm xuất hiện: Mancozeb, Copper oxychloride hoặc một số hoạt chất FRAC 3/11 (Difenoconazole, Azoxystrobin, Tebuconazole) tùy sản phẩm và nhãn đăng ký.",
                    'chemical_groups' => 'Mancozeb, Copper oxychloride, Azoxystrobin, Difenoconazole, Tebuconazole (FRAC M03, FRAC M01, FRAC 11, FRAC 3).',
                    'notes' => "Cây có thể bị bệnh: Sầu riêng, chanh dây, cà chua, khoai tây, ớt và một số cây ăn quả.\n⚠️ Lưu ý lâm sàng: Không gộp đốm nâu với thán thư chỉ dựa vào màu vết bệnh. Cần kiểm tra kỹ viền quầng vàng và mặt dưới vết bệnh.",
                ],
                'crop_ids' => array_filter([$sauRiengId, $chanhDayId]),
                'pesticide_keywords' => ['Mancozeb', 'Asmiltatop', 'Tilt Super', 'Tebaz'],
            ],

            // =========================================================================
            // 7. SEPTORIA — ĐỐM XÁM (Nấm thật) — Bổ sung sầu riêng + chanh dây
            // =========================================================================
            [
                'match_keys' => ['Septoria', 'Đốm Xám'],
                'data' => [
                    'name' => 'Bệnh Đốm Xám — Septoria spp.',
                    'pathogen_type' => 'nam',
                    'caunho' => 'Septoria = ĐỐM LÁ GIỮA XÁM VIỀN SẪM CHẤM ĐEN (cần xác minh tác nhân trên sầu riêng nếu chưa có xét nghiệm).',
                    'symptoms' => "Nguyên nhân: Nấm Septoria spp.; cần xác nhận loài gây bệnh trên cây đang xét.\nĐiều kiện phát sinh: Lá ẩm lâu, mưa nhiều, tàn dư lá bệnh và vườn thiếu thông thoáng.\nDấu hiệu: Đốm lá có phần giữa màu xám tro hoặc nâu nhạt, viền sẫm; đôi khi có chấm đen nhỏ li ti là ổ bào tử nấm; bệnh nặng làm lá vàng và rụng nhanh.",
                    'symptoms_detail' => [
                        'la' => 'Đốm tròn nhỏ 2-5mm, tâm màu xám trắng tro, viền ngoài nâu sẫm, rải rác chấm đen li ti; lá úa vàng và rụng hàng loạt.',
                        'canh_than' => 'Vết sọc đốm nhỏ trên cuống lá và thân cành non.',
                        'goc_re' => 'Không gây hại vùng rễ.',
                        'qua' => 'Vết đốm xám nhỏ trên vỏ quả, làm giảm phẩm cấp mẫu mã quả.',
                    ],
                    'prevention' => "Loại bỏ lá bệnh nặng, hạn chế ẩm độ kéo dài, tỉa giàn/tán cao ráo thông thoáng và theo dõi kỹ đợt lá mới bung đọt.",
                    'treatment' => "Mancozeb, Difenoconazole hoặc các thuốc trừ nấm phù hợp có thể được xem xét theo cây trồng, tác nhân và nhãn đăng ký.",
                    'chemical_groups' => 'Mancozeb, Difenoconazole, Chlorothalonil, Azoxystrobin (FRAC M03, FRAC 3, FRAC M05, FRAC 11).',
                    'notes' => "Cây có thể bị bệnh: Cà chua, cần tây, lúa mì, chanh dây; bệnh trên sầu riêng cần xác minh bằng tài liệu chuyên ngành hoặc chẩn đoán.\n⚠️ Lưu ý: Thư mục này giữ riêng nhưng đánh dấu 'cần xác minh tác nhân trên sầu riêng' nếu chưa có bằng chứng xét nghiệm cụ thể.",
                ],
                'crop_ids' => array_filter([$sauRiengId, $chanhDayId]),
                'pesticide_keywords' => ['Mancozeb', 'Asmiltatop', 'Tilt Super'],
            ],

            // =========================================================================
            // 8. PHOMOPSIS — ĐỐM LÁ, CHÁY LÁ SẦU RIÊNG (Nấm thật)
            // =========================================================================
            [
                'match_keys' => ['Phomopsis'],
                'data' => [
                    'name' => 'Bệnh Đốm Lá, Cháy Lá — Phomopsis durionis',
                    'pathogen_type' => 'nam',
                    'caunho' => 'Phomopsis = ĐỐM NÂU QUẦNG VÀNG LAN CHÁY LÁ (nghiên cứu VN ghi nhận Phomopsis durionis trên sầu riêng).',
                    'symptoms' => "Nguyên nhân: Nấm thuộc nhóm Phomopsis; tài liệu nghiên cứu tại Việt Nam đã xác định Phomopsis durionis liên quan bệnh cháy lá sầu riêng (Cục Đổi mới Công nghệ Việt Nam).\nĐiều kiện phát sinh: Độ ẩm cao, mưa kéo dài, lá/cành bệnh tồn tại trong vườn.\nDấu hiệu: Đốm nâu, có thể có quầng vàng; vết bệnh lan rộng thành từng vùng cháy khô lớn trên phiến lá.",
                    'symptoms_detail' => [
                        'la' => 'Đốm nhỏ màu nâu vàng như đầu kim, lan rộng thành vệt bầu dục màu nâu sẫm viền quầng vàng, sau liên kết thành mảng cháy khô và rụng lá.',
                        'canh_than' => 'Vết đốm sẫm màu trên cọng lá và cành non; cành hoại tử nặng nếu không xử lý kịp.',
                        'goc_re' => 'Không gây hại vùng rễ.',
                        'qua' => 'Vết đốm làm giảm mẫu mã vỏ trái sầu riêng.',
                    ],
                    'prevention' => "Tỉa tán thông thoáng, thu gom lá bệnh tiêu hủy, tránh để tán lá ẩm kéo dài; nếu cành bị hoại tử nặng thì cắt bỏ phần cành bệnh xuống dưới mô lành.",
                    'treatment' => "Mancozeb, thuốc gốc đồng (Copper oxychloride) hoặc hoạt chất trừ nấm nhóm FRAC 3/11 (Azoxystrobin, Difenoconazole, Chlorothalonil) theo nhãn đăng ký.",
                    'chemical_groups' => 'Azoxystrobin, Difenoconazole, Mancozeb, Copper oxychloride, Chlorothalonil (FRAC 11, FRAC 3, FRAC M03, FRAC M01, FRAC M05).',
                    'notes' => "Cây có thể bị bệnh: Sầu riêng, cây ăn quả và cây thân gỗ khác.\nTham khảo: [Hình đốm lá Phomopsis trên sầu riêng](https://www.mardubai.in.th/phomosis-durian01) | Nghiên cứu Cục Đổi mới Công nghệ Việt Nam.",
                ],
                'crop_ids' => array_filter([$sauRiengId]),
                'pesticide_keywords' => ['Asmiltatop', 'Mancozeb', 'Tilt Super', 'Tebaz'],
            ],

            // =========================================================================
            // 9. LASIODIPLODIA — KHÔ CÀNH, HOẠI TỬ MÔ (Nấm thật)
            // =========================================================================
            [
                'match_keys' => ['Lasiodiplodia'],
                'data' => [
                    'name' => 'Bệnh Khô Cành, Hoại Tử Mô — Lasiodiplodia theobromae',
                    'pathogen_type' => 'nam',
                    'caunho' => 'Lasiodiplodia = VẾT THƯƠNG + CÂY STRESS → KHÔ CÀNH (cắt bỏ phần chết + khử trùng dụng cụ, thuốc lá không chữa được gỗ chết).',
                    'symptoms' => "Nguyên nhân: Nấm Lasiodiplodia spp.; Lasiodiplodia theobromae đã được ghi nhận liên quan bệnh cháy lá và khô cành sầu riêng tại Việt Nam (Cục Đổi mới Công nghệ Việt Nam).\nĐiều kiện phát sinh: Cây suy yếu, cành bị tổn thương cơ học, điều kiện nóng ẩm hoặc mô cây bị stress sau thu hoạch.\nDấu hiệu: Cành khô dần, vỏ/mô cành chuyển nâu thâm đen, xuất hiện vùng hoại tử mục khô làm chết toàn bộ nhánh.",
                    'symptoms_detail' => [
                        'la' => 'Lá trên cành bệnh mất màu xanh, héo rũ, khô cháy vàng nhưng vẫn dính trên cành một thời gian trước khi rụng.',
                        'canh_than' => 'Vỏ cành nứt khô chuyển nâu đen, mô gỗ bên trong hoại tử thâm mục, cành giòn dễ gãy ngang.',
                        'goc_re' => 'Ít biểu hiện trực tiếp ở rễ.',
                        'qua' => 'Có thể gây thối cuống trái và thối núm quả.',
                    ],
                    'prevention' => "Cắt bỏ cành bệnh xuống phần mô gỗ khỏe 10-15cm; khử trùng dụng cụ kéo tỉa bằng cồn hoặc vôi; thu gom cành bệnh khỏi vườn; hạn chế gây thương tích khi tỉa cành.",
                    'treatment' => "Quét thuốc gốc đồng (Copper oxychloride, Bordeaux) vào vết cắt. Phun thuốc trừ nấm phổ rộng nhóm FRAC 3/11 (Difenoconazole, Tebuconazole, Mancozeb) có đăng ký phù hợp. ⚠️ Không xem thuốc phun lá là đủ để chữa phần gỗ đã chết.",
                    'chemical_groups' => 'Difenoconazole, Tebuconazole, Mancozeb, Copper oxychloride (FRAC 3, FRAC M03, FRAC M01).',
                    'notes' => "Cây có thể bị bệnh: Sầu riêng, xoài, ca cao, cây có múi và nhiều cây thân gỗ nhiệt đới.\nTham khảo: Báo cáo Cục Đổi mới Công nghệ Việt Nam ghi nhận Lasiodiplodia theobromae trên sầu riêng.",
                ],
                'crop_ids' => array_filter([$sauRiengId, $coMuiId]),
                'pesticide_keywords' => ['Tebaz', 'Tilt Super', 'Mancozeb', 'Asmiltatop'],
            ],

            // =========================================================================
            // 10. NẤM HỒNG — BỆNH THÂN CÀNH (Nấm thật)
            // =========================================================================
            [
                'match_keys' => ['Nấm Hồng', 'Corticium', 'Erythricium'],
                'data' => [
                    'name' => 'Bệnh Nấm Hồng — Erythricium salmonicolor',
                    'pathogen_type' => 'nam',
                    'caunho' => 'Nấm hồng = MẢNG NẤM HỒNG CAM TRÊN VỎ CÀNH (Corticium salmonicolor, cắt cành nặng + quét thuốc cành chạc ba).',
                    'symptoms' => "Nguyên nhân: Nấm Erythricium salmonicolor (tên cũ thường gặp: Corticium salmonicolor).\nĐiều kiện phát sinh: Mưa nhiều, độ ẩm cao, tán cây rậm rạp, cành thiếu thông thoáng (đặc biệt ở các chạc ba).\nDấu hiệu: Lớp nấm màu hồng hoặc hồng cam trên vỏ cành; vỏ bị tổn thương nứt nẻ, cành phía trên bị suy kiệt và khô chết.",
                    'symptoms_detail' => [
                        'la' => 'Lá trên cành bị nấm hồng bao quanh ngả vàng úa, héo khô và rụng trơ trụi cành.',
                        'canh_than' => 'Lớp màng sợi nấm màu hồng hoặc hồng cam phủ quanh vỏ cành, sau đó nứt nẻ chảy nhựa nhẹ rồi chết khô.',
                        'goc_re' => 'Không gây hại vùng rễ.',
                        'qua' => 'Không gây hại trực tiếp trên trái.',
                    ],
                    'prevention' => "Cắt bỏ cành nhiễm nặng; làm thông thoáng tán trước mùa mưa; vệ sinh dụng cụ tỉa; xử lý phần bệnh còn lại bằng sản phẩm có chỉ dẫn phù hợp.",
                    'treatment' => "Quét hoặc phun trực tiếp vào thân cành bệnh: Validamycin, Hexaconazole, thuốc gốc đồng (Copper Hydroxide, Đồng Oxyclorua) hoặc Mancozeb theo đúng nhãn đăng ký.",
                    'chemical_groups' => 'Validamycin, Hexaconazole, Copper oxychloride, Copper Hydroxide, Mancozeb (FRAC 26, FRAC 3, FRAC M01, FRAC M03).',
                    'notes' => "Cây có thể bị bệnh: Sầu riêng, cao su, chè, ca cao, cà phê và một số cây thân gỗ nhiệt đới.\nTham khảo: [Nấm hồng trên cành sầu riêng](https://giangtaycorp.com/ki-thuat-trong-cay/ky-thuat-trong-cay-sau-rieng/phong-tru-benh-nam-hong-tren-sau-rieng-1.html)",
                ],
                'crop_ids' => array_filter([$sauRiengId, $caPheId]),
                'pesticide_keywords' => ['Validamycin', 'Anvil', 'Mancozeb'],
            ],

            // =========================================================================
            // 11. PHẤN TRẮNG — BỘT TRẮNG TRÊN MÔ NON (Nấm thật)
            // =========================================================================
            [
                'match_keys' => ['Phấn Trắng', 'Oidium'],
                'data' => [
                    'name' => 'Bệnh Phấn Trắng — Oidium spp.',
                    'pathogen_type' => 'nam',
                    'caunho' => 'Phấn trắng = BỘT TRẮNG TRÊN MÔ NON VÀ LÁ (Lưu huỳnh / Triazole, không phối lưu huỳnh với dầu khoáng).',
                    'symptoms' => "Nguyên nhân: Nấm gây phấn trắng, thường thuộc nhóm Oidium spp.; cần xác định đúng tác nhân trên cây bị bệnh.\nĐiều kiện phát sinh: Thời tiết và độ ẩm thuận lợi, mô non dễ nhiễm; điều kiện phát bệnh không giống hoàn toàn các bệnh cần lá ướt kéo dài.\nDấu hiệu: Lớp bột trắng như phấn rôm phủ trên bề mặt lá, chồi non hoặc bộ phận non làm lá xoăn vẹo biến dạng.",
                    'symptoms_detail' => [
                        'la' => 'Lớp phấn trắng như bột mì bám trên mặt lá non, lá gợn sóng biến dạng, mép lá cong queo rũ xuống.',
                        'canh_than' => 'Chồi non và cành non bị bao phủ lớp bụi trắng, chồi chùn lại còi cọc không vươn dài.',
                        'goc_re' => 'Không gây hại ở rễ.',
                        'qua' => 'Bám trên chùm hoa và quả non làm hoa khô rụng, vỏ quả non sần sùi kém phát triển.',
                    ],
                    'prevention' => "Tỉa tán vừa phải tạo đối lưu không khí, theo dõi sát chồi non và trái non; xử lý sớm khi bệnh mới xuất hiện.",
                    'treatment' => "Lưu huỳnh (Sulfur), một số thuốc nhóm Triazole (FRAC 3: Hexaconazole, Difenoconazole, Tebuconazole) hoặc hoạt chất chuyên trị phấn trắng theo nhãn đăng ký.\n⚠️ Cảnh báo: Không tự phối hợp Lưu huỳnh với Dầu khoáng nếu nhãn cảnh báo nguy cơ cháy lá.",
                    'chemical_groups' => 'Hexaconazole, Difenoconazole, Tebuconazole, Sulfur / Lưu huỳnh (FRAC 3, FRAC M02).',
                    'notes' => "Cây có thể bị bệnh: Nho, dưa, xoài, hoa hồng, sầu riêng, chanh dây.\nTham khảo: [Phấn trắng trên sầu riêng](https://vnfarm.com.vn/benh-phan-trang-sau-rieng)",
                ],
                'crop_ids' => array_filter([$sauRiengId, $chanhDayId]),
                'pesticide_keywords' => ['Anvil', 'Asmiltatop', 'Japa Vil', 'Tilt Super'],
            ],

            // =========================================================================
            // 12. ĐỐM RONG — TẢO ĐỎ (Tảo ký sinh, KHÔNG PHẢI NẤM)
            // =========================================================================
            [
                'match_keys' => ['Đốm Rong', 'Cephaleuros'],
                'data' => [
                    'name' => 'Bệnh Đốm Rong / Tảo Đỏ — Cephaleuros spp.',
                    'pathogen_type' => 'vi_khuan',
                    'caunho' => 'Đốm rong = TẢO KÝ SINH CEPHALEUROS (KHÔNG PHẢI NẤM, thuốc nấm không hiệu lực, dùng thuốc gốc đồng).',
                    'symptoms' => "Nguyên nhân: Tảo gây bệnh thuộc nhóm Cephaleuros spp. Đây là bệnh do TẢO, KHÔNG PHẢI NẤM THẬT.\nĐiều kiện phát sinh: Vườn ẩm ướt, tán rậm, cây sinh trưởng yếu và thông thoáng kém.\nDấu hiệu: Đốm tròn màu xanh xám, nâu đỏ hoặc đỏ cam như gạch tôm, bề mặt hơi nổi nhung mịn và sần trên lá già và vỏ thân cành.",
                    'symptoms_detail' => [
                        'la' => 'Đốm tròn nhung màu đỏ cam gạch tôm nhô cao trên mặt lá già, sau hóa xám nâu làm lá dày cộm, cằn cỗi.',
                        'canh_than' => 'Lớp màng đỏ cam bám chặt trên vỏ thân cành, làm vỏ sần sùi nứt nẻ, nhánh kém phát triển.',
                        'goc_re' => 'Không gây hại vùng rễ.',
                        'qua' => 'Ít tấn công trực tiếp quả.',
                    ],
                    'prevention' => "Tỉa tán nhận đủ ánh sáng mặt trời, giảm ẩm độ kéo dài, chăm sóc bón phân cân đối tăng cường Magie, Kẽm giúp cây khỏe.",
                    'treatment' => "Phun hoặc quét thuốc trừ bệnh gốc đồng: Copper Hydroxide, Đồng Oxyclorua (Copper oxychloride), Bordeaux hoặc Nano Đồng. ⚠️ Không mặc định mọi thuốc trừ nấm đều có hiệu lực với tảo.",
                    'chemical_groups' => 'Copper oxychloride, Copper Hydroxide, Đồng Bordeaux, Nano Đồng (FRAC M01).',
                    'notes' => "Cây có thể bị bệnh: Sầu riêng, xoài, chè, cà phê, cam quýt, ổi và nhiều cây thân gỗ nhiệt đới.\nTham khảo: [Đốm rong trên sầu riêng](https://anphatnong.com.vn/benh-dom-rong-tren-cay-sau-rieng-nguyen-nhan-va-cach-xu-ly)",
                ],
                'crop_ids' => array_filter([$sauRiengId, $caPheId, $coMuiId]),
                'pesticide_keywords' => ['Alien', 'Dimethor'],
            ],

            // =========================================================================
            // 13. BỆNH MỚI BỔ SUNG: BỆNH ĐỐM DẦU / BÃ TRẦU TRÊN CÂY CHANH DÂY
            // (Phytophthora nicotianae & Vi khuẩn Pseudomonas)
            // =========================================================================
            [
                'match_keys' => ['Đốm Dầu', 'Bã Trầu'],
                'data' => [
                    'name' => 'Bệnh Đốm Dầu / Bã Trầu — Phytophthora nicotianae & Pseudomonas spp.',
                    'crop_name' => 'Chanh dây',
                    'pathogen_type' => 'nam',
                    'caunho' => 'Đốm dầu (bã trầu) = VẾT THẤM DẦU TRÊN TRÁI + THỐI LAN DÂY THÂN (Phytophthora / Vi khuẩn, kiểm tra vết bệnh trước khi kê thuốc).',
                    'symptoms' => "Nguyên nhân: Phytophthora nicotianae (nấm giả Oomycetes); một số tài liệu Việt Nam còn đề cập vi khuẩn Pseudomonas hoặc phân loại đốm dầu do vi khuẩn.\nĐiều kiện phát sinh: Mưa nhiều, ẩm độ cao, giàn rậm rạp, thoát nước kém.\nDấu hiệu:\n• Trên trái: Vết nâu sẫm hoặc xanh đen trông như bị thấm dầu ăn; vết có thể lan rộng làm trái thối nhũn hoặc rụng khi bệnh nặng.\n• Trên lá: Đốm sẫm màu ngậm nước, ban đầu nhỏ rồi lan thành mảng loang; bệnh nặng làm lá hư hỏng và rụng.\n• Trên thân/dây: Xuất hiện vết lõm thâm nâu, sũng nước hoặc thối lan, teo thắt cành.",
                    'symptoms_detail' => [
                        'la' => 'Đốm sẫm màu ngậm nước loang lổ như thấm dầu, mép vết bệnh ủng nước, lá úa rách và rụng sớm.',
                        'canh_than' => 'Vết lõm thâm nâu hoặc sũng nước chạy dọc dây thân, cành teo thắt (phân biệt với thối thân/gốc cổ rễ).',
                        'goc_re' => 'Giàn ẩm ướt kém thoát nước làm hệ rễ suy giảm sức đề kháng.',
                        'qua' => 'Vết nâu sẫm hoặc xanh đen bóng như bị nhúng dầu ăn, loang nhanh làm thối ủng toàn quả và rụng non.',
                    ],
                    'prevention' => "Thoát nước tốt, tỉa giàn thông thoáng (nâng giàn cao ráo 1.6 - 1.8m), thu gom tiêu hủy triệt để tàn dư bệnh, dùng cây giống sạch bệnh đạt chuẩn F1.",
                    'treatment' => "Xử lý nhóm Oomycetes & Thuốc gốc đồng: Phosphonate / Axit phosphorous, Fosetyl-Al, Đồng Oxychloride (Copper oxychloride), Dimethomorph, Mancozeb theo hướng dẫn trên chanh dây.\n⚠️ Kiểm tra nhãn và danh mục đăng ký hiện hành trước khi tư vấn sử dụng.",
                    'chemical_groups' => 'Phosphonate / Axit phosphorous, Fosetyl-Al, Copper oxychloride, Dimethomorph, Mancozeb (FRAC P07, FRAC 40, FRAC M01, FRAC M03).',
                    'notes' => "Cây có thể bị bệnh: Chanh dây (chanh leo).\n⚠️ Lưu ý chẩn đoán phân biệt quan trọng: Trung tâm Khuyến nông Quốc gia mô tả bệnh đốm nâu do Alternaria và bệnh thối thân, thối quả do Phytophthora nicotianae là các bệnh riêng trên chanh dây. Đốm dầu dạng ướt cũng có thể bị nhầm với thán thư. Không chốt tác nhân chỉ theo tên bệnh dân gian.\nTham khảo: [Naseeds – Bệnh bã trầu trên chanh dây](https://naseeds.com/ky-thuat-canh-tac/benh-ba-trau-tren-chanh-day/) | [Trung tâm Khuyến nông Quốc gia – Bệnh hại chanh leo](https://khuyennongvn.gov.vn/khoa-hoc-cong-nghe/khcn-trong-nuoc/trieu-chung-dac-diem-phat-sinh-gay-hai-cua-mot-so-sau-benh-chinh-tren-cay-chanh-leo--phan-1-21008.html?utm_source=chatgpt.com)",
                ],
                'crop_ids' => array_filter([$chanhDayId]),
                'pesticide_keywords' => ['Agri-Fos', 'Delta Fos', 'Alien', 'Dimethor', 'Mancozeb', 'Ridomil'],
            ],

            // =========================================================================
            // CÁC ĐỐI TƯỢNG BỆNH / CÔN TRÙNG QUAN TRỌNG KHÁC (GIỮ NGUYÊN CHUẨN HÓA)
            // =========================================================================
            [
                'match_keys' => ['Virus', 'Woodiness', 'Cứng Trái'],
                'data' => [
                    'name' => 'Bệnh Virus Khảm & Hóa Gỗ Cứng Trái — Passion Fruit Woodiness Virus (PWV)',
                    'pathogen_type' => 'virus',
                    'caunho' => 'Virus = KHẢM + XOĂN + CỨNG TRÁI (không dùng thuốc nấm, phải diệt rệp/bọ trĩ truyền bệnh!).',
                    'symptoms' => "Virus làm lá chanh dây bị khảm loang lổ xanh vàng, biến dạng xoăn tít, mép lá cong queo. Trái bị méo mó, vỏ quả dày cộm cứng như gỗ, dịch quả ít và chua. Lây lan qua rệp muội, bọ trĩ và dụng cụ tỉa bấm cành.",
                    'symptoms_detail' => [
                        'la' => 'Lá non bị khảm xanh vàng xen kẽ, phiến lá gồ ghề phồng rộp biến dạng xoăn tít.',
                        'canh_than' => 'Đọt non chùn ngắn lại, cây còi cọc ngừng vươn ngọn.',
                        'goc_re' => 'Rễ kém phát triển do cây mất khả năng quang hợp.',
                        'qua' => 'Trái méo mó gồ ghề, vỏ dày cứng như gỗ, không có ruột hoặc ít dịch ruột.',
                    ],
                    'prevention' => "Sử dụng cây giống sạch bệnh đạt chuẩn F1. Tuyệt đối không dùng dao kéo cắt cành từ cây bệnh sang cây khỏe mà không khử trùng.",
                    'treatment' => "KHÔNG CÓ THUỐC ĐẶC TRỊ NẤM/VI KHUẨN! Tiêu hủy nhổ bỏ cây bệnh nặng. Phun thuốc trừ côn trùng chích hút (bọ trĩ, rệp muội) để chặn đường truyền virus.",
                    'chemical_groups' => 'Thuốc trừ sâu chích hút: Spinetoram, Acetamiprid, Dinotefuran, Dầu khoáng (IRAC 5, IRAC 4A).',
                    'notes' => '⚠️ Lưu ý cốt lõi: Virus không có thuốc trị, chỉ có phòng ngừa côn trùng môi giới và chọn giống sạch!',
                ],
                'crop_ids' => array_filter([$chanhDayId]),
                'pesticide_keywords' => ['Thần Chớp', 'Nofara', 'Riegenf'],
            ],

            [
                'match_keys' => ['Tuyến Trùng', 'Meloidogyne'],
                'data' => [
                    'name' => 'Tuyến Trùng Hại Rễ — Meloidogyne spp. & Pratylenchus spp.',
                    'pathogen_type' => 'tuyen_trung',
                    'caunho' => 'Tuyến trùng = RỄ U SẦN NỐT BƯỚU (mở đường nấm rễ, xử lý tuyến trùng + phục hồi rễ).',
                    'symptoms' => "Tuyến trùng nốt sần (Meloidogyne spp.) và tuyến trùng thương tổn (Pratylenchus spp.) chui vào rễ hút dịch dinh dưỡng, tạo thành các nốt sần u bướu phồng tròn. Rễ mất khả năng hút nước, tạo cửa ngõ cho Phytophthora và Fusarium xâm nhập phá hoại thứ cấp gây chết cây.",
                    'symptoms_detail' => [
                        'la' => 'Lá vàng nhạt đọt non, phiến lá mỏng cụp xuống, cây sinh trưởng còi cọc ủ rũ dù được bón phân đầy đủ.',
                        'canh_than' => 'Cành khẳng khiu, đốt thân ngắn, cây không chịu phóng cơi đọt mới.',
                        'goc_re' => 'Hệ rễ tơ xuất hiện chuỗi nốt sần u bướu tròn như chuỗi hạt, chóp rễ bị cùn đen thối mục.',
                        'qua' => 'Hoa rụng nhiều, tỷ lệ đậu trái kém, quả non chậm lớn và dễ rụng non.',
                    ],
                    'prevention' => "Bước 1 — Canh tác:\n• Bón nhiều phân hữu cơ hoai mục ủ vi sinh và Axit Humic để đất tơi xốp, kích thích rễ cám phục hồi.\n• Trồng xen cúc vạn thọ quanh rìa tán để xua đuổi tuyến trùng tự nhiên.\n• Định kỳ tưới chế phẩm sinh học nấm bẫy tuyến trùng Paecilomyces lilacinus.",
                    'treatment' => "Bước 2 — Xử lý thuốc đặc trị:\n• Tưới thuốc đặc trị tuyến trùng vào vùng đất quanh tán rễ: Fluopyram (Velum Prime) hoặc Abamectin (Resgant).\n• Tưới 2 lần cách nhau 15-20 ngày vào đầu mùa mưa.\nBước 3 — Phục hồi rễ:\n• Sau khi diệt tuyến trùng 7-10 ngày, tưới dưỡng rễ Humic + Amino Acid để tái tạo bộ rễ mới.",
                    'chemical_groups' => 'Fluopyram, Abamectin, Chế phẩm sinh học Paecilomyces lilacinus (Nhóm FRAC 7, IRAC 6, Sinh học BM02).',
                    'notes' => 'Tuyến trùng phát triển bùng nổ trên nền đất cát pha nghèo hữu cơ và đất bị chua (pH < 5.0).',
                ],
                'crop_ids' => array_filter([$sauRiengId, $chanhDayId, $caPheId, $hoTieuId]),
                'pesticide_keywords' => ['Velum Prime', 'Resgant'],
            ],

            [
                'match_keys' => ['Hội Chứng Vàng Lá'],
                'data' => [
                    'name' => 'Hội Chứng Vàng Lá – Thối Rễ – Suy Cây Sầu Riêng',
                    'pathogen_type' => 'nam',
                    'caunho' => 'Vàng lá = Phyto + Pythium + Fusarium + Tuyến trùng + Úng (Khám rễ trước khi kê đơn thuốc!).',
                    'symptoms' => "Hội chứng phức tạp đa nguyên nhân làm rễ hư hại, cây vàng lá rụng cành và suy kiệt dần. Kỹ sư phải chẩn đoán 5 bước phân biệt: Đất có úng không? Rễ còn trắng hay nâu đen mục? Gốc có xì mủ không? Có nốt sần tuyến trùng không? Cây vàng nhanh hay từ từ?",
                    'symptoms_detail' => [
                        'la' => 'Vàng lá toàn cây hoặc vàng từng cành, lá rụng trơ cành, đọt non chùn lại không phát triển.',
                        'canh_than' => 'Có thể kèm xì mủ gốc (Phytophthora) hoặc khô cành mạch dẫn thâm nâu (Fusarium).',
                        'goc_re' => 'Rễ tơ thối mục, rụng vỏ rễ, chóp rễ cụt đen hoặc xuất hiện các nốt sần u bướu tuyến trùng.',
                        'qua' => 'Rụng hoa, rụng trái non hàng loạt, cây suy kiệt.',
                    ],
                    'prevention' => "Khơi thông mương rãnh thoát nước, hạ mực nước ngầm, nâng pH đất lên 6.0, không bón phân hóa học khi rễ đang hỏng.",
                    'treatment' => "Xử lý thuốc theo đúng nguyên nhân chẩn đoán (Oomycetes: Phosphonate/Metalaxyl; Nấm đất: Triazole/Mancozeb; Tuyến trùng: Fluopyram/Abamectin). Sau đó tưới phục hồi rễ bằng Humic + Trichoderma + Bacillus.",
                    'chemical_groups' => 'Phosphonate, Metalaxyl-M, Dimethomorph, Mancozeb, Hexaconazole, Fluopyram, Abamectin, Trichoderma, Bacillus (FRAC P07, FRAC 4, FRAC 40, FRAC M03, FRAC 3, FRAC 7, IRAC 6).',
                    'notes' => 'Khách hàng kêu vàng lá, tuyệt đối không bốc 1 loại thuốc bừa bãi. Phải hỏi kỹ các câu hỏi chẩn đoán phân biệt.',
                ],
                'crop_ids' => array_filter([$sauRiengId]),
                'pesticide_keywords' => ['Agri-Fos', 'Delta Fos', 'Alien', 'Dimethor', 'Ridomil', 'Anvil', 'Mancozeb', 'Velum Prime'],
            ],

            // =========================================================================
            // NHÓM SÂU HẠI CHÍCH HÚT (6 THƯ MỤC CHUẨN HÓA THEO SỔ TAY BÁN THUỐC)
            // =========================================================================

            // --- 1. BỌ TRĨ ---
            [
                'match_keys' => ['Bọ Trĩ', 'Thrips'],
                'data' => [
                    'name' => 'Bọ Trĩ Hại Cây Trồng — Thrips spp.',
                    'pathogen_type' => 'sau_hai',
                    'caunho' => 'Bọ trĩ = LÁ NON BẠC, XOĂN + HOA VÀ TRÁI NON BỊ SẸO (ẩn trong đọt non/hoa, Spinetoram, Abamectin).',
                    'image' => 'https://images.openai.com/static-rsc-4/OpggqoegeRjrUCoXMEk1yEubbbp81sRW-kAZ3FYDgNx0DZToNcwSGTSlXoQdiEQXy8gQJcSa2YPL7UhoY4UswOmaVnuudL5YNliXRXNxIt0ILEyKtU2emeSYSeacdexOd9mNKWezUhlIQlJY3WkcA8hOHU0LUfen3EibiadpSOo?purpose=inline',
                    'images' => [
                        'https://images.openai.com/static-rsc-4/OpggqoegeRjrUCoXMEk1yEubbbp81sRW-kAZ3FYDgNx0DZToNcwSGTSlXoQdiEQXy8gQJcSa2YPL7UhoY4UswOmaVnuudL5YNliXRXNxIt0ILEyKtU2emeSYSeacdexOd9mNKWezUhlIQlJY3WkcA8hOHU0LUfen3EibiadpSOo?purpose=inline',
                        'https://images.openai.com/static-rsc-4/4aocEQL17BpDQARO_2j4Ivn6KF6xOrFJzmzo-EXt7B76mZQRBlzdeRqvzwpII4Xt7Ie_ejznnLyQE19REf2V2uc9Qqu34324nFRBEQY8U-JTGi0dlFOxtzp1j3htp5Oo0JGHgplL-TicR6YLD5ouubCsALDR2uLPPoolP4D-GUk?purpose=inline',
                        'https://images.openai.com/static-rsc-4/pM2ZnfL7FS9xHvytTXTGOMtOQo4XvYRbeTVJSd0lDPlXEoH68YSuziAjvMbAiHe_f38vpRuWKutJ9cQx6NLZO36O16MXK7ZE5Up_oOdAZkEh-6qa3bccF6cq7_HqDYI_NQBCo9KskT48FpJz6GFrMqmMXAIwB8H8ivSyOnZqCWU?purpose=inline',
                    ],
                    'symptoms' => "Đặc điểm: Côn trùng rất nhỏ, thân thon dài; thường ẩn trong đọt non, hoa và mặt dưới lá.\nCây bị hại: Sầu riêng, chanh dây, cà phê, ớt, dưa, xoài và nhiều cây trồng khác.\nDấu hiệu: Lá non xoăn, biến dạng, có vết bạc hoặc sẹo; hoa và trái non bị sần sùi, nám da cám.",
                    'symptoms_detail' => [
                        'la' => 'Lá non xoăn, phiến lá biến dạng quăn queo, mặt dưới lá có vệt sáng bóng ánh bạc hoặc xước rám màu gỉ đồng.',
                        'canh_than' => 'Chồi đọt non bị chùn lại, phát triển dị dạng, còi cọc ngừng vươn ngọn.',
                        'goc_re' => 'Không gây hại ở rễ.',
                        'qua' => 'Hoa bị khô đen rụng cuống, trái non bị sần sùi, xuất hiện quầng sẹo xước cám quanh đài hoa và vỏ quả.',
                    ],
                    'prevention' => "Theo dõi đọt non và hoa định kỳ, vệ sinh vườn sạch cỏ dại, hạn chế phun thuốc tràn lan làm chết thiên địch (bọ xít bắt mồi Orius, bọ rùa).",
                    'treatment' => "Phun thuốc khi cơi đọt mới nhú hạt gạo đến hé mũi giáo hoặc trước khi hoa nở rộ. Luân phiên các nhóm hoạt chất IRAC: Spinetoram (Radiant), Spinosad, Abamectin, Cyantraniliprole, Imidacloprid, Thiamethoxam, Acetamiprid.",
                    'chemical_groups' => 'Spinetoram, Spinosad, Abamectin, Cyantraniliprole, Thiamethoxam, Imidacloprid, Acetamiprid, Dinotefuran, Sulfoxaflor (IRAC 5, IRAC 6, IRAC 28, IRAC 4A, IRAC 4C).',
                    'notes' => 'Chọn đúng sản phẩm có đăng ký cho cây trồng và đối tượng cần trị. Bọ trĩ phát triển mạnh vào mùa khô, nắng nóng và cơi đọt non ra rộ.',
                ],
                'crop_ids' => array_filter([$sauRiengId, $chanhDayId, $caPheId, $coMuiId]),
                'pesticide_keywords' => ['Nofara', 'Thần Chớp', 'THPRO', 'Riegenf', 'Resgant'],
            ],

            // --- 2. BỌ XÍT MUỖI ---
            [
                'match_keys' => ['Bọ Xít Muỗi', 'Helopeltis'],
                'data' => [
                    'name' => 'Bọ Xít Muỗi — Helopeltis spp.',
                    'pathogen_type' => 'sau_hai',
                    'caunho' => 'Bọ xít muỗi = VẾT CHÍCH NÂU ĐEN + MÔ NON HOẠI TỬ (thân mảnh chân dài, cúc tổng hợp Lambda-cyhalothrin).',
                    'image' => 'https://images.openai.com/static-rsc-4/Xek9quNvACrHyrgK3c_qCHCNFDD1lGjuUYLJiaH2Wgo-K6-NcPJhxRyzfKhDAx1BcX1JdeVRMHK_ac-zCrRvlO5oNGUSrQmleAh02-CVr1QwmeOhaaFF5Wt2DKiRAoITQqaRa4-W5nsWU6Q1efqnnFjMZ_IA8FDzQMb4FPtP5_0?purpose=inline',
                    'images' => [
                        'https://images.openai.com/static-rsc-4/Xek9quNvACrHyrgK3c_qCHCNFDD1lGjuUYLJiaH2Wgo-K6-NcPJhxRyzfKhDAx1BcX1JdeVRMHK_ac-zCrRvlO5oNGUSrQmleAh02-CVr1QwmeOhaaFF5Wt2DKiRAoITQqaRa4-W5nsWU6Q1efqnnFjMZ_IA8FDzQMb4FPtP5_0?purpose=inline',
                        'https://images.openai.com/static-rsc-4/n8m5B58K9e5tklw5anrvWl5xtrcCM3p9p2xcoUgM_fUgYzcwSWpC-9oZ6a9DZLoxRLsYPsWWQSfeJBWmcrCoealK73jcPX9CgaeQxM2oen03CtuQ-w9oGQpW-UaZZsobwtKE3vKKGATazG2TdKFH9GKYsC9xdmkzZhDSeT0ll1U?purpose=inline',
                        'https://images.openai.com/static-rsc-4/VJflJhGcKIbNflVyP7B5xDKklIGnSbS44YElFjjhWB57oMsoWFERHrsRd0mfP7MZvSBMB5f4z4RFZI1rNUtWQnY0wiP1_yDAJP75XoHqsyhyJ7uvCzEQa2ZPG_3zEZ3zZiVvM64DotJ9sI_8z7hNDgS0ggEJsqL0b3FzLAWXGu4?purpose=inline',
                    ],
                    'symptoms' => "Đặc điểm: Côn trùng thân mảnh, chân dài; dùng vòi chích hút mô cây.\nCây bị hại: Sầu riêng, chanh dây, cà phê, ca cao, chè và một số cây ăn trái khác.\nDấu hiệu: Vết chích ban đầu nhỏ úng nước, sau chuyển nâu đen; đọt non héo khô, cành non hoặc trái non có vết hoại tử.",
                    'symptoms_detail' => [
                        'la' => 'Lá non bị chích hút có các chấm đen thủng lỗ chỗ, mép lá cong queo, chồi non héo rũ và khô chết.',
                        'canh_than' => 'Vết chích màu nâu đen trên vỏ cành non, làm cành bị nứt, sần sùi và khô chết cành.',
                        'goc_re' => 'Không gây hại ở rễ.',
                        'qua' => 'Vết chích đen lõm trên vỏ quả non sầu riêng/chanh dây/cà phê, quả bị ghẻ sần, méo mó hoặc rụng non.',
                    ],
                    'prevention' => "Kiểm tra cây ở rìa vườn và nơi rậm rạp râm mát (thường xuất hiện sáng sớm hoặc chiều mát), phát hiện sớm, tỉa cành tạo tán thông thoáng, dọn sạch cỏ dại.",
                    'treatment' => "Phun thuốc vào lúc sáng sớm hoặc chiều tối khi bọ xít muỗi hoạt động mạnh. Sử dụng nhóm cúc tổng hợp (Pyrethroid): Lambda-cyhalothrin, Permethrin, Cypermethrin, Alpha-cypermethrin, Deltamethrin, Bifenthrin.",
                    'chemical_groups' => 'Lambda-cyhalothrin, Cypermethrin, Permethrin, Alpha-cypermethrin, Deltamethrin, Bifenthrin (Nhóm Cúc tổng hợp Pyrethroid - IRAC 3A).',
                    'notes' => '⚠️ Lưu ý bán thuốc: Không mặc định thuốc trị bọ trĩ sẽ trị tốt bọ xít muỗi. Cần tra cứu đúng hoạt chất cúc tổng hợp đăng ký cho đúng cây trồng và đối tượng bọ xít muỗi.',
                ],
                'crop_ids' => array_filter([$sauRiengId, $chanhDayId, $caPheId, $coMuiId]),
                'pesticide_keywords' => ['Riegenf', 'THPRO', 'Thần Chớp'],
            ],

            // --- 3. CÁC LOẠI RỆP CHÍCH HÚT KHÁC (RỆP MUỘI, RỆP MỀM, RỆP BÔNG) ---
            [
                'match_keys' => ['Rệp Muội', 'Rệp Mềm', 'Rệp Bông', 'Rệp Chích Hút', 'Aphids'],
                'data' => [
                    'name' => 'Rệp Muội, Rệp Mềm & Rệp Chích Hút Khác — Aphids spp.',
                    'pathogen_type' => 'sau_hai',
                    'caunho' => 'Rệp chích hút khác = RỆP MỀM HOẶC RỆP MUỘI TỤ THÀNH CỤM (đọt quăn queo, tiết mật nấm bồ hóng, Flonicamid, Pymetrozine).',
                    'image' => 'https://images.openai.com/static-rsc-4/OqSf_97eLKB43Q4V2G6MxWZ3Ls3_QL4Of2NdpHKlHX7gdQNSUziuwdvY9G50Qb-KN-xs2vj-ttZCK1nS-rn8PzoZYRas3yWpJnUDBhgLfJ7skVJOCwOqevLLyQSO62xgXXSxG7v08Ao8vkYx5r-K0S6AWxEkUIlYSivkcC5Vml4?purpose=inline',
                    'images' => [
                        'https://images.openai.com/static-rsc-4/OqSf_97eLKB43Q4V2G6MxWZ3Ls3_QL4Of2NdpHKlHX7gdQNSUziuwdvY9G50Qb-KN-xs2vj-ttZCK1nS-rn8PzoZYRas3yWpJnUDBhgLfJ7skVJOCwOqevLLyQSO62xgXXSxG7v08Ao8vkYx5r-K0S6AWxEkUIlYSivkcC5Vml4?purpose=inline',
                        'https://images.openai.com/static-rsc-4/ntkwLhKgpJoPqfHF-8EIeCHF3F5rv_zrNPTPRhd65z-bADJzng-7Q4EAQJ_TB1uEGv8DUFVRyhhUoOWMqwAYz1_NK2Q4_uIoJsGYdbG5jxJq9NvalK42f6AvNH96vd7kuCFFGFLDyQtMFrf-mJoboswUFqJG6fjarXb5UeFUjXc?purpose=inline',
                        'https://images.openai.com/static-rsc-4/m9BneBRNt9pubRnLxbIdn-vemvtM_OQ2fTELFqNkXdmgW1Boo03SzqoxPKV2YJOgdEUQn-EjPY6le-vLSOqSoKlTNPfe-n2W2445v9lPRZMnw-WglEmXA3yw0G7KV9dN4f9ATcHWVytT9bVfrsj71jyw3oNec4-ALmEMtaULO9U?purpose=inline',
                    ],
                    'symptoms' => "Đặc điểm: Côn trùng cơ thể mềm, nhỏ; thường tụ tập thành từng đàn dày đặc ở đọt non, cuống lá và mặt dưới lá bánh tẻ.\nCây bị hại: Chanh dây, sầu riêng, cà phê, rau màu và nhiều cây ăn trái.\nDấu hiệu: Cụm côn trùng tập trung ở đọt non, cuống lá; lá quăn queo, cây suy yếu còi cọc; có thể xuất hiện dịch mật ngọt và nấm bồ hóng phủ đen.",
                    'symptoms_detail' => [
                        'la' => 'Lá non bị hút nhựa quăn queo biến dạng, mặt dưới lá bám dày đặc rệp mềm màu đen, xanh hoặc vàng; phủ lớp bồ hóng đen.',
                        'canh_than' => 'Đọt non rụt ngắn, ngừng phát triển; đàn rệp bám dày ở các nách chồi non.',
                        'goc_re' => 'Không gây hại trực tiếp ở rễ.',
                        'qua' => 'Bám ở cuống quả và quả non làm quả phát triển méo mó, nám vỏ.',
                    ],
                    'prevention' => "Cắt bỏ bộ phận cành lá nhiễm nặng khi phù hợp đem tiêu hủy, bảo vệ bọ rùa và thiên địch tự nhiên; kiểm soát kiến nếu chúng bảo vệ rệp tha đi khắp cây.",
                    'treatment' => "Phun thuốc nội hấp, thấm sâu chọn lọc: Flonicamid, Acetamiprid, Pymetrozine, Spirotetramat, Dinotefuran, Sulfoxaflor, Afidopyropen.",
                    'chemical_groups' => 'Flonicamid, Acetamiprid, Pymetrozine, Spirotetramat, Dinotefuran, Imidacloprid, Sulfoxaflor, Afidopyropen (IRAC 29, IRAC 4A, IRAC 9B, IRAC 23, IRAC 4C, IRAC 9D).',
                    'notes' => 'Thư mục này dùng để lưu và tra cứu các loại rệp chưa xếp riêng như rệp mềm, rệp muội và rệp bông. Là vector chính truyền virus khảm lá chanh dây.',
                ],
                'crop_ids' => array_filter([$chanhDayId, $sauRiengId, $caPheId, $coMuiId]),
                'pesticide_keywords' => ['Thần Chớp', 'Nofara', 'Tề Thiên', 'Riegenf'],
            ],

            // --- 4. RẦY (RẦY XANH, RẦY PHẤN, RẦY NHẢY, RẦY NÂU) ---
            [
                'match_keys' => ['Rầy Nhảy', 'Allocaridara', 'Rầy Xanh', 'Rầy Phấn', 'Rầy Nâu', 'Empoasca'],
                'data' => [
                    'name' => 'Rầy Hại Cây Trồng (Rầy Xanh, Rầy Phấn, Rầy Nhảy) — Empoasca spp. & Allocaridara spp.',
                    'pathogen_type' => 'sau_hai',
                    'caunho' => 'Rầy = CÔN TRÙNG NHẢY NHANH + MẶT DƯỚI LÁ + CHÙN ĐỌT (xác định loài rầy trước khi chọn thuốc, Pymetrozine, Flonicamid, Acetamiprid).',
                    'image' => 'https://images.openai.com/static-rsc-4/CmgvytWrjastODGLvE4UwYVD92CskWCttr1NSQIZZ_fhbB6pBJy1ZkAuXRLn2G2GF9SvsA5PyFEhpVdWpFY8ADrChJOzZ_x1QhzuIBKLTyrTQN9tK1vtzmjS5PWjtv97sYtuvizZwRsP80XfuQOm-JvT_Ypnpw1ER1mjZfMa7vk?purpose=inline',
                    'images' => [
                        'https://images.openai.com/static-rsc-4/CmgvytWrjastODGLvE4UwYVD92CskWCttr1NSQIZZ_fhbB6pBJy1ZkAuXRLn2G2GF9SvsA5PyFEhpVdWpFY8ADrChJOzZ_x1QhzuIBKLTyrTQN9tK1vtzmjS5PWjtv97sYtuvizZwRsP80XfuQOm-JvT_Ypnpw1ER1mjZfMa7vk?purpose=inline',
                        'https://images.openai.com/static-rsc-4/GgTjohhF4PsCf0txGp_pWpndKNo9zX1Abhfw1TCCwtCoSGyIWeVlqwuw4cnCj7WohbSaA2Vg2hiOEIogm-iHxCy5sTW2aotqkU-wROOEnH3zWpHa_MuGwQTuUjNKqPibtQOaqhUH8oEWy3c1MD7gjZTCJDeKodcdKOnZRjUHjms?purpose=inline',
                        'https://images.openai.com/static-rsc-4/z6gJQZHbf5sBI0MqpxMn8SRUeHQlWQfdwl3NSLrsMpu99MkiLCsxFzsvybTP9OV8PHYeSj05RtkfUewr4rg5PtyrPLHHFw_Wlokbn3MU-yjgiCwKrdWX4MS9ZQdNPq3kLg8ATrfNfL-_1ebtmiCgJmN27U8TZ7yWOtw9mUiXgiA?purpose=inline',
                    ],
                    'symptoms' => "Đặc điểm: Nhóm côn trùng chích hút gồm nhiều loài; nhảy rất nhanh khi động vào; cần xác định rõ rầy xanh, rầy nâu, rầy phấn hay rầy nhảy sầu riêng.\nCây bị hại: Sầu riêng, cà phê, chanh dây và nhiều cây trồng khác tùy loài rầy.\nDấu hiệu: Lá non vàng mép cháy khô hình chữ V (rầy xanh), đọt suy chùn ngọn rụng trơ cành, cây sinh trưởng kém; một số loài có thể truyền bệnh virus.",
                    'symptoms_detail' => [
                        'la' => 'Rầy chích hút mép lá làm mép lá cong queo, vàng rồi cháy khô viền lá, lá non rụng hàng loạt để lại cành trơ trụi.',
                        'canh_than' => 'Đọt non chùn lại, khô đọt; ấu trùng rầy phấn tiết sợi sáp trắng bám quanh cành non.',
                        'goc_re' => 'Không gây hại ở rễ.',
                        'qua' => 'Không gây hại trực tiếp quả, nhưng làm suy kiệt bộ lá nuôi quả.',
                    ],
                    'prevention' => "Bón phân tưới nước điều khiển cơi đọt ra đồng loạt toàn vườn. Thường xuyên kiểm tra kỹ cả mặt dưới lá và đọt non giai đoạn mũi giáo đến hé mở.",
                    'treatment' => "Xác định loài trước khi chọn thuốc. Phun thuốc khi cơi đọt mới hé mũi giáo (1-2cm), lần 2 sau 5-7 ngày: Pymetrozine, Flonicamid, Acetamiprid, Dinotefuran, Thiamethoxam, Buprofezin, Triflumezopyrim, Nitenpyram.",
                    'chemical_groups' => 'Pymetrozine, Flonicamid, Acetamiprid, Dinotefuran, Thiamethoxam, Buprofezin, Imidacloprid, Triflumezopyrim, Nitenpyram (IRAC 9B, IRAC 29, IRAC 4A, IRAC 16, IRAC 4E).',
                    'notes' => 'Phun đón cơi đọt khi mới nhú mũi giáo (1-2cm), luân phiên hoạt chất tránh rầy kháng thuốc.',
                ],
                'crop_ids' => array_filter([$sauRiengId, $caPheId, $chanhDayId]),
                'pesticide_keywords' => ['Thần Chớp', 'Nofara', 'Tề Thiên', 'Riegenf'],
            ],

            // --- 5. RỆP SÁP ---
            [
                'match_keys' => ['Rệp Sáp', 'Planococcus', 'Mealybug'],
                'data' => [
                    'name' => 'Rệp Sáp & Kiến Cộng Sinh — Planococcus spp.',
                    'pathogen_type' => 'sau_hai',
                    'caunho' => 'Rệp sáp = CÓ LỚP SÁP TRẮNG + ĐI CÙNG KIẾN (thuốc tiếp xúc khó hiệu quả, Spirotetramat, Buprofezin, Dầu khoáng).',
                    'image' => 'https://images.openai.com/static-rsc-4/J-lOkvEqo15LWG9hp7fAgrjm5wodsRwxbeq3-dwLepHpI8s-bASAgTWIEiixHVUgWPQz6TyNKVdiptawUeMnoH-iFspvlFSEqyvShMokr43dXp6lSz_yMXiytuwoEVxww9ViLnZ8g67JJTZNjZo6RU4iFZvITXtZEm_QsZcaH_s?purpose=inline',
                    'images' => [
                        'https://images.openai.com/static-rsc-4/J-lOkvEqo15LWG9hp7fAgrjm5wodsRwxbeq3-dwLepHpI8s-bASAgTWIEiixHVUgWPQz6TyNKVdiptawUeMnoH-iFspvlFSEqyvShMokr43dXp6lSz_yMXiytuwoEVxww9ViLnZ8g67JJTZNjZo6RU4iFZvITXtZEm_QsZcaH_s?purpose=inline',
                        'https://images.openai.com/static-rsc-4/DXln02UMfK62BYtZI-Oyl7XYNf5lD-lS5fGDgYxJpZUSQetuIG0TcsdWz_OEGXJTAuNLS7ltNywMOuyTq1dlOUZk2PaVghbrw3-F5M_uXTaI84O8D9BIRHg-ZNRVlzkxHLieDjAnXPd48DH-gAyljgHJW4WDvBPo4dvH-Ni9M3E?purpose=inline',
                        'https://images.openai.com/static-rsc-4/gqi4_foCECw5c6EOfnpNC8FumUERMFs110tmMjviY4BnK-kb-9uBvP7AQdgQJ5SSWxo2rk6e5eDd7fui4sPjLL5rEiMfOZR-9NFMpbliX6gPAAuzpi2xgyxR20kUKHJbRMb4kzCekRXt6CbP5VhHgsc810Mw7tcPvl3pf26yTXU?purpose=inline',
                    ],
                    'symptoms' => "Đặc điểm: Cơ thể phủ lớp sáp trắng, thường tụ thành cụm ở kẽ nứt, cuống hoa, trái và cổ rễ.\nCây bị hại: Sầu riêng, chanh dây, cà phê, cây có múi, hồ tiêu và nhiều cây ăn trái.\nDấu hiệu: Rệp bám trên trái, cuống, cành, kẽ lá hoặc rễ; cây suy yếu, trái xấu méo mó; thường có kiến và nấm bồ hóng phủ đen.",
                    'symptoms_detail' => [
                        'la' => 'Lá bị phủ màng muội đen bồ hóng làm giảm quang hợp nghiêm trọng.',
                        'canh_than' => 'Các cụm bông trắng bám dày đặc ở nách cành, chạc ba, kẽ nứt vỏ cành.',
                        'goc_re' => 'Rệp sáp có thể chui xuống bám ở cổ rễ và chóp rễ non dưới mặt đất.',
                        'qua' => 'Bám dày đặc kẽ gai sầu riêng và cuống quả, làm quả nhỏ, méo mó, vỏ chai sần xùi.',
                    ],
                    'prevention' => "Kiểm soát kiến, tỉa cành rậm rạp, xử lý ổ rệp; rệp có lớp sáp nên thuốc tiếp xúc có thể khó đạt hiệu quả, cần vòi nước áp lực cao xịt rửa kết hợp diệt kiến dưới gốc.",
                    'treatment' => "Phun thuốc có tính lưu dẫn 2 chiều hoặc phối Dầu khoáng nông nghiệp để phá vỡ màng sáp: Spirotetramat, Buprofezin, Pyriproxyfen, Dinotefuran, Thiamethoxam, Profenofos, Clothianidin.",
                    'chemical_groups' => 'Spirotetramat, Buprofezin, Pyriproxyfen, Dinotefuran, Thiamethoxam, Profenofos, Clothianidin, Dầu khoáng nông nghiệp (IRAC 23, IRAC 16, IRAC 7C, IRAC 4A, IRAC 1B, IRAC Dầu khoáng).',
                    'notes' => 'Kiểm tra kỹ nếu rệp nằm dưới đất hoặc trên rễ. Kiến là tác nhân chính vận chuyển rệp sáp phát tán khắp cây.',
                ],
                'crop_ids' => array_filter([$sauRiengId, $chanhDayId, $caPheId, $hoTieuId, $coMuiId]),
                'pesticide_keywords' => ['Tề Thiên', 'THPRO', 'Nofara', 'Riegenf'],
            ],

            // --- 6. RỆP VẢY ---
            [
                'match_keys' => ['Rệp Vảy', 'Rệp Vẩy', 'Aspidiotus', 'Durian pit Scale'],
                'data' => [
                    'name' => 'Rệp Vảy Hại Cây Trồng — Coccus spp. & Aspidiotus spp.',
                    'pathogen_type' => 'sau_hai',
                    'caunho' => 'Rệp vảy = VẢY NHỎ BÁM CHẶT TRÊN LÁ VÀ CÀNH (Dầu khoáng, Buprofezin, Pyriproxyfen, cắt bỏ cành nhiễm nặng).',
                    'image' => 'https://images.openai.com/static-rsc-4/x1YI1oxxTv_zf5_LW4FHJH5BnGvZBNq2aw7UeF_iuahU63Lvcgwtwqykj7ovrGyraC_equT80pL-zve6we_Pa9TehdnGJGCBlk-4_DJDyDf4G31xAY_9U1cLYdo44IpkkrPqb9vxVcElDrZknyLW2cxgtCJAjTW9WMF506kAQDU?purpose=inline',
                    'images' => [
                        'https://images.openai.com/static-rsc-4/x1YI1oxxTv_zf5_LW4FHJH5BnGvZBNq2aw7UeF_iuahU63Lvcgwtwqykj7ovrGyraC_equT80pL-zve6we_Pa9TehdnGJGCBlk-4_DJDyDf4G31xAY_9U1cLYdo44IpkkrPqb9vxVcElDrZknyLW2cxgtCJAjTW9WMF506kAQDU?purpose=inline',
                        'https://images.openai.com/static-rsc-4/7rtVKA1MKiSSk4k04UQBMz3yi6Zb_DR8ZV3JVHyU3UTxpQdEFpFA2PXUVxgLzg7co2tOL5gLir_zUUzIWEE8omvAVpThepNF17H6v-ClC-PTCSe_6NExL_TzEGangqDrEi3TZJYq0yO-Whj_9jE3qMP_7j3acnwxcn_cczOLDTM?purpose=inline',
                        'https://images.openai.com/static-rsc-4/EstcGBeZJMqskwxJpBSzcjdJ-4cItMf8-aVDnK2PRrZmmMWwZrvcASzOeX1jaMwyynaZtXEPlZ9f9sFZRZRID1blN1utqLonzwR3uz4faxzlsht--oQl_5tuaCNkr7zznfARSnnwRZnYot8Je99aQh9_eL5zVyYE_deTP__3ffw?purpose=inline',
                    ],
                    'symptoms' => "Đặc điểm: Cơ thể nhỏ, thường có lớp vảy cứng hoặc lớp phủ bám chặt bất động trên lá, cành, thân cây.\nCây bị hại: Nhiều cây ăn trái và cây công nghiệp (sầu riêng, cây có múi, cà phê, chanh dây...), tùy loài rệp vảy.\nDấu hiệu: Các đốm hoặc vảy bám dày đặc trên cành, lá; lá vàng, cành suy kiệt hoặc chết khô khi nhiễm nặng.",
                    'symptoms_detail' => [
                        'la' => 'Các đốm vảy tròn nhỏ gồ lên bám dọc gân chính và mặt dưới phiến lá, mô lá quanh vết chích vàng úa, rụng sớm.',
                        'canh_than' => 'Vỏ cành bị bao phủ bởi lớp vảy dày đặc làm cành teo tóp, nứt nẻ, cành khô chết dần từ ngọn.',
                        'goc_re' => 'Ít gây hại ở rễ.',
                        'qua' => 'Vảy bám trên vỏ trái làm vỏ sần sùi xấu xí, giảm giá trị thương phẩm trầm trọng.',
                    ],
                    'prevention' => "Cắt bỏ cành nhiễm nặng đem tiêu hủy xa vườn, kiểm soát kiến và bảo vệ thiên địch (ong ký sinh, bọ rùa).",
                    'treatment' => "Phun thuốc diệt rệp non mới nở trước khi chúng hình thành lớp vảy sáp dày cứng. Phun Dầu khoáng nông nghiệp (làm ngạt thở rệp) hoặc thuốc điều hòa sinh trưởng côn trùng: Buprofezin, Pyriproxyfen, Spirotetramat, Dinotefuran, Clothianidin.",
                    'chemical_groups' => 'Dầu khoáng nông nghiệp (Mineral oil), Buprofezin, Pyriproxyfen, Spirotetramat, Dinotefuran, Clothianidin (IRAC Dầu khoáng, IRAC 16, IRAC 7C, IRAC 23, IRAC 4A).',
                    'notes' => 'Dầu khoáng có thể hữu ích với một số loài khi dùng đúng thời điểm (giai đoạn rệp non). Kiểm tra kỹ nhãn đăng ký trước khi sử dụng.',
                ],
                'crop_ids' => array_filter([$sauRiengId, $coMuiId, $caPheId, $chanhDayId]),
                'pesticide_keywords' => ['Tề Thiên', 'Nofara', 'Riegenf', 'THPRO'],
            ],

            // --- ĐỐI TƯỢNG NHỆN HẠI (CHÍCH HÚT DIỆP LỤC) ---
            [
                'match_keys' => ['Nhện Đỏ', 'Tetranychus'],
                'data' => [
                    'name' => 'Nhện Đỏ – Nhện Trắng — Tetranychus spp.',
                    'pathogen_type' => 'sau_hai',
                    'caunho' => 'Nhện đỏ = NẮNG NÓNG KHÔ + LẤM TẤM VÀNG CÁM (xịt ướt mặt dưới lá, luân phiên IRAC).',
                    'symptoms' => "Nhện đỏ và nhện trắng chích hút dịch diệp lục ở mặt dưới phiến lá, bùng phát mạnh trong mùa khô nóng, ít mưa. Lá mất màu xanh bóng, chuyển sang màu vàng cám lấm tấm, mặt dưới giăng tơ mỏng, lá rụng hàng loạt làm suy kiệt trơ cành.",
                    'symptoms_detail' => [
                        'la' => 'Mặt trên lá mất diệp lục lấm tấm vàng cám như phủ bụi cám, mặt dưới lá có nhện nhỏ li ti và tơ nhện mỏng; nặng lá khô giòn và rụng.',
                        'canh_than' => 'Cành trơ trụi lá do lá già và lá bánh tẻ bị rụng đồng loạt.',
                        'goc_re' => 'Không gây hại ở rễ.',
                        'qua' => 'Nhện có thể bu chích hút vỏ quả non làm vỏ quả sần sùi da cám.',
                    ],
                    'prevention' => "Bước 1 — Biện pháp canh tác:\n• Tưới phun mưa áp lực cao rửa trôi nhện trên tán lá trong mùa khô nóng.\n• Không phun thuốc trừ sâu phổ rộng vô tội vạ làm chết thiên địch (nhện bắt mồi Phytoseiidae, bọ rùa).",
                    'treatment' => "Bước 2 — Xử lý thuốc đặc trị nhện:\n• Phun kỹ ướt đẫm 2 mặt lá (đặc biệt mặt dưới lá) bằng các hoạt chất đặc trị nhện: Diafenthiuron, Fenpyroximate, Abamectin, Pyridaben, Hexythiazox.\n• Luân phiên nhóm thuốc IRAC và phun dập lại sau 3-5 ngày để diệt lứa trứng mới nở.",
                    'chemical_groups' => 'Diafenthiuron, Fenpyroximate, Abamectin, Pyridaben, Hexythiazox, Dầu khoáng (IRAC 12A, IRAC 21A, IRAC 6, IRAC 25, IRAC 10A).',
                    'notes' => 'Nhện có tính kháng thuốc cực kỳ nhanh, bắt buộc phải đổi gốc thuốc giữa các lần phun.',
                ],
                'crop_ids' => array_filter([$sauRiengId, $chanhDayId, $coMuiId]),
                'pesticide_keywords' => ['Resgant', 'Abamectin'],
            ],

            // =========================================================================
            // NHÓM SÂU HẠI CÂY TRỒNG (5 THƯ MỤC CHUẨN HÓA THEO SỔ TAY BÁN THUỐC)
            // =========================================================================

            // --- 1. RUỒI VÀNG ---
            [
                'match_keys' => ['Ruồi Vàng', 'Ruồi Đục Quả', 'Bactrocera'],
                'data' => [
                    'name' => 'Ruồi Vàng Hại Trái Cây Trồng — Bactrocera spp.',
                    'pathogen_type' => 'sau_hai',
                    'caunho' => 'Ruồi vàng = CHẤM CHÍCH TRÊN TRÁI + DÒI BÊN TRONG + THỐI MỀM (bẫy dẫn dụ Methyl eugenol, bả ruồi, thu gom trái rụng).',
                    'image' => 'https://images.openai.com/static-rsc-4/LRfgTD4lNNETY8Rr42QNLP29griUDgU9Ap_GBQ68_GthAjh9LFepOJLOsFbcgSycfcvEXHwOxmGXBHUMuhEtJCrnguZVDAUtde8DzWN1OLbKYgpakuv3Ua30CfJ5p-VidIPeKm1COxX7qnwnB8env1DeJ7gi9qMvcE4kaE1FClg?purpose=inline',
                    'images' => [
                        'https://images.openai.com/static-rsc-4/LRfgTD4lNNETY8Rr42QNLP29griUDgU9Ap_GBQ68_GthAjh9LFepOJLOsFbcgSycfcvEXHwOxmGXBHUMuhEtJCrnguZVDAUtde8DzWN1OLbKYgpakuv3Ua30CfJ5p-VidIPeKm1COxX7qnwnB8env1DeJ7gi9qMvcE4kaE1FClg?purpose=inline',
                        'https://images.openai.com/static-rsc-4/lIT-hfamMJbQoBREQNAOEXeTOg8H9KDyGMGnl7OU4qIsDzX6Q6UiW85nsDOy63En5WBq-Nd3p9QQFZc76kaTmthYsYBhq5YPRtk_R9mjXOIWVWoYqH9ExNYoLKOVA76V_wqr8OXIG_VLE8qida8IxtCZyHC6aexl-WtNQYoqnh8?purpose=inline',
                        'https://images.openai.com/static-rsc-4/DQGwzoBwfohdAXsUXxOjT8_5198w3gs3N8e6v-V59Y7phFdcf413pawaxUdQziuK2ov0SASHNd-8Ca0SaVj6yLPNXmMACDNzv3Ck5K2W6zzn5Vtolvm_sUNwSCfcdoF0uXuknzDi6Fqdf1l3fQxTsgmwmtaGmd3_850uagsQddM?purpose=inline',
                    ],
                    'symptoms' => "Cây bị hại: Chanh dây, xoài, ổi, mít và nhiều loại cây ăn trái tùy loài ruồi. Không mặc định mọi loài ruồi vàng đều gây hại sầu riêng.\nDấu hiệu: Trái có chấm chích nhỏ, chảy mủ nhẹ hoặc thâm quầng; trái chuyển thối mềm; bên trong có dòi ngoe nguẩy đục khoét thịt quả, trái dễ rụng non.",
                    'symptoms_detail' => [
                        'la' => 'Không gây hại trên lá.',
                        'canh_than' => 'Không gây hại trên cành thân.',
                        'goc_re' => 'Nhộng ruồi vàng có thể hóa nhộng và ẩn nấp trong lớp đất mặt dưới tán cây.',
                        'qua' => 'Vỏ trái có vết chích thâm đen, úng mềm, chảy nhựa; bên trong thịt trái đầy dòi đục khoét làm trái thối rữa và rụng hàng loạt.',
                    ],
                    'prevention' => "Thu gom triệt để trái rụng và trái nhiễm dòi đem tiêu hủy đúng cách (ngâm nước vôi hoặc chôn sâu rắc vôi); dùng bẫy dẫn dụ protein thủy phân hoặc Methyl eugenol phù hợp loài ruồi; bao trái sớm khi trái đạt kích thước thích hợp.",
                    'treatment' => "Đặt bẫy dẫn dụ Methyl eugenol hoặc chất dẫn dụ chuyên dụng quanh vườn (treo bìa vườn, cách mặt đất 1.5m); phun bả protein thủy phân phối hoạt chất diệt ruồi (Spinosad, Abamectin, Cypermethrin, Deltamethrin, Malathion) điểm xuyết từng đốm nhỏ. ⚠️ Lưu ý: Bẫy dẫn dụ không đồng nghĩa với thuốc phun toàn vườn.",
                    'chemical_groups' => 'Bẫy Methyl Eugenol, Protein thủy phân, Spinosad, Abamectin, Cypermethrin, Deltamethrin, Malathion (Pheromone / Bả sinh học, IRAC 5, IRAC 6, IRAC 3A, IRAC 1B).',
                    'notes' => '⚠️ Lưu ý bán thuốc: Bẫy dẫn dụ dùng để bắt ruồi đực giảm mật độ, không thay thế cho thuốc trừ sâu phun trực tiếp. Không phun xịt bừa bãi toàn bộ tán lá làm tiêu diệt thiên địch.',
                ],
                'crop_ids' => array_filter([$chanhDayId]),
                'pesticide_keywords' => ['Resgant', 'Abamectin', 'Thần Chớp'],
            ],

            // --- 2. SÂU ĂN BÔNG ---
            [
                'match_keys' => ['Sâu Ăn Bông', 'Thalassodes'],
                'data' => [
                    'name' => 'Sâu Ăn Bông Hại Cây Trồng — Thalassodes spp. & loài sâu cắn hoa',
                    'pathogen_type' => 'sau_hai',
                    'caunho' => 'Sâu ăn bông = BÔNG BỊ CẮN + PHÂN SÂU HOẶC TƠ CHÙM HOA (thận trọng thuốc hại ong, Bt, Emamectin, Chlorantraniliprole).',
                    'image' => 'https://images.openai.com/static-rsc-4/5qH4ozMFnU8I-hPOTnQ4ItSqjIzXEWf3d088En1pdAjWvrR3pD8CMTNi37NB2RqJt8i2fILOlBWxjxOSPi0FWF0Z3nyjf0NG70abdIzQy4GTt-nsj3wWi1_wAiYb1-F_kseEdeFAhjGCvwY4uyK-uQDw_lEDH4bhjtqZ2sLOqBY?purpose=inline',
                    'images' => [
                        'https://images.openai.com/static-rsc-4/5qH4ozMFnU8I-hPOTnQ4ItSqjIzXEWf3d088En1pdAjWvrR3pD8CMTNi37NB2RqJt8i2fILOlBWxjxOSPi0FWF0Z3nyjf0NG70abdIzQy4GTt-nsj3wWi1_wAiYb1-F_kseEdeFAhjGCvwY4uyK-uQDw_lEDH4bhjtqZ2sLOqBY?purpose=inline',
                        'https://images.openai.com/static-rsc-4/JjfHvJXcWrNkydhbbqUrSZFq5IQMHLXLuIZ2GKRBTbIowQZ3O4DhuwGJWk2sokNNBw2Tvqg76yA30SR4MsK92eF-A8nO5WaYcfIUjRmiYZbgDnqC-FPG5soi3mHASg7dZXc06qxkAIL0GqGjtKVJo_oJjfiMGPyXjw9xRvvtyAQ?purpose=inline',
                    ],
                    'symptoms' => "Cây bị hại: Sầu riêng, chanh dây và nhiều cây ăn trái có hoa; loài sâu cụ thể tùy cây trồng.\nDấu hiệu: Bông bị cắn phá, rụng bất thường, có phân sâu nhỏ li ti hoặc màng tơ mỏng kết dính ở chùm hoa.",
                    'symptoms_detail' => [
                        'la' => 'Ít gây hại trên lá già, sâu có thể cắn nhẹ mép lá non kề chùm bông.',
                        'canh_than' => 'Sâu non thường ẩn nấp ở nách cành gần chùm hoa vào ban ngày.',
                        'goc_re' => 'Không gây hại ở rễ.',
                        'qua' => 'Chùm hoa bị cắn rách cánh, đứt nhụy và cuống hoa, hoa thâm đen rụng lả tả; có tơ sâu và hạt phân đen bám dính.',
                    ],
                    'prevention' => "Kiểm tra chùm hoa vào sáng sớm và chiều tối, rung nhẹ cành bắt sâu khi mật độ thấp; tỉa thưa chùm hoa mọc quá dày sít; bảo vệ côn trùng thụ phấn tự nhiên.",
                    'treatment' => "Phun thuốc sinh học mát bông trước khi hoa nở rộ (xổ nhụy) 3-5 ngày: Bacillus thuringiensis (Bt), Emamectin benzoate, Chlorantraniliprole, Spinetoram, Spinosad, Flubendiamide.",
                    'chemical_groups' => 'Bacillus thuringiensis (Bt), Emamectin benzoate, Chlorantraniliprole, Spinetoram, Spinosad, Flubendiamide (Sinh học, IRAC 6, IRAC 28, IRAC 5).',
                    'notes' => '⚠️ Lưu ý cực kỳ quan trọng: Giai đoạn ra hoa cần đặc biệt thận trọng với thuốc gây hại ong và côn trùng thụ phấn. Tuyệt đối không phun thuốc gốc nhũ dầu (EC) hoặc thuốc độc với ong khi hoa đang nở rộ.',
                ],
                'crop_ids' => array_filter([$sauRiengId, $chanhDayId]),
                'pesticide_keywords' => ['Resgant', 'Abamectin'],
            ],

            // --- 3. SÂU ĂN LÁ ---
            [
                'match_keys' => ['Sâu Ăn Lá', 'Sâu Khoang', 'Sâu Róm', 'Sâu Đo', 'Sâu Xanh'],
                'data' => [
                    'name' => 'Sâu Ăn Lá Hại Cây Trồng — Sâu Khoang, Sâu Róm, Sâu Đo',
                    'pathogen_type' => 'sau_hai',
                    'caunho' => 'Sâu ăn lá = LÁ THỦNG, KHUYẾT MÉP, TRƠ GÂN (xác định mật độ trước khi phun, Bt, Emamectin, Spinosad, Chlorantraniliprole).',
                    'symptoms' => "Cây bị hại: Sầu riêng, chanh dây, cà phê và nhiều cây trồng khác.\nDấu hiệu: Phiến lá bị cắn khuyết mép, thủng lỗ chỗ hoặc trơ trụi chỉ còn gân lá; có thể thấy sâu non bò cắn phá hoặc phân sâu đọng trên mặt lá dưới.",
                    'symptoms_detail' => [
                        'la' => 'Lá non và lá bánh tẻ bị cắn nham nhở, thủng rách từng mảng lớn, nặng chỉ còn trơ cuống và gân lá chính.',
                        'canh_than' => 'Cành xơ xác do mất diện tích lá quang hợp.',
                        'goc_re' => 'Không gây hại ở rễ.',
                        'qua' => 'Một số loài sâu ăn lá có thể cắn nhẹ bề mặt vỏ quả non.',
                    ],
                    'prevention' => "Thường xuyên thăm vườn kiểm tra mặt dưới lá và ổ trứng ở các cơi đọt non; bắt giết ổ sâu non mới nở khi chúng còn tụ tập; bảo vệ chim ăn sâu, bọ ngựa, kiến ba khoang.",
                    'treatment' => "Xác định sâu non hay sâu trưởng thành; chỉ phun khi mật độ gây hại đáng kể ảnh hưởng cơi đọt: Bacillus thuringiensis (Bt), Emamectin benzoate, Spinosad, Chlorantraniliprole, Lufenuron, Indoxacarb, Methoxyfenozide.",
                    'chemical_groups' => 'Bacillus thuringiensis (Bt), Emamectin benzoate, Spinosad, Chlorantraniliprole, Lufenuron, Indoxacarb, Methoxyfenozide, Tebufenozide (Sinh học, IRAC 6, IRAC 5, IRAC 28, IRAC 15, IRAC 22A, IRAC 18).',
                    'notes' => '⚠️ Kinh nghiệm tư vấn: “Sâu ăn lá” là nhóm triệu chứng gồm nhiều loài (sâu róm, sâu đo, sâu khoang). Phun khi sâu ở tuổi 1-2 (mới nở) đạt hiệu quả cao nhất.',
                ],
                'crop_ids' => array_filter([$sauRiengId, $chanhDayId, $caPheId]),
                'pesticide_keywords' => ['Resgant', 'Abamectin', 'Thần Chớp'],
            ],

            // --- 4. SÂU ĐỤC CÀNH ---
            [
                'match_keys' => ['Sâu Đục Cành', 'Sâu Đục Thân', 'Mọt Đục Cành', 'Batocera', 'Zeuzera', 'Xylosandrus'],
                'data' => [
                    'name' => 'Sâu Đục Cành, Thân & Mọt Đục Cành — Batocera spp., Zeuzera spp. & Xylosandrus spp.',
                    'pathogen_type' => 'sau_hai',
                    'caunho' => 'Sâu đục cành = LỖ ĐỤC + MÙN CƯA PHÂN SÂU + CÀNH KHÔ GÃY (bơm thuốc xông hơi vào lỗ, không phun tràn lan ngoài tán).',
                    'image' => 'https://images.openai.com/static-rsc-4/7RN4T7VFh256bWBi0tadohBhnzeeaM4BX9Q7Ewi2oLR0sabbntwvfwoty5uX62sEhuZuG9igiGiHSnN5o-aNmht6CbT_aSuHmpnhGErW1hykBkbxnS4wUm7-3fc-r7cGydNSziP7dKEZRzOj5rlh6qchUnZlzDaep5cLgIMqGV4?purpose=inline',
                    'images' => [
                        'https://images.openai.com/static-rsc-4/7RN4T7VFh256bWBi0tadohBhnzeeaM4BX9Q7Ewi2oLR0sabbntwvfwoty5uX62sEhuZuG9igiGiHSnN5o-aNmht6CbT_aSuHmpnhGErW1hykBkbxnS4wUm7-3fc-r7cGydNSziP7dKEZRzOj5rlh6qchUnZlzDaep5cLgIMqGV4?purpose=inline',
                        'https://images.openai.com/static-rsc-4/JMQL_DRFI0JHkW_JGw0P5bSgT81usFw5mXVjIEq6oxnFCSi-0OLrXxULpKM-IJ74o4_MC8B4Fij7cKxv1upsJNJyAg8fxNFeTaGPH4DnKzvHidXWYYQ7BgcLnd7ihF-mlGp0W_JSKcx_hqTUII8wOMLW-fowA4ez7qVph6J3f6U?purpose=inline',
                        'https://images.openai.com/static-rsc-4/jxmo7WwQe8Ac9P7idGe5l7gEN_eyty43jaERPoexTos2j7pJ0lnlqyuPI-POdVP6qFl5zs1LnOybXlAbW3uLoh9RwmOba7UPJqi5J8KyACRT0jD7nsc5BfmKbBUCmljk9aCyzNfPnGZ4r4-e1hYs20Ss83Zri7RhUXZnB594rlVNR7vvvPwFDb-ruRvLCbVD?purpose=inline',
                    ],
                    'symptoms' => "Cây bị hại: Sầu riêng, cà phê và nhiều cây thân gỗ, tùy loài sâu đục.\nDấu hiệu: Cành có lỗ đục nhỏ, có mùn cưa và hạt phân sâu đùn ra đọng ở chạc cành; cành héo rũ đột ngột, khô cháy hoặc gãy ngang khi gặp gió lớn.",
                    'symptoms_detail' => [
                        'la' => 'Lá trên cành bị đục héo rũ đột ngột, lá khô vàng giòn nhưng vẫn dính trên cành.',
                        'canh_than' => 'Lỗ đục tròn trên vỏ cành hoặc thân cây, có mùn cưa và bã phân gỗ đùn ra ngoài; bên trong ruột gỗ bị rỗng dọc theo thớ gỗ.',
                        'goc_re' => 'Ấu trùng xén tóc có thể đục xuống sát cổ rễ thân gốc.',
                        'qua' => 'Cành mang trái bị gãy làm rụng toàn bộ quả trên cành.',
                    ],
                    'prevention' => "Cắt bỏ cành bị hại nặng đem tiêu hủy xa vườn để diệt nguồn sâu/nhộng; bắt xén tóc trưởng thành vào đầu mùa mưa; quét vôi hoặc Booc-đô quanh gốc thân 0.8-1m để ngăn đẻ trứng.",
                    'treatment' => "Dùng dây kẽm soi vào lỗ đục xiên chết sâu non, bơm thuốc trừ sâu xông hơi lưu dẫn mạnh (Profenofos, Cypermethrin, Thiamethoxam, Chlorantraniliprole, Diazinon, Cartap) trực tiếp vào lỗ đục rồi bít kín bằng bông gòn hoặc đất sét. Quét thuốc đậm đặc quanh gốc nếu bị đục thân sát gốc.",
                    'chemical_groups' => 'Profenofos, Cypermethrin, Thiamethoxam, Chlorantraniliprole, Chlorpyrifos-methyl, Diazinon, Cartap (IRAC 1B, IRAC 3A, IRAC 4A, IRAC 28, IRAC 14).',
                    'notes' => '⚠️ Lưu ý bán thuốc: Chỉ chọn thuốc có đăng ký đúng sâu đục cành và cây trồng. Không nên phun thuốc tràn lan ngoài tán lá vì sâu nằm sâu bên trong mô gỗ, thuốc tiếp xúc không ngấm tới được.',
                ],
                'crop_ids' => array_filter([$sauRiengId, $caPheId]),
                'pesticide_keywords' => ['THPRO', 'Riegenf', 'Thần Chớp'],
            ],

            // --- 5. SÂU ĐỤC TRÁI ---
            [
                'match_keys' => ['Sâu Đục Trái', 'Conogethes', 'Sâu Đục Quả'],
                'data' => [
                    'name' => 'Sâu Đục Trái Hại Cây Trồng — Conogethes punctiferalis & sâu đục quả',
                    'pathogen_type' => 'sau_hai',
                    'caunho' => 'Sâu đục trái = LỖ ĐỤC TRÊN TRÁI + PHÂN SÂU KẼ GAI/VỎ + TRÁI THỐI (bao trái, phòng ngừa sớm khi bướm rộ đẻ trứng).',
                    'image' => 'https://images.openai.com/static-rsc-4/2gSdcfHeH7g4ECuQwZrSybinrMJ_88IJ3xL-KrSiW-Zwmxm7wZ4acDPdjz64GlHejPuZ8KQqX3DBeHkjpcTlwrYtAFSOGc1am6PwTtvLxenoE3wLIq5-t6M00ibUiVFnJbH7SSXe4aqqccGlpzw1K_abvz88BzAgwFjj6L76-tE?purpose=inline',
                    'images' => [
                        'https://images.openai.com/static-rsc-4/2gSdcfHeH7g4ECuQwZrSybinrMJ_88IJ3xL-KrSiW-Zwmxm7wZ4acDPdjz64GlHejPuZ8KQqX3DBeHkjpcTlwrYtAFSOGc1am6PwTtvLxenoE3wLIq5-t6M00ibUiVFnJbH7SSXe4aqqccGlpzw1K_abvz88BzAgwFjj6L76-tE?purpose=inline',
                        'https://images.openai.com/static-rsc-4/5NBTf7WhlubdYeI7F7f3E5UmzWI343NGHc0vXeyDImfmfhKerbYzS8ZskFdvkXZlhkB4aDW8wz3l0mdHgw7Wl4diUAc5me6eVXeIvZeGeRqcXMkKs3_Q_DECVK_2EDeHFF2dv09w1dDiX2sd3lXvGjvglkNa4qie7ghOJDoYf-g?purpose=inline',
                        'https://images.openai.com/static-rsc-4/ZBf9OBA_dVL4HJsY0h190rvtpERBBHqsDZXVkrYxUuCDxbihpEru8yTrqReNV_TL94y0V5aAnR4kNIZjQ2XaZCM370MNiKFGVhIv1IND0735lxWAYpYgmiLya_Dp9KvDu_uqtfxp0jTlVm-pTS6LAdu2_amedO9K5eMkBT0rXNQ?purpose=inline',
                    ],
                    'symptoms' => "Cây bị hại: Sầu riêng, chanh dây, xoài, ổi, cà chua và nhiều cây ăn trái; sầu riêng cũng cần xác định đúng loài gây hại trước khi kết luận.\nDấu hiệu: Trái có lỗ đục, có khối phân sâu màu nâu đen đùn ra đọng ở kẽ gai hoặc cuống quả; mô thịt bên trong bị cắn phá nham nhở, trái dễ thối ủng hoặc rụng non.",
                    'symptoms_detail' => [
                        'la' => 'Không gây hại trên lá.',
                        'canh_than' => 'Không gây hại trên cành thân.',
                        'goc_re' => 'Không gây hại ở rễ.',
                        'qua' => 'Lỗ đục trên vỏ quả và kẽ gai, có đống phân sâu màu nâu đen kết dính đùn ra; cơm quả bên trong bị thối nhũn và bốc mùi chua khi nấm xâm nhập.',
                    ],
                    'prevention' => "Tỉa trái sớm không để các trái mọc cọ xát dính sát vào nhau; bao trái bằng túi lưới/bao chuyên dụng khi trái còn nhỏ; thu gom tiêu hủy triệt để quả rụng.",
                    'treatment' => "Theo dõi bẫy đèn/thời điểm bướm rộ đẻ trứng; phun phòng khi sâu non mới nở trước khi chúng đục sâu vào trong vỏ: Bacillus thuringiensis (Bt), Emamectin benzoate, Spinosad, Chlorantraniliprole, Lufenuron, Cyantraniliprole, Indoxacarb.",
                    'chemical_groups' => 'Bacillus thuringiensis (Bt), Emamectin benzoate, Spinosad, Chlorantraniliprole, Lufenuron, Cyantraniliprole, Indoxacarb (Sinh học, IRAC 6, IRAC 5, IRAC 28, IRAC 15, IRAC 22A).',
                    'notes' => '⚠️ Khi sâu non đã đục sâu vào trong ruột trái thì phun thuốc bên ngoài hầu như không còn tác dụng. Bắt buộc phải phòng sớm giai đoạn trứng và sâu non mới nở.',
                ],
                'crop_ids' => array_filter([$sauRiengId, $chanhDayId]),
                'pesticide_keywords' => ['Resgant', 'Abamectin'],
            ],
        ];

        // 3. Tiến hành gộp dữ liệu và đồng bộ vào database
        DB::transaction(function () use ($consolidatedList) {
            foreach ($consolidatedList as $item) {
                $matchKeys = $item['match_keys'];
                $data = $item['data'];
                $cropIds = $item['crop_ids'];
                $keywords = $item['pesticide_keywords'] ?? [];

                // Tìm các bản ghi cũ trùng khớp với match_keys
                $matchedDiseases = Disease::where(function ($q) use ($matchKeys) {
                    foreach ($matchKeys as $key) {
                        $q->orWhere('name', 'like', "%{$key}%");
                    }
                })->get();

                // Lấy bản ghi đầu tiên hoặc tạo mới
                $primaryDisease = $matchedDiseases->first();
                if (!$primaryDisease) {
                    $primaryDisease = new Disease();
                }

                // Cập nhật thông tin chuẩn
                $primaryDisease->fill($data);
                // Lưu chuỗi tên các cây vào crop_name để tương thích ngược
                $cropNames = Crop::whereIn('id', $cropIds)->pluck('name')->implode(', ');
                $primaryDisease->crop_name = $cropNames;

                // Ánh xạ mã thư mục tra cứu chuẩn theo sổ tay tài liệu máy tính
                $folderMapping = [
                    'Phytophthora' => ['B-01', 'nam_benh', '1-Phytophthora - xì mủ, thối rễ, thối trái', 1],
                    'Pythium' => ['B-02', 'nam_benh', '2-Pythium - thối rễ', 2],
                    'Fusarium' => ['B-03', 'nam_benh', '3-Fusarium - bệnh rễ, héo cây', 3],
                    'Rhizoctonia' => ['B-04', 'nam_benh', '4-Rhizoctonia - cháy lá, chết ngọn', 4],
                    'Colletotrichum' => ['B-05', 'nam_benh', '5-Colletotrichum - thán thư', 5],
                    'Alternaria' => ['B-06', 'nam_benh', '6-Alternaria - đốm nâu', 6],
                    'Septoria' => ['B-07', 'nam_benh', '7-Septoria - đốm xám', 7],
                    'Phomopsis' => ['B-08', 'nam_benh', '8-Phomopsis - đốm lá', 8],
                    'Lasiodiplodia' => ['B-09', 'nam_benh', '9-Lasiodiplodia - khô cành, hoại tử mô', 9],
                    'Erythricium' => ['B-10', 'nam_benh', '10-Nấm hồng - bệnh thân cành', 10],
                    'Oidium' => ['B-11', 'nam_benh', '11-Phấn trắng', 11],
                    'Cephaleuros' => ['B-12', 'nam_benh', '12-Đốm rong - tảo đỏ', 12],
                    'Bã Trầu' => ['B-13', 'nam_benh', '13-Bệnh đốm dầu (bã trầu)', 13],
                    'Đốm Dầu' => ['B-13', 'nam_benh', '13-Bệnh đốm dầu (bã trầu)', 13],
                    'Khảm' => ['B-14', 'nam_benh', '14- khảm soăn', 14],
                    'Vàng Lá – Thối Rễ' => ['CD-01', 'nam_benh', 'Chẩn đoán phân biệt vàng lá thối rễ', 15],
                    'Thrips' => ['CH-01', 'chich_hut', '1-Bọ trĩ', 1],
                    'Bọ Trĩ' => ['CH-01', 'chich_hut', '1-Bọ trĩ', 1],
                    'Helopeltis' => ['CH-02', 'chich_hut', '2-Bọ xít muỗi', 2],
                    'Bọ Xít Muỗi' => ['CH-02', 'chich_hut', '2-Bọ xít muỗi', 2],
                    'Aphids' => ['CH-03', 'chich_hut', '3-Rệp muội, rệp mềm (rệp chích hút khác)', 3],
                    'Rệp Muội' => ['CH-03', 'chich_hut', '3-Rệp muội, rệp mềm (rệp chích hút khác)', 3],
                    'Rầy' => ['CH-04', 'chich_hut', '4-Rầy', 4],
                    'Rệp Sáp' => ['CH-05', 'chich_hut', '5-Rệp sáp', 5],
                    'Planococcus' => ['CH-05', 'chich_hut', '5-Rệp sáp', 5],
                    'Rệp Vảy' => ['CH-06', 'chich_hut', '6-Rệp vảy', 6],
                    'Ruồi Vàng' => ['S-01', 'sau_hai', '1 Ruồi vàng', 1],
                    'Bactrocera' => ['S-01', 'sau_hai', '1 Ruồi vàng', 1],
                    'Sâu Ăn Bông' => ['S-02', 'sau_hai', '2 Sâu ăn bông', 2],
                    'Thalassodes' => ['S-02', 'sau_hai', '2 Sâu ăn bông', 2],
                    'Sâu Ăn Lá' => ['S-03', 'sau_hai', '3 Sâu ăn lá', 3],
                    'Sâu Đục Cành' => ['S-04', 'sau_hai', '4 Sâu đục cành', 4],
                    'Batocera' => ['S-04', 'sau_hai', '4 Sâu đục cành', 4],
                    'Sâu Đục Trái' => ['S-05', 'sau_hai', '5 Sâu đục trái', 5],
                    'Conogethes' => ['S-05', 'sau_hai', '5 Sâu đục trái', 5],
                    'Nhện Đỏ' => ['N-01', 'nhen_tuyen_trung', '06. NHỆN HẠI CÂY', 1],
                    'Tetranychus' => ['N-01', 'nhen_tuyen_trung', '06. NHỆN HẠI CÂY', 1],
                    'Tuyến Trùng' => ['N-02', 'nhen_tuyen_trung', '07. TUYẾN TRÙNG – SÂU HẠI ĐẤT', 2],
                    'Meloidogyne' => ['N-02', 'nhen_tuyen_trung', '07. TUYẾN TRÙNG – SÂU HẠI ĐẤT', 2],
                ];

                foreach ($folderMapping as $kw => [$code, $group, $fName, $fNum]) {
                    if (str_contains($primaryDisease->name, $kw)) {
                        $primaryDisease->folder_code = $code;
                        $primaryDisease->folder_group = $group;
                        $primaryDisease->folder_name = $fName;
                        $primaryDisease->folder_number = $fNum;
                        break;
                    }
                }

                $primaryDisease->save();

                // Gom toàn bộ ảnh và thuốc từ các bản ghi trùng cũ trước khi xóa
                $allImages = $primaryDisease->images ?? [];
                $allPesticideIds = $primaryDisease->pesticides()->pluck('pesticides.id')->toArray();

                foreach ($matchedDiseases as $other) {
                    if ($other->id !== $primaryDisease->id) {
                        if (!empty($other->images)) {
                            $allImages = array_merge($allImages, (array)$other->images);
                        }
                        $otherPesticideIds = $other->pesticides()->pluck('pesticides.id')->toArray();
                        $allPesticideIds = array_merge($allPesticideIds, $otherPesticideIds);

                        // Xóa bản ghi trùng lặp
                        $other->pesticides()->detach();
                        $other->crops()->detach();
                        $other->delete();
                    }
                }

                if (!empty($allImages)) {
                    $primaryDisease->images = array_values(array_unique(array_filter($allImages)));
                    $primaryDisease->save();
                }

                // Gắn quan hệ nhiều-nhiều với Crops
                $primaryDisease->crops()->sync($cropIds);

                // Đồng bộ thuốc
                $primaryDisease->autoSyncPesticidesByChemicalGroups();

                if (!empty($keywords)) {
                    $extraIds = Pesticide::where(function ($q) use ($keywords) {
                        foreach ($keywords as $kw) {
                            $q->orWhere('name', 'like', "%{$kw}%")
                              ->orWhere('active_ingredient', 'like', "%{$kw}%");
                        }
                    })->pluck('id')->toArray();

                    $allPesticideIds = array_merge($allPesticideIds, $extraIds);
                }

                if (!empty($allPesticideIds)) {
                    $primaryDisease->pesticides()->syncWithoutDetaching(array_unique($allPesticideIds));
                }
            }
        });
    }
}
