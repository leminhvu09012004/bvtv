<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class RuoiVangDucQuaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Tải và lưu các ảnh minh họa chuẩn nếu chưa có
        $imageUrls = [
            'https://images.openai.com/static-rsc-4/cLUXGrZO_torHpaptLwUC7EBfV8LGkrgbpBZeGVTPDN2LNw1jwn0JZzm-cno_-ba4T3Mxb5BX_aPPsCQri_obl2hFiCa2VbuIPa5njLMVCn395h7DqRnuD90s74ks4_4TIGnRaN5Tm0mOlmenkB8Xh_9G9sjsEGpuP_kcVUWN5w?purpose=inline',
            'https://images.openai.com/static-rsc-4/yr7O2BfJ0hd1V4zCqEkjFhqYukl-UX0eaCdEXTYOcWLDtUDbg16tnFHDTY8CVP5r2VNuxgpeb-s4QrS34zSOFR9MaIOh6gLptRuV9j-g-Bju0lDoYrjnekiMatNxEthDRQoP4RCTQUDJZ3b84SkSckjntT5hFsY9IX61-ZhiJGo?purpose=inline',
            'https://images.openai.com/static-rsc-4/N3To-kLdyKd6b4E-PIq0_gLWeoxJfgec1PXY7ya2hGSJQ9HKA24x7AlROPYoxs8uZke1G4pw8Oyy3R0W0kUeaJcTJYWrWiNNAsLCtAhKgsHf4k6lzPAEX46IJHX5e_AE1FQmz-bCXL5I1DOganpC4GY6Ff2qJOU9M6QcoBvF0flCt1G90kB3G8pFBikuCYQO?purpose=inline',
            'https://images.openai.com/static-rsc-4/0o8eV3fDBwNWEq29NWi6n818G-NemaeEGmOQCu9VI6Qb8u9IdndPHU1-6HjVOA0WbgBIc9OEKccVGzlgeUFBsUt_vFTlWuuIlCHAFp-4gBwoJ5o75ZzEMnwwglZhUV8AzG6cY_OeP-vulYxBcmDsp6l4KeBCo-lqtL9701sZrkg?purpose=inline',
            'https://images.openai.com/static-rsc-4/e9DkUlP2Z6-e-yRAm8RM0yNjcjGceauW6tNNRjHZeeODw83AIfJbKNbDB1iJZW0O23v1zYMNFBTCg6NH-B2d05ed6Uw3z-Mxe1C_srb8P4o3_1SKwqRhTZyRv-xlZM3IdVV8LP1bc-olemPDA2RL32ShoZ5KpTeLkkk-1RNJPZ4?purpose=inline',
            'https://images.openai.com/static-rsc-4/Amxtm8J79zd_DdA6u_FO6wuyMlfTvOI_G6yfpXeDYXxkvbk86Z4zVyKIyMtFwu7m25Dc9tEHJ0ZgaqiqHiFTwHeHbawfPOnrBiwBJE0A44k8LXKFsiVaiwuem3owWxo1gP-JxgIebQp0J_2MBGBEw3HeBra7pXqTRvjIJly9Uhc?purpose=inline',
            'https://images.openai.com/static-rsc-4/_Ux9y1JI9ve8kWr8nwTTan86VQ_fIsvw010onqT5OiZo1Iwz0cfQSOz70tTjaI-m4fVKW8R5_UL0gO8KNYy7M0SEWcLY6xhe5zxcvy3rQO12iUjExxqw-n2ex3zx4zfPuxkbU3_oxPErw6i6tOpgy2aRicd5rXiVv_tdI-H9CbDM3_xZau3Of2vdsN3dfZFi?purpose=inline',
        ];

        $savedImages = [];
        $destDir = storage_path('app/public/diseases');
        if (!is_dir($destDir)) {
            mkdir($destDir, 0755, true);
        }

        $ctx = stream_context_create([
            'http' => [
                'timeout' => 10,
                'user_agent' => 'Mozilla/5.0',
            ],
        ]);

        foreach ($imageUrls as $idx => $url) {
            $num = $idx + 1;
            $filename = "ruoi-vang-{$num}.jpg";
            $destPath = "$destDir/$filename";

            if (!file_exists($destPath)) {
                $data = @file_get_contents($url, false, $ctx);
                if ($data !== false && strlen($data) > 1000) {
                    file_put_contents($destPath, $data);
                    $savedImages[] = "diseases/$filename";
                } else {
                    $savedImages[] = $url;
                }
            } else {
                $savedImages[] = "diseases/$filename";
            }
        }

        // 2. Tạo hoặc cập nhật bản ghi Bệnh hại / Đối tượng Dịch hại: Ruồi Vàng Đục Quả
        $diseaseData = [
            'name' => 'Ruồi Vàng Đục Quả (Bactrocera dorsalis / Bactrocera spp.)',
            'pathogen_type' => 'sau_hai',
            'folder_code' => 'S-01',
            'folder_group' => 'sau_hai',
            'folder_name' => '1 Ruồi vàng',
            'folder_number' => 1,
            'caunho' => 'Ruồi đục quả = Châm nâu vỏ, dòi ăn thối ruột, quả rụng sớm. Diệt bả Spinosad + Bẫy Protein thủy phân / Methyl Eugenol / Cue-lure; bao quả kịp thời.',
            'symptoms' => "• Ruồi trưởng thành châm vào vỏ quả đẻ trứng tạo vết châm màu nâu hoặc vết chích có quầng đen/nâu nhạt.\n• Trứng nở thành dòi (ấu trùng không chân, màu trắng ngà) đục khoét ăn phần thịt và ruột quả bên trong.\n• Vết châm chuyển nâu, quả mềm, thối và có thể rụng sớm. Ruồi phát triển thuận lợi khi có nhiều quả ký chủ thích hợp; quả rụng và quả nhiễm không được thu gom sẽ tiếp tục duy trì nguồn ruồi phát tán.",
            'symptoms_detail' => [
                'la' => 'Thường không gây hại trực tiếp trên lá. Ruồi trưởng thành thường đậu nghỉ dưới mặt lá rậm rạp che nắng vào ban ngày.',
                'canh_than' => 'Không gây hại trên thân cành.',
                'goc_re' => 'Dòi sau khi đẫy sức trong quả sẽ chui ra ngoài, rơi xuống đất quanh tán cây ở độ sâu 2 - 5cm để hóa nhộng.',
                'qua' => 'Vết châm nhỏ màu nâu trên vỏ quả; dòi trắng ngà cắn phá ăn luồn bên trong làm thịt quả mềm nhũn, thối rửa, chảy dịch chua và rụng sớm hàng loạt.',
            ],
            'prevention' => "1. Vệ sinh vườn định kỳ: Thu gom và tiêu hủy toàn bộ quả bị dòi, quả rụng dưới gốc (đào hố chôn sâu có rải vôi bột hoặc cho vào bao kín phơi nắng) để diệt triệt để nguồn nhộng và dòi phát tán, tuyệt đối không vứt bừa bãi xuống mương nước.\n2. Bao quả đúng thời điểm: Tiến hành bao quả sớm bằng túi chuyên dụng ngay sau khi tỉa định quả hoặc khi quả đạt kích thước thích hợp – đây là giải pháp cơ học bảo vệ quả hiệu quả và an toàn nhất.\n3. Đặt bẫy dẫn dụ: Dùng bẫy Pheromone dẫn dụ Methyl Eugenol (cho ruồi đực trên cây ăn quả) hoặc Cue-lure (cho cây họ bầu bí) treo quanh rìa vườn với mật độ 20–30 bẫy/ha để theo dõi mật độ và tiêu diệt ruồi trưởng thành.\n4. Cày xới gốc: Xới nhẹ đất quanh tán vào cuối vụ để phơi nhộng cho thiên địch ăn hoặc chết dưới ánh nắng.",
            'treatment' => "1. Biện pháp bả mồi Protein thủy phân (Ento-Pro, SOFRI...):\n• Pha bả protein thủy phân kết hợp tác nhân diệt ruồi (như Spinosad sinh học hoặc Fipronil liều nhỏ). Phun đốm bả mồi 1–2m² dưới tán lá rậm rạp mỗi cây vào buổi sáng sớm (7–9h) khi ruồi hoạt động mạnh; không phun tràn lan lên toàn bộ quả.\n2. Các nhóm hoạt chất hóa học phổ biến quản lý ruồi đục quả:\n• Nhóm Cúc tổng hợp (Pyrethroid - IRAC 3A): Alpha-cypermethrin, Lambda-cyhalothrin, Beta-cypermethrin... Tác động tiếp xúc, vị độc, tác động thần kinh cực nhanh, hạ gục ruồi trưởng thành và diệt trứng.\n• Nhóm Neonicotinoid (IRAC 4A): Thiamethoxam, Imidacloprid... Tính lưu dẫn, nội hấp và thấm sâu mạnh, diệt cả côn trùng chích hút và ruồi ăn bả.\n• Nhóm Lân hữu cơ (Organophosphate - IRAC 1B): Profenofos, Phoxim... Tác động tiếp xúc, vị độc, xông hơi và thấm sâu mạnh, phổ rộng.\n• Nhóm Phenylpyrazole (IRAC 2B): Fipronil (trong Regent 800WG, Tango 50SC...). Thường dùng phối trộn trong bả protein hoặc bả mồi để dẫn dụ và diệt ruồi đực hiệu quả.\n3. Nguyên tắc an toàn & cách ly:\n• Tuyệt đối không phun thuốc hóa học độc hại phổ rộng trực tiếp lên quả sắp thu hoạch để tránh tồn dư thuốc BVTV; kiểm tra đúng đối tượng đăng ký và tuân thủ thời gian cách ly (PHI). Methyl Eugenol và Cue-lure là chất dẫn dụ dùng trong bẫy pheromone, không phải thuốc trừ sâu để phun xịt.",
            'chemical_groups' => 'Alpha-cypermethrin / Lambda-cyhalothrin / Beta-cypermethrin / Cypermethrin (Cúc tổng hợp Pyrethroid - IRAC 3A), Thiamethoxam / Imidacloprid (Neonicotinoid lưu dẫn - IRAC 4A), Profenofos / Phoxim (Lân hữu cơ Organophosphate - IRAC 1B), Fipronil (Phenylpyrazole làm bả - IRAC 2B), Spinosad (Sinh học - IRAC 5), Protein thủy phân (Bả dẫn dụ đực và cái), Methyl Eugenol (Pheromone dẫn dụ ruồi đực cây ăn quả), Cue-lure (Pheromone dẫn dụ ruồi đực bầu bí)',
            'notes' => "Lưu ý chuyên môn:\n• Cây ăn quả bị hại: Xoài, ổi, cam, quýt, bưởi, đu đủ, thanh long, nhãn, táo, mận, na, khế, chanh dây, sầu riêng...\n• Cây họ bầu bí bị hại: Dưa leo, dưa hấu, mướp, khổ qua, bí đỏ, bí xanh...\n• Không phải tất cả cây trong danh sách đều do cùng một loài ruồi gây hại; cần xác định đúng loài (Bactrocera dorsalis hại cây ăn trái, Bactrocera cucurbitae hại bầu bí) để chọn bẫy dẫn dụ thích hợp (Methyl Eugenol hoặc Cue-lure).\n• Nguồn ảnh và tài liệu tham khảo: Khuyến nông Việt Nam (khuyennongvn.gov.vn), Đại học Hawaii (cms.ctahr.hawaii.edu), Cục Bảo vệ Thực vật, Thuốc diệt côn trùng 24h, Nông nghiệp Liên Quan.",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Chanh dây, Cây có múi, Dưa leo & Bầu bí, Cà chua & Họ cà, Nho, Sầu riêng',
            'treatment_plans' => [
                [
                    'title'        => 'Phác đồ 1: Dập dịch Ruồi vàng bằng bả dẫn dụ sinh học & Phun điểm hạ gục (Riegenf USA / THPRO 550EC + Protein thủy phân)',
                    'badge'        => 'Dập dịch ruồi vàng',
                    'badge_color'  => 'rose',
                    'stage'        => 'Khi bắt đầu thấy ruồi vàng bay vo ve trong vườn hoặc trên bẫy Pheromone có trên 5 - 10 con/bẫy',
                    'dosage_guide' => 'Pha 50ml Protein thủy phân (SOFRI / Ento-Pro) + 10ml Riegenf USA (hoặc THPRO 550EC) cho 1 lít nước. Phun đốm 1 - 2m² dưới tán lá rậm rạp mỗi cây vào sáng sớm (7h - 9h).',
                    'safety_note'  => 'Chỉ phun đốm dưới tán lá che nắng, tuyệt đối KHÔNG phun tràn lan lên toàn bộ quả để tránh tồn dư thuốc BVTV; thu gom quả rụng chôn sâu có rải vôi bột.',
                    'groups'       => [
                        [
                            'label'                => 'Lambda-Cyhalothrin + Thiamethoxam hạ gục cực nhanh ruồi ăn bả',
                            'primary_pesticide_id' => 187, // Riegenf USA
                            'substitute_ids'       => [192, 185], // TEGULA ẤN ĐỘ 247SC, THPRO 550EC
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 2: Xua đuổi ruồi đẻ trứng & Bảo vệ vỏ quả sáng đẹp, chống thối nhũn (Tegula 247SC + Antracol 70WP + CanxiBo EDTA)',
                    'badge'        => 'Xua đuổi & Ngừa thối quả',
                    'badge_color'  => 'sky',
                    'stage'        => 'Giai đoạn quả non đang phát triển đến trước khi bao trái hoặc quả bắt đầu chuyển màu chín',
                    'dosage_guide' => 'Pha 1 chai Tegula Ấn Độ 247SC (240ml) + 1 gói Antracol 70WP Bayer (300g) + 1 chai CanxiBo EDTA (250ml) cho 400 lít nước. Phun ướt đều khắp tán cây và chùm quả.',
                    'safety_note'  => 'Huyền phù SC sữa mát trái xua đuổi ruồi cái không dám châm đẻ trứng, Áo giáp Kẽm sát trùng vết châm ngừa nấm thối quả, Canxi-Bo làm dày cứng vỏ trái.',
                    'groups'       => [
                        [
                            'label'                => 'Tegula dạng SC sữa xua đuổi và hạ gục ruồi vàng trưởng thành',
                            'primary_pesticide_id' => 192, // TEGULA ẤN ĐỘ 247SC
                            'substitute_ids'       => [187], // Riegenf USA
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Áo giáp Kẽm Propineb Zinc++ sát khuẩn vết chích, chống thối nấm quả',
                            'primary_pesticide_id' => 7, // Antracol 70WP Bayer
                            'substitute_ids'       => [32], // Ridomil Gold 68WG
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Canxi-Bo hữu cơ làm dày vỏ quả, dai cuống chống rụng quả non',
                            'primary_pesticide_id' => 80, // CanxiBo EDTA
                            'substitute_ids'       => [158], // WEYZYM-A MULTIAGRO48
                        ],
                    ],
                ],
                [
                    'title'        => 'Phác đồ 3: Dưỡng trái sáng bóng, làm lành sẹo vết châm & Nuôi quả lớn nhanh xuất khẩu',
                    'badge'        => 'Dưỡng trái bóng đẹp',
                    'badge_color'  => 'amber',
                    'stage'        => 'Sau khi dập sạch ruồi, giai đoạn nuôi quả lớn nhanh và phục hồi vết chích cọ xát',
                    'dosage_guide' => 'Pha 1 chai Xanh Um Monyka (500ml) + 1 chai Weyzym-A Multiagro48 (100ml) cho 400 lít nước. Phun ướt đều tán lá và chùm quả.',
                    'safety_note'  => 'Axit Amin hữu cơ đạm cá và Rong biển làm lành sẹo, giúp quả căng mọng bóng đẹp, lên màu đồng đều, ngọt nước chắc múi.',
                    'groups'       => [
                        [
                            'label'                => 'Amino Acid đạm cá & Tảo biển Seaweed nuôi quả lớn nhanh, bóng đẹp',
                            'primary_pesticide_id' => 159, // Xanh Um Monyka
                            'substitute_ids'       => [],
                        ],
                        [
                            'operator'             => '➕',
                            'label'                => 'Enzyme sinh học & Canxi-Bo làm lành vết thương, chống nứt méo quả',
                            'primary_pesticide_id' => 158, // WEYZYM-A MULTIAGRO48
                            'substitute_ids'       => [80], // CanxiBo EDTA
                        ],
                    ],
                ],
            ],
        ];

        $disease = Disease::updateOrCreate(
            ['name' => $diseaseData['name']],
            $diseaseData
        );

        // 3. Gắn cây trồng liên quan
        $targetCropNames = ['Chanh dây', 'Cây có múi', 'Dưa leo & Bầu bí', 'Cà chua & Họ cà', 'Nho', 'Sầu riêng'];
        $linkedCropIds = Crop::whereIn('name', $targetCropNames)->pluck('id')->toArray();
        if (!empty($linkedCropIds)) {
            $disease->crops()->sync($linkedCropIds);
        }

        // 4. Gắn các thuốc BVTV đang có sẵn trong kho chứa các hoạt chất trên (không tự động tạo mới thuốc)
        $pesticideKeywords = ['cypermethrin', 'cyhalothrin', 'thiamethoxam', 'imidacloprid', 'profenofos', 'phoxim', 'fipronil'];
        $matchingPesticideIds = \App\Models\Pesticide::where(function ($q) use ($pesticideKeywords) {
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
