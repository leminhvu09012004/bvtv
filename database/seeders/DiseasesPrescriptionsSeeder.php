<?php

namespace Database\Seeders;

use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class DiseasesPrescriptionsSeeder extends Seeder
{
    /**
     * Seed major plant diseases and their treatment prescriptions.
     */
    public function run(): void
    {
        $diseasesData = [
            // 1. Ghẻ loét sẹo
            [
                'name'        => 'Ghẻ loét sẹo',
                'image'       => 'diseases/ghe_loet_seo.jpg',
                'images'      => ['diseases/ghe_loet_seo.jpg'],
                'notes'       => 'Tổ hợp bệnh hại nghiêm trọng trên nhóm cây có múi (cam, chanh, bưởi, quýt), xoài, ổi... gồm: Ghẻ sẹo/ghẻ nhám do nấm Elsinoë fawcettii và Loét do vi khuẩn Xanthomonas citri. Làm giảm nghiêm trọng mẫu mã quả thương phẩm và làm suy kiệt cành lá non.',
                'symptoms'    => "- Bệnh Ghẻ sẹo (Scab do nấm): Vết bệnh là những nốt sần sùi, gồ ghề nhô cao như mụn cóc màu nâu nhạt hoặc vàng xám ở mặt dưới lá non, cuống lá và cành non. Mặt trên lá thường lõm vào. Trên quả non, vết sẹo sần sùi màu nâu nhám làm méo mó trái, da cám, vỏ sần mất giá trị.\n- Bệnh Loét vi khuẩn (Canker do vi khuẩn Xanthomonas): Vết loét hình tròn, ở giữa lõm xuống có màu nâu đậm xốp như bọt biển, xung quanh luôn có quầng vàng sáng (halo) rất rõ nét; vết bệnh xuyên qua cả 2 mặt của phiến lá. Trên quả, vết loét nứt nẻ thành hình mắt cua, dễ làm quả bị rụng non hoặc thối nứt khi gặp mưa.",
                'prevention'  => "- Cắt tỉa cành thông thoáng sau thu hoạch, dọn sạch cành lá và quả rụng bị bệnh đem chôn hoặc đốt.\n- Phòng trừ triệt để sâu vẽ bùa và rầy chổng cánh ở các đợt cơi đọt non, vì vết thương do sâu chích phá là cửa ngõ trực tiếp cho vi khuẩn và nấm xâm nhiễm.\n- Tránh làm trầy xước vỏ cây và cành non trong quá trình chăm sóc.\n- Phun phòng ngừa khi cây vừa nhú cơi đọt non mới (lá dài 1 - 2cm) và khi quả non vừa rụng hết cánh hoa.",
                'treatment'   => "- Phải phối hợp thuốc trừ nấm (Propineb, Mancozeb, Gốc Đồng) với thuốc kháng sinh trừ vi khuẩn (Kasugamycin, Ningnanmycin).\n- Sử dụng các hợp chất Gốc Đồng (Đồng Đỏ, Đồng Oxychloride) vừa diệt nấm vừa có tính sát trùng vết loét vi khuẩn cực tốt.\n- Phun đều ướt cả 2 mặt lá và bao phủ toàn bộ bề mặt quả non.\n- Phun nhắc lại lần 2 sau 5 - 7 ngày cho đến khi lá đọt non chuyển sang màu xanh đậm (bánh tẻ).",
                'treatment_plans' => [
                    [
                        'title'        => 'Phác đồ 1: Cặp đôi Mát Lá - Mát Hoa & Ngừa Sẹo Đọt Non',
                        'badge'        => 'Cặp đôi phối hợp (2 trong 1)',
                        'badge_color'  => 'emerald',
                        'stage'        => 'Giai đoạn nhú cơi đọt non (1 - 2cm), dưỡng hoa nở rộ & quả non vừa đậu',
                        'dosage_guide' => 'Pha 1 gói Antracol 70WP (1kg) + 1 chai KASUGACIN 3SL (450ml) cho 400 - 500 lít nước (tương đương 2 phuy 200L). Phun sương ướt đều 2 mặt lá và chùm quả non.',
                        'safety_note'  => 'Cặp đôi này cực kỳ an toàn, mát hoa mát quả, vừa chặn đứng vi khuẩn loét vừa tạo áo giáp Kẽm (Zinc++) bảo vệ lá non chống nấm ghẻ sẹo. KHÔNG BAO GIỜ KẾT TỦA.',
                        'groups'       => [
                            [
                                'label'                => 'Thuốc trừ nấm & Tạo áo giáp Kẽm bảo vệ',
                                'primary_pesticide_id' => 7, // Antracol 70WP Bayer
                                'substitute_ids'       => [],
                            ],
                            [
                                'operator'             => '➕',
                                'label'                => 'Kháng sinh đặc trị vi khuẩn gây loét',
                                'primary_pesticide_id' => 23, // KASUGACIN 3SL VI KHUAN
                                'substitute_label'     => 'Hoặc có thể chọn thay thế bằng kháng sinh tương đương:',
                                'substitute_ids'       => [11], // BACOLINH 450ML
                            ],
                        ],
                    ],
                    [
                        'title'        => 'Phác đồ 2: Sát trùng vết loét cành & Rửa vườn sau thu hoạch',
                        'badge'        => 'Phun đơn / Quét đặc',
                        'badge_color'  => 'blue',
                        'stage'        => 'Giai đoạn sau khi thu hoạch vụ mùa, cắt tỉa cành vô hiệu, hoặc cạo rửa ổ loét trên thân cành già',
                        'dosage_guide' => 'Phun rửa vườn: Pha 1 gói EDDY 72WP (300g) hoặc COC 85 (1kg) cho 400 - 500 lít nước phun ướt đẫm thân cành. Quét vết loét: Pha đậm đặc 50g thuốc với 1 lít nước quét trực tiếp vào vết loét đã cạo sạch.',
                        'safety_note'  => '⚠️ Phun đơn độc lập. Tuyệt đối KHÔNG trộn chung thuốc Gốc Đồng (EDDY, COC 85) với Antracol 70WP trong cùng một bình phun (nguy cơ kết tủa bùn vón cục, nghẹt béc xịt và cháy lá non). Đợt phun này phải cách đợt phun Antracol ít nhất 5 - 7 ngày.',
                        'groups'       => [
                            [
                                'label'                => 'Thuốc Gốc Đồng sát khuẩn & Sát trùng vết loét mạnh (Chọn 1 trong 2)',
                                'primary_pesticide_id' => 18, // EDDY 72WP HOPTRI
                                'substitute_label'     => 'Hoặc thay thế bằng thuốc Gốc Đồng tương đương:',
                                'substitute_ids'       => [12], // COC 85 NGAN ANH 1KG
                            ],
                        ],
                    ],
                ],
                'pesticides'  => [7, 23, 11, 18, 12],
            ],

            // 2. Thán thư
            [
                'name'        => 'Thán thư',
                'image'       => 'diseases/than_thu.jpg',
                'images'      => ['diseases/than_thu.jpg'],
                'notes'       => 'Bệnh thán thư do nấm Colletotrichum spp. gây hại phổ biến trên hầu hết các loại cây ăn trái (sầu riêng, xoài, bơ, thanh long, cam quýt) và rau màu (ớt, dưa hấu, hành tỏi). Phát triển cực mạnh trong điều kiện nóng ẩm, mưa nhiều hoặc sương mù kéo dài.',
                'symptoms'    => "- Trên lá non & già: Xuất hiện các chấm nhỏ màu nâu sẫm, sau đó lan rộng thành đốm tròn hoặc bầu dục có các vòng đồng tâm màu nâu đen hơi lõm xuống, xung quanh có quầng vàng sáng.\n- Lá bị cháy từng mảng lớn, khô giòn từ chóp lá và mép lá lan vào trong gân chính, lá quăn queo và rụng sớm làm trơ cành.\n- Trên đọt non & cành non: Đọt non bị thối đen, khô héo chết ngọn (hiện tượng khô đọt). Cành non có các vết loét dài màu nâu đen, nứt vỏ.\n- Trên hoa: Chùm hoa bị thâm đen, úa tàn và thối rụng hàng loạt, làm giảm nghiêm trọng tỉ lệ đậu trái.\n- Trên trái non & trái già: Xuất hiện các đốm tròn trũng lõm màu nâu xám đến đen. Trong điều kiện ẩm ướt, trên vết bệnh hình thành các ổ nấm màu hồng cam li ti (khối bào tử), vỏ trái nứt nẻ, thối nhũn và rụng non.",
                'prevention'  => "- Tỉa cành tạo tán thông thoáng, dọn sạch cỏ rác và cắt bỏ toàn bộ cành lá, hoa quả bị nhiễm bệnh gom ra xa vườn tiêu hủy hoặc ủ nấm vi sinh Trichoderma.\n- Bón phân cân đối N-P-K, tuyệt đối không bón thừa đạm vô cơ trong mùa mưa; bổ sung Canxi - Bo và Silic giúp vách tế bào cứng cáp, tăng tính chống chịu.\n- Tránh tưới phun sương trực tiếp lên tán lá vào buổi chiều tối hoặc đêm muộn.\n- Phun phòng ngừa chủ động vào các giai đoạn mẫn cảm: khi cây vừa nhú cơi đọt non, chuẩn bị nhú mắt cua trổ hoa và sau các đợt mưa dầm kéo dài.",
                'treatment'   => "- Khi bệnh chớm xuất hiện, phun ngay hỗn hợp hoạt chất lưu dẫn 2 chiều kết hợp tiếp xúc bảo vệ để chặn đứng lây lan.\n- Phun luân phiên các hoạt chất diệt nấm đặc trị: Azoxystrobin + Difenoconazole, Hexaconazole, Mancozeb, Propineb, Pyraclostrobin.\n- Phun ướt đều và đẫm cả 2 mặt lá, các nách chồi, chùm hoa và chùm quả.\n- Phun nhắc lại lần 2 sau 5 - 7 ngày nếu thời tiết mưa ẩm kéo dài.\n- Tạm ngưng sử dụng phân bón lá có hàm lượng đạm cao và chất kích thích sinh trưởng khi cây đang phát bệnh.",
                'treatment_plans' => [
                    [
                        'title'        => 'Phác đồ 1: Combo Dập dịch Thán thư Cấp tốc (Lưu dẫn nội hấp + Tiếp xúc bảo vệ)',
                        'badge'        => 'Combo dập dịch cực mạnh',
                        'badge_color'  => 'emerald',
                        'stage'        => 'Khi vườn chớm phát hiện đốm thán thư đồng tâm trên lá non, chùm hoa hoặc quả non',
                        'dosage_guide' => 'Pha 1 chai ASMILTATOP SUPER 400SC (250ml) + 1 gói MANCOZEB 80WP (1kg) cho 400 - 500 lít nước (2 phuy). Phun ướt đẫm 2 mặt lá và chùm quả non.',
                        'safety_note'  => 'Cơ chế 2 tác động hiệp đồng: Azoxystrobin + Difenoconazole lưu dẫn thấm sâu tiêu diệt sợi nấm bên trong mô lá, Mancozeb bọc lớp màng bảo vệ bên ngoài ngăn bào tử nảy mầm.',
                        'groups'       => [
                            [
                                'label'                => 'Thuốc lưu dẫn nội hấp 2 chiều dập nấm bên trong',
                                'primary_pesticide_id' => 10, // ASMILTATOP SUPER 400SC
                                'substitute_label'     => 'Hoặc thay thế bằng thuốc nội hấp tương đương:',
                                'substitute_ids'       => [37, 21], // TILT SUPER, HEADLINE 250EC
                            ],
                            [
                                'operator'             => '➕',
                                'label'                => 'Thuốc tiếp xúc phổ rộng tạo màng bảo vệ bên ngoài',
                                'primary_pesticide_id' => 26, // MANCOZEB 80WP 1KG
                                'substitute_label'     => 'Hoặc thay thế bằng thuốc tiếp xúc có bổ sung Kẽm:',
                                'substitute_ids'       => [7], // Antracol 70WP Bayer
                            ],
                        ],
                    ],
                    [
                        'title'        => 'Phác đồ 2: Luân phiên chặn nấm & Chống nhờn thuốc (Dòng Triazole lưu dẫn)',
                        'badge'        => 'Phun luân phiên chống kháng',
                        'badge_color'  => 'blue',
                        'stage'        => 'Phun nhắc lại sau đợt 1 từ 5 - 7 ngày để dứt điểm mầm bệnh và chống kháng thuốc',
                        'dosage_guide' => 'Pha 1 chai ANVIL 5SC (1 lít) + 1 gói Antracol 70WP (1kg) cho 400 - 500 lít nước. Phun ướt đều tán lá.',
                        'safety_note'  => 'Hexaconazole trong Anvil có khả năng cô lập vết thán thư nhanh chóng, kết hợp Áo giáp Kẽm Antracol giúp lá xanh dày, cứng cáp, vết bệnh khô giòn ngay lập tức.',
                        'groups'       => [
                            [
                                'label'                => 'Thuốc nội hấp chuyên sâu dòng Triazole',
                                'primary_pesticide_id' => 9, // ANVIL SYNGENTA 5SC 1LIT
                                'substitute_ids'       => [],
                            ],
                            [
                                'operator'             => '➕',
                                'label'                => 'Áo giáp Kẽm Antracol giúp phục hồi xanh lá',
                                'primary_pesticide_id' => 7, // Antracol 70WP Bayer
                                'substitute_ids'       => [],
                            ],
                        ],
                    ],
                ],
                'pesticides'  => [10, 26, 7, 9, 21, 37],
            ],

            // 3. Rỉ sắt
            [
                'name'        => 'Rỉ sắt',
                'image'       => 'diseases/ri_sat.jpg',
                'images'      => ['diseases/ri_sat.jpg'],
                'notes'       => 'Bệnh rỉ sắt do nấm Hemileia vastatrix hoặc Puccinia spp. gây ra, là dịch bệnh nguy hiểm hàng đầu trên cây cà phê, mai vàng, hoa hồng, ngô, đậu đỗ và một số cây ăn trái. Nấm phát tán bào tử rất nhanh qua gió và giọt nước mưa.',
                'symptoms'    => "- Ở mặt dưới lá: Ban đầu xuất hiện các đốm nhỏ hình tròn màu vàng nhạt hoặc vàng chanh.\n- Sau đó, vết bệnh mở rộng và bề mặt nổi lên các ổ nấm phấn màu vàng cam đến nâu đỏ sẫm như màu bột rỉ sét kim loại.\n- Khi lấy tay quẹt nhẹ vào mặt dưới lá sẽ thấy dính lớp bột phấn màu vàng cam mịn (chính là hàng triệu bào tử nấm).\n- Ở mặt trên lá: Tương ứng với vị trí ổ nấm ở mặt dưới lá là những vết loang màu vàng úa, dần chuyển sang màu nâu khô và cháy mảng.\n- Bệnh nặng làm toàn bộ phiến lá vàng úa, rụng trơ cành hàng loạt, cây kiệt sức, giảm năng suất hạt và hoa rõ rệt.",
                'prevention'  => "- Trồng cây với mật độ hợp lý, thường xuyên tỉa cành tạo tán thông thoáng cho ánh sáng xuyên đều vào tán cây.\n- Cắt tỉa cành vô hiệu sau thu hoạch, dọn sạch lá rụng nhiễm bệnh dưới gốc gom lại tiêu hủy.\n- Bón tăng cường phân hữu cơ hoai mục, phân Kali và vi lượng Kẽm, Bo để cây khỏe, thành vách lá dày bóng.\n- Định kỳ phun thuốc phòng ngừa vào đầu mùa mưa ẩm hoặc các tháng sương mù nhiều trong năm.",
                'treatment'   => "- Khi thấy vết rỉ sắt chớm xuất hiện ở mặt dưới lá, phun ngay thuốc đặc trị thuộc nhóm Triazole (Hexaconazole, Difenoconazole, Propiconazole) hoặc gốc Đồng.\n- Cần chỉnh béc phun mịn và hướng vòi xịt từ dưới lên trên để thuốc tiếp xúc trực tiếp với mặt dưới của phiến lá (nơi ổ nấm sinh sản).\n- Phun luân phiên hoạt chất để tránh hiện tượng nấm nhờn thuốc.\n- Phun nhắc lại lần 2 sau 7 - 10 ngày để dập tắt hoàn toàn lứa bào tử mới nở.",
                'treatment_plans' => [
                    [
                        'title'        => 'Phác đồ 1: Đặc trị ổ nấm rỉ sắt mặt dưới lá (Khắc tinh rỉ sắt Triazole)',
                        'badge'        => 'Cặp đôi đặc trị chuyên sâu',
                        'badge_color'  => 'emerald',
                        'stage'        => 'Khi phát hiện các đốm phấn vàng cam rỉ sắt chớm xuất hiện ở mặt dưới lá',
                        'dosage_guide' => 'Pha 1 lít ANVIL 5SC (hoặc 500ml Japa Vil 110SC) + 250ml ASMILTATOP SUPER cho 400 - 500 lít nước. Chỉnh vòi phun mịn hướng từ dưới lên để thuốc bám đẫm mặt dưới lá.',
                        'safety_note'  => 'Hexaconazole + Difenoconazole thấm sâu cực nhanh vào mặt dưới phiến lá, làm teo khô các ổ bào tử nấm rỉ sắt chỉ sau 48 giờ.',
                        'groups'       => [
                            [
                                'label'                => 'Khắc tinh nấm rỉ sắt (Hexaconazole)',
                                'primary_pesticide_id' => 9, // ANVIL SYNGENTA 5SC 1LIT
                                'substitute_label'     => 'Hoặc thay thế bằng Hexaconazole đậm đặc:',
                                'substitute_ids'       => [22], // Japa Vil 110SC Monyka
                            ],
                            [
                                'operator'             => '➕',
                                'label'                => 'Thuốc lưu dẫn đa điểm dập tắt bào tử nảy mầm',
                                'primary_pesticide_id' => 10, // ASMILTATOP SUPER 400SC
                                'substitute_label'     => 'Hoặc thay thế bằng:',
                                'substitute_ids'       => [37], // TILT SUPER SYNGENTA 100
                            ],
                        ],
                    ],
                    [
                        'title'        => 'Phác đồ 2: Rửa sạch ổ bào tử rỉ sắt & Diệt mầm bệnh tồn dư trong vườn',
                        'badge'        => 'Phun đơn tẩy nấm',
                        'badge_color'  => 'blue',
                        'stage'        => 'Đầu mùa mưa hoặc sau đợt dập dịch, giúp tẩy sạch mầm nấm ngủ đông',
                        'dosage_guide' => 'Pha 1kg G.O.C 85 Japan cho 400 - 500 lít nước, phun đều toàn bộ tán cây và mặt đất dưới gốc cây.',
                        'safety_note'  => 'G.O.C 85 có phụ gia bám dính đặc biệt giúp gốc Đồng Oxychloride bám chắc, diệt sạch bào tử rỉ sắt vương vãi trên cành lá già.',
                        'groups'       => [
                            [
                                'label'                => 'Thuốc Gốc Đồng tẩy nấm rỉ sắt & Diệt khuẩn phổ rộng',
                                'primary_pesticide_id' => 20, // G.O.C 85 Japan
                                'substitute_ids'       => [],
                            ],
                        ],
                    ],
                ],
                'pesticides'  => [9, 20, 37, 10, 22],
            ],

            // 4. Nấm hồng
            [
                'name'        => 'Nấm hồng',
                'image'       => 'diseases/nam_hong.jpg',
                'images'      => ['diseases/nam_hong.jpg'],
                'notes'       => 'Bệnh nấm hồng do nấm Erythricium salmonicolor (Corticium salmonicolor) gây hại nghiêm trọng trên sầu riêng, cao su, cà phê, bưởi, cam quýt, xoài, mít, hồ tiêu... Thường bùng phát trong mùa mưa bão tại các vườn cây rậm rạp, ẩm thấp.',
                'symptoms'    => "- Giai đoạn đầu: Xuất hiện các sợi nấm mỏng màu trắng bạc như tơ nhện mọc bò lan trên bề mặt vỏ ở các chạc 3, chẽ cành hoặc phần thân cành khuất nắng.\n- Giai đoạn phát triển: Lớp tơ nấm chuyển dần sang màu hồng phấn hoặc màu cam nhạt đặc trưng, đóng thành mảng dày bao quanh chu vi cành cây.\n- Nấm ăn sâu phá hủy lớp biểu bì và mô mạch dẫn của vỏ cành, làm vỏ cây bị thối nứt, chảy mủ nâu hoặc khô mục nát.\n- Lá ở đoạn cành phía trên vết bệnh bị héo rũ, chuyển sang màu vàng khô rồi rụng dần, cành bị khô chết ngược từ ngọn vào trong (hiện tượng khô cành), cành giòn dễ gãy.",
                'prevention'  => "- Hàng năm sau thu hoạch, tiến hành cắt tỉa toàn bộ cành tăm, cành sâu bệnh, cành mọc đan chéo trong tán để vườn luôn thông thoáng, nhiều ánh sáng.\n- Tránh trồng quá dày và không để cỏ dại mọc che kín gốc cành trong mùa mưa.\n- Quét vôi hoặc dung dịch thuốc gốc Đồng (Đồng đỏ Nordox, Đồng Oxychloride) vào các chẽ cành và thân chính từ 1 - 2 lần trước khi mùa mưa bắt đầu.\n- Bón phân cân đối, hạn chế bón phân đạm quá mức trong giai đoạn mưa dầm ẩm ướt.",
                'treatment'   => "- Cắt bỏ các cành đã bị nấm ăn chết khô và mang ra ngoài vườn đốt tiêu hủy để tránh lây lan bào tử.\n- Với cành còn giữ được: Dùng bàn chải mềm cạo sơ lớp nấm hồng bên ngoài, sau đó dùng cọ quét thuốc đậm đặc (gốc Đồng hoặc Validamycin, Hexaconazole) trực tiếp lên vết bệnh.\n- Đồng thời phun ướt đẫm tán cây, thân cành và các chẽ cành bằng các loại thuốc lưu dẫn kết hợp sát khuẩn gốc đồng.\n- Phun nhắc lại sau 5 - 7 ngày cho đến khi vết nấm khô giòn và tự bong tróc.",
                'treatment_plans' => [
                    [
                        'title'        => 'Phác đồ 1: Cặp đôi quét trực tiếp cành nhiễm nấm & Phun dập dịch',
                        'badge'        => 'Cặp đôi đặc trị nấm sợi',
                        'badge_color'  => 'emerald',
                        'stage'        => 'Khi phát hiện tơ nấm màu hồng hoặc trắng bạc bám quanh các chạc ba, chẽ cành',
                        'dosage_guide' => 'Quét cành: Pha 100ml VALIDACIN + 100ml ANVIL 5SC vào 1 lít nước quét thẳng vào vết nấm hồng. Phun tán: Pha 1 chai Validacin + 1 chai Anvil cho 400 - 500 lít nước phun ướt đẫm thân cành.',
                        'safety_note'  => 'Validamycin A là kháng sinh sinh học đặc trị nấm sợi, kết hợp Hexaconazole lưu dẫn sâu giúp diệt sợi nấm đã ăn sâu vào lớp mạch dẫn của vỏ cành.',
                        'groups'       => [
                            [
                                'label'                => 'Kháng sinh sinh học đặc trị nấm sợi nấm hồng',
                                'primary_pesticide_id' => 40, // VALIDACIN SUMITOMO VI
                                'substitute_ids'       => [],
                            ],
                            [
                                'operator'             => '➕',
                                'label'                => 'Thuốc thấm sâu diệt chân nấm trong mạch gỗ',
                                'primary_pesticide_id' => 9, // ANVIL SYNGENTA 5SC 1LIT
                                'substitute_ids'       => [],
                            ],
                        ],
                    ],
                    [
                        'title'        => 'Phác đồ 2: Sát khuẩn vết nấm & Rửa sạch chẽ cành (Gốc Đồng đỏ tinh khiết)',
                        'badge'        => 'Phun đơn / Quét chạc cành',
                        'badge_color'  => 'blue',
                        'stage'        => 'Trước mùa mưa dầm hoặc sau khi tỉa cành để phòng ngừa nấm hồng tái phát',
                        'dosage_guide' => 'Pha 1 gói EDDY 72WP (300g) hoặc COC 85 (1kg) hoặc G.O.C 85 (1kg) cho 400 - 500 lít nước, phun kỹ vào thân chính và các chạc cành cấp 1, cấp 2.',
                        'safety_note'  => 'Đồng đỏ tinh khiết bám dính cực dai trên vỏ cây, kháng rửa trôi trong mùa mưa bão, ngăn tơ nấm phát triển.',
                        'groups'       => [
                            [
                                'label'                => 'Thuốc Gốc Đồng đỏ sát trùng chạc cành (Chọn 1 trong 3)',
                                'primary_pesticide_id' => 18, // EDDY 72WP HOPTRI
                                'substitute_label'     => 'Hoặc thay thế bằng thuốc Gốc Đồng Oxychloride tương đương:',
                                'substitute_ids'       => [20, 12], // G.O.C 85 Japan, COC 85 NGAN ANH
                            ],
                        ],
                    ],
                ],
                'pesticides'  => [20, 40, 9, 18, 12],
            ],

            // 5. Sương mai
            [
                'name'        => 'Sương mai',
                'image'       => 'diseases/suong_mai.jpg',
                'images'      => ['diseases/suong_mai.jpg'],
                'notes'       => 'Bệnh sương mai và giả sương mai do nấm Oomycetes (Pseudoperonospora cubensis, Plasmopara viticola, Phytophthora infestans...) gây hại tàn phá trên dưa leo, dưa lưới, bầu bí, cà chua, khoai tây, nho, ớt, vải, nhãn... Phát triển bùng phát cực nhanh khi đêm lạnh ẩm ướt, sáng có sương mù và ngày ấm áp.',
                'symptoms'    => "- Vết bệnh phát sinh đầu tiên ở các lá già dưới gốc rồi lan dần lên ngọn theo chiều cao cây.\n- Mặt trên lá: Xuất hiện các đốm màu vàng nhạt hoặc vàng xanh, hình dạng bất định nhưng bị giới hạn bởi các gân phụ của lá tạo thành các hình đa giác góc cạnh rất đặc trưng.\n- Mặt dưới lá: Tương ứng với vết vàng mặt trên là một lớp nấm mọc mịn như nhung màu trắng xám, xám xanh hoặc tím xám trông như một lớp sương muối phủ dày.\n- Về sau, các vết bệnh liên kết lại làm cháy khô từng mảng lá, mép lá cong queo, giòn rụm và rách nát; cả luống cây có thể bị cháy lá rụi tàn chỉ trong vòng 3 - 5 ngày nếu không xử lý kịp thời.",
                'prevention'  => "- Lên luống cao, có mương rãnh thoát nước nhanh, phủ bạt màng phủ nông nghiệp để ngăn nấm từ đất bắn lên tán lá.\n- Trồng mật độ vừa phải, làm giàn thông thoáng, thường xuyên ngắt bỏ bớt các lá già sát gốc.\n- Tưới nước gốc hoặc nhỏ giọt vào buổi sáng sớm, tuyệt đối không tưới phun mưa vào buổi chiều mát hoặc tối ẩm.\n- Chủ động phun phòng định kỳ vào những đợt trời âm u, sương mù dày đặc hoặc sau mưa rào.",
                'treatment'   => "- Sử dụng ngay các hoạt chất đặc trị nấm Oomycetes lưu dẫn thấm sâu cực mạnh: Dimethomorph, Oxathiapiprolin, Fluopicolide, Fosetyl-Aluminium, Metalaxyl.\n- Phối hợp hoạt chất tiếp xúc (như Mancozeb, Propineb) để tăng hiệu lực bám dính tiêu diệt bào tử nấm bên ngoài.\n- Phun thật ướt đẫm mặt dưới phiến lá (nơi bào tử nấm phóng thích và hình thành tơ nấm).\n- Phun nhắc lại lần 2 cách nhau 3 - 5 ngày để dập dịch dứt điểm.",
                'treatment_plans' => [
                    [
                        'title'        => 'Phác đồ 1: Combo Dập dịch Sương mai Thần tốc (Thế hệ mới lưu dẫn 2 chiều)',
                        'badge'        => 'Đặc trị Oomycetes đỉnh cao',
                        'badge_color'  => 'emerald',
                        'stage'        => 'Khi ruộng dưa, cà chua, giàn bầu bí chớm xuất hiện đốm vàng góc cạnh sương mai',
                        'dosage_guide' => 'Pha 1 chai ZORVEC ENCANTIA 330SE (100ml) + 1 chai Dimethor 500SC (hoặc 1 gói Phytocide 50WP) cho 400 - 500 lít nước. Phun tập trung vào mặt dưới của lá lúc sáng sớm ráo sương.',
                        'safety_note'  => 'Oxathiapiprolin (Zorvec) phá vỡ chu kỳ sinh sản của nấm Oomycetes ngay từ giai đoạn bào tử, kết hợp Dimethomorph lưu dẫn 2 chiều dập dịch nhanh trong 24 giờ.',
                        'groups'       => [
                            [
                                'label'                => 'Thuốc thế hệ mới kiểm soát sương mai cực nhanh',
                                'primary_pesticide_id' => 42, // ZORVEC ENCANTIA 330SE 1
                                'substitute_label'     => 'Hoặc thay thế bằng thuốc lưu dẫn 2 chiều Bayer:',
                                'substitute_ids'       => [30], // PROFILER 711,1WG BAYER 3
                            ],
                            [
                                'operator'             => '➕',
                                'label'                => 'Thuốc chuyên trị nấm Oomycetes kháng thuốc (Dimethomorph)',
                                'primary_pesticide_id' => 15, // Dimethor 500SC
                                'substitute_label'     => 'Hoặc thay thế bằng:',
                                'substitute_ids'       => [29], // Phytocide 50WP Hợp Trí
                            ],
                        ],
                    ],
                    [
                        'title'        => 'Phác đồ 2: Phác đồ luân phiên & Bảo vệ phổ rộng toàn luống',
                        'badge'        => 'Bảo vệ phổ rộng & Ngừa lây lan',
                        'badge_color'  => 'blue',
                        'stage'        => 'Phun luân phiên sau đợt 1 từ 3 - 5 ngày để khóa chặt vùng bệnh không cho lây sang luống khác',
                        'dosage_guide' => 'Pha 100g Ridomil Gold 68WG cho bình 25 lít nước (hoặc 1kg cho 300 - 400 lít nước) phun đều ướt đẫm tán lá.',
                        'safety_note'  => 'Metalaxyl M nội hấp cực nhanh kết hợp Mancozeb tạo lớp màng bọc chống mưa rửa trôi và ngăn chặn nấm lây lan qua giọt nước.',
                        'groups'       => [
                            [
                                'label'                => 'Thuốc đặc trị nấm nẩy mầm phổ rộng',
                                'primary_pesticide_id' => 32, // Ridomil Gold 68WG
                                'substitute_ids'       => [],
                            ],
                        ],
                    ],
                ],
                'pesticides'  => [29, 15, 42, 30, 32],
            ],

            // 6. Tẩy rong rêu nấm mốc trên thân cành
            [
                'name'        => 'Tẩy rong rêu nấm mốc trên thân cành',
                'image'       => 'diseases/tay_rong_reu.jpg',
                'images'      => ['diseases/tay_rong_reu.jpg'],
                'notes'       => 'Hiện tượng rong rêu, tảo lục, tảo đỏ và các mảng địa y (cộng sinh nấm - tảo) cùng nấm mốc bám chặt dày đặc quanh thân chính và cành tán của cây ăn trái lâu năm (sầu riêng, bưởi, cam, quýt, bơ, cà phê, nhãn, vải...). Thường xuất hiện sau mùa mưa kéo dài hoặc ở các vườn ẩm ướt, rậm rạp thiếu ánh sáng.',
                'symptoms'    => "- Trên thân chính và các cành cấp 1, cấp 2: Vỏ cây bị bao phủ bởi lớp rêu xanh mướt nhớt, hoặc các mảng địa y màu trắng xám, đốm tròn xám xanh loang lổ bám chặt vào da cây.\n- Thân cành bị bó nghẹt, lớp vỏ bên dưới bị giữ ẩm liên tục gây thối vỏ, nghẹt khí khổng thở của cây.\n- Các mắt cua, mắt ngủ mầm hoa bị rêu và địa y che lấp, không bung được mầm hoa hoặc hoa nở ra dễ bị thối rụng.\n- Lớp rêu mốc là nơi trú ngụ ẩn nấp lý tưởng của mọt đục cành, rệp sáp, trứng côn trùng và các bào tử nấm gây bệnh nứt thân xì mủ (Phytophthora), nấm hồng.",
                'prevention'  => "- Sau vụ thu hoạch hàng năm, tiến hành tỉa cành tạo tán thông thoáng, nâng cao tán cây để ánh nắng chiếu sâu vào thân chính và các chạc cành.\n- Khơi thông mương rãnh thoát nước trong vườn, không để nước ngập tù đọng dưới gốc cây.\n- Bón vôi nông nghiệp xung quanh gốc cây định kỳ vào đầu mùa mưa để nâng pH đất và hạn chế ẩm mốc.\n- Định kỳ thực hiện công tác Rửa Vườn 1 - 2 lần/năm (sau thu hoạch và trước khi xử lý ra hoa).",
                'treatment'   => "- Sử dụng dung dịch tẩy rong rêu chuyên dụng hoặc các hợp chất Gốc Đồng mạnh (Nano Đồng Chelate, Đồng Đỏ Cuprous Oxide, Đồng Oxychloride) pha theo tỷ lệ rửa vườn đậm đặc.\n- Dùng máy bơm xịt thuốc có áp lực vừa phải, phun trực tiếp vào thân, cành nơi có rêu mốc bám dày.\n- Thuốc sẽ làm mất nước của tế bào rêu và nấm mốc; sau 3 - 5 ngày lớp rong rêu và địa y sẽ khô giòn, chuyển sang màu vàng cháy hoặc nâu sẫm rồi tự bong tróc rơi xuống đất khi gặp mưa hoặc gió.\n- Vỏ cây sạch bóng, thông thoáng, mắt cua sáng rõ, phục hồi khả năng trao đổi chất qua vỏ và sẵn sàng cho cơi đọt, cơi hoa mới.",
                'treatment_plans' => [
                    [
                        'title'        => 'Phác đồ 1: Tẩy rong rêu sinh học & Bóc tróc mảng bám không hại vỏ cây',
                        'badge'        => 'Cặp đôi rửa cành sạch bong',
                        'badge_color'  => 'emerald',
                        'stage'        => 'Giai đoạn sau thu hoạch hoặc chuẩn bị làm bông (cần làm sáng mắt cua, sạch thân)',
                        'dosage_guide' => 'Pha 1 chai RUA CANH MONYKA (550g) + 1 chai Đồng Xanh Mekong Agro (500ml) cho 300 - 400 lít nước. Dùng cần xịt áp lực phun ướt đẫm thân chính, cành cấp 1 và cành cấp 2.',
                        'safety_note'  => 'Chất tẩy sinh học bóc tách lớp rêu bám dai dẳng, kết hợp Nano Đồng Chelate diệt khuẩn, làm sáng da cây, mắt cua sáng rõ mà không làm khô nám vỏ cây.',
                        'groups'       => [
                            [
                                'label'                => 'Chất tẩy rong rêu sinh học chuyên dụng',
                                'primary_pesticide_id' => 33, // RUA CANH MONYKA 550GR
                                'substitute_ids'       => [],
                            ],
                            [
                                'operator'             => '➕',
                                'label'                => 'Đồng hữu cơ chelate & Nano Đồng xanh lá sạch rêu',
                                'primary_pesticide_id' => 17, // Đồng Xanh Mekong Agro
                                'substitute_ids'       => [],
                            ],
                        ],
                    ],
                    [
                        'title'        => 'Phác đồ 2: Rửa vườn toàn diện & Sát trùng thân gốc (Gốc Đồng đỏ Nordox)',
                        'badge'        => 'Phun đơn rửa vườn',
                        'badge_color'  => 'blue',
                        'stage'        => 'Sau khi dọn vườn cắt cành, phun toàn vườn để sát trùng và tẩy sạch rêu mốc tồn dư',
                        'dosage_guide' => 'Pha 1 gói EDDY 72WP (300g) hoặc 1kg COC 85 hoặc 1kg G.O.C 85 cho 400 - 500 lít nước. Phun ướt đều cả thân, cành và tán lá.',
                        'safety_note'  => 'Gốc Đồng đỏ tinh khiết diệt sạch nấm mốc, tảo đỏ và rong rêu, đồng thời sát trùng các vết kéo cắt tỉa cành tránh nấm xâm nhiễm.',
                        'groups'       => [
                            [
                                'label'                => 'Thuốc Gốc Đồng rửa vườn sát trùng cực mạnh (Chọn 1 trong 3)',
                                'primary_pesticide_id' => 18, // EDDY 72WP HOPTRI
                                'substitute_label'     => 'Hoặc thay thế bằng thuốc Gốc Đồng tương đương:',
                                'substitute_ids'       => [12, 20], // COC 85 NGAN ANH, G.O.C 85 Japan
                            ],
                        ],
                    ],
                ],
                'pesticides'  => [33, 17, 18, 12, 20],
            ],

            // 7. Phytophthora Palmivora
            [
                'name'        => 'Phytophthora Palmivora',
                'image'       => 'diseases/KPmBxPsTw9exehJSiu0ga1sepZHJgQjHFPB1frGG.png',
                'images'      => ['diseases/KPmBxPsTw9exehJSiu0ga1sepZHJgQjHFPB1frGG.png'],
                'notes'       => 'Nấm Phytophthora Palmivora gây bệnh nứt thân xì mủ, thối rễ, cháy lá và thối trái trên sầu riêng, hồ tiêu, bưởi, cam, cao su... Cực kỳ nguy hiểm và gây chết cây nhanh chóng nếu không dập dịch kịp thời.',
                'symptoms'    => "- Vết bệnh ban đầu xuất hiện ở phần vỏ gốc thân gần mặt đất hoặc trên thân, cành: vỏ cây bị úng nước, thối nâu rồi chuyển sang màu nâu đen sẫm.\n- Vỏ thân nứt nẻ, chảy nhựa màu nâu đỏ hoặc vàng đặc quánh, có mùi chua đặc trưng.\n- Lá chuyển sang màu vàng úa, rụng nhiều từ các cành thấp lên ngọn, đọt non chùn đọt và khô dần.\n- Trên trái non và trái già: xuất hiện các đốm nâu đen lan nhanh, gây thối nhũn và mốc trắng bao phủ trong điều kiện ẩm ướt.\n- Dưới gốc: rễ cám bị thối đen, mục nát, cây mất khả năng hút nước và dinh dưỡng.",
                'prevention'  => "- Chọn đất trồng thoát nước tốt, đắp mô cao tránh ngập úng gốc trong mùa mưa bão.\n- Bón phân cân đối N-P-K, hạn chế bón thừa đạm vô cơ; tăng cường bón phân hữu cơ vi sinh ủ nấm đối kháng Trichoderma để ức chế nấm hại trong đất.\n- Quét vôi hoặc dung dịch Booc-đô quanh thân gốc từ mặt đất lên 0.8 - 1.0m định kỳ vào đầu và cuối mùa mưa.\n- Tỉa cành tạo tán thông thoáng, dọn sạch cỏ dại và tàn dư cây bệnh đem tiêu hủy xa vườn.\n- Thường xuyên kiểm tra vết nứt thân và vùng rễ sau các đợt mưa kéo dài.",
                'treatment'   => "- Với vết loét trên thân cành: Dùng dao bén cạo sạch phần vỏ thối đến lớp gỗ lành, quét trực tiếp thuốc đặc trị (Dimethomorph, Metalaxyl hoặc Fosetyl Aluminium) nguyên chất lên vết cạo, để khô rồi quét lớp keo liền sẹo.\n- Với bệnh ở rễ và lá: Phun ướt đều tán lá và tưới đẫm vùng rễ quanh hình chiếu tán cây bằng các hoạt chất lưu dẫn 2 chiều (Dimethomorph, Fosetyl-Al, Mancozeb).\n- Phun/tưới lặp lại lần 2 sau 5 - 7 ngày để dập dịch triệt để.\n- Tạm ngưng bón phân bón lá và phân đạm trong suốt thời gian cây đang nhiễm bệnh.",
                'treatment_plans' => [
                    [
                        'title'        => 'Phác đồ 1: Cạo sạch mủ & Quét đậm đặc vết loét nứt thân xì mủ',
                        'badge'        => 'Cặp đôi quét vết xì mủ',
                        'badge_color'  => 'emerald',
                        'stage'        => 'Khi phát hiện thân cây xì mủ nâu đỏ, vỏ nứt ứa nhựa chua',
                        'dosage_guide' => 'Dùng dao cạo sạch lớp vỏ thối đen đến phần gỗ trắng lành lặn. Pha 50g Alien An Nông + 50ml Dimethor 500SC vào 100ml nước tạo hỗn hợp sệt, dùng cọ quét kín miệng vết cạo. Để khô 24h rồi quét keo liền sẹo bảo vệ.',
                        'safety_note'  => 'Fosetyl-Aluminium kích kháng sinh học kết hợp Dimethomorph diệt nấm Phytophthora trực tiếp, làm khô miệng vết loét trong 48 giờ.',
                        'groups'       => [
                            [
                                'label'                => 'Thuốc kích kháng lưu dẫn 2 chiều Fosetyl-Al',
                                'primary_pesticide_id' => 4, // Alien An Nông 800WP
                                'substitute_ids'       => [],
                            ],
                            [
                                'operator'             => '➕',
                                'label'                => 'Thuốc đặc trị nấm Oomycetes phá vách nấm',
                                'primary_pesticide_id' => 15, // Dimethor 500SC
                                'substitute_ids'       => [],
                            ],
                        ],
                    ],
                    [
                        'title'        => 'Phác đồ 2: Phun ướt tán lá & Tưới đẫm vùng rễ cám quanh tán',
                        'badge'        => 'Combo tưới gốc dập dịch rễ',
                        'badge_color'  => 'blue',
                        'stage'        => 'Cây có biểu hiện vàng lá, thối rễ cám hoặc sau đợt mưa ngập úng gốc',
                        'dosage_guide' => 'Pha 1 chai Dimethor 500SC (500ml) + 1 gói MANCOZEB 80WP (1kg) cho 400 - 500 lít nước (2 phuy). Phun ướt đều tán lá và tưới 20 - 30 lít dung dịch quanh hình chiếu tán cây.',
                        'safety_note'  => 'Vừa diệt nấm Phytophthora trên lá vừa tiêu diệt nguồn nấm trong đất quanh rễ cám, kích thích ra rễ mới.',
                        'groups'       => [
                            [
                                'label'                => 'Thuốc lưu dẫn thấm sâu tiêu diệt nấm thối rễ',
                                'primary_pesticide_id' => 15, // Dimethor 500SC
                                'substitute_label'     => 'Hoặc thay thế bằng:',
                                'substitute_ids'       => [4], // Alien An Nông
                            ],
                            [
                                'operator'             => '➕',
                                'label'                => 'Thuốc tiếp xúc tạo màng bảo vệ rễ và tán lá',
                                'primary_pesticide_id' => 26, // MANCOZEB 80WP 1KG
                                'substitute_ids'       => [],
                            ],
                        ],
                    ],
                ],
                'pesticides'  => [4, 15, 26],
            ],
        ];

        foreach ($diseasesData as $item) {
            $pesticideIds = $item['pesticides'] ?? [];
            unset($item['pesticides']);

            $disease = Disease::updateOrCreate(
                ['name' => $item['name']],
                $item
            );

            if (! empty($pesticideIds)) {
                $validPesticideIds = Pesticide::whereIn('id', $pesticideIds)->pluck('id')->toArray();
                $disease->pesticides()->sync($validPesticideIds);
            }
        }
    }
}
