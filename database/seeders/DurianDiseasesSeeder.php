<?php

namespace Database\Seeders;

use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class DurianDiseasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Thêm và chuẩn hóa toàn bộ bộ nấm bệnh hại trên sầu riêng theo phân loại:
     * 1. Phytophthora (Thối rễ, Xì mủ / thối gốc, Thối trái)
     * 2. Fusarium (Thối rễ → Vàng lá → Cây suy)
     * 3. Colletotrichum (Thán thư → Đốm nâu lá)
     * 4. Rhizoctonia (Cháy lá → Chết ngọn)
     * 5. Pythium (Thối rễ non)
     * 6. Lasiodiplodia (Khô cành / Bệnh mô)
     * 7. Nấm hồng (Bệnh trên thân cành)
     */
    public function run(): void
    {
        $diseasesData = [
            // 1. Phytophthora - Thối rễ
            [
                'match_name' => 'Phytophthora: Thối rễ sầu riêng',
                'aliases'    => ['Phytophthora - Thối rễ', 'Thối rễ sầu riêng'],
                'data'       => [
                    'name'       => 'Phytophthora: Thối rễ sầu riêng',
                    'image'      => 'diseases/phytophthora_thoi_re.jpg',
                    'images'     => [
                        'diseases/phytophthora_thoi_re.jpg',
                        'diseases/KPmBxPsTw9exehJSiu0ga1sepZHJgQjHFPB1frGG.png',
                    ],
                    'notes'      => 'Bệnh do nấm thủy sinh Phytophthora palmivora gây ra trong điều kiện ngập úng mùa mưa. Rễ bị thối đen, tuột vỏ khiến cây suy kiệt, vàng lá rụng cành.',
                    'symptoms'   => "- Nấm tấn công hệ thống rễ dưới mặt đất, đặc biệt là các chóp rễ tơ, rễ cám và rễ cọc.\n- Vỏ rễ bị ủng nước, chuyển sang màu nâu đen mục nát, vỏ rễ dễ bong tróc và tuột khỏi lõi gỗ, bốc mùi chua hôi ẩm ướt.\n- Do rễ mất khả năng hút nước và khoáng chất, lá trên tán ngả màu vàng úa, rụng từ các cành thấp lên ngọn.\n- Cơi đọt non bị chùn lại, không bung lá mới được, các đầu cành khô dần và cây suy kiệt nhanh chóng.",
                    'prevention' => "- Đắp mô cao, đào mương rãnh thoát nước sâu giữa các hàng liếp, tuyệt đối không để đọng vũng nước quanh gốc trong mùa mưa.\n- Bón phân hữu cơ hoai mục định kỳ 2-3 lần/năm kết hợp ủ nấm đối kháng Trichoderma để áp chế mầm bệnh trong đất.\n- Kiểm tra và nâng pH đất đạt 5.5 - 6.5 bằng vôi nông nghiệp hoặc tinh vôi định kỳ đầu và cuối mùa mưa.\n- Tránh xới xáo đất quá sâu sát gốc làm đứt rễ non tạo vết thương hở cho nấm xâm nhập.",
                    'treatment'  => "- Cào nhẹ lớp lá mục và cỏ rác quanh tán cho thông thoáng vùng rễ.\n- Xử lý thuốc đặc trị nấm Oomycetes lưu dẫn 2 chiều: Pha tưới đẫm vùng rễ bằng Dimethomorph (Dimethor 500SC), Fosetyl-Aluminium (Alien An Nông / Aliette) hoặc Lân 2 chiều Phosphonate (Delta Fos).\n- Tưới lặp lại lần 2 sau 7 ngày để dập triệt để nguồn nấm.\n- Sau 10 - 15 ngày khi vết thối khô ráo, tưới phục hồi rễ bằng Humic Amino Roots + vi lượng để kích thích rễ cám mới phát triển.",
                ],
                'pesticides' => [
                    'Dimethor 500SC',
                    'Alien An Nông 800WP',
                    'Delta Fos Mekong Agro',
                    'MANCOZEB 80WP 1KG',
                    'Humic Amino Roots & Bio Humic F88',
                ],
            ],

            // 2. Phytophthora - Xì mủ / Thối gốc
            [
                'match_name' => 'Phytophthora: Xì mủ / Thối gốc sầu riêng',
                'aliases'    => ['Phytophthora Palmivora', 'Xì mủ sầu riêng', 'Thối gốc chảy nhựa'],
                'data'       => [
                    'name'       => 'Phytophthora: Xì mủ / Thối gốc sầu riêng',
                    'image'      => 'diseases/KPmBxPsTw9exehJSiu0ga1sepZHJgQjHFPB1frGG.png',
                    'images'     => [
                        'diseases/KPmBxPsTw9exehJSiu0ga1sepZHJgQjHFPB1frGG.png',
                        'diseases/phytophthora_thoi_re.jpg',
                    ],
                    'notes'      => 'Bệnh xì mủ thối gốc chảy nhựa (Gummosis / Foot rot) do nấm Phytophthora palmivora gây hại trên thân chính và cổ rễ.',
                    'symptoms'   => "- Vết bệnh ban đầu xuất hiện ở phần vỏ gốc thân gần mặt đất hoặc trên thân, chảng ba cành: vỏ cây bị úng nước, thối nâu rồi chuyển sang màu nâu đen sẫm.\n- Vỏ thân nứt nẻ, ứa ra các giọt nhựa màu nâu đỏ hoặc vàng cánh gián đặc quánh, sau đó khô lại thành từng mảng keo dẻo có mùi chua nồng đặc trưng.\n- Cạo lớp biểu bì vỏ thấy phần mô mạch gỗ bên trong bị thâm nâu đen hoại tử ăn sâu vào thân cây.\n- Khi vết bệnh ăn giáp vòng chu vi thân, mạch dẫn nhựa bị cắt đứt hoàn toàn làm toàn bộ cây chết rũ đột ngột.",
                    'prevention' => "- Cào bớt đất xung quanh cổ rễ cho lộ phần cổ rễ đón ánh nắng trực tiếp, không đắp đất chôn sâu cổ rễ.\n- Quét vôi hoặc quét dung dịch Booc-đô, Đồng đỏ quanh thân gốc từ mặt đất lên cao 0.8m - 1m định kỳ vào đầu và cuối mùa mưa.\n- Cắt tỉa sạch các cành nhánh sát mặt đất để gốc cây luôn khô ráo, thông thoáng gió.\n- Thường xuyên kiểm tra thân gốc, phát hiện sớm vết nứt ứa nhựa ngay từ khi vết bệnh còn nhỏ.",
                    'treatment'  => "- Dùng dao bén cạo sạch toàn bộ phần vỏ và mô gỗ bị thối đen đến tận phần gỗ lành màu trắng xanh.\n- Quét trực tiếp thuốc đặc trị nguyên chất (pha sệt dạng kem) lên vết cạo: Quét Fosetyl-Aluminium (Alien An Nông), Dimethomorph (Dimethor) hoặc Đồng đỏ (Eddy 72WP). Để vết quét khô ráo rồi quét keo liền sẹo bảo vệ.\n- Phun ướt đều tán lá và tưới đẫm vùng gốc bằng Fosetyl-Al hoặc Lân 2 chiều Phosphonate để lưu dẫn nội hấp diệt nấm từ bên trong mạch dẫn.\n- Xử lý lại sau 5 - 7 ngày nếu vết cạo còn dấu hiệu ứa nhựa mới.",
                ],
                'pesticides' => [
                    'Alien An Nông 800WP',
                    'Dimethor 500SC',
                    'EDDY 72WP HOPTRI 300GRA',
                    'G.O.C 85 Japan',
                    'Delta Fos Mekong Agro',
                ],
            ],

            // 3. Phytophthora - Cháy Lá & Thối Trái
            [
                'match_name' => 'Phytophthora: Cháy Lá & Thối Trái Sầu Riêng',
                'aliases'    => ['Phytophthora: Thối trái sầu riêng', 'Thối trái sầu riêng', 'Cháy lá sương mai sầu riêng'],
                'data'       => [
                    'name'       => 'Phytophthora: Cháy Lá & Thối Trái Sầu Riêng',
                    'image'      => 'diseases/phytophthora_thoi_trai.jpg',
                    'images'     => [
                        'diseases/phytophthora_thoi_trai.jpg',
                        'diseases/KPmBxPsTw9exehJSiu0ga1sepZHJgQjHFPB1frGG.png',
                    ],
                    'notes'      => "Kinh nghiệm dập dịch Phytophthora trên lá và trái non: Cần phối hợp 3 trong 1 (Thuốc đặc trị nấm Oomycetes phá vách nấm + Kháng sinh diệt khuẩn chống thối nhũn bội nhiễm + Thuốc tiếp xúc áo giáp Kẽm/Mangan bọc màng bảo vệ bề mặt chống mưa rửa trôi). Luân phiên hoạt chất để chống kháng thuốc.",
                    'symptoms'   => "- Bệnh trên cơi đọt: Vết bệnh từ chóp lá non hoặc mép lá lan dần vào trong phiến lá theo hình quạt úng nước màu nâu xám sũng nước như bị luộc, làm rũ rụi chùm lá non và đọt mới nhú.\n- Bệnh trên trái non & trái già: Xuất hiện ở đít trái hoặc cuống trái các mảng thối ủng màu nâu đen ăn sâu vào ruột múi, thịt nhão chua, bề mặt phủ lớp mốc trắng phấn mịn (bào tử nấm).",
                    'prevention' => "- Tỉa cành tạo tán thông thoáng, neo giữ chùm trái hợp lý không để va quẹt tổn thương cơ giới.\n- Thu gom ngay các trái rụng bị thối đem ra xa vườn tiêu hủy rắc vôi bột.\n- Phun phòng định kỳ bằng Mancozeb hoặc Antracol (Áo giáp kẽm) trước và sau các đợt mưa bão kéo dài.",
                    'treatment'  => "- Hái bỏ ngay các trái chớm thối tiêu hủy triệt để.\n- Phun dập dịch toàn diện bằng bộ 3 tác động (Trị Phytophthora + Kháng sinh diệt khuẩn + Áo giáp Kẽm phủ bề mặt).\n- Phun kỹ chùm trái, cuống trái và mặt dưới lá; phun nhắc lại sau 4 - 5 ngày nếu trời tiếp tục mưa.",
                    'treatment_plans' => [
                        [
                            'title'        => 'Phác đồ 1: Combo Dập Dịch Phytophthora Toàn Diện (3 Trong 1: Trị Nấm + Diệt Khuẩn + Áo Giáp Kẽm)',
                            'badge'        => 'Combo dập dịch cực mạnh (3 trong 1)',
                            'badge_color'  => 'emerald',
                            'stage'        => 'Khi vườn chớm xuất hiện đốm úng nước trên lá non, nấm cuống trái, thâm kim gai trái hoặc thời tiết mưa dầm ẩm ướt liên tục',
                            'dosage_guide' => 'Pha 1 chai Dimethor 500SC (250ml) + 1 chai KASUGACIN 3SL (450ml) + 1 gói Antracol 70WP Bayer (1kg) cho 400 - 500 lít nước (2 phuy 200L). Phun ướt đều 2 mặt lá, chùm trái và kẽ cành.',
                            'safety_note'  => 'Bộ 3 hiệp đồng hoàn hảo: Dimethomorph phá vách tế bào nấm Phytophthora, Kasugamycin diệt vi khuẩn chống thối nhũn bội nhiễm, Antracol tạo áo giáp Kẽm (Zinc++) bọc màng bảo vệ bên ngoài chống rửa trôi. Cực kỳ mát đọt non và mát chùm trái, không gây lem trái.',
                            'groups'       => [
                                [
                                    'label'                => 'Thuốc chủ lực: Đặc trị nấm Oomycetes phá vách nấm Phytophthora',
                                    'primary_pesticide_id' => 15, // Dimethor 500SC
                                    'substitute_label'     => 'Hoặc có thể chọn thay thế bằng sản phẩm tương đương:',
                                    'substitute_ids'       => [3, 4, 29, 34, 30], // Aliette Bayer, Alien An Nông, Phytocide, TD-Lumordie, Profiler
                                ],
                                [
                                    'operator'             => '➕',
                                    'label'                => 'Thuốc phối hợp: Kháng sinh đặc trị vi khuẩn (Chống thối nhũn bội nhiễm)',
                                    'primary_pesticide_id' => 23, // KASUGACIN 3SL VI KHUAN
                                    'substitute_label'     => 'Hoặc có thể chọn thay thế bằng kháng sinh sinh học:',
                                    'substitute_ids'       => [11], // BACOLINH 450ML
                                ],
                                [
                                    'operator'             => '➕',
                                    'label'                => 'Thuốc áo giáp: Phủ mạnh bề mặt, chống mưa rửa trôi & Làm dày xanh lá',
                                    'primary_pesticide_id' => 7, // Antracol 70WP Bayer
                                    'substitute_label'     => 'Hoặc có thể chọn thay thế bằng thuốc tiếp xúc phổ rộng:',
                                    'substitute_ids'       => [26, 27], // MANCOZEB 80WP, NOFACOL 700WP
                                ],
                            ],
                        ],
                        [
                            'title'        => 'Phác đồ 2: Bẻ Kháng Thuốc & Mát Cây Tuyệt Đối (Ethaboxam + Ningnanmycin + Mancozeb)',
                            'badge'        => 'Chống kháng & Mát đọt non (3 trong 1)',
                            'badge_color'  => 'blue',
                            'stage'        => 'Dùng khi nấm đã lờn thuốc Metalaxyl cũ, hoặc cơi đọt non đang phóng mạnh, mắt cua đang nhú cần độ mát an toàn tuyệt đối',
                            'dosage_guide' => 'Pha 1 chai DANJIRI SUMITOMO 10SC (250ml) + 1 chai BACOLINH 450ML + 1 gói MANCOZEB 80WP (1kg) cho 400 - 500 lít nước (2 phuy). Phun ướt đều tán lá và chùm trái non.',
                            'safety_note'  => 'Ethaboxam là nhóm hoạt chất Oomycetes thế hệ mới nhất chuyên bẻ gãy tính kháng thuốc, kết hợp Ningnanmycin sinh học mát đọt và Mancozeb bảo vệ bề mặt kéo dài. An toàn 100% cho hoa và lá non.',
                            'groups'       => [
                                [
                                    'label'                => 'Thuốc chủ lực: Hoạt chất Oomycetes thế hệ mới bẻ gãy tính kháng thuốc',
                                    'primary_pesticide_id' => 13, // DANJIRI SUMITOMO 10SC 1
                                    'substitute_label'     => 'Hoặc có thể chọn thay thế bằng thuốc lưu dẫn 2 chiều / kích kháng:',
                                    'substitute_ids'       => [14, 1, 15], // Delta Fos, AGRI-FOS, Dimethor 500SC
                                ],
                                [
                                    'operator'             => '➕',
                                    'label'                => 'Thuốc phối hợp: Kháng sinh sinh học diệt khuẩn mát cây',
                                    'primary_pesticide_id' => 11, // BACOLINH 450ML
                                    'substitute_label'     => 'Hoặc có thể chọn thay thế bằng:',
                                    'substitute_ids'       => [23], // KASUGACIN 3SL VI KHUAN
                                ],
                                [
                                    'operator'             => '➕',
                                    'label'                => 'Thuốc áo giáp: Phủ bề mặt bảo vệ cuống trái & Chống mưa rửa trôi',
                                    'primary_pesticide_id' => 26, // MANCOZEB 80WP 1KG
                                    'substitute_label'     => 'Hoặc có thể chọn thay thế bằng:',
                                    'substitute_ids'       => [7, 27], // Antracol 70WP Bayer, NOFACOL 700WP
                                ],
                            ],
                        ],
                        [
                            'title'        => 'Phác đồ 3: Dập Dịch Thối Trái & Cháy Lá Mùa Mưa Bão (Ridomil Gold + Kasugacin + Áo Giáp)',
                            'badge'        => 'Dập dịch mưa bão & Thối trái',
                            'badge_color'  => 'amber',
                            'stage'        => 'Mùa mưa bão kéo dài nhiều ngày, trái sầu riêng đang nuôi lớn có nguy cơ thối đít trái hoặc rụng trái non hàng loạt',
                            'dosage_guide' => 'Pha 1 gói Ridomil Gold 68WG (1kg) + 1 chai KASUGACIN 3SL (450ml) cho 400 - 500 lít nước (2 phuy). Phun kỹ vào chùm trái, cuống trái và mặt dưới lá.',
                            'safety_note'  => 'Metalaxyl-M nội hấp cực nhanh thấm sâu vào cuống trái, Mancozeb bám chặt vỏ gai chống mưa rửa trôi, Kasugamycin chặn đứng thối nhũn vi khuẩn xâm nhập qua vết nứt gai hoặc vết côn trùng chích.',
                            'groups'       => [
                                [
                                    'label'                => 'Thuốc chủ lực: Vừa diệt nấm Phytophthora vừa có màng phủ bám chặt vỏ gai',
                                    'primary_pesticide_id' => 32, // Ridomil Gold 68WG
                                    'substitute_label'     => 'Hoặc có thể chọn thay thế bằng bộ đôi tương đương:',
                                    'substitute_ids'       => [30, 15], // PROFILER 711.1WG Bayer, Dimethor 500SC
                                ],
                                [
                                    'operator'             => '➕',
                                    'label'                => 'Thuốc phối hợp: Diệt vi khuẩn chống thối nhũn trái',
                                    'primary_pesticide_id' => 23, // KASUGACIN 3SL VI KHUAN
                                    'substitute_label'     => 'Hoặc thay thế bằng kháng sinh sinh học:',
                                    'substitute_ids'       => [11], // BACOLINH 450ML
                                ],
                                [
                                    'operator'             => '➕',
                                    'label'                => 'Thuốc bổ trợ: Áo giáp Kẽm tăng cường độ bám dính & Bảo vệ vỏ trái',
                                    'primary_pesticide_id' => 7, // Antracol 70WP Bayer
                                    'substitute_label'     => 'Hoặc thay thế bằng:',
                                    'substitute_ids'       => [26], // MANCOZEB 80WP 1KG
                                ],
                            ],
                        ],
                    ],
                ],
                'pesticides' => [
                    'Dimethor 500SC',
                    'KASUGACIN 3SL VI KHUAN',
                    'Antracol 70WP Bayer',
                    'DANJIRI SUMITOMO 10SC 1',
                    'BACOLINH 450ML',
                    'MANCOZEB 80WP 1KG',
                    'Ridomil Gold 68WG',
                    'ALIETTE BAYER 500 GRAM',
                    'Alien An Nông 800WP',
                    'Phytocide 50WP Hợp Trí',
                    'TD - Lumordie 500WP Sạch Bệnh',
                    'PROFILER 711,1WG BAYER 3',
                    'Delta Fos Mekong Agro',
                    'AGRI-FOS DONA-TECHNO 1',
                    'NOFACOL 700WP 1KG',
                ],
            ],

            // 4. Fusarium - Thối rễ, vàng lá suy cây
            [
                'match_name' => 'Fusarium: Thối rễ → Vàng lá → Cây suy',
                'aliases'    => ['Fusarium', 'Vàng lá thối rễ', 'Thối rễ vàng lá'],
                'data'       => [
                    'name'       => 'Fusarium: Thối rễ → Vàng lá → Cây suy',
                    'image'      => 'diseases/fusarium_thoi_re_vang_la.jpg',
                    'images'     => [
                        'diseases/fusarium_thoi_re_vang_la.jpg',
                        'diseases/phytophthora_thoi_re.jpg',
                    ],
                    'notes'      => 'Bệnh vàng lá thối rễ do nấm Fusarium solani và Fusarium oxysporum kết hợp tuyến trùng làm tắc mạch dẫn, cây suy kiệt dần.',
                    'symptoms'   => "- Lá già và lá bánh tẻ chuyển sang màu vàng úa từ gân lá ra mép lá hoặc từ chóp lá vào, lá mất dần sắc xanh bóng, rụng lác đác rồi rụng trơ cành.\n- Cây bị suy kiệt từ từ, đọt non ra yếu ớt, lá nhỏ biến dạng và không phát triển được cơi đọt mới.\n- Rễ tơ bị thối khô màu nâu sẫm, vỏ rễ dễ tuột ra khỏi lõi gỗ.\n- Khi chẻ dọc phần thân rễ hoặc cổ rễ thấy các bó mạch dẫn bên trong bị thâm đen hoặc có sọc nâu đỏ chạy dài do độc tố của nấm Fusarium làm tắc mạch vận chuyển nước.",
                    'prevention' => "- Cải tạo đất, nâng độ pH đất luôn đạt từ 5.5 - 6.5; tuyệt đối không để đất bị chua phèn (pH < 5 là môi trường lý tưởng cho nấm Fusarium bùng phát).\n- Bổ sung phân chuồng hoai mục kết hợp chế phẩm nấm đối kháng Trichoderma và vi khuẩn Bacillus định kỳ 2-3 tháng/lần.\n- Quản lý tốt tuyến trùng hại rễ vì vết chích hút của tuyến trùng là cửa ngõ chính để Fusarium xâm nhập phá hủy rễ.",
                    'treatment'  => "- Xử lý kết hợp thuốc đặc trị nấm Fusarium với thuốc trị tuyến trùng nếu vườn có mật độ tuyến trùng cao.\n- Tưới đẫm vùng gốc quanh hình chiếu tán cây bằng Lân 2 chiều Phosphonate (Delta Fos) hoặc Metalaxyl + Mancozeb, Hexaconazole (Japa Vil).\n- Tưới nhắc lại lần 2 sau 7-10 ngày; ngừng hoàn toàn các loại phân bón hóa học NPK và phân có hàm lượng đạm cao.\n- Sau khi cây ngừng rụng lá và nhú rễ mới, tưới Humic Amino Roots để tái tạo bộ rễ tơ khỏe mạnh.",
                ],
                'pesticides' => [
                    'Delta Fos Mekong Agro',
                    'Japa Vil 110SC Monyka',
                    'MANCOZEB 80WP 1KG',
                    'Humic Amino Roots & Bio Humic F88',
                ],
            ],

            // 5. Colletotrichum - Thán thư đốm nâu lá
            [
                'match_name' => 'Colletotrichum: Thán thư → Đốm nâu lá sầu riêng',
                'aliases'    => ['Thán thư', 'Colletotrichum'],
                'data'       => [
                    'name'       => 'Colletotrichum: Thán thư → Đốm nâu lá sầu riêng',
                    'image'      => 'diseases/than_thu.jpg',
                    'images'     => [
                        'diseases/than_thu.jpg',
                    ],
                    'notes'      => 'Bệnh thán thư do nấm Colletotrichum gloeosporioides gây hại phổ biến trên lá non, lá già và chồi non sầu riêng.',
                    'symptoms'   => "- Vết bệnh ban đầu là những chấm nhỏ màu nâu sẫm ở chóp lá hoặc mép lá, sau lan dần vào trong phiến lá thành từng mảng lớn.\n- Đốm bệnh có hình tròn hoặc bầu dục với các vòng tròn đồng tâm nổi rõ rệt, xung quanh viền nâu đậm có quầng vàng ngăn cách mô bệnh và mô khỏe.\n- Mô bệnh bị khô giòn, dễ rách thủng khi gặp gió lớn.\n- Bệnh nặng làm lá khô cháy từng mảng lớn, lá rụng sớm hàng loạt làm trơ trụi cành, cây không đủ diện tích quang hợp để nuôi cơi đọt và nuôi trái.",
                    'prevention' => "- Cắt tỉa cành tạo tán thông thoáng, dọn sạch tàn dư lá bệnh rụng dưới gốc mang đi tiêu hủy.\n- Bón phân cân đối N-P-K, không bón thừa phân đạm trong mùa mưa ẩm ướt; tăng cường bón Silic, Canxi Bo và Kẽm giúp vách tế bào lá dày chắc khỏe.\n- Phun phòng định kỳ vào đầu mùa mưa hoặc khi cây chuẩn bị bung cơi đọt mới bằng Antracol, Nofacol hoặc Mancozeb.",
                    'treatment'  => "- Khi bệnh vừa chớm xuất hiện trên lá, phun ngay các hoạt chất đặc trị thán thư nội hấp lưu dẫn: Azoxystrobin + Difenoconazole (Asmiltatop Super), Pyraclostrobin (Headline 250EC) hoặc Propineb (Antracol/Nofacol).\n- Phun ướt đều cả 2 mặt lá và đỉnh sinh trưởng, phun luân phiên hoạt chất để tránh hiện tượng nấm kháng thuốc.\n- Phun nhắc lại lần 2 sau 5 - 7 ngày nếu áp lực bệnh cao.",
                ],
                'pesticides' => [
                    'ASMILTATOP SUPER 400SC',
                    'HEADLINE 250EC BASF 100',
                    'Antracol 70WP Bayer',
                    'NOFACOL 700WP 1KG',
                    'MANCOZEB 80WP 1KG',
                ],
            ],

            // 6. Rhizoctonia - Cháy lá chết ngọn
            [
                'match_name' => 'Rhizoctonia: Cháy lá → Chết ngọn sầu riêng',
                'aliases'    => ['Rhizoctonia', 'Cháy lá chết ngọn', 'Bệnh cháy lá'],
                'data'       => [
                    'name'       => 'Rhizoctonia: Cháy lá → Chết ngọn sầu riêng',
                    'image'      => 'diseases/rhizoctonia_chay_la.jpg',
                    'images'     => [
                        'diseases/rhizoctonia_chay_la.jpg',
                    ],
                    'notes'      => 'Bệnh cháy lá chết ngọn do nấm Rhizoctonia solani gây hại nghiêm trọng trên sầu riêng giai đoạn vườn ươm và cây tơ kiến thiết cơ bản.',
                    'symptoms'   => "- Vết bệnh ban đầu xuất hiện trên lá non như bị nhúng nước sôi (vết bỏng nước), sũng nước màu xanh xám.\n- Vết bệnh lan nhanh làm lá bị cháy khô màu nâu sẫm, quăn queo lại; các lá bệnh dính chùm lại với nhau bằng mạng tơ nấm trắng đục li ti bao phủ.\n- Nấm tấn công thẳng lên đỉnh sinh trưởng làm đọt non bị thối đen, khô héo và chết tụt dần từ ngọn xuống (hiện tượng chết ngọn / top dieback).\n- Vào sáng sớm có sương mù ẩm ướt, quan sát thấy rất rõ các sợi tơ nấm trắng như mạng nhện chằng chịt giữa các lá và cành non.",
                    'prevention' => "- Tuyệt đối không dùng béc tưới phun sương lên tán lá vào buổi chiều tối muộn làm ướt lá qua đêm.\n- Tỉa bỏ các cành tăm, cành khuất sáng trong tán cây giúp ánh nắng rọi sâu vào thân cành làm khô ráo tán lá nhanh sau mưa.\n- Không trồng mật độ quá dày và tránh bón thừa đạm khi cây đang phóng đọt non gặp thời tiết nồm ẩm.",
                    'treatment'  => "- Cắt bỏ các chùm lá và ngọn non đã bị cháy gom lại đem ra khỏi vườn tiêu hủy ngay để dập ổ nấm.\n- Phun ngay các hoạt chất đặc trị nấm sợi tơ Rhizoctonia: Hexaconazole (Anvil 5SC, Japa Vil 110SC), Azoxystrobin + Difenoconazole (Asmiltatop) hoặc Ningnanmycin (Bacolinh).\n- Phun ướt đẫm 2 mặt lá, chồi ngọn và toàn bộ tán cây, phun nhắc lại lần 2 sau 5 ngày.",
                ],
                'pesticides' => [
                    'ANVIL SYNGENTA 5SC 1LIT',
                    'Japa Vil 110SC Monyka',
                    'ASMILTATOP SUPER 400SC',
                    'BACOLINH 450ML',
                ],
            ],

            // 6b. Rhizoctonia - Lở cổ rễ cây con
            [
                'match_name' => 'Rhizoctonia: Lở cổ rễ cây con sầu riêng',
                'aliases'    => ['Lở cổ rễ sầu riêng', 'Lở cổ rễ cây con', 'Rhizoctonia lở cổ rễ'],
                'data'       => [
                    'name'       => 'Rhizoctonia: Lở cổ rễ cây con sầu riêng',
                    'image'      => 'diseases/rhizoctonia_lo_co_re.jpg',
                    'images'     => [
                        'diseases/rhizoctonia_lo_co_re.jpg',
                    ],
                    'notes'      => 'Bệnh lở cổ rễ cây con (Damping-off) do nấm Rhizoctonia solani gây hại nghiêm trọng trong vườn ươm sầu riêng và cây mới trồng.',
                    'symptoms'   => "- Vết bệnh ban đầu xuất hiện ở phần cổ thân giáp mặt đất của cây sầu riêng con trong vườn ươm hoặc cây mới trồng: vỏ cây bị ủng nước, thâm nâu rồi chuyển sang màu đen sẫm.\n- Vùng cổ rễ bị teo tóp, thắt eo nhỏ lại như sợi chỉ, mô vỏ bị thối mục không nâng đỡ được thân cây.\n- Cây con bị héo rũ nhanh chóng và ngã rạp xuống mặt đất trong khi phần lá ngọn bên trên vẫn còn màu xanh tươi (hiện tượng cây chết rạp hàng loạt trong vườn ươm).\n- Khi nhổ cây lên, phần vỏ gốc dễ bị tuột ra, rễ cám bị thối cụt, ẩm ướt bốc mùi chua.",
                    'prevention' => "- Đất đóng bầu ươm phải được xử lý khử trùng sạch nấm bệnh bằng cách phơi nắng kỹ, xông hơi hoặc tưới thuốc gốc Đồng, vôi bột trước khi vô bầu.\n- Kê giàn bầu ươm cao cách mặt đất 20-30cm, không để đáy bầu chạm đất đọng nước ẩm ướt.\n- Tránh tưới quá nhiều nước làm đất ngậm nước bí khí; che lưới giảm bớt độ ẩm và tăng độ thông thoáng gió trong vườn ươm.\n- Trộn giá thể ươm tơi xốp với nấm đối kháng Trichoderma để bảo vệ cổ rễ cây con ngay từ giai đoạn hạt mới nảy mầm.",
                    'treatment'  => "- Gom nhổ bỏ các cây con đã bị thắt eo ngã rạp đem tiêu hủy xa vườn ươm để tránh nấm lây lan qua giọt nước tưới.\n- Giảm ngay lượng nước tưới, ngưng bón phân đạm và phân bón lá.\n- Tưới đẫm dung dịch thuốc đặc trị nấm Rhizoctonia vào gốc và toàn bộ mặt bầu ươm: Hexaconazole (Anvil 5SC, Japa Vil 110SC), Validamycin hoặc Ningnanmycin (Bacolinh 450ML).\n- Tưới nhắc lại lần 2 sau 4 - 5 ngày để dập dịch triệt để.",
                ],
                'pesticides' => [
                    'ANVIL SYNGENTA 5SC 1LIT',
                    'Japa Vil 110SC Monyka',
                    'BACOLINH 450ML',
                    'Antracol 70WP Bayer',
                ],
            ],

            // 7. Pythium - Thối rễ non
            [
                'match_name' => 'Pythium: Thối rễ non sầu riêng',
                'aliases'    => ['Pythium', 'Thối rễ non'],
                'data'       => [
                    'name'       => 'Pythium: Thối rễ non sầu riêng',
                    'image'      => 'diseases/pythium_thoi_re.jpg',
                    'images'     => [
                        'diseases/pythium_thoi_re.jpg',
                        'diseases/phytophthora_thoi_re.jpg',
                    ],
                    'notes'      => 'Bệnh thối rễ non do nấm thủy sinh Pythium spp. tấn công trực tiếp vào hệ thống rễ cám và lông hút của cây sầu riêng.',
                    'symptoms'   => "- Nấm Pythium chuyên tấn công các chóp rễ tơ, rễ cám vừa mới nhú trong điều kiện đất ẩm ướt kéo dài hoặc bị nén dẽ thiếu oxy.\n- Đầu chóp rễ bị ủng nước màu nâu nhạt đến nâu đen, vỏ ngoài của rễ bị nhũn nát và dễ tuột ra chỉ còn trơ lõi rễ mỏng manh bên trong.\n- Cây bị mất toàn bộ hệ thống lông hút khiến đọt non chậm bung cơi, lá ngả màu xanh nhạt hoặc vàng úa, cây đứng đọt còi cọc và suy giảm sức sống rõ rệt.",
                    'prevention' => "- Lên mô cao, đào rãnh thoát nước sâu quanh bờ bao, tuyệt đối không để rễ cây bị ngâm nước quá 24 giờ.\n- Xử lý đất tơi xốp, bón lót phân hữu cơ hoai mục, rải vôi nông nghiệp nâng pH đất > 6.0 để ức chế nấm thủy sinh.\n- Định kỳ tưới men vi sinh đối kháng Trichoderma và xạ khuẩn Streptomyces để bảo vệ đầu rễ non.",
                    'treatment'  => "- Khơi thông rãnh thoát nước cho đất quanh gốc ráo nước nhanh nhất có thể.\n- Tưới thuốc đặc trị nấm Oomycetes: Ethaboxam (Danjiri Sumitomo), Dimethomorph (Dimethor 500SC) hoặc Fosetyl-Aluminium (Alien An Nông).\n- Tưới đẫm vùng đất quanh rìa tán 2 lần cách nhau 7 ngày; tuyệt đối không bón phân hóa học trong thời gian này.\n- Sau 7-10 ngày khi đầu rễ se mặt ngừng thối, tưới Humic Amino Roots để kích thích cây ra rễ tơ và lông hút mới.",
                ],
                'pesticides' => [
                    'DANJIRI SUMITOMO 10SC 1',
                    'Dimethor 500SC',
                    'Alien An Nông 800WP',
                    'Humic Amino Roots & Bio Humic F88',
                ],
            ],

            // 8. Lasiodiplodia - Khô cành, bệnh mô
            [
                'match_name' => 'Lasiodiplodia: Khô cành / Bệnh mô sầu riêng',
                'aliases'    => ['Lasiodiplodia', 'Khô cành sầu riêng', 'Bệnh mô sầu riêng'],
                'data'       => [
                    'name'       => 'Lasiodiplodia: Khô cành / Bệnh mô sầu riêng',
                    'image'      => 'diseases/lasiodiplodia_kho_canh.jpg',
                    'images'     => [
                        'diseases/lasiodiplodia_kho_canh.jpg',
                    ],
                    'notes'      => 'Bệnh khô cành, bệnh mô và thối cuống do nấm Lasiodiplodia theobromae xâm nhập qua các vết thương hở và vết cắt tỉa cành.',
                    'symptoms'   => "- Trên thân cành: Vỏ cành bị nứt nẻ xù xì, ứa nhựa mô màu nâu sẫm, lá trên cành khô héo vàng nhưng vẫn dính chặt trên cành không rụng ngay.\n- Cành bị khô chết dần từ ngoài chóp cành thụt lùi vào thân chính (hiện tượng khô cành dieback). Chẻ đôi cành thấy phần mô gỗ bên trong bị thâm đen ăn sâu vào ruột gỗ.\n- Trên trái: Nấm xâm nhập qua vết cắt cuống hoặc vết chích của sâu rệp, làm cuống trái bị thâm đen, thối mềm từ cuống lan xuống vai trái khiến trái rụng non hàng loạt.",
                    'prevention' => "- Ngay sau khi cắt tỉa cành hoặc thu hoạch trái, bắt buộc phải quét ngay keo liền sẹo hoặc quét thuốc gốc Đồng, Mancozeb vào vết cắt để bịt kín cửa ngõ xâm nhập của nấm.\n- Phòng trừ triệt để sâu đục cành, xén tóc, rệp sáp và bọ vòi voi tạo vết thương trên cành nhánh.\n- Bón phân cân đối, bổ sung Canxi Bo và vi lượng giúp cành gỗ chắc khỏe dẻo dai, chống nứt vỏ khi thời tiết nắng mưa thất thường.",
                    'treatment'  => "- Dùng cưa hoặc kéo bén cắt bỏ toàn bộ đoạn cành bị khô chết sâu vào phần gỗ còn xanh tươi 10cm, mang ra xa vườn đốt tiêu hủy.\n- Bôi trực tiếp thuốc gốc Đồng đỏ Cuprous Oxide (Eddy 72WP), Copper Oxychloride (G.O.C 85) hoặc Difenoconazole vào vết cắt tỉa.\n- Phun phủ toàn bộ tán cây bằng Azoxystrobin + Difenoconazole (Asmiltatop Super) hoặc Mancozeb để tiêu diệt các sợi nấm tiềm ẩn trong mô cây.",
                ],
                'pesticides' => [
                    'EDDY 72WP HOPTRI 300GRA',
                    'G.O.C 85 Japan',
                    'ASMILTATOP SUPER 400SC',
                    'MANCOZEB 80WP 1KG',
                ],
            ],

            // 9. Nấm hồng - Bệnh trên cành/thân
            [
                'match_name' => 'Nấm hồng: Bệnh trên cành / thân sầu riêng',
                'aliases'    => ['Nấm hồng', 'Corticium salmonicolor'],
                'data'       => [
                    'name'       => 'Nấm hồng: Bệnh trên cành / thân sầu riêng',
                    'image'      => 'diseases/nam_hong.jpg',
                    'images'     => [
                        'diseases/nam_hong.jpg',
                    ],
                    'notes'      => 'Bệnh nấm hồng do nấm Corticium salmonicolor (Erythricium salmonicolor) gây hại cành và thân sầu riêng trong mùa mưa ẩm ướt.',
                    'symptoms'   => "- Giai đoạn đầu: Xuất hiện các sợi tơ nấm màu trắng bạc mịn như mạng nhện bò lan trên vỏ cành ở vị trí các chảng ba, chảng hai nơi râm mát ẩm thấp.\n- Giai đoạn phát triển: Mạng tơ chuyển thành lớp váng phấn dày màu hồng phấn hoặc đỏ cam nhạt bao bọc quanh chu vi cành cây.\n- Lớp vỏ cây bên dưới mảng nấm hồng bị thối mục khô nứt nẻ, mạch dẫn nhựa bị phá hủy hoàn toàn làm toàn bộ lá phía trên cành bị héo vàng và cành chết khô trơ trụi.",
                    'prevention' => "- Hàng năm sau thu hoạch, tiến hành cắt tỉa thông thoáng, dọn sạch cành tăm, cành sát mặt đất để ánh nắng chiếu rọi vào toàn bộ khung cành.\n- Quét vôi hoặc quét dung dịch Booc-đô, Đồng đỏ quanh gốc và các vị trí phân cành chính trước khi mùa mưa bắt đầu.\n- Tránh trồng cây với mật độ quá dày đặc làm ẩm độ trong vườn luôn ở mức bão hòa.",
                    'treatment'  => "- Cắt bỏ các cành nhỏ đã bị nấm ăn chết khô sâu dưới vết bệnh 10cm đem đốt tiêu hủy.\n- Với cành lớn: Dùng chổi cọ quét dung dịch thuốc đặc trị nấm hồng trực tiếp lên vết nấm (Hexaconazole, Validamycin hoặc Đồng đỏ pha đậm đặc).\n- Phun phủ toàn tán bằng Hexaconazole (Anvil 5SC, Japa Vil 110SC) kết hợp Mancozeb hoặc Đồng đỏ (Eddy 72WP) khi bệnh lây lan nhiều cành.",
                ],
                'pesticides' => [
                    'ANVIL SYNGENTA 5SC 1LIT',
                    'Japa Vil 110SC Monyka',
                    'EDDY 72WP HOPTRI 300GRA',
                    'G.O.C 85 Japan',
                ],
            ],
        ];

        foreach ($diseasesData as $item) {
            // Tìm bản ghi hiện có theo tên chính hoặc aliases
            $disease = Disease::where('name', $item['match_name'])->first();

            if (! $disease && ! empty($item['aliases'])) {
                foreach ($item['aliases'] as $alias) {
                    $found = Disease::where('name', $alias)->first();
                    if ($found) {
                        $disease = $found;
                        break;
                    }
                }
            }

            if (! $disease) {
                $disease = new Disease();
            }

            $disease->fill($item['data']);
            $disease->save();

            // Gán thuốc liên kết
            if (! empty($item['pesticides'])) {
                $pesticideIds = [];
                foreach ($item['pesticides'] as $pName) {
                    $p = Pesticide::where('name', 'like', "%{$pName}%")->first();
                    if ($p) {
                        $pesticideIds[] = $p->id;
                    }
                }
                if (! empty($pesticideIds)) {
                    $disease->pesticides()->sync(array_unique($pesticideIds));
                }
            }
        }
    }
}
