<?php

namespace App\Services;

use App\Models\Pesticide;
use Illuminate\Support\Collection;

class MixingCompatibilityService
{
    /**
     * Danh sách các nhóm hóa học / sinh học dùng để phân loại và đánh giá tương kỵ.
     */
    public const GROUPS = [
        'inorganic_copper' => [
            'name' => 'Thuốc gốc Đồng vô cơ',
            'examples' => 'Copper Hydroxide, Copper Oxychloride, Cuprous Oxide (Đồng đỏ), Boóc-đô',
            'badge' => 'bg-amber-100 text-amber-800 border-amber-300',
            'icon' => '🥉',
        ],
        'mineral_oil' => [
            'name' => 'Dầu khoáng nông nghiệp',
            'examples' => 'Petroleum Spray Oil, SK Enspray 99EC',
            'badge' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
            'icon' => '🛢️',
        ],
        'sulfur' => [
            'name' => 'Lưu huỳnh (Sulfur)',
            'examples' => 'Sulfur 80WP, Thiovit 80WG, Kumulus, Lưu huỳnh vôi',
            'badge' => 'bg-lime-100 text-lime-800 border-lime-300',
            'icon' => '🟡',
        ],
        'biopesticide' => [
            'name' => 'Chế phẩm Vi sinh & Nấm đối kháng',
            'examples' => 'Trichoderma, Bacillus thuringiensis, Beauveria (nấm trắng), Metarhizium (nấm xanh)',
            'badge' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'icon' => '🦠',
        ],
        'alkaline' => [
            'name' => 'Thuốc / Hợp chất có tính Kiềm cao',
            'examples' => 'Nước vôi, Vôi bột, Boóc-đô, Lưu huỳnh vôi, Canxi hydroxit',
            'badge' => 'bg-blue-100 text-blue-800 border-blue-300',
            'icon' => '🧪',
        ],
        'organophosphate' => [
            'name' => 'Nhóm Lân hữu cơ (Organophosphate)',
            'examples' => 'Profenofos, Prothiofos, Fenitrothion, Diazinon',
            'badge' => 'bg-purple-100 text-purple-800 border-purple-300',
            'icon' => '☠️',
        ],
        'carbamate' => [
            'name' => 'Nhóm Carbamate',
            'examples' => 'Carbosulfan, Fenobucarb (Basa), Benfuracarb',
            'badge' => 'bg-fuchsia-100 text-fuchsia-800 border-fuchsia-300',
            'icon' => '⚡',
        ],
        'pyrethroid' => [
            'name' => 'Nhóm Cúc tổng hợp (Pyrethroid)',
            'examples' => 'Cypermethrin, Alpha-Cypermethrin, Lambda-Cyhalothrin, Deltamethrin',
            'badge' => 'bg-indigo-100 text-indigo-800 border-indigo-300',
            'icon' => '🦗',
        ],
        'fosetyl_al' => [
            'name' => 'Fosetyl-Aluminium (Aliette)',
            'examples' => 'Fosetyl-aluminium (Aliette 800WG, Anlien...)',
            'badge' => 'bg-rose-100 text-rose-800 border-rose-300',
            'icon' => '🛡️',
        ],
        'antibiotic' => [
            'name' => 'Kháng sinh nông nghiệp',
            'examples' => 'Kasugamycin, Streptomycin, Validamycin, Ningnanmycin',
            'badge' => 'bg-teal-100 text-teal-800 border-teal-300',
            'icon' => '💊',
        ],
        'high_calcium' => [
            'name' => 'Phân bón Canxi cao (Calcium)',
            'examples' => 'Canxi Bo, Calcium Nitrate Ca(NO3)2, Chelate Canxi',
            'badge' => 'bg-stone-100 text-stone-800 border-stone-300',
            'icon' => '🦴',
        ],
        'high_phosphorus' => [
            'name' => 'Phân bón Lân cao (Phosphorus) & Sunfat',
            'examples' => 'MKP 0-52-34, Lân 86, MAP, 10-60-10, Kali Sunfat (K2SO4)',
            'badge' => 'bg-cyan-100 text-cyan-800 border-cyan-300',
            'icon' => '🌾',
        ],
        'triazole' => [
            'name' => 'Thuốc trừ nấm nhóm Triazole (FRAC 3)',
            'examples' => 'Hexaconazole, Difenoconazole, Tebuconazole, Propiconazole',
            'badge' => 'bg-orange-100 text-orange-800 border-orange-300',
            'icon' => '🍄',
        ],
        'strobilurin' => [
            'name' => 'Thuốc trừ nấm nhóm Strobilurin (FRAC 11)',
            'examples' => 'Azoxystrobin, Pyraclostrobin, Kresoxim-methyl',
            'badge' => 'bg-sky-100 text-sky-800 border-sky-300',
            'icon' => '🌿',
        ],
        'neonicotinoid' => [
            'name' => 'Thuốc trừ rầy Neonicotinoid (IRAC 4A)',
            'examples' => 'Imidacloprid, Thiamethoxam, Acetamiprid, Dinotefuran, Clothianidin',
            'badge' => 'bg-violet-100 text-violet-800 border-violet-300',
            'icon' => '🦟',
        ],
        'acid_amino' => [
            'name' => 'Axit amin & Phân bón lá vi lượng',
            'examples' => 'Amino Acid, Đạm cá, Rong biển hữu cơ, Humic, Fulvic',
            'badge' => 'bg-emerald-100 text-emerald-800 border-emerald-300',
            'icon' => '🌱',
        ],
    ];

