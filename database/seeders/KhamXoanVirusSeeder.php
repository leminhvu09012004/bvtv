<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class KhamXoanVirusSeeder extends Seeder
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

        // 1. Sao chép ảnh người dùng vừa tải lên
        $userSrc = 'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.user_uploaded/media_1791615603149.jpg';
        $destFile1 = 'kham-xoan-1.jpg';
        $destPath1 = "$destDir/$destFile1";

        if (file_exists($userSrc)) {
            copy($userSrc, $destPath1);
            $savedImages[] = "diseases/$destFile1";
        }

        // 2. Thêm các ảnh chất lượng cao minh họa triệu chứng khảm xoăn do virus
        $sampleUrls = [
            'https://images.openai.com/static-rsc-4/PVO6rUPqyCbRv9AIZpRVLgJHK2S2JcMbRKf_EaKuVnAzw244jSpNmeA9K41zBoimHsvc7VpO11z2zTcDm-KNsM5EZphpIL7DpqZ5Vwt2kRqIVfEXjTPwLAbo96Ceqc5OeaMeDAf-xq1l2MzLxclzrS0vcLc1bYtiYcs2donoyh0?purpose=inline',
            'https://images.openai.com/static-rsc-4/0o8eV3fDBwNWEq29NWi6n818G-NemaeEGmOQCu9VI6Qb8u9IdndPHU1-6HjVOA0WbgBIc9OEKccVGzlgeUFBsUt_vFTlWuuIlCHAFp-4gBwoJ5o75ZzEMnwwglZhUV8AzG6cY_OeP-vulYxBcmDsp6l4KeBCo-lqtL9701sZrkg?purpose=inline',
        ];

        // 3. Tạo hoặc cập nhật bản ghi Bệnh Khảm Xoăn Lá do Virus
        $diseaseData = [
            'name' => 'Bệnh Khảm Xoăn Lá (Virus Xoăn Ngọn, Khảm Lá, Chùn Đọt — Begomovirus / TYLCV / CMV)',
            'pathogen_type' => 'virus',
            'folder_code' => 'B-14',
            'folder_group' => 'nam_benh',
            'folder_name' => '14- khảm soăn',
            'folder_number' => 14,
            'caunho' => 'Khảm xoăn Virus = Lá xoăn tít lòng máng, đọt ngù còi cọc; bọ phấn trắng & bọ trĩ lây truyền. Không có thuốc diệt virus; phòng diệt côn trùng véc-tơ (Thiamethoxam, Imida, Spirotetramat) + tăng đề kháng Kẽm/Silic.',
            'symptoms' => "• Triệu chứng điển hình nhất là lá non bị xoăn tít lại, cuốn cong mép lá theo hình lòng máng (úp xuống hoặc ngửa lên), phiến lá dày cộm, giòn và sần sùi sọc gân.\n• Màu sắc lá loang lổ xen kẽ giữa các vệt xanh đậm và vàng sáng (vết da báo, hoa khảm); gân lá chuyển màu trong suốt hoặc biến màu vàng nhạt.\n• Cây bị chùn đọt (ngù ngọn), đốt thân co ngắn lại, cây lùn tịt và còi cọc; nụ hoa bị thui chột hoặc rụng sớm; nếu đậu trái thì trái nhỏ xíu, méo mó vặn vẹo, bề mặt sần sùi, chín sượng và không có giá trị thương phẩm.",
            'symptoms_detail' => [
                'la' => 'Lá đọt non xoăn tít, co rút thu nhỏ diện tích; phiến lá dày giòn sần sùi; khảm loang lổ xanh vàng loang lổ dạng da báo; mép lá uốn lượn cuốn cong hình thìa/lòng máng.',
                'canh_than' => 'Lóng thân ngắn cũn cỡn, cành chùn lại mọc thành bụi rậm rạp như chùm gửi; toàn cây lùn thấp còi cọc ngừng sinh trưởng.',
                'goc_re' => 'Hệ rễ suy thoái do thiếu dinh dưỡng quang hợp truyền xuống, rễ tơ cằn cỗi.',
                'qua' => 'Hoa rụng hàng loạt hoặc thui đen nụ; quả non bị méo mó, chai sượng, vỏ sần sùi lồi lõm, chín không đều hoặc rụng non sớm.',
            ],
            'prevention' => "1. Tiêu diệt triệt để véc-tơ truyền bệnh từ giai đoạn vườn ươm: Bọ phấn trắng (Bemisia tabaci), bọ trĩ và rệp muội là môi giới chích hút truyền virus từ cây bệnh sang cây khỏe. Cần dùng lưới chắn côn trùng (50 mesh) cho vườn ươm và luân phiên thuốc trừ rầy bọ phấn trắng.\n2. Vệ sinh đồng ruộng & Nhổ bỏ cây bệnh: Kiểm tra vườn thường xuyên, khi phát hiện cây chớm xuất hiện triệu chứng khảm xoăn cần nhổ bỏ ngay lập tức, cho vào bao nylon bịt kín đem ra xa tiêu hủy để cắt đứt nguồn lây lan.\n3. Đặt bẫy dính màu vàng/xanh: Treo bẫy dính màu vàng (bẫy bọ phấn trắng, rệp) và màu xanh lam (bẫy bọ trĩ) quanh ruộng với mật độ 20–30 bẫy/ha để theo dõi và tiêu diệt côn trùng trưởng thành.\n4. Tránh lây lan cơ giới: Khử trùng kéo tỉa, dao bấm bằng cồn khi tỉa cành bấm ngọn giữa các cây; tránh làm dập nát lá trong quá trình chăm sóc.",
            'treatment' => "1. NGUYÊN TẮC VÀNG TRONG ĐIỀU TRỊ BỆNH VIRUS:\n• Virus thực vật một khi đã xâm nhập sâu vào nhân tế bào thì KHÔNG CÓ THUỐC HÓA HỌC NÀO TIÊU DIỆT ĐƯỢC TRỰC TIẾP VIRUS mà không làm chết cây. Do đó chiến lược điều trị tập trung vào: (1) Diệt sạch côn trùng véc-tơ môi giới + (2) Phục hồi kích kháng miễn dịch tế bào.\n\n2. Phác đồ hóa học diệt véc-tơ môi giới truyền virus (Bọ phấn trắng, Bọ trĩ, Rệp muội):\n• Nhóm Neonicotinoid (IRAC 4A): Thiamethoxam (Nofara 35WG, Tegula 247SC), Imidacloprid (Thần Địch Trùng 200WP, Womida 700WG). Lưu dẫn cực mạnh, thấm sâu bảo vệ đọt non không bị chích hút lại.\n• Nhóm Cúc tổng hợp (IRAC 3A): Lambda-cyhalothrin, Cypermethrin (Dragon 440, Vovatox 600). Tiếp xúc hạ gục nhanh bọ phấn trắng và bọ trĩ ngoài cánh đồng.\n• Nhóm Ketoenol (IRAC 23): Spirotetramat diệt trứng và ấu trùng bọ phấn trắng hai chiều lưu dẫn.\n\n3. Biện pháp sinh học & Phục hồi kích kháng cây trồng:\n• Phun chế phẩm kích kháng sinh học: Chitosan / Oligochitosan hoặc Ningnanmycin để ức chế sự nhân lên của chuỗi RNA virus trong mô cây non.\n• Bổ sung vi lượng Kẽm (Zinc), Canxi - Silic và Axit Amin: Giúp vách tế bào lá dày dặn, cứng cáp chống kim châm của bọ chích hút, thúc cây bung đọt mới khỏe mạnh vượt qua giai đoạn còi cọc.",
            'chemical_groups' => 'Thiamethoxam / Imidacloprid (Neonicotinoid lưu dẫn - IRAC 4A), Alpha-cypermethrin / Lambda-cyhalothrin / Beta-cypermethrin / Cypermethrin (Cúc tổng hợp Pyrethroid - IRAC 3A), Profenofos / Phoxim (Lân hữu cơ Organophosphate - IRAC 1B), Emamectin benzoate / Abamectin (Avermectin sinh học - IRAC 6), Chitosan / Oligochitosan (Kích kháng sinh học vi lượng Kẽm/Silic)',
            'treatment_plans' => [
                [
                    'plan_name' => 'Phác đồ 1: Tiêu diệt triệt để côn trùng véc-tơ (Bọ phấn trắng & Bọ trĩ truyền virus)',
                    'action_type' => 'Phun ướt đẫm hai mặt lá non và đọt ngọn',
                    'stage' => 'Giai đoạn vườn ươm hoặc cây non vừa bén rễ, chớm thấy bọ phấn trắng/bọ trĩ xuất hiện',
                    'mixing_ratio' => '1 chai thuốc Neonicotinoid + Cúc tổng hợp pha cho 400 - 500 lít nước',
                    'instructions' => 'Phun vào sáng sớm hoặc chiều mát, xoáy béc phun từ dưới lên trên mặt lá non nơi bọ phấn trắng đẻ trứng và ẩn nấp.',
                    'target_pests' => ['Bọ phấn trắng', 'Bọ trĩ', 'Rệp muội'],
                    'products' => [
                        [
                            'role' => 'Hạ gục nhanh & lưu dẫn chống chích hút',
                            'recommended_name' => 'Tegula 247SC / Riegenf USA (Thiamethoxam + Lambda-cyhalothrin)',
                            'active_ingredient' => 'Thiamethoxam + Lambda-cyhalothrin',
                            'pesticide_id' => 192,
                            'dosage' => '200ml cho 400 lít nước',
                            'is_main' => true,
                            'substitute_ids' => [187],
                        ],
                    ],
                ],
                [
                    'plan_name' => 'Phác đồ 2: Cắt lứa bọ phấn trắng & rầy chích hút bằng lưu dẫn 2 chiều',
                    'action_type' => 'Phun tán lá định kỳ luân phiên',
                    'stage' => 'Khi mật độ bọ phấn trắng cao, có nguy cơ bùng phát dịch khảm xoăn ngù ngọn',
                    'mixing_ratio' => 'Movento 150OD + Trợ lực tinh dầu sinh học pha cho 400 lít nước',
                    'instructions' => 'Spiroteramat lưu dẫn 2 chiều diệt triệt để ấu trùng non mới nở và làm ung trứng bọ phấn trắng.',
                    'target_pests' => ['Ấu trùng bọ phấn trắng', 'Rệp dính', 'Rệp muội'],
                    'products' => [
                        [
                            'role' => 'Lưu dẫn hai chiều diệt ấu trùng và ung trứng',
                            'recommended_name' => 'Movento 150OD (Spirotetramat)',
                            'active_ingredient' => 'Spirotetramat',
                            'pesticide_id' => 170,
                            'dosage' => '250ml cho 400 lít nước',
                            'is_main' => true,
                            'substitute_ids' => [172],
                        ],
                    ],
                ],
                [
                    'plan_name' => 'Phác đồ 3: Kích kháng sinh học & Phục hồi đọt non còi cọc suy kiệt',
                    'action_type' => 'Phun lá kết hợp tưới gốc phục hồi',
                    'stage' => 'Sau khi đã diệt sạch côn trùng véc-tơ, hỗ trợ cây bung đọt mới lành lặn',
                    'mixing_ratio' => 'Chế phẩm sinh học Oligochitosan + Vi lượng Kẽm (Zinc) Silic + Axit Amin',
                    'instructions' => 'Giúp làm dày vách tế bào lá, nâng cao hệ miễn dịch tự nhiên của cây trồng, giảm thiểu biểu hiện xoăn lá.',
                    'target_pests' => ['Khảm lá', 'Xoăn đọt', 'Còi cọc'],
                    'products' => [
                        [
                            'role' => 'Kích kháng miễn dịch sinh học & Vi lượng chống xoăn',
                            'recommended_name' => 'Chế phẩm Chitosan sinh học + Kẽm Chelate',
                            'active_ingredient' => 'Chitosan + Zn',
                            'pesticide_id' => 158,
                            'dosage' => '250ml cho 400 lít nước',
                            'is_main' => true,
                            'substitute_ids' => [],
                        ],
                    ],
                ],
            ],
            'notes' => "Lưu ý chuyên môn:\n• Bệnh khảm xoăn do virus gây hại phổ biến trên hầu hết các nhóm cây trồng: Họ Cà (cà chua, ớt, cà tím), Họ Bầu bí (dưa leo, dưa lưới, dưa hấu, bí đỏ), Chanh dây (cứng trái khảm lá do PWV), Đu đủ (đốm vòng PRSV), Sắn mì (khảm lá sắn Begomovirus).\n• Tốc độ lây lan cực kỳ khủng khiếp nếu vườn có mật độ bọ phấn trắng hoặc bọ trĩ cao; chỉ cần 1 con bọ chích hút 15-30 phút là đã truyền virus sang cây mới.\n• Tài liệu tham khảo: Viện Nghiên cứu Rau quả (FAVRI), Cục Bảo vệ Thực vật, Bác Sĩ Cây Xanh.",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Cà chua & Họ cà, Dưa leo & Bầu bí, Chanh dây, Sầu riêng, Cây có múi',
        ];

        $disease = Disease::updateOrCreate(
            ['folder_code' => 'B-14'],
            $diseaseData
        );

        // 4. Gắn các cây trồng mẫn cảm
        $targetCropNames = ['Cà chua & Họ cà', 'Dưa leo & Bầu bí', 'Chanh dây', 'Sầu riêng', 'Cây có múi'];
        $linkedCropIds = Crop::whereIn('name', $targetCropNames)->pluck('id')->toArray();
        if (!empty($linkedCropIds)) {
            $disease->crops()->sync($linkedCropIds);
        }

        // 5. Gắn các thuốc BVTV đang có sẵn trong kho đặc trị véc-tơ bọ phấn trắng, bọ trĩ (không tự tạo mới thuốc)
        $pesticideKeywords = ['Lambda-cyhalothrin', 'Cyhalothrin', 'Cypermethrin', 'Thiamethoxam', 'Imidacloprid', 'Profenofos'];
        $matchingPesticideIds = Pesticide::where(function ($q) use ($pesticideKeywords) {
            foreach ($pesticideKeywords as $kw) {
                $q->orWhere('active_ingredient', 'like', "%{$kw}%")
                  ->orWhere('name', 'like', "%{$kw}%");
            }
        })->pluck('id')->toArray();

        if (!empty($matchingPesticideIds)) {
            $disease->pesticides()->sync($matchingPesticideIds);
        }
    }
}
