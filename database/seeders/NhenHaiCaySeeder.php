<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class NhenHaiCaySeeder extends Seeder
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

        // 1. Sao chép ảnh thực tế do người dùng vừa cung cấp (Hình ảnh phân biệt nhện đỏ, nhện vàng, nhện trắng và trứng nhện)
        $src = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791690230736.jpg';
        $filename = 'nhen-hai-cay-1.jpg';

        if (file_exists($src)) {
            copy($src, "$destDir/$filename");
            $savedImages[] = "diseases/$filename";
        }

        // 2. Dữ liệu hồ sơ chuẩn cho Nhện hại cây
        $diseaseData = [
            'name' => 'Nhện Đỏ & Nhện Hại Cây — Tetranychus urticae / Panonychus citri (Nhện Đỏ, Nhện Trắng, Nhện Vàng & Nhện Lông Nhung)',
            'pathogen_type' => 'nhen',
            'folder_code' => 'N-01',
            'folder_group' => 'nhen_tuyen_trung',
            'folder_name' => '06. NHỆN HẠI CÂY',
            'folder_number' => 1,
            'caunho' => 'Nhện hại cây = CHU KỲ NHANH, ĐẺ KHỦNG, ĂN HẾT DIỆP LỤC (Lá bạc màu, lá đồng cằn cỗi, mạng tơ dày đặc). Dập dịch bằng Fenbutatin Oxide (Nilmite), Etoxazole (Beered / Siêu Nhện Đỏ ung trứng), Spirodiclofen (Goldmite) kết hợp Abamectin (Resgant 5EC).',
            'symptoms' => "• Đặc điểm nhận diện & Tập tính phá hại (như hình ảnh phân loại thực tế):\n- Bao gồm các loài: Nhện đỏ hai chấm (Tetranychus urticae), Nhện đỏ cây có múi (Panonychus citri), Nhện vàng (Polyphagotarsonemus latus), Nhện trắng và Nhện lông nhung.\n- Kích thước hiển vi siêu nhỏ (0.2 - 0.5mm), thường tập trung hàng ngàn cá thể ở mặt dưới phiến lá non, lá bánh tẻ và kẽ cuống quả.\n- Cả nhện non và nhện trưởng thành đều dùng kìm hút chọc thủng lớp biểu bì biểu mô, hút cạn dịch nhựa và ăn sạch diệp lục tố (chlorophyll) của tế bào lá.\n• Trên phiến lá:\n- Ban đầu lá xuất hiện các chấm lấm tấm màu vàng xám hoặc trắng bạc li ti dọc theo gân chính của lá.\n- Khi mật độ nhện tăng cao, toàn bộ phiến lá bị biến màu xám bạc, lá chuyển sang màu vàng đồng, lá khô ráp giòn xơ xác (bệnh lá đồng, cháy bạc lá do nhện).\n- Nhện giăng các mạng tơ mỏng li ti bao phủ mặt dưới lá để di chuyển, bám dính bụi bẩn và chống cản nước mưa, thuốc bảo vệ thực vật.\n- Tán lá mất khả năng quang hợp nghiêm trọng, cơi đọt non bị chùn lại không lớn nổi; lá bánh tẻ và lá già rụng hàng loạt, cây trơ cành suy kiệt.\n• Trên quả non & quả bánh tẻ:\n- Nhện cạo lớp biểu bì vỏ trái non tạo thành các mảng da cám, da lu, vỏ sần sùi màu nâu xám xịt làm trái mất giá trị thương phẩm xuất khẩu (đặc biệt trên cam, quýt, bưởi, sầu riêng).",
            'symptoms_detail' => [
                'la' => 'Mặt dưới lá xuất hiện vô số chấm trắng xám li ti; lá chuyển màu bạc xám, ánh đồng cằn cỗi, có mạng tơ mỏng; lá rụng hàng loạt làm trơ trụi cành.',
                'canh_than' => 'Đọt non bị chùn quéo không phóng được, cành khẳng khiu còi cọc do thiếu hụt dinh dưỡng quang hợp.',
                'goc_re' => 'Không gây hại dưới bộ rễ.',
                'qua' => 'Vỏ trái non bị chích cạo tạo thành da cám, da lu xám xịt, trái sần sùi biến dạng, quả non rụng nhiều.',
            ],
            'prevention' => "1. Quản lý độ ẩm vườn trong mùa khô hạn: Nhện đỏ bùng phát dữ dội nhất trong điều kiện KHÔ NÓNG, ĐỘ ẨM THẤP (mùa nắng hạn, gió khô hanh). Cần tưới phun mưa định kỳ lên tán lá để rửa trôi mạng tơ và trứng nhện, duy trì độ ẩm mát trong vườn.\n2. Cắt tỉa cành thông thoáng & vệ sinh vườn: Cắt tỉa cành la sát đất, dọn sạch cỏ dại quanh gốc để ánh sáng phân bố đều, tạo điều kiện thuận lợi cho các loài thiên địch phát triển.\n3. Bảo vệ thiên địch tự nhiên: Không phun thuốc trừ sâu phổ rộng gốc lân hữu cơ hoặc cúc tổng hợp liên tục làm hủy diệt thiên địch (bọ rùa Stethorus, bọ trĩ bắt mồi, bọ xít hoa Orius và nhện bắt mồi Phytoseiidae).\n4. Nguyên tắc phun thuốc trừ nhện sống còn: Nhện sinh sản cực nhanh (chu kỳ chỉ 7 - 12 ngày) và rất mau kháng thuốc. BẮT BUỘC PHẢI LUÂN PHIÊN HOẠT CHẤT và PHẢI KẾT HỢP THUỐC DIỆT NHỆN LỚN + THUỐC UNG TRỨNG.",
            'treatment' => "1. NGUYÊN TẮC VÀNG ĐẶC TRỊ NHỆN ĐỎ:\n• Phun thuốc xoáy ướt đẫm MẶT DƯỚI LÁ và CÁC KẼ ĐỌT NON (nơi nhện tập trung 90% số lượng).\n• Công thức Tank-mix bắt buộc: 1 Thuốc diệt nhện trưởng thành (Fenbutatin Oxide / Spirodiclofen / Abamectin) ➕ 1 Thuốc diệt trứng, ấu trùng (Etoxazole).\n• Phun kép 2 lần cách nhau 4 - 5 ngày để tiêu diệt dứt điểm lứa nhện mới nở từ những quả trứng còn sót lại.\n\n2. Phác đồ hóa học đặc trị luân phiên:\n• Nhóm diệt trứng & ấu trùng (IRAC 10B): Etoxazole (Beered 400SC, Siêu Nhện Đỏ Sachnhen-Eto 110SC, Nhện Chúa 100SC). Hoạt chất vàng làm ung trứng 100%, ức chế lột xác, cắt đứt hoàn toàn vòng đời nhện.\n• Nhóm Thiếc hữu cơ đặc trị nhện lớn: Fenbutatin Oxide 550g/l (Nilmite Hợp Trí). Diệt sạch các dòng nhện đỏ đã kháng thuốc nhóm Cúc và Lân hữu cơ.\n• Nhóm ức chế Lipid (IRAC 23): Spirodiclofen 240g/l (Goldmite 240SC), Spirotetramat 150g/l (Movento 150OD Bayer, Tề Thiên USA). Lưu dẫn 2 chiều cực mạnh, tiêu diệt cả nhện đực, nhện cái và ấu trùng non.\n• Nhóm sinh học thẩm thấu nhanh (IRAC 6): Abamectin 50g/l (Resgant 5EC), Chlorfenapyr + Emamectin (Emaproza 10SC Nano). Hạ gục nhện lập tức sau 15 - 30 phút tiếp xúc.\n\n3. Dưỡng lá & hồi sinh diệp lục tố:\n• Sau khi quét sạch nhện, bổ sung ngay Xanh Um Monyka (Amino Acid hữu cơ & Tảo biển) + MgO - Kẽm EDTA (dạng sữa) để phục hồi tầng diệp lục tố màu xanh, chống hiện tượng cháy xám bạc lá.",
            'chemical_groups' => 'Etoxazole (IRAC 10B - Vua diệt trứng nhện & ấu trùng non), Fenbutatin Oxide (Nilmite Hợp Trí - Thiếc hữu cơ diệt nhện lớn), Spirodiclofen (Goldmite 240SC - IRAC 23 ức chế Lipid), Spirotetramat (Movento 150OD / Tề Thiên USA - IRAC 23 lưu dẫn 2 chiều), Abamectin 5EC (Resgant 5EC - IRAC 6), Chlorfenapyr + Emamectin (Emaproza 10SC), Amino Acid & Tảo biển + MgO Kẽm EDTA phục hồi lá',
            'notes' => "Lưu ý thực tế từ kỹ sư BVTV:\n• Cây trồng chịu thiệt hại nặng nề nhất: Sầu riêng (bạc lá đồng, rụng lá trơ cành), Cây có múi (da cám, da lu quả), Chanh dây, Hồ tiêu, Cà phê, Hoa hồng, Dưa hấu.\n• Nhện đỏ phát triển thành đại dịch trong mùa khô nắng hạn hoặc sau các đợt phun thuốc trừ sâu rầy gốc Pyrethroid làm mất cân bằng sinh thái.\n• Nếu không kèm thuốc diệt trứng (Etoxazole), chỉ 3 - 5 ngày sau lứa trứng cũ nở ra mật độ nhện sẽ bùng phát trở lại như cũ.\n• Tài liệu tham khảo: Viện Cây ăn quả Miền Nam (SOFRI), Cục Bảo vệ Thực vật, Viện Nghiên cứu Rau quả (FAVRI).",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Sầu riêng, Cây có múi, Chanh dây, Hồ tiêu, Cà phê',
            'treatment_plans' => [
                [
                    'title'        => 'Phác đồ 1: Đặc trị dập dịch Nhện đỏ kháng thuốc — Diệt cả nhện lớn và ung sạch trứng nhện (Etoxazole + Fenbutatin Oxide / Spirodiclofen + Abamectin)',
                    'badge'        => 'Dập dịch nhện đỏ',
                    'badge_color'  => 'rose',
                    'stage'        => 'Khi phát hiện mật độ nhện đỏ cao, lá chớm bạc màu lấm tấm, có mạng tơ li ti mặt dưới lá',
                    'dosage_guide' => 'Pha 1 chai Beered 400SC (240ml) hoặc Siêu Nhện Đỏ Sachnhen-Eto (240ml) + 1 chai Nilmite Nhện Đỏ Hợp Trí (240ml) hoặc Goldmite 240SC (240ml) + 1 chai Resgant 5EC (100ml) cho 400 lít nước (2 phuy). Phun xoáy ướt đẫm 2 mặt lá, đặc biệt là mặt dưới lá.',
                    'safety_note'  => 'Phun đẫm đều tán lá vào buổi sáng sớm hoặc chiều mát. Bắt buộc phun nhắc lại lần 2 sau 4 - 5 ngày để dập tắt triệt để lứa nhện con mới nở.',
                    'groups'       => [
                        [
                            'label'                => 'Etoxazole làm ung sạch trứng nhện, cắt đứt vòng đời',
                            'primary_pesticide_id' => 163, // BEERED 400SC NHEN DO 10 (CHAI)
                            'substitute_ids'       => [182, 173], // Siêu Nhện Đỏ Sachnhen-Eto 110SC, NHEN CHUA 100SC
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Fenbutatin Oxide / Spirodiclofen diệt nhện lớn kháng thuốc',
                            'primary_pesticide_id' => 175, // NILMITE NHEN DO HOPTRI (CHAI)
                            'substitute_ids'       => [562], // Goldmite 240SC
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Abamectin sinh học thấm sâu hạ gục nhanh',
                            'primary_pesticide_id' => 180, // RESGANT 5EC VIETTHANG (CHAI)
                            'substitute_ids'       => [171], // Emaproza 10SC Nano
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 2: Lưu dẫn 2 chiều diệt nhện tận đọt non & ngóc ngách kẽ lá (Spirotetramat Movento / Tề Thiên + Etoxazole ung trứng)',
                    'badge'        => 'Lưu dẫn 2 chiều',
                    'badge_color'  => 'sky',
                    'stage'        => 'Giai đoạn cơi đọt non mới bung, tán lá rậm rạp khó phun trúng trực tiếp mặt dưới lá',
                    'dosage_guide' => 'Pha 1 chai Movento 150OD Bayer (240ml) hoặc Tề Thiên USA (240ml) + 1 chai Siêu Nhện Đỏ Sachnhen-Eto (240ml) + 1 chai Tang Truong Panaxilus (250ml) cho 400 lít nước. Phun đều tán cây.',
                    'safety_note'  => 'Spirotetramat lưu dẫn 2 chiều di chuyển vào các mô lá non và khe cuống quả, làm tê liệt nhện chích hút và triệt tiêu khả năng sinh sản của nhện cái.',
                    'groups'       => [
                        [
                            'label'                => 'Spirotetramat lưu dẫn 2 chiều diệt nhện tận ngóc ngách',
                            'primary_pesticide_id' => 170, // MOVENTO 150OD BYER 240 (CHAI)
                            'substitute_ids'       => [188], // Tề Thiên USA
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Etoxazole ức chế lột xác & làm ung trứng nhện',
                            'primary_pesticide_id' => 182, // Siêu Nhện Đỏ Sachnhen-Eto 110SC
                            'substitute_ids'       => [163], // BEERED 400SC
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Vi lượng Chelate dưỡng đọt mát cây',
                            'primary_pesticide_id' => 152, // TANG TRUONG PANAXILUS
                            'substitute_ids'       => [],
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 3: Phục hồi tán lá xanh dày, tái tạo diệp lục tố & chống cháy bạc lá sau nhện',
                    'badge'        => 'Phục hồi xanh lá',
                    'badge_color'  => 'emerald',
                    'stage'        => 'Sau khi dập sạch nhện đỏ, lá bị mất diệp lục biến thành màu bạc đồng cằn cỗi',
                    'dosage_guide' => 'Pha 1 chai Xanh Um Monyka (500ml) + 1 chai MgO - Kẽm EDTA (250ml) + 1 chai Tang Truong Panaxilus (500ml) cho 400 lít nước. Phun ướt đều 2 mặt lá.',
                    'safety_note'  => 'Bổ sung Axit Amin hữu cơ từ đạm cá biển, Tinh chất Rong biển Seaweed kết hợp Magie và Kẽm Chelate dạng sữa giúp kích hoạt lại quá trình quang hợp, phục hồi tầng diệp lục tố xanh mướt cho phiến lá.',
                    'groups'       => [
                        [
                            'label'                => 'Axit Amin đạm cá & Tinh chất tảo biển Seaweed phục hồi',
                            'primary_pesticide_id' => 159, // Xanh Um Monyka
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Magie & Kẽm Chelate dạng sữa bù đắp diệp lục tố',
                            'primary_pesticide_id' => 111, // MgO - Kẽm EDTA
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Vi lượng Chelate nuôi tán lá dày khỏe',
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

        // 3. Gắn các cây trồng mẫn cảm: Sầu riêng, Cây có múi, Chanh dây, Hồ tiêu, Cà phê
        $targetCropNames = ['Sầu riêng', 'Cây có múi', 'Chanh dây', 'Hồ tiêu', 'Cà phê'];
        $linkedCropIds = Crop::whereIn('name', $targetCropNames)->pluck('id')->toArray();
        if (!empty($linkedCropIds)) {
            $disease->crops()->sync($linkedCropIds);
        }

        // 4. Liên kết các thuốc BVTV có sẵn trong kho đặc trị nhện đỏ & nhện hại cây
        // Beered (163), Siêu Nhện Đỏ Eto (182), Nhện Chúa (173), Nilmite (175), Goldmite (562), Resgant (180), Movento (170), Tề Thiên (188), Emaproza (171), Xanh Um Monyka (159), MgO Kẽm (111), Tang Truong Panaxilus (152)
        $targetPesticideIds = [163, 182, 173, 175, 562, 180, 170, 188, 171, 159, 111, 152];
        $validPesticideIds = Pesticide::whereIn('id', $targetPesticideIds)->pluck('id')->toArray();

        if (!empty($validPesticideIds)) {
            $disease->pesticides()->sync($validPesticideIds);
        }
    }
}