    /**
     * Bảng các quy tắc tương kỵ chuẩn mực nông học có dẫn chứng khoa học và trạng thái 4 mức độ:
     * FORBIDDEN (Cấm kỵ), AVOID (Nên tránh / Thận trọng), COMPATIBLE (Tương thích), UNKNOWN (Chưa rõ)
     */
    protected array $rules = [
        // 1. Dầu khoáng + Lưu huỳnh
        [
            'rule_code' => 'R-OIL-SULFUR-01',
            'pair' => ['mineral_oil', 'sulfur'],
            'status' => 'FORBIDDEN',
            'level' => 'danger',
            'priority' => 100,
            'title' => 'CẤM KỴ TUYỆT ĐỐI: Dầu khoáng + Lưu huỳnh',
            'reason' => 'Dầu khoáng phá vỡ lớp cutin sáp bảo vệ biểu bì lá cây, khiến Lưu huỳnh thấm ồ ạt qua khí khổng và màng tế bào dưới ánh nắng tạo phản ứng quang hóa.',
            'consequence' => 'Gây cháy lá dữ dội, rụng lá non hàng loạt, nám và rụng trái. Khoảng cách phun 2 loại thuốc này tối thiểu phải cách nhau 14 đến 30 ngày.',
            'advice' => 'Tuyệt đối không pha chung vào cùng 1 phuy hoặc phun sát ngày nhau.',
            'source_type' => 'official_standard',
            'source_reference' => 'FAO Guidelines on Pesticide Tank-Mix Safety and Specifications & UC IPM Sulfur Guidelines',
            'confidence' => 'HIGH',
        ],

        // 2. Dầu khoáng + Đồng vô cơ / Captan
        [
            'rule_code' => 'R-CU-OIL-01',
            'pair' => ['mineral_oil', 'inorganic_copper'],
            'status' => 'FORBIDDEN',
            'level' => 'danger',
            'priority' => 100,
            'title' => 'CẤM KỴ: Dầu khoáng + Gốc Đồng vô cơ',
            'reason' => 'Dầu khoáng giữ ion Đồng bám quá chặt và tăng nồng độ thẩm thấu ion Cu²⁺ vượt ngưỡng chịu đựng của mô tế bào biểu bì thực vật.',
            'consequence' => 'Rất dễ gây ngộ độc đồng (Phytotoxicity), sém mép lá, đốm cháy trên vỏ quả non.',
            'advice' => 'Nên phun riêng rẽ, cách nhau tối thiểu 7 - 10 ngày.',
            'source_type' => 'manufacturer_label',
            'source_reference' => 'Nhãn Bordeaux & Cẩm nang BVTV Cục Bảo vệ Thực vật 2024',
            'confidence' => 'HIGH',
        ],

        // 3. Đồng vô cơ + Chế phẩm Vi sinh
        [
            'rule_code' => 'R-CU-BIO-01',
            'pair' => ['inorganic_copper', 'biopesticide'],
            'status' => 'FORBIDDEN',
            'level' => 'danger',
            'priority' => 100,
            'title' => 'CẤM KỴ: Gốc Đồng vô cơ + Chế phẩm Vi sinh vật',
            'reason' => 'Ion Đồng vô cơ (Cu²⁺) là chất sát khuẩn phổ rộng cực mạnh, tiêu diệt cả nấm và vi khuẩn không chọn lọc.',
            'consequence' => 'Tiêu diệt hoàn toàn các bào tử nấm đối kháng (Trichoderma, Beauveria, Metarhizium...) và vi khuẩn có ích (Bacillus). Làm mất 100% hiệu lực của chế phẩm vi sinh sinh học.',
            'advice' => 'Phun cách nhau ít nhất 10 - 15 ngày để hệ vi sinh có ích kịp phát triển mật số.',
            'source_type' => 'scientific_paper',
            'source_reference' => 'Tạp chí Nông nghiệp & PTNT - Đánh giá tác động của ion đồng đến bào tử Trichoderma viride',
            'confidence' => 'HIGH',
        ],

        // 4. Kháng sinh + Vi sinh
        [
            'rule_code' => 'R-ANTI-BIO-01',
            'pair' => ['antibiotic', 'biopesticide'],
            'status' => 'FORBIDDEN',
            'level' => 'danger',
            'priority' => 100,
            'title' => 'CẤM KỴ: Thuốc kháng sinh + Chế phẩm Vi sinh vật',
            'reason' => 'Các loại kháng sinh (Kasugamycin, Streptomycin...) diệt khuẩn sẽ tiêu diệt hoặc ức chế các dòng vi sinh có ích trong chế phẩm sinh học.',
            'consequence' => 'Làm chết vi sinh vật đối kháng có ích trong đất và trên tán cây.',
            'advice' => 'Nếu dùng nấm/khuẩn đối kháng thì không phối chung thuốc kháng sinh hóa học.',
            'source_type' => 'scientific_paper',
            'source_reference' => 'Viện Di truyền Nông nghiệp - Khảo nghiệm tương thích chế phẩm sinh học và kháng sinh nông nghiệp',
            'confidence' => 'HIGH',
        ],

        // 5. Tính Kiềm + Lân hữu cơ / Carbamate / Cúc tổng hợp
        [
            'rule_code' => 'R-ALK-ORGANO-01',
            'pair' => ['alkaline', 'organophosphate'],
            'status' => 'FORBIDDEN',
            'level' => 'danger',
            'priority' => 100,
            'title' => 'CẤM KỴ: Thuốc tính Kiềm + Nhóm Lân hữu cơ',
            'reason' => 'Môi trường kiềm (pH > 7.5 - 8.0) làm thủy phân cực nhanh liên kết este của hoạt chất Lân hữu cơ (Alkaline Hydrolysis).',
            'consequence' => 'Hoạt chất bị phân hủy thành dạng mất hoạt tính trong vòng vài chục phút, mất hoàn toàn khả năng diệt sâu rầy.',
            'advice' => 'Không pha chung thuốc Lân hữu cơ với vôi, dung dịch Boóc-đô hay nước có độ kiềm cao.',
            'source_type' => 'official_standard',
            'source_reference' => 'FAO Pesticide Specifications - pH stability of Organophosphorus compounds',
            'confidence' => 'HIGH',
        ],
        [
            'rule_code' => 'R-ALK-CARB-01',
            'pair' => ['alkaline', 'carbamate'],
            'status' => 'FORBIDDEN',
            'level' => 'danger',
            'priority' => 100,
            'title' => 'CẤM KỴ: Thuốc tính Kiềm + Nhóm Carbamate',
            'reason' => 'Gốc Carbamate bị phá hủy cấu trúc phân tử khi tiếp xúc môi trường kiềm (Alkaline Hydrolysis).',
            'consequence' => 'Làm giảm hoặc mất 100% hiệu lực trừ rầy, sâu đục thân.',
            'advice' => 'Tuyệt đối không pha chung với vôi hoặc nước Boóc-đô.',
            'source_type' => 'official_standard',
            'source_reference' => 'Sổ tay sử dụng hóa chất BVTV an toàn - Cục BVTV Việt Nam',
            'confidence' => 'HIGH',
        ],
        [
            'rule_code' => 'R-ALK-PYRE-01',
            'pair' => ['alkaline', 'pyrethroid'],
            'status' => 'FORBIDDEN',
            'level' => 'danger',
            'priority' => 100,
            'title' => 'CẤM KỴ: Thuốc tính Kiềm + Nhóm Cúc tổng hợp (Pyrethroid)',
            'reason' => 'Cúc tổng hợp (Cypermethrin, Lambda-Cyhalothrin...) phân hủy rất nhanh trong môi trường kiềm.',
            'consequence' => 'Mất tác dụng hạ gục sâu hại.',
            'advice' => 'Dùng nước sạch trung tính (pH 5.5 - 6.5) để pha cúc tổng hợp.',
            'source_type' => 'official_standard',
            'source_reference' => 'WHO Specifications and Evaluations for Public Health Pesticides - Pyrethroids',
            'confidence' => 'HIGH',
        ],

        // 6. Tính Kiềm + Vi sinh
        [
            'rule_code' => 'R-ALK-BIO-01',
            'pair' => ['alkaline', 'biopesticide'],
            'status' => 'FORBIDDEN',
            'level' => 'danger',
            'priority' => 100,
            'title' => 'CẤM KỴ: Thuốc tính Kiềm + Chế phẩm Vi sinh',
            'reason' => 'pH cao phá vỡ màng tế bào và ức chế khả năng nảy mầm của bào tử nấm đối kháng Trichoderma, Metarhizium.',
            'consequence' => 'Làm bất hoạt chế phẩm sinh học.',
            'advice' => 'Vi sinh vật chỉ hoạt động tốt ở môi trường trung tính hoặc hơi chua nhẹ.',
            'source_type' => 'scientific_paper',
            'source_reference' => 'Journal of Applied Microbiology - Effect of pH on biocontrol fungi germination',
            'confidence' => 'HIGH',
        ],

        // 7. Đồng vô cơ + Fosetyl-Aluminium (Aliette)
        [
            'rule_code' => 'R-CU-FOSETYL-01',
            'pair' => ['inorganic_copper', 'fosetyl_al'],
            'status' => 'FORBIDDEN',
            'level' => 'danger',
            'priority' => 100,
            'title' => 'CẤM KỴ: Gốc Đồng vô cơ + Fosetyl-Aluminium (Aliette)',
            'reason' => 'Fosetyl-Al có tính axit mạnh phản ứng với ion Đồng tạo kết tủa và giải phóng lượng ion đồng tự do đột ngột ở nồng độ cao.',
            'consequence' => 'Gây cháy lá non, rụng đọt và ngộ độc cây trồng.',
            'advice' => 'Phun riêng 2 loại này, không pha chung vào cùng 1 phuy.',
            'source_type' => 'manufacturer_label',
            'source_reference' => 'Bayer CropScience Technical Guide for Aliette 800WG Tank-Mix Exclusions',
            'confidence' => 'HIGH',
        ],

        // 8. Đồng vô cơ + Axit amin / Đạm hữu cơ
        [
            'rule_code' => 'R-CU-AMINO-01',
            'pair' => ['inorganic_copper', 'acid_amino'],
            'status' => 'AVOID',
            'level' => 'warning',
            'priority' => 100,
            'title' => 'THẬN TRỌNG: Gốc Đồng vô cơ + Phân bón Axit Amin',
            'reason' => 'Axit amin tạo phức càng cua chelate hóa không bền với ion Đồng vô cơ, dễ làm biến tính đạm sinh học hoặc phóng thích Cu tự do gây cháy chóp lá.',
            'consequence' => 'Làm giảm tác dụng của axit amin và tăng nguy cơ sém mép lá non.',
            'advice' => 'Nên phun riêng thuốc gốc đồng làm sạch vườn trước, sau 3 - 5 ngày mới phun amino acid bồi bổ cây.',
            'source_type' => 'extension_manual',
            'source_reference' => 'Tài liệu hướng dẫn dinh dưỡng cây ăn trái Viện Cây ăn quả Miền Nam (SOFRI)',
            'confidence' => 'HIGH',
        ],

        // 9. Canxi cao + Lân cao / Sunfat
        [
            'rule_code' => 'R-CA-PHOSPHATE-01',
            'pair' => ['high_calcium', 'high_phosphorus'],
            'status' => 'FORBIDDEN',
            'level' => 'danger',
            'priority' => 100,
            'title' => 'CẤM KỴ: Phân bón Canxi cao + Lân cao (MKP) hoặc Sunfat (S)',
            'reason' => 'Ion Canxi (Ca²⁺) kết hợp ngay với gốc Photphat (PO₄³⁻) hoặc Sunfat (SO₄²⁻) tạo thành Canxi Photphat hoặc Canxi Sunfat (thạch cao rắn không tan).',
            'consequence' => 'Gây kết tủa trắng đục, đóng cặn dưới đáy phuy, nghẹt béc phun cực kỳ nặng, cây hoàn toàn không thể hấp thụ được.',
            'advice' => 'Không bao giờ pha chung phân bón Canxi/Canxi Bo với MKP, MAP hoặc phân có chứa Lưu huỳnh/Sunfat.',
            'source_type' => 'official_standard',
            'source_reference' => 'Sổ tay Hòa tan & Tương thích Phân bón Nông nghiệp hòa tan (Haifa Fertilizers Manual)',
            'confidence' => 'HIGH',
        ],

        // 10. Trùng nhóm FRAC Triazole
        [
            'rule_code' => 'R-RESIST-TRIAZOLE-01',
            'pair' => ['triazole', 'triazole'],
            'status' => 'AVOID',
            'level' => 'warning',
            'priority' => 100,
            'title' => 'CẢNH BÁO: Trộn 2 thuốc cùng nhóm Triazole (FRAC 3)',
            'reason' => 'Cả 2 hoạt chất đều có cùng cơ chế tác động ức chế sinh tổng hợp ergosterol màng tế bào nấm (nhóm DMI - FRAC 3).',
            'consequence' => 'Không làm tăng phổ phòng trị, gây lãng phí chi phí thuốc và gia tăng nguy cơ tạo dòng nấm kháng thuốc nhóm Triazole.',
            'advice' => 'Nên luân phiên hoặc phối 1 thuốc Triazole (nội hấp) với 1 hoạt chất bảo vệ tiếp xúc đa điểm như Mancozeb hoặc Propineb để tối ưu hiệu lực.',
            'source_type' => 'official_standard',
            'source_reference' => 'FRAC (Fungicide Resistance Action Committee) Mode of Action Classification 2024',
            'confidence' => 'HIGH',
        ],

        // 11. Trùng nhóm IRAC Neonicotinoid
        [
            'rule_code' => 'R-RESIST-NEONIC-01',
            'pair' => ['neonicotinoid', 'neonicotinoid'],
            'status' => 'AVOID',
            'level' => 'warning',
            'priority' => 100,
            'title' => 'CẢNH BÁO: Trộn 2 thuốc cùng nhóm Neonicotinoid (IRAC 4A)',
            'reason' => 'Cùng cơ chế tác động lên thụ thể Nicotinic acetylcholine của hệ thần kinh côn trùng.',
            'consequence' => 'Dễ làm rầy xanh, rầy nâu, bọ trĩ nhanh hình thành tính kháng thuốc chéo.',
            'advice' => 'Nên phối Neonicotinoid với nhóm ức chế lột xác (Buprofezin) hoặc nhóm điều hòa kênh Clo (Abamectin/Emamectin).',
            'source_type' => 'official_standard',
            'source_reference' => 'IRAC (Insecticide Resistance Action Committee) MoA Classification v10.4',
            'confidence' => 'HIGH',
        ],

        // 12. Trùng nhóm IRAC Pyrethroid
        [
            'rule_code' => 'R-RESIST-PYRE-01',
            'pair' => ['pyrethroid', 'pyrethroid'],
            'status' => 'AVOID',
            'level' => 'warning',
            'priority' => 100,
            'title' => 'CẢNH BÁO: Trộn 2 thuốc cùng nhóm Cúc tổng hợp (IRAC 3A)',
            'reason' => 'Cùng cơ chế tác động lên kênh Natri sợi thần kinh.',
            'consequence' => 'Tăng nguy cơ kháng thuốc và có thể gây nóng đọt, cháy rìa lá nếu cộng dồn nồng độ nhũ dầu quá cao.',
            'advice' => 'Nên phối 1 loại cúc tiếp xúc với 1 loại nội hấp lưu dẫn khác cơ chế.',
            'source_type' => 'official_standard',
            'source_reference' => 'IRAC MoA Mode of Action Guidelines for Pyrethroids',
            'confidence' => 'HIGH',
        ],
    ];

