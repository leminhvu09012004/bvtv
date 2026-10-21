<?php

namespace App\Services;

use App\Models\Pesticide;
use Illuminate\Support\Collection;

class HoatChatService
{
    /**
     * Danh mục chuẩn hóa các Hoạt chất & Nhóm Hợp chất BVTV trong nông nghiệp.
     */
    protected array $catalog = [
    // === 1. THUỐC TRỪ BỆNH (FUNGICIDES & BACTERICIDES) ===
    [
        'key'         => 'cuprous_oxide',
        'name'        => 'Cuprous Oxide (Đồng đỏ)',
        'english_name'=> 'Cuprous Oxide',
        'group'       => 'Gốc Đồng (Inorganic Copper)',
        'type'        => 'Trừ bệnh',
        'code'        => 'FRAC M01',
        'action'      => 'Tiếp xúc đa điểm, sát khuẩn cực mạnh, tiêu diệt bào tử nấm và vi khuẩn, rửa sạch rong rêu nấm hồng thân cành.',
        'patterns'    => ['cuprous oxide', 'đồng đỏ', 'eddy', 'nordox', 'norshield', 'norshied'],
    ],
    [
        'key'         => 'copper_oxychloride',
        'name'        => 'Copper Oxychloride',
        'english_name'=> 'Copper Oxychloride',
        'group'       => 'Gốc Đồng (Inorganic Copper)',
        'type'        => 'Trừ bệnh',
        'code'        => 'FRAC M01',
        'action'      => 'Bảo vệ bề mặt, phóng thích ion Cu2+ phá hủy màng tế bào nấm, đặc trị ghẻ sẹo, thán thư, rỉ sắt, xì mủ.',
        'patterns'    => ['copper oxychloride', 'coc 85', 'goc 85', 'g.o.c 85'],
    ],
    [
        'key'         => 'copper_chelate',
        'name'        => 'Đồng hữu cơ & Nano Đồng (Copper Chelate)',
        'english_name'=> 'Copper Chelate / Nano Copper',
        'group'       => 'Hợp chất Đồng hữu cơ',
        'type'        => 'Trừ bệnh & Rửa vườn',
        'code'        => 'FRAC M01',
        'action'      => 'Đồng dạng chelate hấp thụ nhanh, sát khuẩn vết bệnh không gây nóng hoa nóng trái, tẩy sạch rong rêu xanh cây.',
        'patterns'    => ['đồng xanh', 'nano đồng', 'đồng hữu cơ', 'chelate đồng'],
    ],
    [
        'key'         => 'mancozeb',
        'name'        => 'Mancozeb',
        'english_name'=> 'Mancozeb',
        'group'       => 'Nhóm Dithiocarbamate',
        'type'        => 'Trừ bệnh',
        'code'        => 'FRAC M03',
        'action'      => 'Tiếp xúc bảo vệ bề mặt đa điểm, ngăn cản sự nảy mầm bào tử nấm, tạo lớp màng bám dính xanh cây chống rửa trôi.',
        'patterns'    => ['mancozeb'],
    ],
    [
        'key'         => 'propineb',
        'name'        => 'Propineb (Áo giáp Kẽm)',
        'english_name'=> 'Propineb (Zinc Dithiocarbamate)',
        'group'       => 'Nhóm Dithiocarbamate',
        'type'        => 'Trừ bệnh',
        'code'        => 'FRAC M03',
        'action'      => 'Bổ sung Kẽm (Zinc++) tạo lớp áo giáp bảo vệ mặt lá, ức chế enzyme hô hấp nấm, trị thán thư, đốm lá, rỉ sắt.',
        'patterns'    => ['propineb', 'nofacol', 'antracol'],
    ],
    [
        'key'         => 'dimethomorph',
        'name'        => 'Dimethomorph',
        'english_name'=> 'Dimethomorph',
        'group'       => 'Nhóm Cinnamic Acid Amides (CAA)',
        'type'        => 'Trừ bệnh',
        'code'        => 'FRAC 40',
        'action'      => 'Nội hấp lưu dẫn mạnh, ức chế sinh tổng hợp phospholipid và thành tế bào nấm Oomycetes, đặc trị sương mai, nứt thân xì mủ.',
        'patterns'    => ['dimethomorph', 'dimethor', 'phytocide', 'lumordie'],
    ],
    [
        'key'         => 'fosetyl_aluminium',
        'name'        => 'Fosetyl-aluminium',
        'english_name'=> 'Fosetyl-aluminium',
        'group'       => 'Nhóm Phosphonate / Kích kháng',
        'type'        => 'Trừ bệnh',
        'code'        => 'FRAC P07',
        'action'      => 'Lưu dẫn 2 chiều cực mạnh rễ ⇄ lá, kích hoạt hệ thống miễn dịch tự nhiên (phytoalexin) của cây trồng chống Phytophthora.',
        'patterns'    => ['fosetyl', 'aliette', 'anlien'],
    ],
    [
        'key'         => 'potassium_phosphonate',
        'name'        => 'Potassium Phosphonate (Lân 2 chiều)',
        'english_name'=> 'Mono & Di-potassium Phosphonates',
        'group'       => 'Nhóm Phosphonate / Kích kháng',
        'type'        => 'Trừ bệnh',
        'code'        => 'FRAC P07',
        'action'      => 'Lưu dẫn 2 chiều rễ - ngọn, làm dày vách tế bào, kích kháng chủ động cô lập vết nứt thân xì mủ, thối rễ Phytophthora.',
        'patterns'    => ['phosphonate', 'phosphorous', 'delta fos', 'spray gro', 'agri-fos', 'agrifos'],
    ],
    [
        'key'         => 'fluopicolide',
        'name'        => 'Fluopicolide',
        'english_name'=> 'Fluopicolide',
        'group'       => 'Nhóm Acylpicolide',
        'type'        => 'Trừ bệnh',
        'code'        => 'FRAC 43',
        'action'      => 'Phá vỡ cấu trúc protein phổ thông của nấm Oomycetes, diệt bào tử chuyển động và ức chế nảy mầm nấm Phytophthora.',
        'patterns'    => ['fluopicolide', 'profiler'],
    ],
    [
        'key'         => 'metalaxyl',
        'name'        => 'Metalaxyl / Metalaxyl-M',
        'english_name'=> 'Metalaxyl / Mefenoxam',
        'group'       => 'Nhóm Phenylamides: Acylalanines',
        'type'        => 'Trừ bệnh',
        'code'        => 'FRAC 04',
        'action'      => 'Nội hấp và lưu dẫn 2 chiều cực mạnh, ức chế tổng hợp RNA nấm đất Oomycetes, đặc trị nứt thân xì mủ, thối rễ, chết nhanh.',
        'patterns'    => ['metalaxyl', 'mefenoxam', 'karoke', 'ridomil'],
    ],
    [
        'key'         => 'hexaconazole',
        'name'        => 'Hexaconazole',
        'english_name'=> 'Hexaconazole',
        'group'       => 'Nhóm Triazole (DMI)',
        'type'        => 'Trừ bệnh',
        'code'        => 'FRAC 3',
        'action'      => 'Nội hấp, thấm sâu nhanh qua mô lá, ức chế khử methyl C14 trong sinh tổng hợp ergosterol, trị nấm hồng, rỉ sắt, lem lép hạt.',
        'patterns'    => ['hexaconazole', 'anvil', 'japa vil', 'japavil'],
    ],
    [
        'key'         => 'difenoconazole',
        'name'        => 'Difenoconazole',
        'english_name'=> 'Difenoconazole',
        'group'       => 'Nhóm Triazole (DMI)',
        'type'        => 'Trừ bệnh',
        'code'        => 'FRAC 3',
        'action'      => 'Nội hấp lưu dẫn sâu trong mô biểu bì, ức chế sinh tổng hợp ergosterol màng tế bào nấm, đặc trị đốm lá, thán thư, phấn trắng.',
        'patterns'    => ['difenoconazole'],
    ],
    [
        'key'         => 'propiconazole',
        'name'        => 'Propiconazole',
        'english_name'=> 'Propiconazole',
        'group'       => 'Nhóm Triazole (DMI)',
        'type'        => 'Trừ bệnh',
        'code'        => 'FRAC 3',
        'action'      => 'Lưu dẫn phổ rộng, đặc trị nấm rỉ sắt, lem lép hạt, nấm hồng và khô vằn trên nhiều loại cây trồng.',
        'patterns'    => ['propiconazole', 'tilt super'],
    ],
    [
        'key'         => 'tebuconazole',
        'name'        => 'Tebuconazole',
        'english_name'=> 'Tebuconazole',
        'group'       => 'Nhóm Triazole (DMI)',
        'type'        => 'Trừ bệnh',
        'code'        => 'FRAC 3',
        'action'      => 'Nội hấp mạnh, ức chế tổng hợp màng tế bào nấm, phòng trị thán thư, đốm mắt cua, rỉ sắt, thối quả.',
        'patterns'    => ['tebuconazole', 'tebaz'],
    ],
    [
        'key'         => 'azoxystrobin',
        'name'        => 'Azoxystrobin',
        'english_name'=> 'Azoxystrobin',
        'group'       => 'Nhóm Strobilurin (QoI)',
        'type'        => 'Trừ bệnh',
        'code'        => 'FRAC 11',
        'action'      => 'Ức chế quá trình hô hấp ty thể của tế bào nấm, tạo hiệu ứng xanh cây, bóng lá, nâng cao năng suất.',
        'patterns'    => ['azoxystrobin', 'asmiltatop', 'tebaz'],
    ],
    [
        'key'         => 'pyraclostrobin',
        'name'        => 'Pyraclostrobin',
        'english_name'=> 'Pyraclostrobin',
        'group'       => 'Nhóm Strobilurin (QoI)',
        'type'        => 'Trừ bệnh',
        'code'        => 'FRAC 11',
        'action'      => 'Ức chế chuỗi truyền điện tử trong ty thể nấm, bám dính mô biểu bì cực lâu, tạo hiệu ứng F500 xanh bóng lá mượt quả.',
        'patterns'    => ['pyraclostrobin', 'headline'],
    ],
    [
        'key'         => 'famoxadone',
        'name'        => 'Famoxadone',
        'english_name'=> 'Famoxadone',
        'group'       => 'Nhóm Oxazolidinedione (QoI)',
        'type'        => 'Trừ bệnh',
        'code'        => 'FRAC 11',
        'action'      => 'Ức chế hô hấp ty thể tế bào nấm, tạo màng liên kết lipid sáp bám dính kháng mưa tuyệt hảo.',
        'patterns'    => ['famoxadone', 'zorvec'],
    ],
    [
        'key'         => 'oxathiapiprolin',
        'name'        => 'Oxathiapiprolin',
        'english_name'=> 'Oxathiapiprolin',
        'group'       => 'Nhóm Piperidinyl Thiazole Isoxazoline',
        'type'        => 'Trừ bệnh',
        'code'        => 'FRAC 49',
        'action'      => 'Ức chế protein gắn kết oxysterol (OSBP) trong tế bào nấm Oomycetes, hiệu lực cực cao ở liều siêu nhỏ.',
        'patterns'    => ['oxathiapiprolin', 'zorvec'],
    ],
    [
        'key'         => 'fluazinam',
        'name'        => 'Fluazinam',
        'english_name'=> 'Fluazinam',
        'group'       => 'Nhóm 2,6-Dinitroaniline',
        'type'        => 'Trừ bệnh',
        'code'        => 'FRAC 29',
        'action'      => 'Phá vỡ quá trình phosphoryl hóa ty thể tế bào nấm, đặc trị nứt thân xì mủ, thối quả, giả sương mai, kháng mưa siêu đẳng.',
        'patterns'    => ['fluazinam', 'shonam'],
    ],
    [
        'key'         => 'fluopyram',
        'name'        => 'Fluopyram',
        'english_name'=> 'Fluopyram',
        'group'       => 'Nhóm SDHI (Succinate Dehydrogenase Inhibitor)',
        'type'        => 'Trừ tuyến trùng & Nấm',
        'code'        => 'FRAC 7',
        'action'      => 'Ức chế phức hợp II chuỗi hô hấp tế bào, gây tê liệt ấu trùng tuyến trùng rễ và tiêu diệt nấm đất gây hại.',
        'patterns'    => ['fluopyram', 'velum prime'],
    ],
    [
        'key'         => 'ethaboxam',
        'name'        => 'Ethaboxam',
        'english_name'=> 'Ethaboxam',
        'group'       => 'Nhóm Thiazole Carboxamide',
        'type'        => 'Trừ bệnh',
        'code'        => 'FRAC 22',
        'action'      => 'Gắn vào beta-tubulin ức chế phân bào của nấm Oomycetes, công nghệ tiên tiến đặc trị thối rễ Phytophthora và Pythium.',
        'patterns'    => ['ethaboxam', 'danjiri'],
    ],
    [
        'key'         => 'kasugamycin',
        'name'        => 'Kasugamycin',
        'english_name'=> 'Kasugamycin',
        'group'       => 'Kháng sinh Hexopyranosyl',
        'type'        => 'Trừ bệnh & Vi khuẩn',
        'code'        => 'FRAC 24',
        'action'      => 'Kháng sinh nội hấp, ức chế sinh tổng hợp protein của vi khuẩn và nấm, đặc trị cháy bìa lá, thối nhũn, đốm lá.',
        'patterns'    => ['kasugamycin', 'kasugacin'],
    ],
    [
        'key'         => 'validamycin',
        'name'        => 'Validamycin A',
        'english_name'=> 'Validamycin A',
        'group'       => 'Kháng sinh Glucopyranosyl',
        'type'        => 'Trừ bệnh sinh học',
        'code'        => 'FRAC 26',
        'action'      => 'Ức chế enzym trehalase làm nấm mất nước và teo tóp, đặc trị nấm Rhizoctonia solani gây lở cổ rễ, đốm vằn, chết thắt cây.',
        'patterns'    => ['validamycin', 'validacin'],
    ],
    [
        'key'         => 'ningnanmycin',
        'name'        => 'Ningnanmycin',
        'english_name'=> 'Ningnanmycin',
        'group'       => 'Kháng sinh Pyrimidine Nucleoside',
        'type'        => 'Trừ bệnh & Vi khuẩn',
        'code'        => 'FRAC 25/43',
        'action'      => 'Ức chế tổng hợp protein virus/vi khuẩn và phá vỡ vách sợi nấm, đặc trị héo xanh vi khuẩn, đốm lá, lở cổ rễ.',
        'patterns'    => ['ningnanmycin', 'bacolinh'],
    ],
    [
        'key'         => 'trichoderma',
        'name'        => 'Vi nấm đối kháng Trichoderma spp.',
        'english_name'=> 'Trichoderma spp. Antagonist',
        'group'       => 'Vi sinh vật đối kháng (Biologicals)',
        'type'        => 'Vi sinh trừ bệnh',
        'code'        => 'Bio-Fungicide',
        'action'      => 'Ký sinh, tiết enzym phân giải vách tế bào nấm hại (Phytophthora, Fusarium, Rhizoctonia) và kích thích hệ vi sinh vật có ích vùng rễ.',
        'patterns'    => ['trichoderma'],
    ],
    [
        'key'         => 'bio_beneficial_microbes',
        'name'        => 'Phức hợp Vi sinh đối kháng (Bacillus + Streptomyces + Metarhizium)',
        'english_name'=> 'Multi-Microbial Consortium',
        'group'       => 'Vi sinh vật có ích (Biologicals)',
        'type'        => 'Vi sinh trị tuyến trùng & Nấm',
        'code'        => 'Bio-Consortium',
        'action'      => 'Ký sinh ức chế tuyến trùng u sưng rễ, tiêu diệt nấm đất gây hại, bảo vệ rễ non khỏe mạnh.',
        'patterns'    => ['bacillus', 'streptomyces', 'tuyến trùng'],
    ],
    [
        'key'         => 'tay_rong_reu',
        'name'        => 'Hợp chất Tẩy rong rêu & Sát khuẩn sinh học',
        'english_name'=> 'Bio Mineral Bark Cleanser',
        'group'       => 'Sát khuẩn & Vệ sinh vườn',
        'type'        => 'Rửa cành & Rong rêu',
        'code'        => 'Sanitizer',
        'action'      => 'Làm bong tróc mảng bám rong rêu, địa y, tảo đỏ trên vỏ cành thân cây, sát khuẩn vết thương bề mặt.',
        'patterns'    => ['chất tẩy rong rêu', 'rửa cành monyka'],
    ],

    // === 2. THUỐC TRỪ SÂU - RẦY - RỆP - NHỆN (INSECTICIDES & ACARICIDES) ===
    [
        'key'         => 'thiamethoxam',
        'name'        => 'Thiamethoxam',
        'english_name'=> 'Thiamethoxam',
        'group'       => 'Nhóm Neonicotinoid (nAChR)',
        'type'        => 'Trừ sâu - rầy',
        'code'        => 'IRAC 4A',
        'action'      => 'Nội hấp lưu dẫn cực mạnh hướng ngọn, liên kết thụ thể nAChR gây tê liệt thần kinh, đặc trị rầy xanh, bọ trĩ, rầy phấn trắng.',
        'patterns'    => ['thiamethoxam', 'nofara'],
    ],
    [
        'key'         => 'imidacloprid',
        'name'        => 'Imidacloprid',
        'english_name'=> 'Imidacloprid',
        'group'       => 'Nhóm Neonicotinoid (nAChR)',
        'type'        => 'Trừ sâu - rầy',
        'code'        => 'IRAC 4A',
        'action'      => 'Lưu dẫn nội hấp mạnh, tác động lên hệ thần kinh côn trùng chích hút, đặc trị rầy nâu, rầy mềm, bọ trĩ kháng thuốc.',
        'patterns'    => ['imidacloprid', 'thần địch trùng', 'womida', 'confidor'],
    ],
    [
        'key'         => 'acetamiprid',
        'name'        => 'Acetamiprid',
        'english_name'=> 'Acetamiprid',
        'group'       => 'Nhóm Neonicotinoid (nAChR)',
        'type'        => 'Trừ sâu - rầy',
        'code'        => 'IRAC 4A',
        'action'      => 'Thấm sâu nhanh, hạ gục chớp nhoáng rầy nhảy, bọ trĩ, rệp sáp, an toàn tương đối cho thiên địch và hoa non.',
        'patterns'    => ['acetamiprid', 'thần chớp', 'mospilan'],
    ],
    [
        'key'         => 'dinotefuran',
        'name'        => 'Dinotefuran',
        'english_name'=> 'Dinotefuran',
        'group'       => 'Nhóm Neonicotinoid (Thế hệ 3 Furanic)',
        'type'        => 'Trừ chích hút',
        'code'        => 'IRAC 4A',
        'action'      => 'Hấp thụ siêu tốc qua mô biểu bì, đánh gục lập tức rầy xanh, bọ trĩ, rệp dính ngay sau khi trúng thuốc.',
        'patterns'    => ['dinotefuran', 'tề thiên'],
    ],
    [
        'key'         => 'spirotetramat',
        'name'        => 'Spirotetramat',
        'english_name'=> 'Spirotetramat',
        'group'       => 'Nhóm Ketoenol / Tetramic acid',
        'type'        => 'Trừ chích hút & Rệp sáp',
        'code'        => 'IRAC 23',
        'action'      => 'Lưu dẫn 2 chiều duy nhất di chuyển cả mạch gỗ và mạch rây, ức chế tổng hợp lipid diệt triệt để rệp sáp, bọ phấn trắng tận ngọn và rễ.',
        'patterns'    => ['spirotetramat', 'movento'],
    ],
    [
        'key'         => 'chlorfenapyr',
        'name'        => 'Chlorfenapyr',
        'english_name'=> 'Chlorfenapyr',
        'group'       => 'Nhóm Pyrrole',
        'type'        => 'Trừ sâu kháng thuốc',
        'code'        => 'IRAC 13',
        'action'      => 'Ức chế sản sinh ATP ty thể tế bào côn trùng, công phá triệt để sâu đục thân, sâu đục trái, sâu tơ kháng thuốc.',
        'patterns'    => ['chlorfenapyr'],
    ],
    [
        'key'         => 'abamectin',
        'name'        => 'Abamectin',
        'english_name'=> 'Abamectin',
        'group'       => 'Nhóm Avermectin (Sinh học)',
        'type'        => 'Trừ sâu & Nhện sinh học',
        'code'        => 'IRAC 6',
        'action'      => 'Kích hoạt kênh ion Clo gây tê liệt thần kinh côn trùng và nhện hại, thấm sâu mô lá nhanh, diệt bọ trĩ, nhện đỏ, sâu cuốn lá.',
        'patterns'    => ['abamectin', 'resgant', 'reasgant'],
    ],
    [
        'key'         => 'emamectin_benzoate',
        'name'        => 'Emamectin benzoate',
        'english_name'=> 'Emamectin Benzoate',
        'group'       => 'Nhóm Avermectin (Sinh học)',
        'type'        => 'Trừ sâu sinh học',
        'code'        => 'IRAC 6',
        'action'      => 'Hoạt chất sinh học thế hệ mới với hiệu lực gấp nhiều lần Abamectin, diệt nhanh sâu xanh, sâu đục trái, bọ trĩ.',
        'patterns'    => ['emamectin', 'emaproza'],
    ],
    [
        'key'         => 'carbosulfan',
        'name'        => 'Carbosulfan',
        'english_name'=> 'Carbosulfan',
        'group'       => 'Nhóm Carbamate',
        'type'        => 'Trừ sâu - rầy',
        'code'        => 'IRAC 1A',
        'action'      => 'Nội hấp, xông hơi và vị độc, ức chế enzyme acetylcholinesterase, hạ gục sâu đục thân, mọt đục cành, rầy nâu tức thì.',
        'patterns'    => ['carbosulfan', 'afudan'],
    ],
    [
        'key'         => 'fenobucarb',
        'name'        => 'Fenobucarb',
        'english_name'=> 'Fenobucarb',
        'group'       => 'Nhóm Carbamate',
        'type'        => 'Trừ rầy - chích hút',
        'code'        => 'IRAC 1A',
        'action'      => 'Tiếp xúc và xông hơi cực mạnh, đánh gục rầy nâu, rầy xanh, bọ xít muỗi chỉ trong vài phút sau phun.',
        'patterns'    => ['fenobucarb', 'basa'],
    ],
    [
        'key'         => 'cartap',
        'name'        => 'Cartap Hydrochloride',
        'english_name'=> 'Cartap Hydrochloride',
        'group'       => 'Nhóm Nereistoxin',
        'type'        => 'Trừ sâu hại',
        'code'        => 'IRAC 14',
        'action'      => 'Phong bế synap cholinergic, làm sâu ngừng ăn ngay lập tức và chết rũ, đặc trị sâu đục thân, sâu đục trái sầu riêng.',
        'patterns'    => ['cartap', 'ledan'],
    ],
    [
        'key'         => 'thiosultap_sodium',
        'name'        => 'Thiosultap-sodium (Nereistoxin)',
        'english_name'=> 'Thiosultap-sodium',
        'group'       => 'Nhóm Nereistoxin',
        'type'        => 'Trừ sâu hại',
        'code'        => 'IRAC 14',
        'action'      => 'Tiếp xúc, vị độc và nội hấp cực mạnh, diệt trừ hữu hiệu sâu đục thân, rầy rệp, bọ trĩ.',
        'patterns'    => ['thiosultap', 'padang'],
    ],
    [
        'key'         => 'profenofos',
        'name'        => 'Profenofos',
        'english_name'=> 'Profenofos',
        'group'       => 'Nhóm Lân hữu cơ (Organophosphate)',
        'type'        => 'Trừ sâu - rệp sáp',
        'code'        => 'IRAC 1B',
        'action'      => 'Tiếp xúc, vị độc, xông hơi và thấm sâu cực nhanh, hạ gục chớp nhoáng sâu đục trái, rệp sáp, mọt đục cành.',
        'patterns'    => ['profenofos', 'dragon', 'vovatox', 'thpro'],
    ],
    [
        'key'         => 'prothiofos',
        'name'        => 'Prothiofos',
        'english_name'=> 'Prothiofos',
        'group'       => 'Nhóm Lân hữu cơ (Organophosphate)',
        'type'        => 'Trừ rệp sáp & Sâu hại',
        'code'        => 'IRAC 1B',
        'action'      => 'Lân hữu cơ thế hệ mới ít mùi hơn, diệt trừ hữu hiệu rệp sáp dính, rệp sáp mềm và ấu trùng sâu ẩn sâu khe cành.',
        'patterns'    => ['prothiofos', 'sheba'],
    ],
    [
        'key'         => 'cypermethrin',
        'name'        => 'Cypermethrin',
        'english_name'=> 'Cypermethrin',
        'group'       => 'Nhóm Cúc tổng hợp (Pyrethroid)',
        'type'        => 'Trừ sâu',
        'code'        => 'IRAC 3A',
        'action'      => 'Tác động lên kênh ion Natri sợi thần kinh, hạ gục chớp nhoáng các loài sâu ăn lá, sâu cuốn lá, bọ xít.',
        'patterns'    => ['cypermethrin'],
    ],
    [
        'key'         => 'permethrin',
        'name'        => 'Permethrin',
        'english_name'=> 'Permethrin',
        'group'       => 'Nhóm Cúc tổng hợp (Pyrethroid)',
        'type'        => 'Trừ sâu',
        'code'        => 'IRAC 3A',
        'action'      => 'Hạ gục nhanh sâu hại, phổ tác động rộng trên nhiều loại cây trồng và rau màu.',
        'patterns'    => ['permethrin', 'fullkill'],
    ],
    [
        'key'         => 'lambda_cyhalothrin',
        'name'        => 'Lambda-Cyhalothrin',
        'english_name'=> 'Lambda-Cyhalothrin',
        'group'       => 'Nhóm Cúc tổng hợp (Pyrethroid)',
        'type'        => 'Trừ sâu - rầy',
        'code'        => 'IRAC 3A',
        'action'      => 'Cúc thế hệ mới có hoạt lực cực mạnh ở liều cực thấp, hạ gục nhanh bọ trĩ, sâu đục cành, sâu khoang.',
        'patterns'    => ['lambda-cyhalothrin', 'riegenf'],
    ],
    [
        'key'         => 'etoxazole',
        'name'        => 'Etoxazole',
        'english_name'=> 'Etoxazole',
        'group'       => 'Nhóm Diphenyloxazoline',
        'type'        => 'Trừ nhện & Ung trứng',
        'code'        => 'IRAC 10B',
        'action'      => 'Ức chế tổng hợp chitin làm ung trứng nhện và tiêu diệt ấu trùng nhện đỏ, nhện vàng, cắt đứt hoàn toàn vòng đời nhện.',
        'patterns'    => ['etoxazole', 'nhện chúa', 'beered', 'sachnhen'],
    ],
    [
        'key'         => 'spirodiclofen',
        'name'        => 'Spirodiclofen',
        'english_name'=> 'Spirodiclofen',
        'group'       => 'Nhóm Tetronic acid',
        'type'        => 'Trừ nhện hại',
        'code'        => 'IRAC 23',
        'action'      => 'Ức chế sinh tổng hợp lipid, diệt sạch mọi giai đoạn phát triển của nhện đỏ, nhện lông nhung đã kháng thuốc.',
        'patterns'    => ['spirodiclofen', 'nhện đỏ cạp'],
    ],
    [
        'key'         => 'fenbutatin_oxide',
        'name'        => 'Fenbutatin Oxide',
        'english_name'=> 'Fenbutatin Oxide',
        'group'       => 'Nhóm Thiếc hữu cơ (Organotin)',
        'type'        => 'Trừ nhện hại',
        'code'        => 'IRAC 12B',
        'action'      => 'Ức chế tổng hợp ATP ty thể của nhện, chuyên trị các dòng nhện đỏ đã kháng thuốc hóa học khác, hiệu lực kéo dài 3-4 tuần.',
        'patterns'    => ['fenbutatin', 'nilmite'],
    ],

    // === 3. DINH DƯỠNG & ĐIỀU HÒA SINH TRƯỞNG (PLANT NUTRITION & BIOSTIMULANTS) ===
    [
        'key'         => 'amino_acids',
        'name'        => 'Axit Amin tự do (Amino Acids thực vật & cá biển)',
        'english_name'=> 'Free Amino Acids (Plant & Marine Peptides)',
        'group'       => 'Axit Amin Sinh học',
        'type'        => 'Dinh dưỡng sinh học',
        'code'        => 'Bio-Amino',
        'action'      => 'Cung cấp trực tiếp các phân tử axit amin xây dựng protein tế bào, giúp mát bông mát trái, giải độc phèn mặn và sốc thời tiết.',
        'patterns'    => ['amino', 'axit amin', 'xanh um'],
    ],
    [
        'key'         => 'seaweed_extract',
        'name'        => 'Chiết xuất Rong biển (Seaweed / Tảo nâu Sargassum)',
        'english_name'=> 'Seaweed Extract (Ascophyllum & Sargassum)',
        'group'       => 'Chiết xuất Rong tảo biển',
        'type'        => 'Dinh dưỡng sinh học',
        'code'        => 'Bio-Seaweed',
        'action'      => 'Chứa Alginic acid và khoáng vi lượng đại dương giúp hạ nhiệt tán lá, mát cây, tăng đậu trái, chống rụng hoa và trái non.',
        'patterns'    => ['rong biển', 'seaweed', 'sargassum', 'innozim'],
    ],
    [
        'key'         => 'humic_fulvic_acid',
        'name'        => 'Axit Humic & Fulvic (Kích rễ & Cải tạo đất)',
        'english_name'=> 'Humic & Fulvic Acids',
        'group'       => 'Hợp chất Humic sinh học',
        'type'        => 'Dinh dưỡng kích rễ',
        'code'        => 'Bio-Humic',
        'action'      => 'Kích thích tái tạo hệ rễ tơ bung trắng, giải độc hữu cơ và phèn mặn, tăng dung tích hấp thu dưỡng chất của đất.',
        'patterns'    => ['humic', 'fulvic', 'roots'],
    ],
    [
        'key'         => 'boron_chelate',
        'name'        => 'Bo hữu cơ (Boron / Bo Chelate)',
        'english_name'=> 'Organic Boron / Boron Chelate',
        'group'       => 'Dinh dưỡng Vi lượng',
        'type'        => 'Vi lượng Bo',
        'code'        => 'Micro-Boron',
        'action'      => 'Tăng cường sức sống hạt phấn, tăng tỷ lệ thụ phấn đậu trái, dai cuống, chống rụng hoa và rụng trái non sinh lý.',
        'patterns'    => ['bo 150.000', 'boyello', 'boron', 'bo hữu cơ'],
    ],
    [
        'key'         => 'zinc_chelate',
        'name'        => 'Kẽm Chelate (Zn-EDTA)',
        'english_name'=> 'Chelated Zinc (Zn-EDTA)',
        'group'       => 'Dinh dưỡng Vi lượng',
        'type'        => 'Vi lượng Kẽm',
        'code'        => 'Micro-Zinc',
        'action'      => 'Kích hoạt enzym tổng hợp auxin, khắc phục triệt để bệnh vàng lá gân xanh, giúp dày lá, xanh lá, mở lá nhanh.',
        'patterns'    => ['kẽm edta', 'siêu kẽm gold', 'zn-edta', 'kẽm (zn)'],
    ],
    [
        'key'         => 'calcium_boron',
        'name'        => 'Canxi - Bo (CanxiBo EDTA / Bo Sữa)',
        'english_name'=> 'Calcium & Boron Complex',
        'group'       => 'Dinh dưỡng Trung - Vi lượng',
        'type'        => 'Trung vi lượng',
        'code'        => 'Meso-Micro',
        'action'      => 'Làm dày vách tế bào, dẻo dai cuống trái, chống nứt trái nứt gai sầu riêng, hạn chế thối đít trái.',
        'patterns'    => ['canxibo', 'cabo', 'canxi bo', 'canxinitrat'],
    ],
    [
        'key'         => 'magnesium_chelate',
        'name'        => 'Magie Chelate & MgSO4 (Magiê)',
        'english_name'=> 'Magnesium Chelate & MgSO4',
        'group'       => 'Dinh dưỡng Trung lượng',
        'type'        => 'Trung lượng Magie',
        'code'        => 'Meso-Mg',
        'action'      => 'Trung tâm của nhân chất diệp lục, tăng cường hiệu suất quang hợp, giúp lá xanh dày bóng mượt, chống cháy chóp lá.',
        'patterns'    => ['mage kẽm', 'mgo - kẽm', 'mgso4', 'magnesium'],
    ],
    [
        'key'         => 'combi_micronutrients',
        'name'        => 'Phức hợp Đa Vi lượng Chelate Combi (Fe, Mn, Zn, Cu, B, Mo)',
        'english_name'=> 'Multi-Micronutrients Chelate (Combi BM / Great 8)',
        'group'       => 'Dinh dưỡng Vi lượng Chelate',
        'type'        => 'Đa vi lượng',
        'code'        => 'Micro-Combi',
        'action'      => 'Cung cấp đầy đủ các nguyên tố vi lượng thiết yếu dạng chelate 100% hòa tan, ngăn ngừa vàng lá biến dạng đọt non.',
        'patterns'    => ['combi edta', 'combi bm', 'great 8', 'f8 edta', 'tvl-monyka'],
    ],
    [
        'key'         => 'calcium_starfish',
        'name'        => 'Canxi hữu cơ chiết xuất Sao Biển (Vinco79)',
        'english_name'=> 'Organic Starfish Calcium',
        'group'       => 'Canxi Sinh học hữu cơ',
        'type'        => 'Dinh dưỡng sinh học',
        'code'        => 'Bio-Calcium',
        'action'      => 'Canxi hữu cơ mát cây hấp thụ cực nhanh, tăng độ cứng cáp của mô biểu bì, chống rụng hoa và nứt cuống.',
        'patterns'    => ['vinco79', 'sao biển'],
    ],
    [
        'key'         => 'n3m_root_stimulant',
        'name'        => 'Hợp chất Kích rễ N3M (N-P-K + Vi lượng Chelate)',
        'english_name'=> 'N3M Root Stimulant Complex',
        'group'       => 'Dinh dưỡng Kích rễ chuyên sâu',
        'type'        => 'Kích rễ cành chiết',
        'code'        => 'Root-Stim',
        'action'      => 'Kích thích ra rễ cực mạnh cho cây con, cành giâm, cành chiết, phục hồi bộ rễ sau ngập úng.',
        'patterns'    => ['n3m'],
    ],
    [
        'key'         => 'plant_enzymes',
        'name'        => 'Enzyme thực vật hữu cơ (MultiAgro)',
        'english_name'=> 'Plant Bio-Enzymes',
        'group'       => 'Enzyme Sinh học',
        'type'        => 'Dinh dưỡng sinh học',
        'code'        => 'Bio-Enzymes',
        'action'      => 'Enzyme thực vật lên men hấp thụ siêu nhanh, hỗ trợ chuyển hóa dinh dưỡng và tăng sức sống cây.',
        'patterns'    => ['weyzym', 'innozim', 'enzym'],
    ],
    [
        'key'         => 'wound_healing_polymer',
        'name'        => 'Polymer bọc vết thương & Vi lượng liền sẹo (Keo Mỹ Tiến)',
        'english_name'=> 'Tree Wound Healing Polymer',
        'group'       => 'Bảo vệ vết cắt thân cành',
        'type'        => 'Keo liền sẹo',
        'code'        => 'Wound-Seal',
        'action'      => 'Tạo màng che phủ bảo vệ vết cắt tỉa cành, ngăn nước mưa và nấm khuẩn xâm nhập, kích thích sinh mô sẹo nhanh lành.',
        'patterns'    => ['keo lien da', 'keo liền da', 'mỹ tiến'],
    ],
    [
        'key'         => 'silicone_surfactant',
        'name'        => 'Chất trợ lực Loang trải Siêu thấm (Silicone Copolymer)',
        'english_name'=> 'Organosilicone Super-Spreader',
        'group'       => 'Chất trợ lực & Bám dính',
        'type'        => 'Trợ lực BVTV',
        'code'        => 'Surfactant',
        'action'      => 'Phá vỡ sức căng bề mặt giọt nước, giúp thuốc lan tỏa cực nhanh và loang đều hai mặt lá, chống rửa trôi khi trời mưa.',
        'patterns'    => ['loang trải', 'siêu thấm', 'polyether polymethylsiloxane'],
    ],
    [
        'key'         => 'sea_ginseng_extract',
        'name'        => 'Chiết xuất Mốc sâm biển (Monyka)',
        'english_name'=> 'Sea Ginseng Bio-Extract',
        'group'       => 'Chiết xuất Sinh học quý hiếm',
        'type'        => 'Dinh dưỡng sinh học',
        'code'        => 'Bio-Ginseng',
        'action'      => 'Giàu vi chất khoáng hiếm đại dương và acid amin tự nhiên, giúp dày phiến lá, xanh bóng đọt, dưỡng trái lớn tròn đều.',
        'patterns'    => ['mốc sâm', 'mọc sâm', 'moc sam'],
    ],
    [
        'key'         => 'gibberellic_acid',
        'name'        => 'Gibberellic Acid (GA3)',
        'english_name'=> 'Gibberellic Acid (GA3)',
        'group'       => 'Điều hòa sinh trưởng (Gibberellin)',
        'type'        => 'Kích thích sinh trưởng',
        'code'        => 'PGR-GA3',
        'action'      => 'Kích thích kéo dài lóng, vọt đọt nhanh, tăng kích thước trái và kéo dài cuống hoa.',
        'patterns'    => ['gibberellic', 'egibo', 'ga3'],
    ],
    [
        'key'         => 'auxin_alpha_naa',
        'name'        => 'Auxin (Alpha-NAA)',
        'english_name'=> 'Alpha-Naphthyl Acetic Acid (NAA)',
        'group'       => 'Điều hòa sinh trưởng (Auxin)',
        'type'        => 'Kích hoa & Giữ trái',
        'code'        => 'PGR-Auxin',
        'action'      => 'Điều khiển phân hóa mầm hoa, kích thích ra hoa đồng loạt, chống rụng cuống trái non.',
        'patterns'    => ['alpha-naa', 'auxin 18', 'flower 95', 'naa'],
    ],
    [
        'key'         => 'sodium_nitrophenolate',
        'name'        => 'Sodium Nitrophenolate (Atonik sinh học)',
        'english_name'=> 'Sodium Nitrophenolate',
        'group'       => 'Điều hòa sinh trưởng (Nitro-phenolate)',
        'type'        => 'Kích hoạt sinh trưởng',
        'code'        => 'PGR-Bio',
        'action'      => 'Thúc đẩy dòng chảy chất nguyên sinh tế bào thực vật, kích thích nảy mầm, ra rễ, phục hồi sinh lực cây.',
        'patterns'    => ['nitrophenolate', 'gonik', 'atonik', 'auxin dieu hoa'],
    ],
    [
        'key'         => 'b_vitamins_complex',
        'name'        => 'Phức hợp Vitamin B1, B6, B12 & C (Monyka)',
        'english_name'=> 'Vitamin B-Complex & Vitamin C',
        'group'       => 'Vitamin & Vi chất kích kháng',
        'type'        => 'Dinh dưỡng vi lượng',
        'code'        => 'Bio-Vitamin',
        'action'      => 'Chống sốc môi trường thời tiết hạn mặn, tăng cường sức đề kháng và giảm căng thẳng cho cây trong giai đoạn mang hoa nuôi trái.',
        'patterns'    => ['vitamin monyka', 'vitamin b1', 'axit folic'],
    ],
    [
        'key'         => 'mkp_phosphate_potassium',
        'name'        => 'Mono Potassium Phosphate (MKP 0-52-34 & Lân 86+)',
        'english_name'=> 'Monopotassium Phosphate (MKP 0-52-34)',
        'group'       => 'Phân bón Lân - Kali tinh khiết',
        'type'        => 'Tạo mầm & Chặn đọt',
        'code'        => 'MKP High-PK',
        'action'      => 'Hàm lượng Lân và Kali siêu cao giúp lá già nhanh đồng loạt, ức chế đọt non cạnh tranh dinh dưỡng, kích thích phân hóa mầm hoa mạnh.',
        'patterns'    => ['mkp', 'lân 86', 'lan 86', 'pk 30-35', 'fda chan dot', 'kingkong chan dot'],
    ],
    [
        'key'         => 'potassium_sulfate',
        'name'        => 'Kali Sulphat & Kali hữu cơ (K2SO4 - Kali trắng)',
        'english_name'=> 'Potassium Sulfate (K2SO4 Chloride-Free)',
        'group'       => 'Phân bón Kali tinh khiết',
        'type'        => 'Vào cơm & Lên màu ngọt trái',
        'code'        => 'SOP High-K',
        'action'      => 'Kali trắng không chứa Clo, giúp vận chuyển tinh bột vào trái, múi cơm vàng ruộm, ngọt thanh, thơm ngon, nặng ký.',
        'patterns'    => ['kali sunphat', 'k2so4', 'k-ro edta', 'kali 25', 'kali mekong', '1.0.16', 'golf & turf', 'golf and turf'],
    ],
    [
        'key'         => 'npk_high_nitrogen',
        'name'        => 'NPK Đạm cao kéo đọt (30-10-10, 30-14-5, Vọt đọt)',
        'english_name'=> 'High-N NPK Foliar Fertilizer',
        'group'       => 'Phân bón NPK Đạm cao',
        'type'        => 'Kéo đọt & Mập chồi',
        'code'        => 'NPK High-N',
        'action'      => 'Tỷ lệ Đạm cao kết hợp vi lượng giúp bung đọt nhanh, đâm chồi cực mạnh, nở lá, mập cành, tạo cơi đọt khỏe.',
        'patterns'    => ['30.10.10', '30.14.5', '30-14-5', '30-10-10', 'vọt đọt', 'củ sâm', 'cú đấm rồng', 'bud&leaf'],
    ],
    [
        'key'         => 'npk_high_potassium',
        'name'        => 'NPK Kali cao nuôi trái (7-5-44, 12-11-18, 13-0-46, Nutrivant)',
        'english_name'=> 'High-K NPK Fruit Enhancer',
        'group'       => 'Phân bón NPK Kali cao',
        'type'        => 'Nuôi trái & Lớn trái',
        'code'        => 'NPK High-K',
        'action'      => 'Tỷ lệ Kali cao giúp trái lớn nhanh, nở gai đều, đầy hộc cơm sầu riêng, mẫu mã quả đẹp chuẩn xuất khẩu.',
        'patterns'    => ['7.5.44', '12.11.18', '13.0.46', 'nutrivant', 'nuôi trái edta', 'nuoi trai monyka'],
    ],
    [
        'key'         => 'npk_balanced',
        'name'        => 'NPK Cân đối đa mục đích (15-15-15, 20-20-20, 12-12-12)',
        'english_name'=> 'Balanced NPK Foliar Fertilizer',
        'group'       => 'Phân bón NPK Cân đối',
        'type'        => 'Tăng trưởng cân bằng',
        'code'        => 'NPK Balanced',
        'action'      => 'Đạm, Lân, Kali cân bằng nhau giúp nuôi cây phát triển toàn diện, dày lá khỏe thân, duy trì sức bền của cây trồng.',
        'patterns'    => ['15.15.15', '15-15-15', '20.20.20', '20.20', '20-20', '12.12.12', 'tăng trưởng edta', 'tang truong panaxilus', 'dh 10sr'],
    ],
    [
        'key'         => 'npk_flower_bloom',
        'name'        => 'NPK Rước hoa & Dưỡng bông (10-60-10, Ra hoa vàng, Ra hoa xanh)',
        'english_name'=> 'Bloom & Flower Bud Enhancer NPK',
        'group'       => 'Phân bón NPK Kích hoa',
        'type'        => 'Kích ra hoa & Sáng bông',
        'code'        => 'NPK Bloom',
        'action'      => 'Lân cao kích thích mắt cua bung nở, dưỡng bông mập sáng, cuống hoa khỏe, tăng tỷ lệ hạt phấn sống.',
        'patterns'    => ['10.60.10', 'ra hoa vàng', 'ra hoa xanh', 'ra hoa vang', 'ra hoa xanh'],
    ],
    [
        'key'         => 'organic_soil_conditioner',
        'name'        => 'Chất hữu cơ cải tạo đất & Phân bón nở (Organic Matter 75%)',
        'english_name'=> 'Organic Soil Conditioner Pellets',
        'group'       => 'Phân bón Hữu cơ sinh học',
        'type'        => 'Bón gốc cải tạo đất',
        'code'        => 'Bio-Organic',
        'action'      => 'Tăng hàm lượng mùn hữu cơ trong đất, kích thích vi sinh vật có lợi, giúp đất tơi xốp giữ ẩm và giữ phân.',
        'patterns'    => ['phân nở', 'bi amino seawe', 'đạm hữu cơ humic', 'black-o', 'black - o'],
    ],
];

