<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class RepVaySeeder extends Seeder
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

        // 1. Sao chép ảnh thực tế do người dùng cung cấp (Rệp vảy nâu mai cứng bám dày đặc trên cành thân)
        $src = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690263151.jpg';
        $filename = 'rep-vay-1.jpg';

        if (file_exists($src)) {
            copy($src, "$destDir/$filename");
            $savedImages[] = "diseases/$filename";
        }

        // 2. Dữ liệu hồ sơ chuẩn cho Rệp vảy
        $diseaseData = [
            'name' => 'Rệp Vảy & Rệp Sáp Vảy — Coccidae & Diaspididae (Rệp Vảy Nâu, Rệp Vảy Ốc, Rệp Vảy Cứng Thân Cành)',
            'pathogen_type' => 'chich_hut',
            'folder_code' => 'CH-06',
            'folder_group' => 'chich_hut',
            'folder_name' => '6-Rệp vảy',
            'folder_number' => 6,
            'caunho' => 'Rệp vảy = MAI CỨNG VỎ ỐC BÁM DÀY CÀNH THÂN (hút cạn nhựa, cành khô đen, nấm bồ hóng). Dập bằng Spirotetramat (Movento 150OD / Tề Thiên lưu dẫn 2 chiều), Prothiofos (Sheba 50EW phá lớp sáp) kết hợp Dầu khoáng và Thiamethoxam / Imidacloprid.',
            'symptoms' => "• Đặc điểm hình thái & Tập tính phá hại (như hình ảnh thực tế):\n- Rệp vảy thuộc hai nhóm chính: Rệp vảy mềm / vảy nâu (Coccidae - Coccus hesperidum, Saissetia oleae) và Rệp vảy cứng / vảy ốc (Diaspididae - Lepidosaphes spp., Aonidiella aurantii).\n- Cơ thể hình mai rùa, hình vỏ ốc hoặc hình bầu dục khum tròn, màu nâu đỏ, nâu xám hoặc đen bóng. Con trưởng thành tiết ra lớp sáp cứng bao phủ như lớp áo giáp dày bảo vệ toàn bộ cơ thể.\n- Chân và râu của con cái bị thoái hóa, chúng bám cố định một chỗ thành từng mảng dày đặc chằng chịt dọc theo thân cây, cành nhánh, cuống lá và vỏ quả.\n- Dùng vòi chích hút cắm sâu vào mô mạch dẫn hút cạn dịch nhựa dinh dưỡng của cây.\n• Trên thân cành & nhánh non:\n- Cành bị rệp vảy bám chi chít có bề mặt sần sùi cộm lên như vỏ ốc; mô vỏ cành bị teo tóp, nứt nẻ, chảy mủ.\n- Cành mất nhựa trở nên khô giòn, lá vàng úa và rụng trơ trụi cành; cành non khô chết dần từ ngoài ngọn vào trong thân.\n• Trên lá & quả non:\n- Bám dọc theo gân chính và cuống lá làm lá vàng vọt, biến dạng cằn cỗi.\n- Bám trên vỏ quả làm vỏ bị chai sần sùi, méo mó, quả non rụng nhiều, quả lớn bị nám xỉn màu mất giá trị thương phẩm.\n• Kéo theo nấm bồ hóng đen:\n- Trong quá trình chích hút, rệp vảy tiết ra chất thải chứa nhiều dịch đường ngọt thu hút đàn kiến đen/kiến lửa cộng sinh và tạo môi trường cho nấm bồ hóng (Capnodium / Meliola) phát triển đen kịt bao phủ toàn bộ bề mặt cành lá, ngăn cản hoàn toàn khả năng quang hợp của cây.",
            'symptoms_detail' => [
                'la' => 'Rệp bám dọc gân chính và cuống lá; lá vàng vọt úa tàn, rụng sớm; bề mặt lá bị mảng nấm bồ hóng đen kịt che phủ.',
                'canh_than' => 'Hàng trăm con rệp bám dày đặc như lớp vảy ốc bao bọc kín cành nhánh; vỏ cành teo tóp, nứt nẻ, khô chết cành giàn.',
                'goc_re' => 'Không gây hại trực tiếp dưới bộ rễ.',
                'qua' => 'Vỏ trái non bị bám đầy vảy rệp, vỏ chai sần, méo mó, biến màu và dễ rụng non trước thu hoạch.',
            ],
            'prevention' => "1. Cắt tỉa cành thông thoáng & tiêu hủy cành nhiễm nặng: Cắt bỏ các cành tăm, cành già khuất sáng bên trong tán cây. Với những cành nhánh bị rệp vảy bám dày đặc đen kịt không thể cứu chữa, cần cắt bỏ gom ra xa vườn đốt tiêu hủy để triệt tiêu ổ lây lan.\n2. Cọ rửa cơ học & phun rửa thân cành: Dùng vòi nước áp lực cao hoặc bàn chải cọ bớt lớp vảy rệp trên thân cành gốc, kết hợp phun Đồng Chelate để sát trùng vỏ cây và tẩy sạch nấm bồ hóng rêu mốc.\n3. Tiêu diệt đàn kiến cộng sinh: Rắc thuốc bột hoặc phun chân gốc diệt sạch đàn kiến đen, kiến lửa quanh gốc (kiến là phương tiện tha và phát tán ấu trùng rệp non từ cành này sang cành khác).\n4. Bảo vệ thiên địch tự nhiên: Bảo tồn các loài bọ rùa Chilocorus, ong ký sinh Encyrtidae và nấm ký sinh côn trùng trong tự nhiên.",
            'treatment' => "1. NGUYÊN TẮC VÀNG ĐẶC TRỊ RỆP VẢY:\n• Rệp vảy có lớp mai sáp cứng bao bọc như mai rùa nên các loại thuốc tiếp xúc thông thường PHUN LÊN SẼ BỊ TRÔI TUỘT, KHÔNG THẤM ĐƯỢC vào cơ thể rệp.\n• Bắt buộc áp dụng 2 chiến thuật: (1) Sử dụng hoạt chất LƯU DẪN 2 CHIỀU (Spirotetramat) để thuốc ngấm sâu vào mạch nhựa, rệp chích hút nhựa sẽ bị tiêu diệt từ bên trong; (2) Sử dụng hoạt chất XÔNG HƠI PHÁ SÁP (Prothiofos, Profenofos) kết hợp Dầu khoáng để làm mềm và hòa tan lớp mai sáp bên ngoài.\n• Phun thuốc xoáy kỹ vào các cành nhánh bị rệp bám; phun kép 2 lần cách nhau 5 - 7 ngày.\n\n2. Phác đồ hóa học đặc trị luân phiên:\n• Nhóm lưu dẫn 2 chiều đỉnh cao (IRAC 23): Spirotetramat 150g/l (Movento 150OD Bayer, Tề Thiên USA). Lưu dẫn hướng ngọn và hướng rễ cực mạnh, diệt sạch rệp vảy tận ngóc ngách kẽ cành mà không phụ thuộc vào lớp vỏ sáp.\n• Nhóm xông hơi phá vỡ màng sáp (IRAC 1B): Prothiofos 50% w/w (Sheba 50EW Hợp Trí), Profenofos 450g/l + Thiamethoxam (THPRO 550EC), Vovatox 600. Tác động tiếp xúc xông hơi cực mạnh, làm tan chảy lớp biểu bì sáp của rệp.\n• Nhóm Neonicotinoid lưu dẫn mô cây (IRAC 4A): Thiamethoxam (Nofara 35WG), Imidacloprid (Womida 700WG Juno). Chống tái nhiễm kéo dài 15 - 20 ngày.\n• Nhóm Carbamate lưu dẫn (IRAC 1A): Carbosulfan 200g/l (Afudan 20SC).\n\n3. Rửa sạch thân cành & phục hồi sinh lực:\n• Sau khi rệp vảy chết khô, phun kết hợp Đồng Xanh Mekong Agro để rửa trôi toàn bộ mảng nấm bồ hóng đen và mảng xác rệp bám trên cành.\n• Phun bổ sung Amino Acid (Xanh Um Monyka) và Enzyme vi lượng (Weyzym-A, Tang Truong Panaxilus) để làm lành vết nứt sẹo trên vỏ cành, thúc cây bung cơi đọt mới khỏe mạnh.",
            'chemical_groups' => 'Spirotetramat (Movento 150OD / Tề Thiên USA - IRAC 23 lưu dẫn 2 chiều đặc trị rệp vảy), Prothiofos (Sheba 50EW - IRAC 1B chuyên phá màng sáp), Profenofos + Thiamethoxam (THPRO 550EC / Vovatox 600 - IRAC 1B + 4A), Thiamethoxam (Nofara 35WG - IRAC 4A), Carbosulfan (Afudan 20SC - IRAC 1A), Đồng Chelate rửa sạch bồ hóng, Amino Acid & Enzyme phục hồi thân cành',
            'notes' => "Lưu ý thực tế từ kỹ sư BVTV:\n• Cây trồng chịu thiệt hại nặng nhất: Cây có múi (cam, quýt, bưởi), Sầu riêng, Chanh dây, Cà phê, Hồ tiêu, Nhãn, Vải, Hoa mai vàng, Hoa trà mi.\n• Khi quan sát thấy rệp chuyển sang màu xám tro, khô giòn và dễ dùng móng tay cạy tróc ra là rệp đã chết 100%.\n• Không phun phân bón lá có hàm lượng đạm cao khi cây đang bị rệp vảy tấn công nặng vì đạm làm vỏ cành non mềm kích thích rệp bùng phát nhanh hơn.\n• Tài liệu tham khảo: Viện Cây ăn quả Miền Nam (SOFRI), Cục Bảo vệ Thực vật, Viện KHKT Nông Lâm nghiệp Tây Nguyên (WASI).",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Sầu riêng, Cây có múi, Chanh dây, Cà phê, Hồ tiêu',
            'treatment_plans' => [
                [
                    'title'        => 'Phác đồ 1: Đặc trị dập dịch Rệp vảy mai cứng — Lưu dẫn 2 chiều dập tắt rệp tận mạch nhựa (Spirotetramat Movento / Tề Thiên + Prothiofos Sheba 50EW phá sáp)',
                    'badge'        => 'Lưu dẫn 2 chiều phá sáp',
                    'badge_color'  => 'emerald',
                    'stage'        => 'Khi phát hiện rệp vảy bám cộm dày đặc từng mảng trên cành thân, cây còi cọc nứt vỏ',
                    'dosage_guide' => 'Pha 1 chai Movento 150OD Bayer (240ml) hoặc Tề Thiên USA (240ml) + 1 chai Sheba 50EW Hợp Trí (250ml) cho 400 lít nước (2 phuy). Phun xoáy ướt đẫm các cành nhánh bị rệp bám.',
                    'safety_note'  => 'Spirotetramat lưu dẫn vào mạch nhựa tiêu diệt rệp từ bên trong, Prothiofos xông hơi phá tan lớp mai sáp bảo vệ bên ngoài. Phun lặp lại lần 2 sau 5 - 7 ngày để dập sạch lứa rệp non mới nở.',
                    'groups'       => [
                        [
                            'label'                => 'Spirotetramat lưu dẫn 2 chiều diệt rệp tận mạch nhựa',
                            'primary_pesticide_id' => 170, // MOVENTO 150OD BYER 240 (CHAI)
                            'substitute_ids'       => [188], // Tề Thiên USA
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Prothiofos xông hơi phá tan lớp mai sáp cứng',
                            'primary_pesticide_id' => 181, // Sheba 50EW Hợp Trí
                            'substitute_ids'       => [161], // AFUDAN 20SC 100MIL
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Vi lượng Chelate dưỡng cành mát cây',
                            'primary_pesticide_id' => 152, // TANG TRUONG PANAXILUS
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 2: Xông hơi hạ gục nhanh & Sát trùng thân cành rửa sạch nấm bồ hóng (Profenofos THPRO 550EC / Vovatox 600 + Nofara 35WG + Đồng Xanh)',
                    'badge'        => 'Xông hơi tẩy bồ hóng',
                    'badge_color'  => 'sky',
                    'stage'        => 'Vườn bị rệp vảy lan rộng diện tích lớn, cành lá đen kịt nấm bồ hóng',
                    'dosage_guide' => 'Pha 1 chai THPRO 550EC (450ml) hoặc Vovatox 600 (450ml) + 1 gói Nofara 35WG (100g) hoặc Womida 700WG (100g) + 1 chai Đồng Xanh Mekong Agro (500ml) cho 400 lít nước. Phun ướt đều thân cành và tán lá.',
                    'safety_note'  => 'Profenofos xông hơi mạnh làm mềm mai rệp, Thiamethoxam lưu dẫn diệt rệp non, Đồng Chelate sát trùng vỏ cành và tẩy sạch hoàn toàn lớp nấm bồ hóng đen.',
                    'groups'       => [
                        [
                            'label'                => 'Profenofos xông hơi cực mạnh làm mềm lớp mai sáp',
                            'primary_pesticide_id' => 185, // THPRO 550EC 450ML (CHAI)
                            'substitute_ids'       => [186, 165], // VOVATOX 600, DRAGON 999
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Thiamethoxam / Imidacloprid nội hấp lưu dẫn chống tái nhiễm',
                            'primary_pesticide_id' => 176, // NOFARA 35WG 100 GRAM (GOI)
                            'substitute_ids'       => [189], // Womida 700WG Juno
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Nano Đồng Chelate tẩy sạch nấm bồ hóng đen & rêu mốc',
                            'primary_pesticide_id' => 17, // Đồng Xanh Mekong Agro
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 3: Phục hồi sinh lực cành thân, dưỡng chồi non & làm lành biểu bì vỏ sau rệp',
                    'badge'        => 'Phục hồi thân cành',
                    'badge_color'  => 'amber',
                    'stage'        => 'Sau khi rệp vảy đã chết khô và tróc vảy, cần dưỡng cành mau liền sẹo và bung cơi đọt',
                    'dosage_guide' => 'Pha 1 chai Xanh Um Monyka (500ml) + 1 chai Weyzym-A (100ml) + 1 chai Tang Truong Panaxilus (500ml) cho 400 lít nước. Phun ướt đều tán lá và thân cành.',
                    'safety_note'  => 'Cung cấp Axit Amin đạm cá hữu cơ, Tinh chất Rong biển Seaweed, Enzyme sinh học và Canxi-Bo giúp làm lành các vết nứt châm chích trên vỏ cành, hồi sinh dòng nhựa lưu thông.',
                    'groups'       => [
                        [
                            'label'                => 'Axit Amin đạm cá & Tinh chất tảo biển Seaweed',
                            'primary_pesticide_id' => 159, // Xanh Um Monyka
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Enzyme & Canxi-Bo làm lành mô sẹo vỏ cây',
                            'primary_pesticide_id' => 158, // Weyzym-A Multiagro48
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Đa trung vi lượng Chelate nuôi chồi mới mập khỏe',
                            'primary_pesticide_id' => 152, // TANG TRUONG PANAXILUS
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

        // 3. Gắn các cây trồng mẫn cảm: Sầu riêng, Cây có múi, Chanh dây, Cà phê, Hồ tiêu
        $targetCropNames = ['Sầu riêng', 'Cây có múi', 'Chanh dây', 'Cà phê', 'Hồ tiêu'];
        $linkedCropIds = Crop::whereIn('name', $targetCropNames)->pluck('id')->toArray();
        if (!empty($linkedCropIds)) {
            $disease->crops()->sync($linkedCropIds);
        }

        // 4. Liên kết các thuốc BVTV có sẵn trong kho đặc trị rệp vảy
        // Movento (170), Tề Thiên (188), Sheba (181), Afudan (161), THPRO (185), Vovatox (186), Dragon 999 (165), Nofara (176), Womida (189), Đồng Xanh (17), Xanh Um Monyka (159), Weyzym-A (158), Tang Truong Panaxilus (152)
        $targetPesticideIds = [170, 188, 181, 161, 185, 186, 165, 176, 189, 17, 159, 158, 152];
        $validPesticideIds = Pesticide::whereIn('id', $targetPesticideIds)->pluck('id')->toArray();

        if (!empty($validPesticideIds)) {
            $disease->pesticides()->sync($validPesticideIds);
        }
    }
}