    /**
     * Nhận diện các nhóm thuộc tính hóa học / sinh học của một thuốc.
     */
    public function detectGroups(Pesticide $pesticide): array
    {
        $tags = [];
        $text = mb_strtolower(implode(' ', array_filter([
            $pesticide->name,
            $pesticide->active_ingredient,
            $pesticide->target,
            $pesticide->usage,
            $pesticide->notes,
            $pesticide->form_type,
            $pesticide->category?->name,
        ])));

        // 1. Gốc đồng vô cơ
        if (preg_match('/(copper oxychloride|cuprous oxide|đồng đỏ|copper hydroxide|boóc-đô|bordeaux|boc do|nordox|coc 85|goc 85)/u', $text)) {
            $tags[] = 'inorganic_copper';
        }

        // 2. Dầu khoáng
        if (preg_match('/(dầu khoáng|dau khoang|mineral oil|petroleum spray oil|enspray)/u', $text)) {
            $tags[] = 'mineral_oil';
        }

        // 3. Lưu huỳnh
        if (preg_match('/(lưu huỳnh|luu huynh|sulfur|thiovit|kumulus)/u', $text) && !str_contains($text, 'kali sunphat') && !str_contains($text, 'k2so4')) {
            $tags[] = 'sulfur';
        }

        // 4. Vi sinh vật & sinh học
        if (preg_match('/(trichoderma|bacillus|beauveria|metarhizium|vi sinh|nấm đối kháng|khuẩn đối kháng|vi sinh vật)/u', $text)
            || ($pesticide->category?->slug === 'che-pham-vi-sinh')) {
            $tags[] = 'biopesticide';
        }

        // 5. Tính kiềm
        if (preg_match('/(nước vôi|vôi tôi|boóc-đô|bordeaux|lưu huỳnh vôi|tính kiềm|ph cao)/u', $text)) {
            $tags[] = 'alkaline';
        }

        // 6. Lân hữu cơ
        if (preg_match('/(profenofos|prothiofos|chlorpyrifos|fenitrothion|diazinon|lân hữu cơ)/u', $text)) {
            $tags[] = 'organophosphate';
        }

        // 7. Carbamate
        if (preg_match('/(carbosulfan|fenobucarb|benfuracarb|basa|afudan)/u', $text)) {
            $tags[] = 'carbamate';
        }

        // 8. Cúc tổng hợp (Pyrethroid)
        if (preg_match('/(cypermethrin|cyhalothrin|deltamethrin|permethrin|cúc tổng hợp)/u', $text)) {
            $tags[] = 'pyrethroid';
        }

        // 9. Fosetyl-Aluminium
        if (preg_match('/(fosetyl|aliette|anlien)/u', $text)) {
            $tags[] = 'fosetyl_al';
        }

        // 10. Kháng sinh
        if (preg_match('/(kasugamycin|streptomycin|validamycin|ningnanmycin|kháng sinh|kasu)/u', $text)) {
            $tags[] = 'antibiotic';
        }

        // 11. Canxi cao
        if (preg_match('/(canxi bo|canxi-bo|calcium|canxi clorua|canxi nitrat|ca\(no3\)2)/u', $text)) {
            $tags[] = 'high_calcium';
        }

        // 12. Lân cao / Sunfat
        if (preg_match('/(mkp|0-52-34|0.52.34|lân 86|lan 86|10-60-10|k2so4|kali sunphat|kali sunfat)/u', $text)) {
            $tags[] = 'high_phosphorus';
        }

        // 13. Triazole (FRAC 3)
        if (preg_match('/(hexaconazole|difenoconazole|tebuconazole|propiconazole|triazole|anvil|tilt)/u', $text)) {
            $tags[] = 'triazole';
        }

        // 14. Strobilurin (FRAC 11)
        if (preg_match('/(azoxystrobin|pyraclostrobin|kresoxim|strobilurin|amistar)/u', $text)) {
            $tags[] = 'strobilurin';
        }

        // 15. Neonicotinoid (IRAC 4A)
        if (preg_match('/(imidacloprid|thiamethoxam|acetamiprid|dinotefuran|clothianidin)/u', $text)) {
            $tags[] = 'neonicotinoid';
        }

        // 16. Axit amin / hữu cơ
        if (preg_match('/(amino|axit amin|acid amin|đạm cá|rong biển|humic|fulvic)/u', $text)) {
            $tags[] = 'acid_amino';
        }

        return array_unique($tags);
    }

