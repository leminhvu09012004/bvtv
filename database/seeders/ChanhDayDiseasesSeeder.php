<?php

namespace Database\Seeders;

use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class ChanhDayDiseasesSeeder extends Seeder
{
    /**
     * Run the database seeds for 8 primary Passion Fruit (Chanh Dây) diseases.
     */
    public function run(): void
    {
        $diseasesData = [
            [
                'name' => 'Bệnh Đốm Nâu — Alternaria',
                'crop_name' => 'Chanh dây',
                'pathogen_type' => 'nam',
                'caunho' => 'Alternaria → ĐỐM NÂU → lá + cành + quả (vết bệnh có viền vàng, vòng đồng tâm).',
                'symptoms' => "Trên lá: Xuất hiện các đốm nâu, vết bệnh có thể có viền vàng. Nhiều vết liên kết → lá khô, cháy, rụng.\nTrên cành/thân: Vết nâu đen, kéo dài. Nếu vết bệnh bao quanh cành → chồi phía trên có thể héo.\nTrên quả: Đốm nâu ban đầu nhỏ, sau đó lõm xuống, lan rộng, có thể tạo vòng đồng tâm. Quả nhăn, thối và rụng.",
                'symptoms_detail' => [
                    'la' => 'Đốm nâu có viền vàng. Nhiều vết liên kết làm lá khô, cháy và rụng hàng loạt.',
                    'canh_than' => 'Vết nâu đen kéo dài. Bao quanh đốt cành làm chồi non và cành phía trên bị héo rũ.',
                    'goc_re' => 'Ít biểu hiện trực tiếp ở gốc rễ, chủ yếu tấn công tầng tán phía trên.',
                    'qua' => 'Đốm nâu nhỏ lõm xuống, lan rộng tạo các vòng tròn đồng tâm. Quả nhăn nheo, teo thối và rụng non.',
                ],
                'prevention' => "• Tỉa giàn tạo độ thông thoáng, giảm ẩm độ trong tán.\n• Không để tán cây quá rậm rạp.\n• Thu gom triệt để lá và quả bị bệnh đem tiêu hủy xa vườn.\n• Hạn chế để nước tưới làm ướt tán lá kéo dài.\n• Đặc biệt cảnh giác cao điểm vào mùa mưa dầm + ẩm độ cao.",
                'treatment' => "Khi bệnh chớm xuất hiện, phun ướt đều 2 mặt lá và chùm quả bằng các hoạt chất trừ nấm phổ rộng hoặc nhóm DMI/Strobilurin.\nLuân phiên các nhóm hoạt chất để hạn chế tối đa nguy cơ kháng thuốc.\n⚠️ Chú ý: Tuân thủ đúng nồng độ và liều lượng theo khuyến cáo trên nhãn chai/gói, không tự ý tăng liều.",
                'chemical_groups' => 'Mancozeb, Azoxystrobin, Difenoconazole, Tebuconazole (Nhóm FRAC M03, FRAC 11, FRAC 3).',
                'notes' => 'Thường phát sinh mạnh vào đầu mùa mưa và giai đoạn quả non đang phát triển.',
                'pesticide_keywords' => ['Mancozeb', 'Asmiltatop', 'Tebaz'],
            ],
            [
                'name' => 'Bệnh Thối Gốc / Thối Rễ / Thối Thân — Phytophthora',
                'crop_name' => 'Chanh dây',
                'pathogen_type' => 'nam',
                'caunho' => 'Phytophthora → NƯỚC → THỐI GỐC/RỄ → HÉO (Xử lý gốc + rễ + thoát nước, không chỉ phun lá).',
                'symptoms' => "Gốc/thân: Vỏ thân có vết bệnh nâu, thối nứt, mô bên trong chuyển nâu hoại tử. Nặng → toàn cây héo rũ và chết đứng.\nRễ: Hệ rễ tơ và rễ cọc bị thối đen, rụng vỏ rễ, giảm khả năng hút nước/dinh dưỡng, cây vàng lá.\nQuả: Xuất hiện các vùng nâu úng nước rồi thối nhũn nhanh chóng.\nPhát triển bùng phát khi đất ẩm độ cao, mưa nhiều và vườn thoát nước kém.",
                'symptoms_detail' => [
                    'la' => 'Lá mất sức căng, úa vàng, héo rũ từ đọt non xuống gốc do hệ rễ bị hủy hoại.',
                    'canh_than' => 'Đoạn thân gần mặt đất sũng nước, chuyển màu nâu đen, vỏ nứt toác và tiết dịch nhờn.',
                    'goc_re' => 'Cổ rễ thối đen, rễ tơ chết mục, bóc lớp vỏ thấy lõi gỗ chuyển nâu xám sũng nước.',
                    'qua' => 'Vùng úng nước loang lổ trên quả, phủ lớp mốc trắng mịn trong điều kiện ẩm ướt.',
                ],
                'prevention' => "Quan trọng hàng đầu: THOÁT NƯỚC ↓ KHÔNG ĐỂ ÚNG ↓ QUẢN LÝ VÙNG RỄ.\n• Làm rãnh thoát nước sâu giữa các liếp trồng, không để nước đọng quanh cổ rễ.\n• Tuyệt đối không lấy đất hay bầu cây giống từ vườn bị nhiễm bệnh.\n• Định kỳ tưới chế phẩm nấm đối kháng Trichoderma hoặc xạ khuẩn bảo vệ vùng rễ.",
                'treatment' => "Phải kết hợp vừa tưới đẫm vùng gốc rễ vừa phun thân tán bằng các hoạt chất chuyên trị nấm giả Oomycetes.\nXới nhẹ lớp đất mặt quanh gốc để thoát ẩm trước khi tưới thuốc.",
                'chemical_groups' => 'Phosphonate / Phosphorous acid, Fosetyl-Aluminium, Metalaxyl / Metalaxyl-M, Dimethomorph, Fluopicolide (Nhóm FRAC P07, FRAC 4, FRAC 40, FRAC 43).',
                'notes' => 'Bệnh lây lan rất nhanh theo dòng nước chảy mặt trong vườn.',
                'pesticide_keywords' => ['Aliette', 'Ridomil', 'Binhtaxyl', 'Profiler'],
            ],
            [
                'name' => 'Bệnh Phình Thân / Héo — Fusarium',
                'crop_name' => 'Chanh dây',
                'pathogen_type' => 'nam',
                'caunho' => 'Fusarium → PHÌNH GỐC + NỨT + HÉO (Mô mạch dẫn bên trong thâm nâu).',
                'symptoms' => "Điểm đặc trưng nhất: GỐC/THÂN PHÌNH TO → NỨT VỎ → MÔ BÊN TRONG NÂU → CÂY HÉO RŨ VÀ CHẾT.\nCây có biểu hiện sinh trưởng còi cọc, vàng lá một bên hoặc toàn cây rồi héo rũ từ từ.\nCắt ngang gốc thấy bó mạch dẫn libe-gỗ bị thâm nâu đen chặn dòng nhựa nguyên.",
                'symptoms_detail' => [
                    'la' => 'Vàng lá rải rác từ dưới lên, ban ngày héo ban đêm hồi phục nhẹ rồi sau vài ngày héo hẳn.',
                    'canh_than' => 'Đoạn thân cách mặt đất 10-30cm bị phình to bất thường gấp 1.5 - 2 lần, nứt dọc thân.',
                    'goc_re' => 'Gốc phình to, nứt sâu, lớp gỗ bên trong hóa nâu sẫm, rễ chính bị tổn thương.',
                    'qua' => 'Quả nhỏ, teo tóp, nhăn nheo do thiếu dinh dưỡng truyền lên.',
                ],
                'prevention' => "• Đất trồng phải tơi xốp, thoát nước cực tốt, bổ sung nhiều phân hữu cơ ủ hoai.\n• Tuyệt đối không làm tổn thương vùng rễ và gốc khi làm cỏ hoặc bón phân.\n• Vệ sinh khử trùng dụng cụ cắt tỉa cành bằng cồn hoặc vôi bột.\n• Nhổ bỏ và tiêu hủy tận gốc các cây bị bệnh nặng, rắc vôi bột khử trùng hố trồng.",
                'treatment' => "Tưới gốc bằng nhóm hoạt chất trừ nấm đất thẩm thấu sâu hoặc chế phẩm sinh học đối kháng.\nLưu ý: Phải chẩn đoán phân biệt kỹ với Phytophthora và Tuyến trùng trước khi xử lý thuốc.",
                'chemical_groups' => 'Triazole (Hexaconazole, Tebuconazole), Mancozeb, Chế phẩm Trichoderma sp. (FRAC 3, FRAC M03, Sinh học BM02).',
                'notes' => 'Nấm tồn tại dai dẳng nhiều năm trong đất dưới dạng bào tử hậu.',
                'pesticide_keywords' => ['Anvil', 'Mancozeb', 'Tebaz', 'Japa Vil'],
            ],
            [
                'name' => 'Bệnh Thán Thư — Colletotrichum',
                'crop_name' => 'Chanh dây',
                'pathogen_type' => 'nam',
                'caunho' => 'Colletotrichum → THÁN THƯ → đốm nâu lõm trên lá/cành/quả (khô đầu cành).',
                'symptoms' => "Lá: Xuất hiện các đốm nâu tròn hoặc bất định, vết bệnh lan rộng làm khô rách phiến lá.\nCành: Vết bệnh màu nâu đen hơi lõm, có thể chạy dọc cành làm khô chết ngọn và chết cành.\nQuả: Đốm nâu sẫm hơi lõm xuống, trên vết bệnh có thể xuất hiện các chấm đen nhỏ li ti (ổ bào tử) xếp theo vòng tròn, quả rụng non.",
                'symptoms_detail' => [
                    'la' => 'Đốm bệnh tròn màu nâu viền đậm, giữa vết bệnh có màu xám tro, rách thủng lỗ chỗ.',
                    'canh_than' => 'Vết loét nâu đen chạy dọc thân cành non, làm khô ngọn và teo thắt cành quả.',
                    'goc_re' => 'Không gây hại trực tiếp ở gốc rễ.',
                    'qua' => 'Vết bệnh tròn lõm sâu màu nâu cánh gián, ẩm ướt tiết dịch bào tử hồng nhạt, quả biến dạng.',
                ],
                'prevention' => "• Thường xuyên tỉa cành tạo độ thông thoáng tối đa cho giàn chanh dây.\n• Giảm ẩm độ trong tán cây sau mỗi cơn mưa.\n• Thu gom quả rụng và tàn dư cành lá bệnh đem ra khỏi vườn tiêu hủy.\n• Bón phân cân đối N-P-K, hạn chế bón thừa đạm khi thời tiết mưa ẩm kéo dài.",
                'treatment' => "Phun thuốc bảo vệ hoặc lưu dẫn nội hấp khi phát hiện vết thán thư chớm xuất hiện trên lá hoặc cành non.\nĐảm bảo luân phiên hoạt chất để tránh hiện tượng nấm kháng thuốc.",
                'chemical_groups' => 'Mancozeb, Azoxystrobin, Difenoconazole, Tebuconazole, Propiconazole (FRAC M03, FRAC 11, FRAC 3).',
                'notes' => 'Bào tử nấm lây lan mạnh nhờ giọt nước mưa bắn và gió.',
                'pesticide_keywords' => ['Mancozeb', 'Asmiltatop', 'Tebaz', 'Anvil'],
            ],
            [
                'name' => 'Bệnh Đốm Xám — Septoria',
                'crop_name' => 'Chanh dây',
                'pathogen_type' => 'nam',
                'caunho' => 'Septoria → ĐỐM XÁM (vết đốm xám tro trên phiến lá, rụng lá nhanh).',
                'symptoms' => "Lá xuất hiện các đốm nhỏ màu nâu viền đậm, tâm vết bệnh chuyển màu xám tro nhạt.\nVết bệnh lan rộng nhanh chóng làm lá bị cháy từng mảng lớn.\nTrường hợp nặng: Lá vàng và rụng hàng loạt làm trơ trụi cành, quả bị rám nắng.\nBệnh cũng có thể lây lan sang cành và vỏ quả non.",
                'symptoms_detail' => [
                    'la' => 'Đốm tròn nhỏ 2-5mm, tâm xám trắng có chấm đen nhỏ, viền nâu sẫm, rụng lá trơ cành.',
                    'canh_than' => 'Vết sọc xám nâu nhỏ trên thân cành non, làm cành kém phát triển.',
                    'goc_re' => 'Không gây hại vùng gốc rễ.',
                    'qua' => 'Vỏ quả có các chấm đốm xám nâu nhỏ li ti, làm xấu mã vỏ quả thương phẩm.',
                ],
                'prevention' => "• Tỉa giàn giữ độ thông thoáng, gom lá rụng tiêu hủy.\n• Giảm ẩm độ trong giàn bằng cách bố trí mật độ trồng và giàn chữ T hoặc giàn nghiêng hợp lý.\n• Kiểm tra theo dõi sát sao sau các đợt mưa kéo dài nhiều ngày.",
                'treatment' => "Phun thuốc trừ nấm phổ rộng kết hợp hoạt chất thẩm thấu nội hấp theo đúng khuyến cáo kỹ thuật.",
                'chemical_groups' => 'Mancozeb, Difenoconazole, Azoxystrobin, Chlorothalonil (FRAC M03, FRAC 3, FRAC 11, FRAC M05).',
                'notes' => 'Gây hại nặng nhất trên lá già và lá bánh tẻ ở tầng tán rậm rạp.',
                'pesticide_keywords' => ['Mancozeb', 'Asmiltatop', 'Alien'],
            ],
            [
                'name' => 'Bệnh Phấn Trắng',
                'crop_name' => 'Chanh dây',
                'pathogen_type' => 'nam',
                'caunho' => 'Oidium → PHẤN TRẮNG (Lá non, chồi phủ lớp bột trắng mịn, biến dạng chồi).',
                'symptoms' => "Dấu hiệu nhận biết đặc trưng nhất: TRÊN LÁ NON VÀ CHỒI CÓ LỚP BỘT TRẮNG MỊN NHƯ PHẤN.\nLá bị biến dạng, mép lá cong queo, chồi non rụt lại không vươn dài được.\nLá bị phủ phấn giảm khả năng quang hợp, chuyển vàng rồi khô cháy sớm.",
                'symptoms_detail' => [
                    'la' => 'Mặt trên và mặt dưới lá non phủ lớp bột trắng mịn như phấn rôm, lá xoăn vặn vẹo.',
                    'canh_than' => 'Đọt non và tua cuốn bị phủ phấn trắng, ngọn chùn đọt không phát triển được.',
                    'goc_re' => 'Không gây hại ở gốc rễ.',
                    'qua' => 'Hoa và quả non bị phủ bột trắng dễ bị rụng sớm hoặc quả phát triển sần sùi.',
                ],
                'prevention' => "• Không để giàn quá rậm rạp, bấm ngọn tỉa cành định kỳ tạo thông thoáng ánh sáng.\n• Bón phân cân đối, tăng cường Kali và Canxi-Bo để tăng độ dày vách tế bào lá non.\n• Thường xuyên kiểm tra các đọt non và chồi nách vào buổi sáng sớm.",
                'treatment' => "Phun thuốc trừ nấm nhóm DMI/Triazole hoặc các dòng chuyên trị phấn trắng khi thấy lớp bột phấn trắng chớm xuất hiện.",
                'chemical_groups' => 'Hexaconazole, Tebuconazole, Difenoconazole, Dinocap, Sulfur (Lưu huỳnh vi sinh) (FRAC 3, FRAC 29, FRAC M02).',
                'notes' => 'Phát triển mạnh trong điều kiện thời tiết se lạnh, ẩm độ cao xen kẽ nắng ấm.',
                'pesticide_keywords' => ['Anvil', 'Tebaz', 'Japa Vil'],
            ],
            [
                'name' => 'Bệnh Virus — Cứng Trái / Khảm / Xoăn Lá',
                'crop_name' => 'Chanh dây',
                'pathogen_type' => 'virus',
                'caunho' => 'Virus → KHẢM + XOĂN + CỨNG/MÉO TRÁI (Không có thuốc nấm nào chữa được virus, phòng bọ trĩ/rệp truyền bệnh).',
                'symptoms' => "Lá: Khảm đốm vàng loang lổ, phiến lá phồng rộp gồ ghề, xoăn tít biến dạng, mép lá quăn queo.\nQuả: Quả bị méo mó dị dạng, vỏ sần sùi nổi u cục, quả nhỏ còi cọc và đặc biệt vỏ quả hóa gỗ CỨNG BẤT THƯỜNG (bệnh Woodiness).\n❌ Cực kỳ quan trọng: Virus KHÔNG PHẢI NẤM, không có thuốc bảo vệ thực vật hóa học nào chữa khỏi cây đã nhiễm virus.",
                'symptoms_detail' => [
                    'la' => 'Lá khảm đốm vàng xanh loang lổ, phiến lá phồng rộp biến dạng nặng, gân lá nổi rõ.',
                    'canh_than' => 'Đọt non rụt ngắn, lóng thân co ngắn lại, cành khẳng khiu còi cọc.',
                    'goc_re' => 'Hệ rễ suy yếu gián tiếp do cây mất khả năng quang hợp.',
                    'qua' => 'Quả méo mó dị dạng, vỏ dày nổi u cục hóa gỗ cứng ngắc, ruột ít dịch và chua chát.',
                ],
                'prevention' => "Quy trình cốt lõi:\nCÂY GIỐNG SẠCH VIRUS ↓ QUẢN LÝ CÔN TRÙNG CHÍCH HÚT (Bọ trĩ, Rệp muội, Bọ phấn) ↓ PHÁT HIỆN SỚM CÂY BỆNH ↓ NHỔ BỎ TIÊU HỦY NGAY ↓ TUYỆT ĐỐI KHÔNG LẤY CÂY BỆNH LÀM GIỐNG.\n• Khử trùng kéo tỉa bằng cồn 70 độ khi cắt tỉa từ cây này sang cây khác.\n• Trồng xen bẫy dính màu vàng/xanh trong vườn để theo dõi côn trùng môi giới.",
                'treatment' => "Không có thuốc chữa khỏi cây đã nhiễm virus. Cây bị bệnh nặng phải nhổ bỏ, tiêu hủy xa vườn.\nVới các cây xung quanh: Phun trừ triệt để bọ trĩ, rệp muội, bọ phấn trắng bằng các thuốc trừ sâu chích hút + phun tăng cường vi lượng và kích kháng để tăng sức đề kháng.",
                'chemical_groups' => 'Thuốc trừ sâu chích hút: Imidacloprid, Thiamethoxam, Acetamiprid, Dinotefuran (IRAC 4A), kết hợp Chitosan/Chất kích kháng sinh học.',
                'notes' => 'Rệp muội (Aphids) và bọ trĩ là vector truyền bệnh virus nguy hiểm nhất.',
                'pesticide_keywords' => ['Alien An Nông', 'Asmiltatop'],
            ],
            [
                'name' => 'Tuyến Trùng Hại Rễ',
                'crop_name' => 'Chanh dây',
                'pathogen_type' => 'tuyen_trung',
                'caunho' => 'Tuyến trùng → RỄ CÒI + NỐT SẦN + VÀNG LÁ (Cửa ngõ cho nấm Phytophthora & Fusarium xâm nhập).',
                'symptoms' => "Cây còi cọc chậm lớn dù vẫn tưới nước bón phân đầy đủ.\nLá vàng nhạt từ đọt non xuống, lá nhỏ, cây thiếu sức sống.\nRễ bị tổn thương nghiêm trọng: Xuất hiện nhiều nốt sần u cục (bướu rễ), rễ chùm bị thối cụt đầu rễ.\nTuyến trùng đục phá tạo vết thương hở mở đường cho nấm Phytophthora và Fusarium tấn công thứ cấp gây thối rễ chết nhanh.",
                'symptoms_detail' => [
                    'la' => 'Lá vàng nhạt đọt non, phiến lá mỏng, mép lá cụp xuống, cây sinh trưởng ủ rũ.',
                    'canh_than' => 'Cành khẳng khiu, đốt thân ngắn, cây không chịu đâm tược non mới.',
                    'goc_re' => 'Hệ rễ tơ xuất hiện các chuỗi nốt sần u bướu phồng tròn, chóp rễ đen cụt.',
                    'qua' => 'Hoa rụng nhiều, tỷ lệ đậu quả kém, quả non chậm lớn và dễ rụng.',
                ],
                'prevention' => "• Tuyệt đối chọn cây giống có bầu đất sạch tuyến trùng.\n• Xử lý đất trước khi trồng bằng vôi bột hoặc chế phẩm sinh học đối kháng Paecilomyces lilacinus.\n• Luân canh hoặc trồng xen cúc vạn thọ quanh bờ liếp để xua đuổi tuyến trùng.\n• Tăng cường bón phân chuồng ủ hoai mục và Axit Humic để tái tạo phục hồi bộ rễ tơ.",
                'treatment' => "Tưới thuốc đặc trị tuyến trùng vào vùng đất quanh gốc theo hình chiếu tán lá.\nXử lý 2 lần cách nhau 15 - 20 ngày trong mùa mưa.\nKết hợp tưới thuốc phục hồi rễ sau khi đã tiêu diệt tuyến trùng 5-7 ngày.",
                'chemical_groups' => 'Abamectin, Fluopyram, Chế phẩm sinh học Paecilomyces / Nấm bẫy tuyến trùng (IRAC 6, FRAC 7, Sinh học BM02).',
                'notes' => 'Tuyến trùng phát triển rất nhanh trên nền đất cát pha, nghèo hữu cơ và chua (pH < 5.0).',
                'pesticide_keywords' => ['Alien', 'Ridomil', 'Anvil'],
            ],
            [
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
                'notes' => "Cây có thể bị bệnh: Chanh dây (chanh leo).\n⚠️ Lưu ý chẩn đoán phân biệt: Trung tâm Khuyến nông Quốc gia mô tả bệnh đốm nâu do Alternaria và bệnh thối thân, thối quả do Phytophthora nicotianae là các bệnh riêng trên chanh dây. Đốm dầu dạng ướt cũng có thể bị nhầm với thán thư. Không chốt tác nhân chỉ theo tên bệnh dân gian.\nTham khảo: [Naseeds – Bệnh bã trầu trên chanh dây](https://naseeds.com/ky-thuat-canh-tac/benh-ba-trau-tren-chanh-day/) | [Trung tâm Khuyến nông Quốc gia – Bệnh hại chanh leo](https://khuyennongvn.gov.vn/khoa-hoc-cong-nghe/khcn-trong-nuoc/trieu-chung-dac-diem-phat-sinh-gay-hai-cua-mot-so-sau-benh-chinh-tren-cay-chanh-leo--phan-1-21008.html?utm_source=chatgpt.com)",
                'pesticide_keywords' => ['Agri-Fos', 'Delta Fos', 'Alien', 'Dimethor', 'Mancozeb', 'Ridomil'],
            ],
        ];

        foreach ($diseasesData as $data) {
            $keywords = $data['pesticide_keywords'] ?? [];
            unset($data['pesticide_keywords']);

            $disease = Disease::updateOrCreate(
                ['name' => $data['name']],
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
