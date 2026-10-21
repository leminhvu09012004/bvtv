<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class BoXitMuoiSeeder extends Seeder
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

        // 1. Sao chép 4 ảnh thực tế do người dùng cung cấp
        $userMediaFiles = [
            'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.tempmediaStorage/media_1791536576252.png',
            'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.tempmediaStorage/media_1791536541475.png',
            'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.tempmediaStorage/media_1791536434388.png',
            'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.tempmediaStorage/media_1791536010112.png',
        ];

        foreach ($userMediaFiles as $idx => $src) {
            $num = $idx + 1;
            $destFile = "bo-xit-muoi-{$num}.png";
            $destPath = "$destDir/$destFile";

            if (file_exists($src)) {
                copy($src, $destPath);
                $savedImages[] = "diseases/$destFile";
            }
        }

        // 2. Thêm các ảnh chất lượng cao minh họa nhận diện vòng đời và triệu chứng trên đọt/bông non
        $additionalUrls = [
            'https://images.openai.com/static-rsc-4/PVO6rUPqyCbRv9AIZpRVLgJHK2S2JcMbRKf_EaKuVnAzw244jSpNmeA9K41zBoimHsvc7VpO11z2zTcDm-KNsM5EZphpIL7DpqZ5Vwt2kRqIVfEXjTPwLAbo96Ceqc5OeaMeDAf-xq1l2MzLxclzrS0vcLc1bYtiYcs2donoyh0?purpose=inline',
        ];

        // 3. Tạo hoặc cập nhật bản ghi Bọ Xít Muỗi
        $diseaseData = [
            'name' => 'Bọ Xít Muỗi (Helopeltis theivora / Helopeltis antonii)',
            'pathogen_type' => 'chich_hut',
            'folder_code' => 'CH-02',
            'folder_group' => 'chich_hut',
            'folder_name' => '2-Bọ xít muỗi',
            'folder_number' => 2,
            'caunho' => 'Bọ xít muỗi = Châm đọt đen cháy, rụng hoa non chai trái; hoạt động sáng sớm & chiều mát. Phun phối hợp Cúc tổng hợp (Lambda/Alpha) + Neonicotinoid (Thiamethoxam/Imida).',
            'symptoms' => "• Cả con trưởng thành và ấu trùng (bọ non) đều dùng vòi chích hút dịch nhựa non từ chồi đọt, cuống lá, chùm hoa non và quả non.\n• Khi chích hút, bọ tiết ra nước bọt chứa độc tố làm tế bào thực vật xung quanh bị hoại tử, tạo thành các chấm đốm màu nâu đen lõm xuống như vết dầu loang.\n• Nhiều vết chích liên kết lại làm đọt non cong queo, khô teo và chết cháy (hiện tượng chổi sể, cháy đọt non); chùm hoa non thâm đen rụng bông hàng loạt; quả non nổi nhiều đốm ghẻ sần sùi màu nâu đen, chảy nhựa đông cứng làm trái biến dạng, chai sượng.",
            'symptoms_detail' => [
                'la' => 'Chồi non và búp lá non bị chích có vô số đốm nâu đen lõm xuống; phiến lá bị biến dạng quăn queo, mép lá rách rưới; toàn bộ cơi đọt non khô đen và rụng lá trơ cành.',
                'canh_than' => 'Cành non bị chích nhiều vết nứt nẻ, chảy nhựa nâu đen, các cành vượt và cành mang hoa khô teo từ ngoài ngọn vào trong thân.',
                'goc_re' => 'Không gây hại dưới bộ rễ.',
                'qua' => 'Châm cuống hoa và đài hoa làm hoa thâm đen, khô cháy rụng bông hàng loạt; quả non bị chích nổi vô số đốm nâu đen ghẻ sần sùi (như trên trái bơ, ca cao, mãng cầu), vỏ quả chai sượng méo mó không phát triển được.',
            ],
            'prevention' => "1. Tỉa cành tạo tán thông thoáng: Thường xuyên cắt tỉa cành tăm, cành sâu bệnh, chồi vượt rậm rạp bên trong tán để ánh nắng rọi vào tiêu diệt và xua đuổi bọ xít muỗi (chúng rất kị ánh sáng mặt trời mạnh).\n2. Vệ sinh vườn & trừ cỏ dại: Dọn sạch tàn dư lá mục ẩm ướt và cỏ dại quanh gốc (đặc biệt là cỏ ký chủ phụ như cỏ lào, cây họ cúc).\n3. Nuôi và bảo vệ thiên địch: Duy trì đàn kiến vàng (Oecophylla smaragdina), bọ rùa và nhện bắt mồi trong vườn cây ăn trái để tiêu diệt ấu trùng và xua đuổi bọ xít muỗi hiệu quả.\n4. Kích đọt và hoa đồng loạt: Bón phân cân đối, kích cơi đọt và xử lý ra hoa tập trung đồng loạt để quản lý phun thuốc bảo vệ tập trung trong thời gian ngắn.",
            'treatment' => "1. Thời điểm phun thuốc quyết định 90% hiệu quả:\n• Bọ xít muỗi ẩn nấp kỹ dưới các tán lá rậm rạp vào ban ngày và chỉ túa ra chích hút mạnh vào SÁNG SỚM (6h - 8h) hoặc CHIỀU MÁT (16h - 18h) hoặc những ngày âm u râm mát.\n• Bắt buộc phun vào sáng sớm hoặc chiều mát; phun xoáy ướt đều tán lá non, cơi đọt và chùm bông hoa non.\n\n2. Phác đồ hoạt chất hóa học đặc trị luân phiên:\n• Nhóm Cúc tổng hợp (Pyrethroid - IRAC 3A): Lambda-cyhalothrin, Alpha-cypermethrin, Cypermethrin. Tác dụng tiếp xúc, vị độc, tác động thần kinh cực nhanh hạ gục bọ xít muỗi ngay khi bay ra.\n• Nhóm Neonicotinoid (IRAC 4A): Thiamethoxam, Imidacloprid, Acetamiprid. Tính lưu dẫn và nội hấp cực mạnh vào mô đọt non, bảo vệ đọt hoa kéo dài 10 - 15 ngày.\n• Công thức Tank-mix hiệu quả nhất: Phối hợp 1 hoạt chất Cúc tổng hợp (hạ gục nhanh) + 1 hoạt chất Neonicotinoid (lưu dẫn chống tái nhiễm), ví dụ: Lambda-cyhalothrin + Thiamethoxam (Tegula 247SC, Riegenf USA).\n• Nhóm Lân hữu cơ (Organophosphate - IRAC 1B): Profenofos (Dragon 440, Vovatox 600) khi áp lực dịch hại bùng phát mạnh diện rộng.\n\n3. Số lần phun: Khi đọt non mới nhú (búp mũi giáo) hoặc nụ hoa vừa hé phun 1 lần; nếu mật độ bọ cao phun nhắc lại lần 2 sau 5 - 7 ngày.",
            'chemical_groups' => 'Alpha-cypermethrin / Lambda-cyhalothrin / Beta-cypermethrin / Cypermethrin (Cúc tổng hợp Pyrethroid - IRAC 3A), Thiamethoxam / Imidacloprid (Neonicotinoid lưu dẫn - IRAC 4A), Profenofos / Phoxim (Lân hữu cơ Organophosphate - IRAC 1B), Emamectin benzoate / Abamectin (Avermectin sinh học - IRAC 6), Tinh dầu Neem / Sinh học thảo mộc',
            'treatment_plans' => [
                [
                    'plan_name' => 'Phác đồ 1: Phun dập dịch bọ xít muỗi hạ gục nhanh & lưu dẫn chống tái nhiễm',
                    'action_type' => 'Phun tán lá non, cơi đọt và chùm hoa',
                    'stage' => 'Cơi đọt non mới nhú mũi giáo hoặc chùm nụ hoa vừa hé sáng sớm/chiều mát',
                    'mixing_ratio' => '1 chai thuốc Cúc tổng hợp + Neonicotinoid pha cho 400 - 500 lít nước',
                    'instructions' => 'Phun vào lúc sáng sớm (6h - 8h) hoặc chiều mát (16h - 18h) khi bọ xít muỗi ra ngoài chích hút. Phun ướt đẫm hai mặt lá non, cơi đọt và chùm hoa non.',
                    'target_pests' => ['Bọ xít muỗi', 'Rầy xanh', 'Bọ trĩ'],
                    'products' => [
                        [
                            'role' => 'Thuốc đặc trị hạ gục nhanh & lưu dẫn nội hấp',
                            'recommended_name' => 'Tegula 247SC / Riegenf USA (Thiamethoxam 141g/l + Lambda-cyhalothrin 106g/l)',
                            'active_ingredient' => 'Thiamethoxam + Lambda-cyhalothrin',
                            'pesticide_id' => 192,
                            'dosage' => '200ml cho 400 - 500 lít nước',
                            'is_main' => true,
                            'substitute_ids' => [187],
                        ],
                        [
                            'role' => 'Chất trợ lực loang trải thấm sâu',
                            'recommended_name' => 'Chất Thấm Sâu Tinh Dầu Cam Hữu Cơ',
                            'active_ingredient' => 'Orange oil / Polysorbate',
                            'pesticide_id' => 158,
                            'dosage' => '100ml cho 400 lít nước',
                            'is_main' => false,
                            'substitute_ids' => [],
                        ],
                    ],
                ],
                [
                    'plan_name' => 'Phác đồ 2: Đột phá cắt lứa bọ xít muỗi bùng phát mật độ cao (Xông hơi cực mạnh)',
                    'action_type' => 'Phun xoáy toàn bộ thân cành và tán lá',
                    'stage' => 'Khi phát hiện mật độ bọ xít muỗi châm đọt đen khô cành trên 5 con/đọt',
                    'mixing_ratio' => '1 chai Lân hữu cơ + Cúc tổng hợp pha cho 400 lít nước',
                    'instructions' => 'Phun xoáy sâu vào bên trong tán rậm rạp nơi bọ xít muỗi ẩn nấp ban ngày. Phun dập 2 lần cách nhau 5 ngày.',
                    'target_pests' => ['Bọ xít muỗi', 'Bọ cánh cứng', 'Rệp sáp'],
                    'products' => [
                        [
                            'role' => 'Lân hữu cơ xông hơi tiếp xúc cực mạnh',
                            'recommended_name' => 'Dragon 440EC / Vovatox 600 (Profenofos + Cypermethrin)',
                            'active_ingredient' => 'Profenofos + Cypermethrin',
                            'pesticide_id' => 176,
                            'dosage' => '400 - 500ml cho 400 lít nước',
                            'is_main' => true,
                            'substitute_ids' => [188],
                        ],
                    ],
                ],
                [
                    'plan_name' => 'Phác đồ 3: Quản lý sinh học an toàn giai đoạn bung hoa & đậu trái non',
                    'action_type' => 'Phun bảo vệ chùm hoa & trái non',
                    'stage' => 'Hoa đang xổ nhụy hoặc trái non mới thụ phấn nhạy cảm với hóa chất nóng',
                    'mixing_ratio' => 'Thuốc sinh học mát cây + Dinh dưỡng Canxi Bo chống rụng',
                    'instructions' => 'Phun hạt sương mịn phủ đều chùm bông và quả non vào chiều mát lúc 17h.',
                    'target_pests' => ['Bọ xít muỗi', 'Bọ trĩ', 'Sâu non'],
                    'products' => [
                        [
                            'role' => 'Sinh học mát hoa hạ gục chích hút',
                            'recommended_name' => 'Mectinstar 10EC / Rồng Đỏ 888 (Emamectin benzoate)',
                            'active_ingredient' => 'Emamectin benzoate',
                            'pesticide_id' => 180,
                            'dosage' => '200ml cho 400 lít nước',
                            'is_main' => true,
                            'substitute_ids' => [185],
                        ],
                    ],
                ],
            ],
            'notes' => "Lưu ý chuyên môn:\n• Bọ xít muỗi có 2 loài gây hại chủ yếu tại Việt Nam: Bọ xít muỗi đỏ (Helopeltis antonii) và Bọ xít muỗi xanh/đen (Helopeltis theivora).\n• Các cây trồng bị hại nặng nhất: Sầu riêng, Bơ, Điều, Cà phê, Ca cao, Hồ tiêu, Chè (trà), Chanh dây, Cây có múi.\n• Vết chích của bọ xít muỗi còn mở đường cho nấm Thán thư (Colletotrichum) và vi khuẩn xâm nhập gây hiện tượng thán thư khô đọt, thối bông và rụng trái non hàng loạt.\n• Tài liệu tham khảo: Viện Khoa học Kỹ thuật Nông Lâm nghiệp Tây Nguyên (WASI), Cục Bảo vệ Thực vật.",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Sầu riêng, Cây có múi, Chanh dây, Hồ tiêu, Cà phê',
        ];

        $disease = Disease::updateOrCreate(
            ['folder_code' => 'CH-02'],
            $diseaseData
        );

        // 4. Gắn các cây trồng mẫn cảm
        $targetCropNames = ['Sầu riêng', 'Cây có múi', 'Chanh dây', 'Hồ tiêu', 'Cà phê'];
        $linkedCropIds = Crop::whereIn('name', $targetCropNames)->pluck('id')->toArray();
        if (!empty($linkedCropIds)) {
            $disease->crops()->sync($linkedCropIds);
        }

        // 5. Gắn các sản phẩm thuốc BVTV có sẵn trong kho đặc trị bọ xít muỗi (không tạo mới sản phẩm thuốc!)
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