    /**
     * Nhận diện dạng thuốc (Formulation): WP, WG, SC, EC, EW, SL...
     */
    public function detectFormType(Pesticide $pesticide): ?string
    {
        $text = mb_strtoupper($pesticide->name . ' ' . ($pesticide->form_type ?? ''));
        if (preg_match('/\b(WG|WDG)\b/', $text)) return 'WG';
        if (preg_match('/\b(WP)\b/', $text)) return 'WP';
        if (preg_match('/\b(SC|FS)\b/', $text)) return 'SC';
        if (preg_match('/\b(EC)\b/', $text)) return 'EC';
        if (preg_match('/\b(EW|ME)\b/', $text)) return 'EW';
        if (preg_match('/\b(SL|AS)\b/', $text)) return 'SL';
        if (preg_match('/\b(SP)\b/', $text)) return 'SP';
        return null;
    }

    /**
     * So sánh cặp 2 thuốc xem có tương kỵ hay không.
     */
    public function checkPair(Pesticide $p1, Pesticide $p2): array
    {
        if ($p1->id === $p2->id) {
            return [
                'status' => 'warning',
                'conflicts' => [
                    [
                        'level' => 'warning',
                        'title' => 'Cùng một sản phẩm',
                        'reason' => 'Bạn đang chọn cùng một sản phẩm thuốc hai lần.',
                        'consequence' => 'Không cần thiết phải tự phối với chính nó.',
                        'advice' => 'Vui lòng chọn 2 sản phẩm khác nhau để phân tích tương kỵ.',
                    ]
                ],
                'mixing_order' => [],
            ];
        }

        $tags1 = $this->detectGroups($p1);
        $tags2 = $this->detectGroups($p2);

        $conflicts = [];
        $dangerCount = 0;
        $warningCount = 0;
        $activeStatus = 'UNKNOWN';

        // 1. Kiểm tra Rule ưu tiên từ Cơ sở dữ liệu (Product-specific: 200 > Group-specific: 100)
        $dbRules = $this->lookupDbRules($p1, $p2, $tags1, $tags2);
        $hasProductSpecificRule = false;

        foreach ($dbRules as $dbr) {
            if ($dbr->scope === 'product_specific' || $dbr->priority >= 200) {
                $hasProductSpecificRule = true;
            }

            $conflicts[] = [
                'rule_code' => $dbr->rule_code,
                'level' => match ($dbr->status) {
                    'FORBIDDEN' => 'danger',
                    'AVOID' => 'warning',
                    'COMPATIBLE' => 'safe',
                    default => 'info',
                },
                'status' => $dbr->status,
                'priority' => $dbr->priority,
                'title' => $dbr->title,
                'reason' => $dbr->reason,
                'consequence' => $dbr->reason . ($dbr->conditions ? " (Điều kiện: {$dbr->conditions})" : ''),
                'advice' => $dbr->advice,
                'source_type' => $dbr->source_type,
                'source_reference' => $dbr->source_reference,
                'confidence' => $dbr->confidence,
            ];

            if ($dbr->status === 'FORBIDDEN') {
                $dangerCount++;
                $activeStatus = 'FORBIDDEN';
            } elseif ($dbr->status === 'AVOID') {
                $warningCount++;
                if ($activeStatus !== 'FORBIDDEN') $activeStatus = 'AVOID';
            } elseif ($dbr->status === 'COMPATIBLE') {
                $activeStatus = 'COMPATIBLE';
            }
        }

        // 2. Kiểm tra bộ luật mẫu chuẩn hóa (built-in rules) nếu KHÔNG CÓ rule cấp sản phẩm ghi đè
        if (!$hasProductSpecificRule) {
            foreach ($this->rules as $rule) {
                [$reqA, $reqB] = $rule['pair'];

                $match = false;
                if ($reqA === $reqB) {
                    // Kiểm tra cùng tag (ví dụ cùng triazole hoặc cùng neonicotinoid)
                    if (in_array($reqA, $tags1, true) && in_array($reqB, $tags2, true)) {
                        $match = true;
                    }
                } else {
                    if (
                        (in_array($reqA, $tags1, true) && in_array($reqB, $tags2, true)) ||
                        (in_array($reqB, $tags1, true) && in_array($reqA, $tags2, true))
                    ) {
                        $match = true;
                    }
                }

                if ($match) {
                    // Tránh trùng nếu đã có rule tương tự từ DB
                    $alreadyExists = false;
                    foreach ($conflicts as $ex) {
                        if (isset($ex['rule_code']) && $ex['rule_code'] === ($rule['rule_code'] ?? '')) {
                            $alreadyExists = true;
                            break;
                        }
                    }

                    if (!$alreadyExists) {
                        $conflicts[] = $rule;
                        if ($rule['level'] === 'danger') {
                            $dangerCount++;
                            $activeStatus = 'FORBIDDEN';
                        } elseif ($rule['level'] === 'warning') {
                            $warningCount++;
                            if ($activeStatus !== 'FORBIDDEN') $activeStatus = 'AVOID';
                        }
                    }
                }
            }
        }

        // 3. Kiểm tra tương kỵ về dạng thuốc (ví dụ 2 loại nhũ dầu EC nồng độ cao)
        $form1 = $this->detectFormType($p1);
        $form2 = $this->detectFormType($p2);

        if ($form1 === 'EC' && $form2 === 'EC') {
            $conflicts[] = [
                'rule_code' => 'R-FORM-EC-EC',
                'level' => 'warning',
                'status' => 'AVOID',
                'title' => 'LƯU Ý DẠNG THUỐC: Cả 2 sản phẩm đều là Dạng Nhũ Dầu (EC)',
                'reason' => 'Hai thuốc dạng EC chứa lượng lớn dung môi và chất nhũ hóa hữu cơ.',
                'consequence' => 'Nếu hòa tan trực tiếp cùng lúc vào ít nước, nhũ tương có thể bị phá vỡ gây tách lớp hoặc làm tăng độ nóng của dung dịch phun, dễ gây bỏng bông, sém đọt non.',
                'advice' => 'Cần pha loãng từng loại riêng biệt vào xô nước lớn trước khi đổ chung vào phuy phun. Không pha ở liều quá đậm đặc.',
                'source_type' => 'extension_manual',
                'source_reference' => 'Cẩm nang Kỹ thuật Pha trộn và Sử dụng Thuốc BVTV an toàn hiệu quả',
                'confidence' => 'HIGH',
            ];
            $warningCount++;
            if ($activeStatus !== 'FORBIDDEN') $activeStatus = 'AVOID';
        }

        // 4. Kiểm tra Quản lý tính kháng độc lập (Resistance Management: FRAC / IRAC / HRAC)
        $resistanceWarnings = $this->checkResistanceSeparation($p1, $p2);

        // Thứ tự pha khuyến cáo
        $mixingOrder = $this->determineMixingOrder([$p1, $p2]);

        $status = 'safe';
        if ($dangerCount > 0) {
            $status = 'danger';
            $activeStatus = 'FORBIDDEN';
        } elseif ($warningCount > 0) {
            $status = 'warning';
            $activeStatus = 'AVOID';
        } elseif ($activeStatus === 'UNKNOWN' && empty($conflicts)) {
            $activeStatus = 'UNKNOWN';
        }

        return [
            'status' => $status,
            'compatibility_status' => $activeStatus, // FORBIDDEN, AVOID, COMPATIBLE, UNKNOWN
            'pesticide_1' => $p1,
            'pesticide_2' => $p2,
            'tags_1' => $tags1,
            'tags_2' => $tags2,
            'conflicts' => $conflicts,
            'resistance_warnings' => $resistanceWarnings,
            'mixing_order' => $mixingOrder,
        ];
    }

