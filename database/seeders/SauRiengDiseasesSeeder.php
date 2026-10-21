<?php

namespace Database\Seeders;

use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class SauRiengDiseasesSeeder extends Seeder
{
    /**
     * Run the database seeds for 20 primary Durian (Sầu Riêng) diseases and pests.
     */
    public function run(): void
    {
        $diseasesData = [
            // 1. Phytophthora
            [
                'name' => 'Bệnh Xì Mủ / Thối Rễ / Thối Trái — Phytophthora',
                'crop_name' => 'Sầu riêng',
                'pathogen_type' => 'nam',
                'caunho' => 'Phytophthora = NƯỚC + THỐI RỄ + XÌ MỦ + THỐI TRÁI (xử lý gốc + rễ + thoát nước).',
                'symptoms' => "Nấm Phytophthora palmivora (nhóm Oomycetes) tấn công toàn diện rễ, vỏ thân và quả sầu riêng trong điều kiện mưa nhiều, ngập úng. Rễ non chuyển nâu đen mục nát; thân xì mủ nâu chảy dịch; lá vàng rụng từng cành; trái thối nâu loang lổ.",
                'symptoms_detail' => [
                    'la' => 'Lá vàng úa, rụng từ các cành thấp lên ngọn, rụng một phía hoặc toàn cây do hệ rễ bị nấm hủy hoại.',
                    'canh_than' => 'Vết nâu sẫm trên vỏ thân cành, chảy nhựa xì mủ nâu đỏ, cạo lớp vỏ thấy mô gỗ thâm đen nát bấy.',
                    'goc_re' => 'Cổ rễ và hệ rễ tơ bị ủng nước, thối đen, vỏ rễ tuột khỏi lõi gỗ, bốc mùi chua hôi ẩm ướt.',
                    'qua' => 'Vết đốm nâu đen úng nước xuất hiện từ đít trái hoặc kẽ gai, lan nhanh làm thối nhũn toàn trái và rụng.',
                ],
                'prevention' => "Bước 1 — Xử lý nguyên nhân canh tác:\n• Đắp mô cao, khơi rãnh thoát nước sâu giữa các hàng liếp, tuyệt đối không để đọng vũng nước quanh gốc trong mùa mưa.\n• Tỉa cành thông thoáng tầng chân từ 0.8 - 1m so với mặt đất.\n• Kiểm tra và nâng pH đất đạt 5.5 - 6.5 bằng vôi hoặc tinh vôi đầu và cuối mùa mưa.\n• Bón phân hữu cơ hoai mục định kỳ kết hợp ủ nấm đối kháng Trichoderma/Bacillus.",
                'treatment' => "Bước 2 — Xử lý thuốc đặc trị:\n• Cây bị rễ: Tưới đẫm vùng rễ bằng Phosphonate, Fosetyl-Aluminium, Metalaxyl-M, Dimethomorph theo liều khuyến cáo.\n• Gốc bị xì mủ: Cạo sạch phần mô vỏ bệnh đến phần gỗ khỏe, quét dung dịch thuốc đậm đặc (Phosphonate / Fosetyl-Aluminium / Metalaxyl).\nBước 3 — Phục hồi rễ:\n• Sau khi khống chế bệnh 10-15 ngày, tưới dưỡng rễ bằng Humic/Fulvic + Amino Acid kết hợp vi sinh Trichoderma/Bacillus.",
                'chemical_groups' => 'Phosphonate, Potassium Phosphonate, Fosetyl-Aluminium, Metalaxyl-M, Dimethomorph, Fluopicolide (FRAC P07, FRAC 4, FRAC 40, FRAC 43).',
                'notes' => 'Bệnh phát tán cực nhanh theo dòng nước chảy mặt trong vườn mùa mưa bão.',
                'pesticide_keywords' => ['Agri-Fos', 'Alien', 'Delta Fos', 'Dimethor', 'Ridomil', 'Profiler'],
            ],

            // 2. Pythium
            [
                'name' => 'Bệnh Thối Rễ — Pythium',
                'crop_name' => 'Sầu riêng',
                'pathogen_type' => 'nam',
                'caunho' => 'Pythium = THỐI RỄ NON (đặc biệt khi đất quá ẩm, rễ thiếu oxy, ngập úng).',
                'symptoms' => "Pythium spp. (nhóm Oomycetes) hủy hoại chóp rễ non và rễ tơ trong điều kiện đất ngậm nước, thiếu oxy kéo dài. Cây chậm phát triển, lá vàng rũ nhẹ rồi suy kiệt từ từ.",
                'symptoms_detail' => [
                    'la' => 'Lá mất sức căng, úa vàng đều khắp tán, chóp đọt non bị chùn không bung cơi đọt mới.',
                    'canh_than' => 'Không có vết xì mủ trực tiếp trên thân cành, cành khẳng khiu kém phát triển.',
                    'goc_re' => 'Rễ tơ và chóp rễ cám bị thối mục đen trước, tuột lớp biểu bì ngoài, rễ cọc bị hoại tử nhẹ.',
                    'qua' => 'Trái chậm lớn, méo mó, dễ rụng non do thiếu hụt dinh dưỡng từ rễ.',
                ],
                'prevention' => "Bước 1 — Xử lý nguyên nhân:\n• Khơi thông mương rãnh thoát nước ngay lập tức, làm đất tơi xốp, hạ mực nước ngầm.\n• Tuyệt đối không tưới thuốc trong khi bồn gốc vẫn ngập úng sũng nước.\n• Hạn chế bón đạm hóa học khi rễ đang bị ngộp.",
                'treatment' => "Bước 2 — Xử lý thuốc:\n• Xới nhẹ lớp váng đất mặt quanh tán để thoát khí.\n• Tưới các hoạt chất đặc trị nấm Oomycetes: Metalaxyl, Dimethomorph, Phosphonate, Fosetyl-Aluminium.\nBước 3 — Phục hồi rễ:\n• Bổ sung Axit Humic, Fulvic kết hợp phân vi sinh đối kháng Bacillus subtilis và Trichoderma để tái tạo hệ rễ cám mới.",
                'chemical_groups' => 'Metalaxyl, Phosphonate, Fosetyl-Aluminium, Dimethomorph (Nhóm FRAC 4, FRAC P07, FRAC 40).',
                'notes' => 'Pythium thường đi trước phá hủy rễ tơ, dọn đường cho Fusarium và Phytophthora tấn công vào rễ chính.',
                'pesticide_keywords' => ['Dimethor', 'Ridomil', 'Alien', 'Delta Fos'],
            ],

            // 3. Fusarium
            [
                'name' => 'Bệnh Vàng Lá, Thối Rễ, Suy Cây — Fusarium',
                'crop_name' => 'Sầu riêng',
                'pathogen_type' => 'nam',
                'caunho' => 'Fusarium = VÀNG + SUY + RỄ BỆNH (cắt gốc thấy mạch dẫn thâm nâu, kiểm tra rễ trước).',
                'symptoms' => "Fusarium solani và Fusarium spp. xâm nhập qua vết thương rễ, làm thối rễ và làm nghẽn tắc bó mạch dẫn libe-gỗ. Cây vàng lá một phía hoặc toàn cây, sinh trưởng suy kiệt dần.",
                'symptoms_detail' => [
                    'la' => 'Lá vàng rải rác từ cành thấp lên, ban ngày nắng lá héo rũ ban đêm hồi phục nhẹ, sau đó vàng khô và rụng.',
                    'canh_than' => 'Thân cành không xì mủ ướt, nhưng cắt ngang gốc rễ thấy bó mạch dẫn bên trong thâm nâu đen.',
                    'goc_re' => 'Rễ bị tổn thương, thâm đen khô chứ không sũng nước nhầy nhớt như Phytophthora.',
                    'qua' => 'Trái nhỏ, teo tóp, méo lệch, cơm quả sượng hoặc rụng sớm.',
                ],
                'prevention' => "Bước 1 — Khắc phục nguyên nhân:\n• Cải tạo đất tơi xốp, bón nhiều hữu cơ vi sinh, không bón phân hóa học đậm đặc sát gốc.\n• Tránh làm đứt rễ khi cuốc cỏ, bón phân quanh tán.\n• Vệ sinh vườn, thu gom tiêu hủy cây bệnh nặng để tránh lây lan qua đất.",
                'treatment' => "Bước 2 — Xử lý nấm:\n• Tưới thuốc trừ nấm đất nhóm Triazole (Hexaconazole, Tebuconazole) hoặc Mancozeb vào vùng rễ.\nBước 3 — Phục hồi rễ:\n• Định kỳ 2-3 tháng/lần tưới nấm đối kháng Trichoderma sp. và Bacillus để cạnh tranh sinh học và tiêu diệt bào tử hậu Fusarium trong đất.",
                'chemical_groups' => 'Hexaconazole, Tebuconazole, Mancozeb, Difenoconazole (FRAC 3, FRAC M03, Sinh học BM02).',
                'notes' => '⚠️ Lưu ý chẩn đoán phân biệt: Vàng lá không đồng nghĩa chắc chắn do Fusarium, cần kiểm tra úng nước, xì mủ Phytophthora và tuyến trùng.',
                'pesticide_keywords' => ['Anvil', 'Mancozeb', 'Japa Vil', 'Tebaz'],
            ],

            // 4. Rhizoctonia
            [
                'name' => 'Bệnh Cháy Lá, Chết Ngọn — Rhizoctonia',
                'crop_name' => 'Sầu riêng',
                'pathogen_type' => 'nam',
                'caunho' => 'Rhizoctonia = CHÁY LÁ → CHẾT NGỌN (vết loang như luộc nước sôi, lá dính chùm vào nhau).',
                'symptoms' => "Rhizoctonia spp. gây cháy lá và chết ngọn sầu riêng phổ biến trong mùa mưa ẩm. Vết bệnh màu xám nâu úng nước lan nhanh trên phiến lá, các lá dính bết lại với nhau bằng sợi tơ nấm trắng rồi khô giòn, làm khô chết ngọn non.",
                'symptoms_detail' => [
                    'la' => 'Đốm úng nước màu xám xanh như luộc nước sôi, loang to làm cháy khô cả phiến lá, nhiều lá dính chùm vào nhau bằng tơ nấm.',
                    'canh_than' => 'Vết bệnh lan từ cuống lá lên ngọn non làm ngọn non bị thối nâu rồi khô chết (hiện tượng chết ngọn sầu riêng).',
                    'goc_re' => 'Không gây hại ở vùng gốc rễ.',
                    'qua' => 'Ít tấn công trực tiếp quả lớn, chủ yếu phá hủy tầng tán lá và cơi đọt non.',
                ],
                'prevention' => "Bước 1 — Canh tác:\n• Tỉa tán thông thoáng, giảm ẩm, không để cành tán quá rậm rạp.\n• Cắt tỉa và thu gom các chùm lá bệnh đem ra xa vườn tiêu hủy.\n• Hạn chế tưới phun mưa ướt đẫm tán vào chiều tối mùa mưa ẩm.",
                'treatment' => "Bước 2 — Phun thuốc đặc trị:\n• Phun ướt đều 2 mặt lá và các chồi ngọn bị bệnh bằng Validamycin, Hexaconazole, Tebuconazole, Mancozeb hoặc Azoxystrobin.\n• Phun lặp lại lần 2 sau 5-7 ngày nếu áp lực bệnh cao trong mùa mưa dầm.",
                'chemical_groups' => 'Validamycin, Hexaconazole, Tebuconazole, Mancozeb, Azoxystrobin (Nhóm FRAC 26, FRAC 3, FRAC M03, FRAC 11).',
                'notes' => 'Bệnh lây lan rất nhanh trong vườn ươm cây giống và vườn sầu riêng giai đoạn kiến thiết cơ bản tán rậm.',
                'pesticide_keywords' => ['Validamycin', 'Anvil', 'Mancozeb', 'Asmiltatop', 'Tebaz'],
            ],

            // 5. Lasiodiplodia
            [
                'name' => 'Bệnh Khô Cành, Hoại Tử Mô — Lasiodiplodia',
                'crop_name' => 'Sầu riêng',
                'pathogen_type' => 'nam',
                'caunho' => 'Lasiodiplodia = VẾT THƯƠNG → KHÔ CÀNH → HOẠI TỬ MÔ (vệ sinh vết cắt, bảo vệ sau tỉa).',
                'symptoms' => "Nấm Lasiodiplodia theobromae xâm nhập qua các vết thương tỉa cành, vết nứt cơ giới hoặc cành bị suy kiệt do hạn mặn/nóng ẩm. Cành chuyển màu nâu đen, mô mạch bên trong hoại tử mục khô, làm chết khô toàn bộ nhánh phía trên.",
                'symptoms_detail' => [
                    'la' => 'Lá trên cành bị bệnh mất màu xanh, héo rũ, khô cháy vàng nhưng vẫn dính chặt trên cành một thời gian trước khi rụng.',
                    'canh_than' => 'Vết loét nâu đen chạy dọc thân cành, vỏ nứt khô, mô gỗ bên trong hoại tử thâm đen, cành khô giòn dễ gãy.',
                    'goc_re' => 'Ít biểu hiện trực tiếp ở rễ.',
                    'qua' => 'Có thể gây thối cuống quả và thối khô núm quả.',
                ],
                'prevention' => "Bước 1 — Phòng ngừa:\n• Cắt tỉa cành đúng kỹ thuật vào ngày nắng ráo, không cắt tỉa ngày mưa ẩm.\n• Vệ sinh khử trùng kéo, cưa cắt cành bằng cồn hoặc nước vôi.\n• Quét keo liền sẹo hoặc dung dịch thuốc gốc đồng bảo vệ mặt cắt cành lớn.",
                'treatment' => "Bước 2 — Xử lý bệnh:\n• Cắt bỏ cành bệnh nhẹ xuống dưới vết hoại tử ít nhất 10-15cm (đến phần mô gỗ còn trắng khỏe).\n• Cành bệnh nặng: Cắt bỏ và đem tiêu hủy ra xa vườn.\n• Phun thuốc trừ nấm: Difenoconazole, Tebuconazole, Mancozeb hoặc quét thuốc gốc đồng.",
                'chemical_groups' => 'Difenoconazole, Tebuconazole, Mancozeb, Đồng Oxyclorua (FRAC 3, FRAC M03, FRAC M01).',
                'notes' => 'Cây bị suy kiệt sau thu hoạch hoặc thiếu nước mùa khô rất dễ bùng phát Lasiodiplodia.',
                'pesticide_keywords' => ['Tebaz', 'Tilt Super', 'Mancozeb', 'Asmiltatop'],
            ],

            // 6. Nấm hồng
            [
                'name' => 'Bệnh Nấm Hồng — Corticium salmonicolor',
                'crop_name' => 'Sầu riêng',
                'pathogen_type' => 'nam',
                'caunho' => 'Nấm hồng = CÀNH CÓ LỚP PHẤN MÀU HỒNG CAM (khô cành, nứt vỏ chạc ba).',
                'symptoms' => "Corticium salmonicolor phát triển mạnh vào mùa mưa ẩm độ cao, đặc biệt ở các chạc ba và cành khuất ánh sáng. Ban đầu xuất hiện tơ nấm trắng bạc, sau chuyển sang mảng phấn màu hồng cam bao quanh vỏ cành, làm khô nứt vỏ và chết khô cả cành.",
                'symptoms_detail' => [
                    'la' => 'Lá trên cành bị nấm hồng bao quanh ngả vàng úa, héo khô và rụng trơ trụi.',
                    'canh_than' => 'Lớp màng nấm màu hồng hoặc hồng cam phủ quanh vỏ cành non và cành cấp 1-2, vỏ nứt nẻ chảy nhựa nhẹ rồi chết khô.',
                    'goc_re' => 'Không gây hại vùng rễ.',
                    'qua' => 'Không gây hại trực tiếp quả.',
                ],
                'prevention' => "Bước 1 — Canh tác:\n• Tỉa bỏ các cành tăm, cành vượt, cành mọc sát đất để ánh sáng lọt vào sâu trong tán.\n• Vệ sinh thông thoáng vườn trước khi bước vào cao điểm mùa mưa.",
                'treatment' => "Bước 2 — Xử lý nấm:\n• Khi mới chớm xuất hiện lớp phấn hồng: Quét hoặc phun thuốc trực tiếp vào cành bệnh bằng Validamycin, Hexaconazole, thuốc gốc đồng (Copper Hydroxide, Đồng đỏ) hoặc Mancozeb.\n• Cành đã khô chết: Cắt bỏ tiêu hủy và quét thuốc bảo vệ vết cắt.",
                'chemical_groups' => 'Validamycin, Hexaconazole, Đồng Oxyclorua, Copper, Mancozeb (Nhóm FRAC 26, FRAC 3, FRAC M01, FRAC M03).',
                'notes' => 'Nấm hồng thường tập trung ở các chạc ba cành chịu lực mang trái, cần phát hiện sớm để tránh gãy cành.',
                'pesticide_keywords' => ['Validamycin', 'Anvil', 'Mancozeb'],
            ],

            // 7. Phấn trắng
            [
                'name' => 'Bệnh Phấn Trắng — Oidium spp.',
                'crop_name' => 'Sầu riêng',
                'pathogen_type' => 'nam',
                'caunho' => 'Phấn trắng = BỘT TRẮNG TRÊN MÔ NON & LÁ (lá biến dạng, chùn chồi).',
                'symptoms' => "Nấm phấn trắng phát triển thuận lợi khi tán rậm, ẩm độ ban đêm cao, nhiều chồi lá non. Lớp bột trắng bao phủ bề mặt phiến lá và chồi non, làm lá co rúm, biến dạng và giảm quang hợp nghiêm trọng.",
                'symptoms_detail' => [
                    'la' => 'Lớp phấn trắng như bột mì bám trên mặt trên và mặt dưới lá non, lá gợn sóng biến dạng, mép lá cong queo.',
                    'canh_than' => 'Chồi non và cành non bị bao phủ lớp bụi trắng, chồi phát triển còi cọc chùn lại.',
                    'goc_re' => 'Không gây hại ở rễ.',
                    'qua' => 'Có thể bám trên chùm hoa và quả non làm hoa khô rụng, vỏ quả non sần sùi.',
                ],
                'prevention' => "Bước 1 — Canh tác:\n• Tỉa cành thông thoáng, tạo sự luân chuyển không khí trong tán.\n• Không bón thừa đạm kích đọt quá mức khi thời tiết ẩm sương mù nhiều.",
                'treatment' => "Bước 2 — Xử lý thuốc:\n• Phun nhóm Triazole/DMI: Hexaconazole, Difenoconazole, Tebuconazole.\n• Hoặc luân phiên với chế phẩm Lưu huỳnh (Sulfur vi sinh) để trị dứt điểm và hạn chế kháng thuốc.",
                'chemical_groups' => 'Hexaconazole, Difenoconazole, Tebuconazole, Sulfur / Lưu huỳnh (FRAC 3, FRAC M02).',
                'notes' => 'Nắng ấm xen lẫn sương mù sáng sớm là điều kiện lý tưởng để bào tử phấn trắng nảy mầm.',
                'pesticide_keywords' => ['Anvil', 'Asmiltatop', 'Japa Vil', 'Tilt Super'],
            ],

            // 8. Thán thư
            [
                'name' => 'Bệnh Thán Thư — Colletotrichum zibethinum',
                'crop_name' => 'Sầu riêng',
                'pathogen_type' => 'nam',
                'caunho' => 'Colletotrichum = THÁN THƯ = ĐỐM NÂU HOẠI TỬ VÒNG ĐỒNG TÂM (khô bìa lá, rụng bông quả non).',
                'symptoms' => "Colletotrichum zibethinum là bệnh đốm lá và thối hoa quả phổ biến hàng đầu trên sầu riêng. Vết bệnh đốm nâu tròn hoặc loang lổ có vòng đồng tâm màu nâu đậm, viền vàng, làm rách thủng lá, thối hoa và rụng quả non.",
                'symptoms_detail' => [
                    'la' => 'Đốm nâu hoại tử bắt đầu từ mép hoặc chóp lá lan vào, có các vân vòng đồng tâm rõ nét, viền vàng nhạt, lá khô rách thủng.',
                    'canh_than' => 'Đốm nâu đen lõm trên cành non, làm cành bị khô ngọn và teo tóp cành mang hoa.',
                    'goc_re' => 'Không gây hại vùng rễ.',
                    'qua' => 'Hoa bị thối khô màu nâu đen rụng hàng loạt; trên quả xuất hiện vết đốm tròn lõm sẫm màu.',
                ],
                'prevention' => "Bước 1 — Canh tác:\n• Cắt tỉa cành thông thoáng, thu gom lá bệnh và hoa quả rụng đem tiêu hủy.\n• Bón phân cân đối N-P-K, tăng cường Canxi Bo và Silic giúp vách tế bào lá dày cứng chống nấm.",
                'treatment' => "Bước 2 — Xử lý thuốc:\n• Phun luân phiên các hoạt chất nấm phổ rộng và nội hấp: Mancozeb, Azoxystrobin, Difenoconazole, Tebuconazole, Propiconazole khi cơi đọt mới mở lá hoặc trước khi hoa nở.",
                'chemical_groups' => 'Mancozeb, Azoxystrobin, Difenoconazole, Tebuconazole, Propiconazole (FRAC M03, FRAC 11, FRAC 3).',
                'notes' => 'Thán thư thường đi kèm bọ trĩ phá hoại tạo vết thương hở trên lá non và chùm hoa.',
                'pesticide_keywords' => ['Mancozeb', 'Asmiltatop', 'Tebaz', 'Tilt Super'],
            ],

            // 9. Phomopsis
            [
                'name' => 'Bệnh Đốm Lá — Phomopsis spp.',
                'crop_name' => 'Sầu riêng',
                'pathogen_type' => 'nam',
                'caunho' => 'Phomopsis = ĐỐM LÁ ĐỐM TRÒN NHỎ (cháy từng mảng phiến lá, luân phiên nhóm FRAC).',
                'symptoms' => "Nấm Phomopsis spp. gây ra các đốm nhỏ màu nâu vàng trên phiến lá sầu riêng, giữa vết bệnh có chấm đen li ti, mép lá cháy khô, bệnh nặng làm rụng lá hàng loạt gây suy kiệt cây.",
                'symptoms_detail' => [
                    'la' => 'Đốm bệnh ban đầu nhỏ như đầu kim, sau lan rộng thành vệt tròn hoặc bầu dục màu nâu vàng viền sẫm, lá vàng và rụng sớm.',
                    'canh_than' => 'Vết đốm sẫm màu trên cọng lá và cành non.',
                    'goc_re' => 'Không gây hại ở rễ.',
                    'qua' => 'Làm giảm mã quả, có thể gây đốm nhẹ vỏ quả.',
                ],
                'prevention' => "Bước 1 — Canh tác:\n• Tỉa thông thoáng tán lá, giảm độ ẩm kéo dài trong vườn.\n• Vệ sinh dọn sạch lá rụng dưới gốc cây.",
                'treatment' => "Bước 2 — Xử lý thuốc:\n• Phun thuốc trừ nấm: Azoxystrobin, Difenoconazole, Mancozeb, Chlorothalonil.\n• Luân phiên nhóm FRAC 11, FRAC 3 và FRAC M03 thay vì dùng lặp lại một hoạt chất liên tục.",
                'chemical_groups' => 'Azoxystrobin, Difenoconazole, Mancozeb, Chlorothalonil (FRAC 11, FRAC 3, FRAC M03, FRAC M05).',
                'notes' => 'Bệnh thường nặng ở các vườn thiếu ánh sáng hoặc bón nhiều đạm mà thiếu kali.',
                'pesticide_keywords' => ['Asmiltatop', 'Mancozeb', 'Tilt Super', 'Tebaz'],
            ],

            // 10. Đốm rong / Tảo đỏ
            [
                'name' => 'Bệnh Đốm Rong / Tảo Đỏ — Cephaleuros spp.',
                'crop_name' => 'Sầu riêng',
                'pathogen_type' => 'vi_khuan',
                'caunho' => 'Đốm rong = ĐỎ CAM/ĐỎ GẠCH NHUNG MỊN (tảo ký sinh, không phải nấm, dùng thuốc gốc đồng).',
                'symptoms' => "Do tảo ký sinh Cephaleuros virescens (KHÔNG PHẢI NẤM) gây ra trên lá già và vỏ thân cành sầu riêng. Vết đốm hình tròn nhung mịn màu đỏ cam hoặc đỏ gạch, làm giảm quang hợp và nứt vỏ cành.",
                'symptoms_detail' => [
                    'la' => 'Đốm tròn nhung màu đỏ cam gạch tôm nhô cao trên mặt lá già, sau hóa xám nâu làm lá dày cộm, cằn cỗi.',
                    'canh_than' => 'Lớp màng đỏ cam bám chặt trên vỏ thân cành, làm vỏ sần sùi, nứt nẻ và nhánh kém phát triển.',
                    'goc_re' => 'Không gây hại vùng rễ.',
                    'qua' => 'Ít tấn công trực tiếp quả.',
                ],
                'prevention' => "Bước 1 — Canh tác:\n• Tỉa cành tạo tán nhận đủ ánh sáng mặt trời, giảm độ ẩm lưu cữu trong tán.\n• Cải thiện sức khỏe cây, bón phân cân đối, bổ sung trung vi lượng (Magiê, Kẽm).",
                'treatment' => "Bước 2 — Xử lý thuốc:\n• Phun các chế phẩm thuốc trừ bệnh gốc đồng: Copper Hydroxide, Đồng Oxyclorua, Bordeaux hoặc Nano Đồng.\n• Quét dung dịch thuốc gốc đồng đậm đặc lên các cành bị đóng rong nặng sau khi thu hoạch.",
                'chemical_groups' => 'Đồng Oxyclorua, Copper Hydroxide, Đồng Bordeaux, Nano Đồng (Nhóm FRAC M01).',
                'notes' => 'Lưu ý kỹ thuật: Thuốc trừ nấm phổ thông thông thường ít có tác dụng trên tảo, phải dùng thuốc gốc đồng!',
                'pesticide_keywords' => ['Alien', 'Dimethor'],
            ],

            // 11. Thối trái
            [
                'name' => 'Thối Trái Sầu Riêng — Phytophthora & Nấm Thối Quả',
                'crop_name' => 'Sầu riêng',
                'pathogen_type' => 'nam',
                'caunho' => 'Thối trái = TÁC NHÂN OOMYCETES & NẤM PHỔ RỘNG (thu gom quả bệnh, bao trái, thoát nước).',
                'symptoms' => "Phytophthora palmivora kết hợp Colletotrichum và nấm hoại sinh gây thối trái sầu riêng giai đoạn nuôi quả lớn và chuẩn bị thu hoạch. Vết thối nâu sũng nước xuất hiện từ đít trái hoặc kẽ gai, lan sâu vào múi quả, bốc mùi chua thối, phủ lớp mốc trắng mịn.",
                'symptoms_detail' => [
                    'la' => 'Cây mang trái bệnh thường có tán lá rậm rạp hoặc đang bị đốm lá/thán thư.',
                    'canh_than' => 'Cuống quả xuất hiện đốm nâu thối làm trái dễ rụng cuống.',
                    'goc_re' => 'Có thể đi kèm hiện tượng rễ bị úng nước.',
                    'qua' => 'Vết nâu đen úng nước loang rộng trên vỏ gai, múi quả bên trong nhũn thối, chảy nước chua và phủ tơ nấm trắng.',
                ],
                'prevention' => "Bước 1 — Giảm nguồn bệnh & giảm ẩm:\n• Thu gom tiêu hủy triệt để trái bệnh ra xa vườn, tuyệt đối không để trái thối nằm dưới gốc.\n• Khơi rãnh thoát nước, không để nước mưa từ đất bắn ngược lên chùm quả thấp.\n• Tỉa bỏ cành mọc quá thấp gần mặt đất (< 1m).",
                'treatment' => "Bước 2 — Xử lý bệnh:\n• Phun thuốc đặc trị nhóm Oomycetes (Phosphonate, Fosetyl-Aluminium, Metalaxyl, Dimethomorph) kết hợp nấm phổ rộng (Mancozeb, Azoxystrobin) trước mùa mưa hoặc khi chớm có vết bệnh.\n• Chú ý thời gian cách ly (PHI) trước khi thu hoạch theo nhãn thuốc.",
                'chemical_groups' => 'Phosphonate, Fosetyl-Aluminium, Metalaxyl-M, Dimethomorph, Mancozeb, Azoxystrobin (FRAC P07, FRAC 4, FRAC 40, FRAC M03, FRAC 11).',
                'notes' => 'Trái ở tầng thấp gần mặt đất là đối tượng dễ bị nhiễm bệnh nhất do nước mưa bắn từ đất.',
                'pesticide_keywords' => ['Agri-Fos', 'Delta Fos', 'Alien', 'Dimethor', 'Ridomil', 'Profiler'],
            ],

            // 12. Hội chứng vàng lá thối rễ
            [
                'name' => 'Hội Chứng Vàng Lá – Thối Rễ – Suy Cây Sầu Riêng',
                'crop_name' => 'Sầu riêng',
                'pathogen_type' => 'nam',
                'caunho' => 'Vàng lá = Phyto + Pythium + Fusarium + Tuyến trùng + Úng (Khám rễ trước khi kê đơn thuốc!).',
                'symptoms' => "Hội chứng phức tạp đa nguyên nhân làm rễ hư hại, cây vàng lá rụng cành và suy kiệt dần. Kỹ sư phải chẩn đoán 5 bước phân biệt: Đất có úng không? Rễ còn trắng hay nâu đen mục? Gốc có xì mủ không? Có nốt sần tuyến trùng không? Cây vàng nhanh hay từ từ?",
                'symptoms_detail' => [
                    'la' => 'Vàng lá toàn cây hoặc vàng từng cành, lá rụng trơ cành, đọt non chùn lại không phát triển.',
                    'canh_than' => 'Có thể kèm xì mủ gốc (Phytophthora) hoặc khô cành mạch dẫn thâm nâu (Fusarium).',
                    'goc_re' => 'Rễ tơ thối mục, rụng vỏ rễ, chóp rễ cụt đen hoặc xuất hiện các nốt sần u bướu tuyến trùng.',
                    'qua' => 'Rụng hoa, rụng trái non hàng loạt, cây suy kiệt.',
                ],
                'prevention' => "Bước 1 — Khắc phục nguyên nhân nền tảng:\n• Không phun thuốc vội vã khi chưa chẩn đoán đúng nguyên nhân.\n• Khơi thông mương rãnh thoát nước, hạ mực nước ngầm, nâng pH đất lên 6.0.\n• Rắc vôi hoặc chế phẩm lân nung chảy cải tạo đất chua nghèo hữu cơ.",
                'treatment' => "Bước 2 — Xử lý thuốc theo đúng nguyên nhân chẩn đoán:\n• Do ngập úng/Oomycetes (Phyto/Pythium): Xử lý Phosphonate, Metalaxyl, Dimethomorph.\n• Do nấm đất (Fusarium): Xử lý Triazole, Mancozeb.\n• Do tuyến trùng: Xử lý Fluopyram, Abamectin.\nBước 3 — Phục hồi hệ rễ:\n• Tưới Axit Humic, Fulvic, Amino Acid kết hợp nấm đối kháng Trichoderma và Bacillus subtilis.",
                'chemical_groups' => 'Phosphonate, Metalaxyl-M, Dimethomorph, Mancozeb, Hexaconazole, Fluopyram, Abamectin, Trichoderma, Bacillus (FRAC P07, FRAC 4, FRAC 40, FRAC M03, FRAC 3, FRAC 7, IRAC 6).',
                'notes' => 'Khách hàng kêu vàng lá, tuyệt đối không bốc 1 loại thuốc bừa bãi. Phải hỏi kỹ các câu hỏi chẩn đoán phân biệt.',
                'pesticide_keywords' => ['Agri-Fos', 'Delta Fos', 'Alien', 'Dimethor', 'Ridomil', 'Anvil', 'Mancozeb', 'Velum Prime'],
            ],

            // 13. Bọ trĩ
            [
                'name' => 'Bọ Trĩ Hại Sầu Riêng — Thrips spp.',
                'crop_name' => 'Sầu riêng',
                'pathogen_type' => 'sau_hai',
                'caunho' => 'Bọ trĩ = XƯỚC BẠC LÁ NON + KHÔ CHÙM BÔNG (chích hút mô non, luân phiên nhóm IRAC).',
                'symptoms' => "Bọ trĩ (Thrips spp.) có kích thước rất nhỏ, chích hút dịch tế bào ở đọt non, lá non và chùm hoa sầu riêng. Khiến lá non bị biến dạng, bề mặt lá xước bạc lấm tấm, hoa bị khô đen rụng cuống, giảm tỷ lệ đậu trái.",
                'symptoms_detail' => [
                    'la' => 'Lá non cong queo, mép lá cụp xuống, mặt dưới lá có vệt sáng bóng ánh bạc hoặc xước rám màu gỉ đồng.',
                    'canh_than' => 'Chồi đọt non bị chùn lại, phát triển dị dạng, còi cọc.',
                    'goc_re' => 'Không gây hại ở rễ.',
                    'qua' => 'Chùm hoa bị thâm đen, khô nhụy hoa; cuống trái non xuất hiện quầng xước cám màu nâu quanh đài hoa.',
                ],
                'prevention' => "Bước 1 — Quản lý sinh thái:\n• Thăm vườn định kỳ, dùng kính lúp hoặc gõ đọt non/hoa lên tờ giấy trắng để phát hiện bọ trĩ sớm.\n• Quản lý cỏ dại và thảm thực vật nơi trú ẩn của bọ trĩ.\n• Bảo vệ thiên địch (bọ xít bắt mồi Orius, bọ rùa).",
                'treatment' => "Bước 2 — Xử lý thuốc:\n• Phun thuốc khi cơi đọt mới nhú hạt gạo đến hé mũi giáo hoặc trước khi hoa nở rộ.\n• Luân phiên các nhóm hoạt chất IRAC: Spinetoram (Radiant), Imidacloprid, Thiamethoxam, Abamectin, Acetamiprid để tránh bọ trĩ kháng thuốc.",
                'chemical_groups' => 'Spinetoram, Thiamethoxam, Imidacloprid, Abamectin, Acetamiprid, Dinotefuran (Nhóm IRAC 5, IRAC 4A, IRAC 6).',
                'notes' => 'Bọ trĩ phát triển mạnh vào mùa khô, nắng nóng và cơi đọt non ra rộ.',
                'pesticide_keywords' => ['Nofara', 'Thần Chớp', 'THPRO', 'Riegenf', 'Resgant'],
            ],

            // 14. Nhện đỏ
            [
                'name' => 'Nhện Đỏ – Nhện Trắng Hại Sầu Riêng — Tetranychus spp.',
                'crop_name' => 'Sầu riêng',
                'pathogen_type' => 'sau_hai',
                'caunho' => 'Nhện đỏ = NẮNG NÓNG KHÔ + LẤM TẤM VÀNG CÁM (xịt ướt mặt dưới lá, luân phiên IRAC).',
                'symptoms' => "Nhện đỏ và nhện trắng chích hút dịch diệp lục ở mặt dưới phiến lá, bùng phát khủng khiếp trong mùa khô nóng, ít mưa. Lá mất màu xanh bóng, chuyển sang màu vàng cám lấm tấm, mặt dưới giăng tơ mỏng, lá rụng hàng loạt làm suy cây trơ cành.",
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
                'pesticide_keywords' => ['Resgant', 'Abamectin'],
            ],

            // 15. Rệp sáp & Kiến
            [
                'name' => 'Rệp Sáp & Kiến Cộng Sinh — Planococcus spp.',
                'crop_name' => 'Sầu riêng',
                'pathogen_type' => 'sau_hai',
                'caunho' => 'Rệp sáp = CỤC BÔNG TRẮNG + KIẾN + MUỘI ĐEN (phải diệt cả kiến cộng sinh).',
                'symptoms' => "Rệp sáp tiết lớp sáp trắng như bông bao bọc cơ thể, chích hút dịch cuống hoa, trái non và kẽ cành. Tiết dịch mật ngọt thu hút kiến cộng sinh phát tán rệp và kích thích nấm muội đen bồ hóng phát triển làm đen vỏ quả, xấu mã thương phẩm.",
                'symptoms_detail' => [
                    'la' => 'Lá bị phủ lớp muội đen bồ hóng do nấm muội phát triển trên chất bài tiết mật ngọt của rệp.',
                    'canh_than' => 'Đám rệp sáp trắng bám dày ở các nách cành, kẽ nứt thân cành.',
                    'goc_re' => 'Rệp sáp có thể chui xuống bám ở cổ rễ và gốc rễ non.',
                    'qua' => 'Các cục bông trắng bám dày đặc ở cuống quả và kẽ gai sầu riêng, quả méo mó, gai bị chai đen.',
                ],
                'prevention' => "Bước 1 — Biện pháp đồng bộ:\n• DIỆT RỆP + QUẢN LÝ KIẾN + RỬA NƯỚC ÁP LỰC + BẢO VỆ THIÊN ĐỊCH.\n• Rắc vôi hoặc xử lý thuốc diệt kiến dưới gốc để chặn kiến tha rệp lên cây.\n• Dùng vòi phun nước áp lực cao xịt rửa trôi lớp phấn sáp trên trái.",
                'treatment' => "Bước 2 — Xử lý thuốc:\n• Phun thuốc có tính lưu dẫn, thấm sâu hoặc xông hơi: Spirotetramat, Dinotefuran, Thiamethoxam, Profenofos kết hợp Dầu khoáng nông nghiệp để phá vỡ lớp màng sáp bảo vệ.",
                'chemical_groups' => 'Spirotetramat, Dinotefuran, Thiamethoxam, Profenofos, Dầu khoáng nông nghiệp (IRAC 23, IRAC 4A, IRAC 1B).',
                'notes' => 'Kiến là tác nhân chính vận chuyển rệp sáp phát tán khắp cây, không diệt kiến thì rệp sáp sẽ tái phát rất nhanh.',
                'pesticide_keywords' => ['Tề Thiên', 'THPRO', 'Nofara', 'Riegenf'],
            ],

            // 16. Rầy nhảy
            [
                'name' => 'Rầy Nhảy / Rầy Phấn Hại Sầu Riêng — Allocaridara malayensis',
                'crop_name' => 'Sầu riêng',
                'pathogen_type' => 'sau_hai',
                'caunho' => 'Rầy nhảy = HÚT ĐỌT NON + CHÙN ĐỌT (phun đón cơi đọt khi mới hé mũi giáo).',
                'symptoms' => "Rầy nhảy (Allocaridara malayensis) là đối tượng gây hại số một trên cơi đọt sầu riêng. Cả rầy trưởng thành và ấu trùng (tiết sợi sáp trắng ở đuôi) chích hút đọt non làm lá khô queo, chùn ngọn, cháy lá và rụng lá non hàng loạt.",
                'symptoms_detail' => [
                    'la' => 'Lá non bị chích hút có các chấm vàng, phiến lá cong queo dị dạng, mép lá cháy khô và rụng sớm để lại cành trơ trụi.',
                    'canh_than' => 'Đọt non bị chùn lại, khô đọt, các sợi sáp trắng của ấu trùng rầy bám quanh cành non.',
                    'goc_re' => 'Không gây hại ở rễ.',
                    'qua' => 'Không gây hại trực tiếp quả, nhưng làm cây mất bộ lá quang hợp nuôi quả.',
                ],
                'prevention' => "Bước 1 — Canh tác:\n• Bón phân và tưới nước điều khiển cho cơi đọt sầu riêng ra đồng loạt toàn vườn.\n• Thường xuyên kiểm tra cơi đọt khi búp lá vừa nhú (giai đoạn mũi giáo).",
                'treatment' => "Bước 2 — Xử lý thuốc:\n• Phun thuốc lần 1 khi cơi đọt mới hé mũi giáo (khoảng 1-2cm).\n• Phun lần 2 sau 5-7 ngày khi lá non bắt đầu mở ra.\n• Hoạt chất đặc trị: Dinotefuran, Acetamiprid, Thiamethoxam, Buprofezin (ức chế lột xác) luân phiên.",
                'chemical_groups' => 'Dinotefuran, Acetamiprid, Thiamethoxam, Buprofezin, Imidacloprid (IRAC 4A, IRAC 16).',
                'notes' => 'Phun trễ khi lá non đã mở xòe ra thì hiệu quả diệt rầy rất thấp vì mô lá đã bị tổn thương biến dạng.',
                'pesticide_keywords' => ['Thần Chớp', 'Nofara', 'Tề Thiên', 'Riegenf'],
            ],

            // 17. Sâu đục cành
            [
                'name' => 'Sâu Đục Cành Sầu Riêng — Batocera spp. & Zeuzera coffeae',
                'crop_name' => 'Sầu riêng',
                'pathogen_type' => 'sau_hai',
                'caunho' => 'Sâu đục cành = LỖ ĐÙN MÙN CƯA PHÂN SÂU (bắt sâu + bơm thuốc xông hơi vào lỗ).',
                'symptoms' => "Ấu trùng sâu đục thân cành (xén tóc Batocera hoặc sâu đục cành Zeuzera coffeae) đục khoét sâu vào bên trong lõi gỗ cành và thân sầu riêng, đùn mùn gỗ và phân ra ngoài. Làm cành bị rỗng ruột, khô héo và gãy ngang khi gặp gió lớn.",
                'symptoms_detail' => [
                    'la' => 'Lá trên nhánh cành bị sâu đục héo rũ đột ngột, khô vàng trong khi các cành khác vẫn xanh tốt.',
                    'canh_than' => 'Xuất hiện lỗ đục tròn trên vỏ cành thân, có mùn cưa và phân sâu đùn ra đọng ở gốc nhánh, vỏ cành thâm đen nứt nẻ.',
                    'goc_re' => 'Ấu trùng xén tóc có thể đục sâu xuống gốc sát cổ rễ.',
                    'qua' => 'Cành mang trái bị gãy làm rụng toàn bộ trái trên cành.',
                ],
                'prevention' => "Bước 1 — Canh tác:\n• Thường xuyên kiểm tra thân cành để phát hiện sớm các lỗ đục mới xuất hiện.\n• Bắt xén tóc trưởng thành vào đầu mùa mưa.\n• Cắt bỏ và tiêu hủy các cành đã bị sâu đục rỗng khô chết.",
                'treatment' => "Bước 2 — Xử lý sâu:\n• Dùng dây kẽm soi vào lỗ đục để xiên chết sâu non bên trong.\n• Dùng xi-lanh bơm thuốc trừ sâu có tính xông hơi và lưu dẫn mạnh (Profenofos, Cypermethrin, Thiamethoxam) trực tiếp vào lỗ đục rồi dùng đất sét hoặc bông gòn bít kín lỗ lại.",
                'chemical_groups' => 'Profenofos, Cypermethrin, Thiamethoxam, Chlorpyrifos-methyl (Nhóm IRAC 1B, IRAC 3A, IRAC 4A).',
                'notes' => 'Thuốc phun bên ngoài tán lá không có tác dụng với sâu non đã chui sâu vào trong lõi gỗ, bắt buộc phải bơm thuốc vào lỗ.',
                'pesticide_keywords' => ['THPRO', 'Riegenf'],
            ],

            // 18. Sâu đục trái
            [
                'name' => 'Sâu Đục Trái Sầu Riêng — Conogethes punctiferalis',
                'crop_name' => 'Sầu riêng',
                'pathogen_type' => 'sau_hai',
                'caunho' => 'Sâu đục trái = PHÂN ĐÙN KẼ GAI (tỉa trái thưa, bao trái, xử lý sớm khi bướm rộ).',
                'symptoms' => "Sâu non đục qua lớp vỏ gai cứng chui vào ăn phần thịt quanh hạt sầu riêng, thải phân sâu ra ngoài kẽ gai kết dính lại. Vết đục tạo điều kiện cho nấm Phytophthora xâm nhập làm thối ủng toàn bộ trái và rụng non.",
                'symptoms_detail' => [
                    'la' => 'Không gây hại trên lá.',
                    'canh_than' => 'Không gây hại trên cành thân.',
                    'goc_re' => 'Không gây hại ở rễ.',
                    'qua' => 'Lỗ đục ở các kẽ gai trên vỏ trái, có khối phân sâu màu nâu đen kết dính đùn ra ngoài kẽ gai; cơm quả bên trong bị thối nhũn.',
                ],
                'prevention' => "Bước 1 — Canh tác:\n• Tỉa trái sớm, không để các trái trong chùm cọ xát dính chặt vào nhau tạo nơi ẩn nấp cho sâu.\n• Sử dụng túi bao trái chuyên dụng khi trái đạt kích thước trứng ngỗng.\n• Thu gom tiêu hủy triệt để các quả non bị sâu đục rơi rụng trong vườn.",
                'treatment' => "Bước 2 — Xử lý thuốc:\n• Phun thuốc khi sâu non mới nở giai đoạn bướm rộ đẻ trứng (trước khi sâu đục chui vào trong vỏ).\n• Hoạt chất ưu tiên sinh học và chọn lọc: Emamectin benzoate, Bacillus thuringiensis (Bt), Chlorantraniliprole, Lufenuron.",
                'chemical_groups' => 'Emamectin benzoate, Bacillus thuringiensis (Bt), Chlorantraniliprole, Lufenuron, Spinetoram (IRAC 6, IRAC 11, IRAC 28, IRAC 15, IRAC 5).',
                'notes' => 'Khi sâu non đã đục sâu vào trong múi thì việc phun thuốc hầu như không còn tác dụng, phải chú ý phòng sớm.',
                'pesticide_keywords' => ['Resgant', 'Abamectin'],
            ],

            // 19. Sâu ăn bông
            [
                'name' => 'Sâu Ăn Bông Sầu Riêng — Thalassodes spp.',
                'crop_name' => 'Sầu riêng',
                'pathogen_type' => 'sau_hai',
                'caunho' => 'Sâu ăn bông = CẮN NHỤY HOA + XƠ XÁC CHÙM BÔNG (ưu tiên thuốc sinh học mát bông).',
                'symptoms' => "Sâu non (sâu róm, sâu đo) cắn phá cánh hoa, nhụy hoa và cuống hoa sầu riêng giai đoạn nhú mắt cua đến xổ nhụy. Làm hoa xơ xác, thâm đen và rụng hàng loạt, ảnh hưởng trực tiếp đến tỷ lệ thụ phấn đậu quả.",
                'symptoms_detail' => [
                    'la' => 'Ít tấn công lá già, có thể cắn rách nhẹ rìa lá non.',
                    'canh_than' => 'Sâu ẩn nấp ở các nách cành gần chùm hoa.',
                    'goc_re' => 'Không gây hại ở rễ.',
                    'qua' => 'Chùm hoa bị cắn rách nham nhở, đứt nhụy hoa, hoa khô héo rụng đầy dưới gốc cây, có phân sâu nhỏ li ti bám trên chùm bông.',
                ],
                'prevention' => "Bước 1 — Canh tác:\n• Tỉa thưa các chùm hoa mọc quá dày sít nhau, tạo độ thông thoáng cho chùm hoa tiếp xúc ánh sáng.\n• Thăm vườn vào ban đêm hoặc sáng sớm khi sâu ra cắn phá để bắt thủ công.",
                'treatment' => "Bước 2 — Xử lý thuốc an toàn cho hoa:\n• Phun thuốc trừ sâu sinh học hoặc thuốc mát không làm nóng bông trước khi hoa xổ nhụy 3-5 ngày.\n• Hoạt chất an toàn cho hoa: Bacillus thuringiensis (Bt), Emamectin benzoate, Spinetoram.",
                'chemical_groups' => 'Bacillus thuringiensis (Bt), Emamectin benzoate, Spinetoram (Sinh học, Nhóm IRAC 6, IRAC 5).',
                'notes' => '⚠️ Tuyệt đối không phun thuốc trừ sâu hóa học có tính nóng hoặc nhũ dầu nặng (EC) trong giai đoạn hoa đang xổ nhụy vì sẽ làm cháy nhụy hoa và chết hạt phấn.',
                'pesticide_keywords' => ['Resgant', 'Abamectin'],
            ],

            // 20. Tuyến trùng
            [
                'name' => 'Tuyến Trùng Hại Rễ Sầu Riêng — Meloidogyne spp. & Pratylenchus spp.',
                'crop_name' => 'Sầu riêng',
                'pathogen_type' => 'tuyen_trung',
                'caunho' => 'Tuyến trùng = RỄ U SẦN NỐT BƯỚU (mở đường nấm rễ, xử lý tuyến trùng + phục hồi rễ).',
                'symptoms' => "Tuyến trùng nốt sần (Meloidogyne spp.) và tuyến trùng thương tổn (Pratylenchus spp.) đục lỗ chui vào rễ non sầu riêng hút dinh dưỡng, tạo thành các nốt u bướu phồng tròn. Rễ mất khả năng hút nước, tạo vết thương hở cho Phytophthora và Fusarium xâm nhập phá hoại thứ cấp.",
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
                'pesticide_keywords' => ['Velum Prime', 'Resgant'],
            ],
        ];

        foreach ($diseasesData as $data) {
            $keywords = $data['pesticide_keywords'] ?? [];
            unset($data['pesticide_keywords']);

            $disease = Disease::updateOrCreate(
                [
                    'name' => $data['name'],
                    'crop_name' => $data['crop_name'],
                ],
                $data
            );

            // Tự động quét và liên kết toàn bộ thuốc trong kho có cùng hoạt chất
            $disease->autoSyncPesticidesByChemicalGroups();

            // Nếu có từ khóa thuốc bổ sung, gắn thêm toàn bộ sản phẩm tìm được
            if (!empty($keywords)) {
                $additionalIds = Pesticide::where(function ($query) use ($keywords) {
                    foreach ($keywords as $kw) {
                        $query->orWhere('name', 'like', "%{$kw}%")
                              ->orWhere('active_ingredient', 'like', "%{$kw}%");
                    }
                })->pluck('id')->toArray();

                if (!empty($additionalIds)) {
                    $disease->pesticides()->syncWithoutDetaching($additionalIds);
                }
            }
        }
    }
}