    /**
     * Lấy toàn bộ dữ liệu Hoạt chất & Nhóm Hợp chất kèm các sản phẩm trực thuộc.
     */
    public function getIngredientsData(): array
    {
        $pesticides = Pesticide::with(['category', 'diseases'])->orderBy('name')->get();

        $activeIngredients = [];
        $matchedPesticideIds = [];

        // 1. Phân loại theo danh mục chuẩn
        foreach ($this->catalog as $item) {
            $key = $item['key'];
            $patterns = $item['patterns'];

            $matchingPesticides = $pesticides->filter(function ($p) use ($patterns, $item) {
                $catName = mb_strtolower($p->category->name ?? '');
                $type = $item['type'] ?? '';

                // Hoạt chất Trừ bệnh / Trừ sâu / Trừ nhện: Loại trừ sản phẩm thuộc nhóm phân bón lá / phân bón gốc
                if (str_contains($type, 'Trừ bệnh') || str_contains($type, 'Trừ sâu') || str_contains($type, 'nhện') || str_contains($type, 'tuyến trùng')) {
                    if (str_contains($catName, 'phân bón')) {
                        return false;
                    }
                }

                // Hoạt chất Dinh dưỡng: Loại trừ thuốc bảo vệ thực vật (thuốc sâu, thuốc bệnh, thuốc khuẩn)
                if (str_contains($type, 'Dinh dưỡng')) {
                    if (str_contains($catName, 'thuốc sâu') || str_contains($catName, 'thuốc trừ bệnh') || str_contains($catName, 'thuốc khuẩn')) {
                        return false;
                    }
                }

                // CHỈ so khớp trên Tên sản phẩm và Hoạt chất (KHÔNG lấy target vì target chứa câu văn miêu tả mục tiêu)
                $text = mb_strtolower($p->name . ' ' . ($p->active_ingredient ?? ''));
                foreach ($patterns as $pattern) {
                    if (str_contains($text, mb_strtolower($pattern))) {
                        return true;
                    }
                }
                return false;
            })->values();

            foreach ($matchingPesticides as $mp) {
                $matchedPesticideIds[$mp->id] = true;
            }

            $activeIngredients[$key] = [
                'key'          => $key,
                'name'         => $item['name'],
                'english_name' => $item['english_name'],
                'group'        => $item['group'],
                'type'         => $item['type'],
                'code'         => $item['code'],
                'action'       => $item['action'],
                'pesticides'   => $matchingPesticides,
                'count'        => $matchingPesticides->count(),
            ];
        }

        // 2. Tự động gom các hoạt chất mới (nếu có thuốc chưa nằm trong catalog chuẩn)
        $unmatchedPesticides = $pesticides->filter(function ($p) use ($matchedPesticideIds) {
            return !isset($matchedPesticideIds[$p->id]);
        });

        if ($unmatchedPesticides->isNotEmpty()) {
            foreach ($unmatchedPesticides as $up) {
                $ingName = trim($up->active_ingredient ?: 'Hoạt chất khác');
                $customKey = 'custom_' . md5(mb_strtolower($ingName));

                if (!isset($activeIngredients[$customKey])) {
                    $activeIngredients[$customKey] = [
                        'key'          => $customKey,
                        'name'         => $ingName,
                        'english_name' => $ingName,
                        'group'        => 'Nhóm Hợp chất BVTV khác',
                        'type'         => $up->category->name ?? 'Thuốc BVTV',
                        'code'         => 'Chung',
                        'action'       => 'Hoạt chất bổ sung trong danh mục bảo vệ thực vật.',
                        'pesticides'   => collect([$up]),
                        'count'        => 1,
                    ];
                } else {
                    $activeIngredients[$customKey]['pesticides']->push($up);
                    $activeIngredients[$customKey]['count']++;
                }
            }
        }

        // Lọc chỉ giữ các hoạt chất có ít nhất 1 sản phẩm
        $activeIngredients = array_filter($activeIngredients, fn($ai) => $ai['count'] > 0);

        // 3. Gom nhóm theo Nhóm Hợp chất (Chemical Groups)
        $chemicalGroups = [];
        foreach ($activeIngredients as $ai) {
            $groupName = $ai['group'];
            if (!isset($chemicalGroups[$groupName])) {
                $chemicalGroups[$groupName] = [
                    'group_name'   => $groupName,
                    'type'         => $ai['type'],
                    'code'         => $ai['code'],
                    'action'       => $ai['action'],
                    'ingredients'  => [],
                    'pesticides'   => collect(),
                ];
            }
            $chemicalGroups[$groupName]['ingredients'][] = $ai['name'];
            foreach ($ai['pesticides'] as $p) {
                if (!$chemicalGroups[$groupName]['pesticides']->contains('id', $p->id)) {
                    $chemicalGroups[$groupName]['pesticides']->push($p);
                }
            }
        }

        // 4. Thống kê tổng quan
        $totalIngredients = count($activeIngredients);
        $totalGroups = count($chemicalGroups);
        $totalPesticides = $pesticides->count();

        return [
            'ingredients'      => collect($activeIngredients),
            'chemical_groups'  => collect($chemicalGroups),
            'statistics'       => [
                'total_ingredients' => $totalIngredients,
                'total_groups'      => $totalGroups,
                'total_pesticides'  => $totalPesticides,
            ],
        ];
    }
}