    /**
     * Tra cứu bộ quy tắc động trong bảng compatibility_rules
     * Hierarchy ưu tiên: Product-specific (priority 200) > Group-specific (priority 100)
     */
    protected function lookupDbRules(Pesticide $p1, Pesticide $p2, array $tags1, array $tags2): Collection
    {
        try {
            if (!\Illuminate\Support\Facades\Schema::hasTable('compatibility_rules')) {
                return collect();
            }

            // 1. Tìm product-specific rules (ưu tiên 200)
            $pId1 = (string) $p1->id;
            $pId2 = (string) $p2->id;

            $productRules = \App\Models\CompatibilityRule::where('is_active', true)
                ->where('scope', 'product_specific')
                ->where(function ($q) use ($pId1, $pId2) {
                    $q->where(fn($sub) => $sub->where('entity_a_key', $pId1)->where('entity_b_key', $pId2))
                      ->orWhere(fn($sub) => $sub->where('entity_a_key', $pId2)->where('entity_b_key', $pId1));
                })
                ->orderByDesc('priority')
                ->get();

            if ($productRules->isNotEmpty()) {
                return $productRules;
            }

            // 2. Tìm group-specific rules (ưu tiên 100)
            $allPairs = [];
            foreach ($tags1 as $t1) {
                foreach ($tags2 as $t2) {
                    $allPairs[] = [$t1, $t2];
                }
            }

            if (empty($allPairs)) {
                return collect();
            }

            $groupRules = \App\Models\CompatibilityRule::where('is_active', true)
                ->where('scope', 'group_specific')
                ->where(function ($q) use ($allPairs) {
                    foreach ($allPairs as $pair) {
                        $q->orWhere(function ($sub) use ($pair) {
                            $sub->where('entity_a_key', $pair[0])->where('entity_b_key', $pair[1]);
                        })->orWhere(function ($sub) use ($pair) {
                            $sub->where('entity_a_key', $pair[1])->where('entity_b_key', $pair[0]);
                        });
                    }
                })
                ->orderByDesc('priority')
                ->get();

            return $groupRules;
        } catch (\Throwable $e) {
            return collect();
        }
    }

    /**
     * Phân tách rạch ròi Quản Lý Tính Kháng (Resistance Management) khỏi Tương kỵ vật lý/hóa học.
     * Cùng FRAC/IRAC/HRAC không phải là kết tủa/cháy lá, mà là cảnh báo dịch tễ học và luân phiên thuốc.
     */
    protected function checkResistanceSeparation(Pesticide $p1, Pesticide $p2): array
    {
        $warnings = [];

        // Kiểm tra FRAC (Thuốc trừ bệnh)
        $frac1 = trim($p1->frac_code ?? '');
        $frac2 = trim($p2->frac_code ?? '');
        if ($frac1 !== '' && $frac1 === $frac2) {
            $profile = null;
            try {
                if (\Illuminate\Support\Facades\Schema::hasTable('resistance_profiles')) {
                    $profile = \App\Models\ResistanceProfile::where('code_type', 'FRAC')
                        ->where('code_value', $frac1)
                        ->first();
                }
            } catch (\Throwable $e) {}

            $warnings[] = [
                'type' => 'FRAC',
                'code' => $frac1,
                'title' => "Cảnh báo luân phiên nấm bệnh: Cùng mã {$frac1}",
                'mechanism' => $profile?->target_site_of_action ?? 'Cùng cơ chế tác động lên bào tử nấm',
                'risk_level' => $profile?->risk_level ?? 'MEDIUM',
                'cross_resistance_group' => $profile?->cross_resistance_group ?? 'Nhóm kháng chéo cùng họ hoạt chất',
                'advice' => $profile?->rotation_advice ?? 'Không nên phối cùng mã kháng; nên luân phiên khác nhóm để ngăn ngừa nấm tạo áp lực đề kháng.',
                'note' => 'Về mặt hóa lý bình phun, 2 thuốc có thể tan tốt không kết tủa, nhưng việc lạm dụng cùng lúc làm nấm nhanh chóng thích nghi kháng chéo.',
            ];
        }

        // Kiểm tra IRAC (Thuốc trừ sâu rầy)
        $irac1 = trim($p1->irac_code ?? '');
        $irac2 = trim($p2->irac_code ?? '');
        if ($irac1 !== '' && $irac1 === $irac2) {
            $profile = null;
            try {
                if (\Illuminate\Support\Facades\Schema::hasTable('resistance_profiles')) {
                    $profile = \App\Models\ResistanceProfile::where('code_type', 'IRAC')
                        ->where('code_value', $irac1)
                        ->first();
                }
            } catch (\Throwable $e) {}

            $warnings[] = [
                'type' => 'IRAC',
                'code' => $irac1,
                'title' => "Cảnh báo kháng thuốc sâu rầy: Cùng mã {$irac1}",
                'mechanism' => $profile?->target_site_of_action ?? 'Cùng cơ chế tác động lên hệ thần kinh hoặc hô hấp côn trùng',
                'risk_level' => $profile?->risk_level ?? 'HIGH',
                'cross_resistance_group' => $profile?->cross_resistance_group ?? 'Nhóm kháng chéo côn trùng',
                'advice' => $profile?->rotation_advice ?? 'Cần luân phiên với nhóm khác cơ chế (vd Neonicotinoid luân phiên với ức chế lột xác Buprofezin).',
                'note' => 'Phối 2 thuốc trừ sâu cùng mã IRAC gây lãng phí chi phí thuốc và chọn lọc dòng sâu rầy kháng chéo.',
            ];
        }

        return $warnings;
    }

    /**
     * Kiểm tra tương thích giữa danh sách các thuốc (2 hoặc nhiều hơn).
     */
    public function checkCompatibility(array $pesticideIds): array
    {
        $pesticideIds = array_values(array_unique(array_filter($pesticideIds)));
        if (count($pesticideIds) < 2) {
            return [
                'status' => 'empty',
                'message' => 'Vui lòng chọn ít nhất 2 sản phẩm để kiểm tra tương kỵ.',
                'conflicts' => [],
                'pairs' => [],
                'pesticides' => [],
                'mixing_order' => [],
            ];
        }

        $pesticides = Pesticide::with('category')->whereIn('id', $pesticideIds)->get()->keyBy('id');
        $items = [];
        foreach ($pesticideIds as $id) {
            if (isset($pesticides[$id])) {
                $items[] = $pesticides[$id];
            }
        }

        $allConflicts = [];
        $pairResults = [];
        $dangerTotal = 0;
        $warningTotal = 0;

        // Duyệt từng cặp C(n, 2)
        $n = count($items);
        for ($i = 0; $i < $n; $i++) {
            for ($j = $i + 1; $j < $n; $j++) {
                $pA = $items[$i];
                $pB = $items[$j];
                $pair = $this->checkPair($pA, $pB);
                $pairResults[] = $pair;

                foreach ($pair['conflicts'] as $c) {
                    $key = $c['title'];
                    if (!isset($allConflicts[$key])) {
                        $allConflicts[$key] = $c;
                        $allConflicts[$key]['involved'] = [$pA->name, $pB->name];
                    } else {
                        $allConflicts[$key]['involved'][] = $pA->name;
                        $allConflicts[$key]['involved'][] = $pB->name;
                        $allConflicts[$key]['involved'] = array_unique($allConflicts[$key]['involved']);
                    }

                    if ($c['level'] === 'danger') $dangerTotal++;
                    if ($c['level'] === 'warning') $warningTotal++;
                }
            }
        }

        $overallStatus = 'safe';
        if ($dangerTotal > 0) {
            $overallStatus = 'danger';
        } elseif ($warningTotal > 0) {
            $overallStatus = 'warning';
        }

        return [
            'status' => $overallStatus,
            'pesticides' => $items,
            'conflicts' => array_values($allConflicts),
            'pair_results' => $pairResults,
            'mixing_order' => $this->determineMixingOrder($items),
        ];
    }

    /**
     * Xác định thứ tự pha vào phuy dựa trên dạng thuốc (Formulation).
     * Chuẩn quốc tế: W-A-L-E-S
     * 1. WP (Bột thấm nước) / WG (Hạt phân tán trong nước)
     * 2. SC (Huyền phù đậm đặc)
     * 3. EC / EW (Nhũ dầu)
     * 4. SL (Dung dịch hòa tan trong nước)
     * 5. Phân bón lá / Bám dính (Foliar / Surfactant)
     */
    public function determineMixingOrder(array $pesticides): array
    {
        $priorityMap = [
            'WG' => 1,
            'WP' => 2,
            'SP' => 3,
            'SC' => 4,
            'EW' => 5,
            'EC' => 6,
            'SL' => 7,
        ];

        $list = [];
        foreach ($pesticides as $p) {
            $form = $this->detectFormType($p);
            $isFertilizer = ($p->category?->slug === 'phan-bon-la');
            $priority = $form ? ($priorityMap[$form] ?? 8) : 8;
            if ($isFertilizer) {
                $priority += 10; // Phân bón thường cho sau cùng
            }

            $list[] = [
                'pesticide' => $p,
                'form_type' => $form ?? 'Chưa rõ',
                'priority' => $priority,
            ];
        }

        usort($list, fn($a, $b) => $a['priority'] <=> $b['priority']);

        return array_map(function ($item, $index) {
            $p = $item['pesticide'];
            return [
                'step' => $index + 1,
                'name' => $p->name,
                'form_type' => $item['form_type'],
                'instruction' => $this->getInstructionForStep($item['form_type'], $index + 1),
            ];
        }, $list, array_keys($list));
    }

    private function getInstructionForStep(string $form, int $step): string
    {
        return match ($form) {
            'WP', 'WG' => "Bước {$step}: Hòa tan dạng bột/cốm ({$form}) vào một xô nước riêng quấy tan 100% trước khi đổ vào phuy.",
            'SC' => "Bước {$step}: Đổ dạng huyền phù ({$form}) vào phuy đang có sẵn 1/2 lượng nước và khuấy đều.",
            'EW', 'EC' => "Bước {$step}: Đổ dạng nhũ dầu ({$form}) vào sau khi các dạng bột và huyền phù đã hòa tan đều.",
            'SL' => "Bước {$step}: Đổ dạng dung dịch lỏng ({$form}) vào phuy.",
            default => "Bước {$step}: Hòa tan riêng và đổ vào phuy, bổ sung nước vừa đủ thể tích.",
        };
    }

    /**
     * Lấy các lưu ý tương kỵ và gợi ý phối trộn cho 1 sản phẩm cụ thể (hiển thị trang chi tiết).
     */
    public function getIncompatibilitiesForPesticide(Pesticide $pesticide): array
    {
        $tags = $this->detectGroups($pesticide);
        $dangers = [];
        $warnings = [];
        $synergies = [];

        foreach ($this->rules as $rule) {
            [$reqA, $reqB] = $rule['pair'];
            $otherTag = null;

            if ($reqA === $reqB && in_array($reqA, $tags, true)) {
                $otherTag = $reqA;
            } elseif (in_array($reqA, $tags, true)) {
                $otherTag = $reqB;
            } elseif (in_array($reqB, $tags, true)) {
                $otherTag = $reqA;
            }

            if ($otherTag) {
                $groupInfo = self::GROUPS[$otherTag] ?? null;
                $item = [
                    'group_key' => $otherTag,
                    'group_name' => $groupInfo['name'] ?? $otherTag,
                    'examples' => $groupInfo['examples'] ?? '',
                    'title' => $rule['title'],
                    'reason' => $rule['reason'],
                    'consequence' => $rule['consequence'],
                    'advice' => $rule['advice'],
                ];

                if ($rule['level'] === 'danger') {
                    $dangers[] = $item;
                } else {
                    $warnings[] = $item;
                }
            }
        }

        // Gợi ý phối cộng lực an toàn dựa trên loại thuốc
        $catSlug = $pesticide->category?->slug ?? '';
        $formType = $this->detectFormType($pesticide);

        if (in_array('inorganic_copper', $tags, true)) {
            $synergies[] = [
                'title' => 'Phun đơn lẻ hoặc chỉ phối bám dính hữu cơ',
                'description' => 'Thuốc gốc đồng vô cơ phát huy hiệu lực rửa vườn tốt nhất khi phun đơn lẻ hoặc chỉ phối thêm chất loang trải siêu thấm.',
            ];
        } elseif (in_array('triazole', $tags, true)) {
            $synergies[] = [
                'title' => 'Cộng lực với Mancozeb / Propineb (FRAC M)',
                'description' => 'Phối hợp 1 thuốc lưu dẫn nội hấp (Triazole) với 1 hoạt chất tiếp xúc bảo vệ bề mặt đa điểm giúp mở rộng phổ trị bệnh và chống nấm kháng thuốc tuyệt hảo.',
            ];
            $synergies[] = [
                'title' => 'Cộng lực với Thuốc vi khuẩn (Kasugamycin)',
                'description' => 'Trong mùa mưa, phối nấm Triazole + Kasugamycin giúp quản lý đồng thời cả bệnh nấm thán thư và vi khuẩn thối nhũn.',
            ];
        } elseif (in_array('neonicotinoid', $tags, true)) {
            $synergies[] = [
                'title' => 'Cộng lực với Abamectin hoặc Emamectin (IRAC 6)',
                'description' => 'Diệt đồng thời cả bọ trĩ, rầy xanh và sâu cuốn lá, sâu đục đọt với cơ chế tiếp xúc + nội hấp mạnh mẽ.',
            ];
            $synergies[] = [
                'title' => 'Cộng lực với Buprofezin (Ức chế lột xác)',
                'description' => 'Neonicotinoid diệt nhanh rầy trưởng thành, Buprofezin diệt sạch trứng và ấu trùng non, cắt lứa rầy triệt để.',
            ];
        } elseif (in_array('biopesticide', $tags, true)) {
            $synergies[] = [
                'title' => 'Phối với Humic / Đạm cá / Bám dính sinh học',
                'description' => 'Cung cấp nguồn hữu cơ vi lượng giúp nấm đối kháng phát triển cực mạnh và tăng mật độ quần thể trong đất.',
            ];
        } else {
            $synergies[] = [
                'title' => 'Phối với Chất trợ lực Loang trải Siêu thấm',
                'description' => 'Giúp thuốc loang đều mặt lá, thấm nhanh qua tầng cutin, chống rửa trôi khi gặp trời mưa thất thường.',
            ];
        }

        return [
            'tags' => $tags,
            'form_type' => $formType,
            'dangers' => $dangers,
            'warnings' => $warnings,
            'synergies' => $synergies,
        ];
    }

    /**
     * Trả về bảng ma trận kỵ phối trộn tổng quan giữa các nhóm hóa chất.
     */
    public function getRulesMatrix(): array
    {
        $selectedKeys = [
            'inorganic_copper',
            'mineral_oil',
            'sulfur',
            'biopesticide',
            'alkaline',
            'organophosphate',
            'fosetyl_al',
            'high_calcium',
            'high_phosphorus',
            'triazole',
            'acid_amino',
        ];

        $matrix = [];
        foreach ($selectedKeys as $rowKey) {
            $matrix[$rowKey] = [];
            foreach ($selectedKeys as $colKey) {
                if ($rowKey === $colKey) {
                    $matrix[$rowKey][$colKey] = [
                        'status' => 'same',
                        'label' => 'Cùng nhóm',
                        'class' => 'bg-gray-100 text-gray-500',
                    ];
                    continue;
                }

                // Tìm rule tương ứng
                $found = null;
                foreach ($this->rules as $rule) {
                    [$a, $b] = $rule['pair'];
                    if (($a === $rowKey && $b === $colKey) || ($b === $rowKey && $a === $colKey)) {
                        $found = $rule;
                        break;
                    }
                }

                if ($found) {
                    if ($found['level'] === 'danger') {
                        $matrix[$rowKey][$colKey] = [
                            'status' => 'danger',
                            'label' => '❌ Cấm kỵ',
                            'title' => $found['title'],
                            'reason' => $found['reason'],
                            'class' => 'bg-red-50 text-red-700 font-bold border border-red-200',
                        ];
                    } else {
                        $matrix[$rowKey][$colKey] = [
                            'status' => 'warning',
                            'label' => '⚠️ Thận trọng',
                            'title' => $found['title'],
                            'reason' => $found['reason'],
                            'class' => 'bg-amber-50 text-amber-700 font-medium border border-amber-200',
                        ];
                    }
                } else {
                    $matrix[$rowKey][$colKey] = [
                        'status' => 'safe',
                        'label' => '✅ An toàn',
                        'title' => 'Tương thích phối trộn',
                        'reason' => 'Có thể phối chung được, chú ý thứ tự pha loãng trước khi đổ vào phuy.',
                        'class' => 'bg-emerald-50 text-emerald-700 font-medium border border-emerald-200',
                    ];
                }
            }
        }

        return [
            'keys' => $selectedKeys,
            'groups' => self::GROUPS,
            'matrix' => $matrix,
        ];
    }

    /**
     * Cung cấp cẩm nang nguyên tắc vàng và quy trình kiểm tra cốc nước (Jar test).
     */
    public function getMixingOrderGuide(): array
    {
        return [
            'golden_rules' => [
                [
                    'rule' => 'Quy tắc 1: Không bao giờ đổ 2 loại thuốc nguyên chất vào nhau',
                    'detail' => 'Phải hòa tan từng loại thuốc vào một lượng nước riêng (1/3 hoặc 1/2 phuy) rồi mới đổ tiếp loại thứ 2 vào.',
                ],
                [
                    'rule' => 'Quy tắc 2: Tuân thủ thứ tự dạng thuốc (Bột ➔ Huyền phù ➔ Nhũ dầu ➔ Nước)',
                    'detail' => 'Dạng hạt khó tan (WP, WG) phải hòa tan trước, dạng nhũ dầu (EC, EW) cho vào sau, và phân bón lá/chất bám dính cho vào cuối cùng.',
                ],
                [
                    'rule' => 'Quy tắc 3: Luôn thử nghiệm cốc nước (Jar Test) khi chưa chắc chắn',
                    'detail' => 'Lấy 1 lít nước, pha tỷ lệ nhỏ các loại thuốc theo đúng thứ tự, khuấy đều và để lắng 15 phút. Nếu không kết tủa, không vón cục, không đổi màu lạ, không tỏa nhiệt thì mới pha cả phuy.',
                ],
                [
                    'rule' => 'Quy tắc 4: Không phối quá 3 đến 4 loại thuốc trong cùng 1 lần phun',
                    'detail' => 'Việc phối quá nhiều loại vừa làm giảm hấp thu qua khí khổng lá, vừa tăng nguy cơ ngộ độc cháy hoa, nám trái và lãng phí tiền bạc.',
                ],
            ],
            'jar_test_steps' => [
                'B1: Chuẩn bị ca nhựa sạch chứa khoảng 1 lít nước từ nguồn nước sẽ pha phuy.',
                'B2: Lấy một lượng nhỏ thuốc cần phối theo đúng tỷ lệ nồng độ khuyến cáo.',
                'B3: Hòa tan thuốc thứ nhất tan hoàn toàn ➔ Cho tiếp thuốc thứ hai vào khuấy đều.',
                'B4: Để yên dung dịch trong 15 - 20 phút và quan sát hiện tượng.',
                'B5: Đánh giá: Nếu xuất hiện vón cục như óc đậu, kết tủa lắng đáy, tách lớp dầu nổi váng, hoặc cốc nóng lên bất thường ➔ TUYỆT ĐỐI KHÔNG PHA!',
            ],
        ];
    }

    /**
     * Phân tích tương kỵ giữa 2 Danh Mục và liệt kê cụ thể các sản phẩm xung đột.
     */
    public function checkCategoryCompatibility(int $cat1Id, int $cat2Id): array
    {
        $cat1 = \App\Models\Category::with('pesticides')->find($cat1Id);
        $cat2 = \App\Models\Category::with('pesticides')->find($cat2Id);

        if (!$cat1 || !$cat2) {
            return [
                'status' => 'empty',
                'message' => 'Không tìm thấy danh mục yêu cầu.',
                'conflict_pairs' => [],
            ];
        }

        $pesticides1 = $cat1->pesticides;
        $pesticides2 = $cat2->pesticides;

        $isSameCategory = ($cat1Id === $cat2Id);
        $isHerbicide1 = in_array($cat1->slug, ['thuoc-tru-co', 'thuoc-co'], true);
        $isHerbicide2 = in_array($cat2->slug, ['thuoc-tru-co', 'thuoc-co'], true);

        $conflictPairs = [];
        $dangerCount = 0;
        $warningCount = 0;
        $seenPairs = [];

        // Trường hợp đặc biệt 1: Một trong 2 danh mục là THUỐC TRỪ CỎ
        if (($isHerbicide1 || $isHerbicide2) && !$isSameCategory) {
            $herbCat = $isHerbicide1 ? $cat1 : $cat2;
            $otherCat = $isHerbicide1 ? $cat2 : $cat1;
            $herbProds = $isHerbicide1 ? $pesticides1 : $pesticides2;
            $otherProds = $isHerbicide1 ? $pesticides2 : $pesticides1;

            foreach ($herbProds as $hp) {
                foreach ($otherProds->take(6) as $op) { // Lấy các đại diện tiêu biểu
                    $conflictPairs[] = [
                        'product_1' => $isHerbicide1 ? $hp : $op,
                        'product_2' => $isHerbicide1 ? $op : $hp,
                        'level' => 'danger',
                        'title' => 'CẤM KỴ TUYỆT ĐỐI: Thuốc trừ cỏ không được trộn với bất kỳ sản phẩm nào!',
                        'reason' => 'Thuốc trừ cỏ chứa các hoạt chất tiêu diệt thực vật. Tuyệt đối không được pha chung với phân bón lá hay thuốc phun lên tán cây trồng.',
                        'consequence' => 'Sẽ làm rụng lá, chết đọt, cháy cây và hủy hoại hoàn toàn vườn cây ăn trái / hoa màu.',
                        'advice' => 'Sử dụng bình phun cỏ riêng biệt, phun sát mặt đất, tránh để bọt thuốc bay dính vào tán lá cây trồng.',
                    ];
                    $dangerCount++;
                }
            }

            return [
                'status' => 'danger',
                'category_1' => $cat1,
                'category_2' => $cat2,
                'is_same' => false,
                'summary' => 'CẢNH BÁO NGUY CẤP: Thuốc trừ cỏ tuyệt đối không bao giờ được pha chung với các danh mục khác!',
                'conflict_pairs' => $conflictPairs,
                'total_conflicts' => count($conflictPairs),
                'pesticides_count_1' => $pesticides1->count(),
                'pesticides_count_2' => $pesticides2->count(),
            ];
        }

        // Trường hợp 2: Kiểm tra chéo từng sản phẩm giữa 2 danh mục
        if ($isSameCategory) {
            // Cùng danh mục: kiểm tra nội bộ C(n, 2)
            $prods = $pesticides1->all();
            $n = count($prods);
            for ($i = 0; $i < $n; $i++) {
                for ($j = $i + 1; $j < $n; $j++) {
                    $pairRes = $this->checkPair($prods[$i], $prods[$j]);
                    if ($pairRes['status'] !== 'safe' && !empty($pairRes['conflicts'])) {
                        foreach ($pairRes['conflicts'] as $conf) {
                            $conflictPairs[] = [
                                'product_1' => $prods[$i],
                                'product_2' => $prods[$j],
                                'level' => $conf['level'],
                                'title' => $conf['title'],
                                'reason' => $conf['reason'],
                                'consequence' => $conf['consequence'],
                                'advice' => $conf['advice'],
                            ];
                            if ($conf['level'] === 'danger') $dangerCount++;
                            if ($conf['level'] === 'warning') $warningCount++;
                        }
                    }
                }
            }
        } else {
            // Khác danh mục: duyệt mọi cặp A in Cat1 x B in Cat2
            foreach ($pesticides1 as $pA) {
                foreach ($pesticides2 as $pB) {
                    $pairKey = $pA->id . '-' . $pB->id;
                    if (isset($seenPairs[$pairKey])) continue;
                    $seenPairs[$pairKey] = true;

                    $pairRes = $this->checkPair($pA, $pB);
                    if ($pairRes['status'] !== 'safe' && !empty($pairRes['conflicts'])) {
                        foreach ($pairRes['conflicts'] as $conf) {
                            $conflictPairs[] = [
                                'product_1' => $pA,
                                'product_2' => $pB,
                                'level' => $conf['level'],
                                'title' => $conf['title'],
                                'reason' => $conf['reason'],
                                'consequence' => $conf['consequence'],
                                'advice' => $conf['advice'],
                            ];
                            if ($conf['level'] === 'danger') $dangerCount++;
                            if ($conf['level'] === 'warning') $warningCount++;
                        }
                    }
                }
            }
        }

        $overallStatus = 'safe';
        $summary = 'Hai danh mục này có tính tương thích tốt. Các sản phẩm nhìn chung có thể phối hợp được nếu tuân thủ đúng thứ tự pha.';
        if ($dangerCount > 0) {
            $overallStatus = 'danger';
            $summary = "Phát hiện {$dangerCount} cặp sản phẩm CẤM KỴ TUYỆT ĐỐI giữa 2 danh mục này! Cần kiểm tra kỹ hoạt chất trước khi pha.";
        } elseif ($warningCount > 0) {
            $overallStatus = 'warning';
            $summary = "Có {$warningCount} cặp sản phẩm cần thận trọng (cùng cơ chế tác động hoặc cùng dạng nhũ dầu EC).";
        }

        return [
            'status' => $overallStatus,
            'category_1' => $cat1,
            'category_2' => $cat2,
            'is_same' => $isSameCategory,
            'summary' => $summary,
            'conflict_pairs' => $conflictPairs,
            'total_conflicts' => count($conflictPairs),
            'danger_count' => $dangerCount,
            'warning_count' => $warningCount,
            'pesticides_count_1' => $pesticides1->count(),
            'pesticides_count_2' => $pesticides2->count(),
        ];
    }

    /**
     * Lấy các lưu ý tương kỵ giữa một Danh mục cụ thể và các Danh mục khác.
     */
    public function getIncompatibilitiesForCategory(\App\Models\Category $category): array
    {
        $allCategories = \App\Models\Category::with('pesticides')->where('id', '!=', $category->id)->get();
        $incompatibleCategories = [];

        foreach ($allCategories as $otherCat) {
            $check = $this->checkCategoryCompatibility($category->id, $otherCat->id);
            if ($check['status'] !== 'safe' && $check['total_conflicts'] > 0) {
                $incompatibleCategories[] = [
                    'category' => $otherCat,
                    'status' => $check['status'],
                    'summary' => $check['summary'],
                    'total_conflicts' => $check['total_conflicts'],
                    'danger_count' => $check['danger_count'] ?? 0,
                    'sample_conflicts' => array_slice($check['conflict_pairs'], 0, 4),
                ];
            }
        }

        // Kiểm tra xung đột nội bộ nếu có (ví dụ phân bón lá)
        $internalCheck = $this->checkCategoryCompatibility($category->id, $category->id);
        $internalConflicts = [];
        if ($internalCheck['status'] !== 'safe' && $internalCheck['total_conflicts'] > 0) {
            $internalConflicts = [
                'status' => $internalCheck['status'],
                'summary' => 'Lưu ý: Ngay trong nội bộ danh mục này cũng có các sản phẩm kỵ nhau (ví dụ Canxi kỵ Lân cao/Sunfat).',
                'sample_conflicts' => array_slice($internalCheck['conflict_pairs'], 0, 4),
            ];
        }

        return [
            'category' => $category,
            'incompatible_categories' => $incompatibleCategories,
            'internal_conflicts' => $internalConflicts,
        ];
    }
}
