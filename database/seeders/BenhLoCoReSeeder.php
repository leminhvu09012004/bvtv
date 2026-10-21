<?php

namespace Database\Seeders;

use App\Models\Crop;
use App\Models\Disease;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class BenhLoCoReSeeder extends Seeder
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

        // 1. Sao chép 3 ảnh thực tế sầu riêng từ local
        $localImages = [
            'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.tempmediaStorage/media_1791536576252.png',
            'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.tempmediaStorage/media_1791536541475.png',
            'C:/Users/ADMIN/.gemini/antigravity-ide/brain/171382ee-9cb5-4975-814c-ed9ffa7b2a58/.tempmediaStorage/media_1791536434388.png',
        ];

        foreach ($localImages as $idx => $locPath) {
            $num = $idx + 1;
            $destFile = "lo-co-re-sau-rieng-{$num}.png";
            $destPath = "$destDir/$destFile";
            if (file_exists($locPath)) {
                copy($locPath, $destPath);
                $savedImages[] = "diseases/$destFile";
            }
        }

        // 2. Tải và lưu 4 ảnh minh họa online từ OpenAI static
        $onlineUrls = [
            'https://images.openai.com/static-rsc-4/PVO6rUPqyCbRv9AIZpRVLgJHK2S2JcMbRKf_EaKuVnAzw244jSpNmeA9K41zBoimHsvc7VpO11z2zTcDm-KNsM5EZphpIL7DpqZ5Vwt2kRqIVfEXjTPwLAbo96Ceqc5OeaMeDAf-xq1l2MzLxclzrS0vcLc1bYtiYcs2donoyh0?purpose=inline',
            'https://images.openai.com/static-rsc-4/YexkziLBAuCafTjDX_zJ6iJVhj-1ynIKjsK-LtK0SHa2JvAajYmZ4A8mqtBTVKV98P6l-FQF1UNF7hAjXFrCK9Nr1Oqs3dfFKAbPpVkgGEnZ_cVgUJ2vmWNm9QL_HlcVQxm1fQw-Qv9KcOjT-De9lgBq102tFqf4pO0CArZy4r8?purpose=inline',
            'https://images.openai.com/static-rsc-4/E7ZEXVSEpe1SOotlYDcA3ETbHdT_rP7wAetzFcGOu8X1msJ9guoZqcPKrmOcjT_4IIRTp83AaMqfZ2nCPq1OYQZ3FvYtsIXFXy8iyrGahHm7_9PwXNFoSqvsOHzLXvBZ21yLH9fp7uL3NvQjBnVqActH0IzTa3BJoJB8VxyC3Ys?purpose=inline',
            'https://images.openai.com/static-rsc-4/d8ewwEIII9qDs22S5SmDhxQiLLH4OvPAhHQBOYPGL111dLdvTv2VldaHsZzN-QDR1XQYbPbxmVV9H7AAtSd1ZNcvIbkqN1jpLxJo0xMR4OHntN_LWMNIMqKV4sVYjIOIpBBcdN1JQf_sqzE21wLVskzXTnbtB-hBh1qPPZjNG4Y?purpose=inline',
        ];

        $ctx = stream_context_create([
            'http' => [
                'timeout' => 10,
                'user_agent' => 'Mozilla/5.0',
            ],
        ]);

        foreach ($onlineUrls as $idx => $url) {
            $num = $idx + 1;
            $destFile = "lo-co-re-online-{$num}.jpg";
            $destPath = "$destDir/$destFile";

            if (!file_exists($destPath)) {
                $data = @file_get_contents($url, false, $ctx);
                if ($data !== false && strlen($data) > 1000) {
                    file_put_contents($destPath, $data);
                    $savedImages[] = "diseases/$destFile";
                } else {
                    $savedImages[] = $url;
                }
            } else {
                $savedImages[] = "diseases/$destFile";
            }
        }

        // 3. Tạo hoặc cập nhật bản ghi Bệnh: Bệnh lở cổ rễ (Rhizoctonia solani) / Chết rạp cây con
        $diseaseData = [
            'name' => 'Bệnh Lở Cổ Rễ (Rhizoctonia solani / Chết Rạp Cây Con)',
            'pathogen_type' => 'nam_benh',
            'folder_code' => 'CD-01',
            'folder_group' => 'nam_benh',
            'folder_name' => 'Chẩn đoán phân biệt vàng lá thối rễ',
            'folder_number' => 15,
            'caunho' => 'Lở cổ rễ = Cổ thân teo thắt thâm nâu, cây con héo rũ đổ gục; nấm đất Rhizoctonia / Fusarium / Pythium. Ngừa Trichoderma, trị Validamycin, Azoxystrobin, Pencycuron, Fludioxonil, Hexaconazole.',
            'symptoms' => "• Gốc thân sát mặt đất xuất hiện các vết đốm nâu đậm, vết loét lõm dần vào trong và thắt nghẽn cổ thân (cổ chai).\n• Phần vỏ cổ thân bị thối rữa, tróc vỏ làm tắc mạch dẫn; cây con héo rũ đột ngột vào buổi trưa, mất sức sống, đổ gục (chết rạp cây con).\n• Bộ rễ bị thối đen, rễ tơ và rễ cám bị tiêu biến hoàn toàn. Trên cây lâu năm (sầu riêng, cà phê), vết bệnh loét thối ẩm ướt ở phần vỏ gốc sát mặt đất, vỏ nứt và chảy dịch nâu, lá trên ngọn vàng héo dần.",
            'symptoms_detail' => [
                'la' => 'Lá chuyển màu xanh tái, héo rũ vào trưa nắng và hồi phục tạm thời chiều mát trong vài ngày đầu; sau đó toàn bộ lá chuyển vàng úa, khô teo và chết rũ nhưng vẫn có thể dính trên cây.',
                'canh_than' => 'Cổ thân sát mặt đất teo thắt nhỏ lại, vỏ thân chuyển màu nâu đen, thối mục làm cây mất điểm tựa và bị đổ rạp gãy ngang gốc.',
                'goc_re' => 'Cổ rễ thâm nâu, vết loét lõm ăn sâu vào tầng mô mạch dẫn. Toàn bộ chùm rễ tơ bị thối nhũn, vỏ rễ dễ dàng tuột khỏi lõi gỗ khi nhổ cây lên kiểm tra.',
                'qua' => 'Bệnh chủ yếu gây hại vùng cổ rễ và gốc thân. Trên các cành quả sà sát mặt đất, nấm có thể theo giọt nước mưa bắn lên làm thối đốm nâu quả non.',
            ],
            'prevention' => "1. Xử lý đất & giá thể ươm: Đất ươm cây con cần được xử lý khử trùng bằng vôi bột hoặc chế phẩm sinh học đối kháng Trichoderma spp., phơi ải đất kỹ trước khi gieo trồng.\n2. Lên luống cao & thoát nước: Thiết kế rãnh thoát nước sâu trong mùa mưa, tránh tuyệt đối ngập úng đọng nước quanh cổ rễ cây con và gốc sầu riêng, cà phê.\n3. Vệ sinh thông thoáng gốc: Cào sạch cỏ rác mục và lá rụng ẩm ướt quanh cổ gốc; tỉa cành thông thoáng sát gốc để ánh nắng rọi vào tiêu diệt bào tử nấm.\n4. Bón lót phân hữu cơ vi sinh: Kết hợp nấm đối kháng Trichoderma ủ cùng phân chuồng hoai mục để cạnh tranh sinh học và ức chế nấm Rhizoctonia solani trong đất.",
            'treatment' => "1. Biện pháp xử lý khẩn cấp cây con & vườn ươm:\n• Nhổ bỏ và tiêu hủy các cây con bị thối nặng, cách ly vùng giá thể nhiễm bệnh.\n• Tưới ướt đẫm gốc toàn bộ luống hoặc khay ươm bằng dung dịch thuốc đặc trị để chặn đứng vết loét và bảo vệ các cây xung quanh.\n\n2. Bảng sản phẩm ví dụ & Liều lượng pha khuyến cáo phòng trị lở cổ rễ (Rhizoctonia solani):\n• Hexaconazole, Difenoconazole (Anvil, Japa Vil, Score...): Thuốc chứa hoạt chất phù hợp, dùng theo liều lượng khuyến cáo trên nhãn.\n• Carbenda Supper 50SC (Carbendazim): Pha 16 ml cho bình 16 lít nước.\n• Vali 5SL / Vali 3SL (Validamycin A): Pha 40 ml (đối với 5SL) hoặc 60 ml (đối với 3SL) cho bình 16 lít nước.\n• Bonny 4SL: Pha 30 ml cho bình 16 lít nước.\n• Pulsor 23F (Thifluzamide - SDHI): Pha 12 ml cho bình 16 lít nước (đặc trị nấm Rhizoctonia).\n• Trobin top 325SC, Heroga 64SL, Niclosat 4SL...: Dùng theo liều khuyến cáo của nhà sản xuất.\n\n3. Đối với cây công nghiệp & cây ăn trái lâu năm (Sầu riêng, Cà phê, Hồ tiêu):\n• Cào nhẹ lớp đất mặt quanh cổ rễ để lộ phần vỏ bị bệnh; cạo sạch phần vỏ thối hoại tử đến lớp gỗ trắng.\n• Quét dung dịch thuốc đặc trị pha sệt đặc (Validacin, Asmiltatop, Tebaz) trực tiếp lên vết loét cổ gốc.\n• Sau khi xử lý thuốc hóa học 7–10 ngày, bổ sung chế phẩm Trichoderma spp. tưới quanh vùng rễ để bảo vệ rễ non tái sinh.",
            'chemical_groups' => 'Validamycin A (Vali / Validacin - FRAC 26), Hexaconazole / Difenoconazole (Triazole - FRAC 3), Thifluzamide (Pulsor 23F - SDHI - FRAC 7), Carbendazim (Carbenda Supper 50SC - FRAC 1), Azoxystrobin (Trobin top / Tebaz - FRAC 11), Pencycuron (Phenylurea - FRAC 20), Fludioxonil (Phenylpyrrole - FRAC 12), Trichoderma spp. (Chế phẩm sinh học đối kháng)',
            'treatment_plans' => [
                [
                    'plan_name' => 'Phác đồ 1: Tưới đẫm cổ rễ đặc trị nấm lở cổ rễ Rhizoctonia solani',
                    'action_type' => 'Tưới ướt đẫm vùng cổ rễ và đất xung quanh gốc',
                    'stage' => 'Cây con vườn ươm hoặc cây mới trồng có dấu hiệu teo thắt cổ rễ, héo rũ',
                    'mixing_ratio' => 'Tebaz 400SC (Azoxystrobin + Tebuconazole) hoặc Validamycin pha cho 400 lít nước',
                    'instructions' => 'Cào nhẹ rác mục quanh cổ rễ; tưới từ 1 - 2 lít dung dịch thuốc cho mỗi gốc cây con (hoặc 5 - 10 lít cho cây lâu năm). Tưới nhắc lại sau 7 ngày.',
                    'target_pests' => ['Rhizoctonia solani', 'Chết rạp cây con', 'Lở cổ rễ'],
                    'products' => [
                        [
                            'role' => 'Đặc trị nấm lở cổ rễ lưu dẫn hai chiều',
                            'recommended_name' => 'Tebaz 400SC (Azoxystrobin + Tebuconazole)',
                            'active_ingredient' => 'Azoxystrobin + Tebuconazole',
                            'pesticide_id' => 190,
                            'dosage' => '250ml cho 400 lít nước',
                            'is_main' => true,
                            'substitute_ids' => [184],
                        ],
                    ],
                ],
                [
                    'plan_name' => 'Phác đồ 2: Phối hợp Oomycetes chặn đứng phức hợp thối gốc chết nhanh cây con',
                    'action_type' => 'Tưới gốc kết hợp phun sương cổ thân',
                    'stage' => 'Giai đoạn vườn ươm ẩm ướt cao điểm mùa mưa',
                    'mixing_ratio' => 'Binhtaxyl 25EC (Metalaxyl) + Thuốc trừ nấm phổ rộng pha cho 400 lít nước',
                    'instructions' => 'Ngăn chặn sự cộng sinh phá hoại giữa nấm Rhizoctonia và Pythium/Phytophthora gây thối nhũn toàn bộ chùm rễ.',
                    'target_pests' => ['Phức hợp lở cổ rễ', 'Pythium thối rễ', 'Thối gốc'],
                    'products' => [
                        [
                            'role' => 'Lưu dẫn nội hấp chặn đứng thối rễ',
                            'recommended_name' => 'Binhtaxyl 25EC / Mataxyl (Metalaxyl)',
                            'active_ingredient' => 'Metalaxyl',
                            'pesticide_id' => 193,
                            'dosage' => '300 - 400ml cho 400 lít nước',
                            'is_main' => true,
                            'substitute_ids' => [172],
                        ],
                    ],
                ],
                [
                    'plan_name' => 'Phác đồ 3: Quét trực tiếp vết loét cổ thân lâu năm & Phục hồi rễ tơ bằng Trichoderma',
                    'action_type' => 'Quét vết thương cổ gốc và tưới sinh học kích rễ',
                    'stage' => 'Cây ăn trái lâu năm (Sầu riêng, Cà phê) bị nứt chảy nhựa lở vỏ cổ gốc',
                    'mixing_ratio' => 'Quét dung dịch thuốc pha đậm đặc; sau 7 ngày tưới Trichoderma + Humic',
                    'instructions' => 'Cạo sạch mô vỏ thối mục đến phần gỗ lành; quét trực tiếp thuốc trừ nấm; sau khi vết bệnh khô mặt 7 ngày, tưới vi sinh đối kháng Trichoderma để bảo vệ rễ non.',
                    'target_pests' => ['Lở cổ rễ cây lâu năm', 'Nứt thân thối gốc'],
                    'products' => [
                        [
                            'role' => 'Trừ nấm bệnh tiếp xúc bám dính bảo vệ',
                            'recommended_name' => 'Tebaz 400SC / Aliette (Quét đặc)',
                            'active_ingredient' => 'Azoxystrobin + Tebuconazole',
                            'pesticide_id' => 190,
                            'dosage' => 'Pha tỷ lệ 1 thuốc : 2 nước quét trực tiếp',
                            'is_main' => true,
                            'substitute_ids' => [158],
                        ],
                    ],
                ],
            ],
            'notes' => "Lưu ý chuyên môn:\n• Tác nhân gây hại chính là nấm Rhizoctonia solani; tuy nhiên ở giai đoạn cây con còn có thể kết hợp với nấm Fusarium spp. và Pythium spp. tạo thành phức hợp bệnh chết rạp cây con.\n• Nấm tồn tại rất lâu trong đất dưới dạng hạch nấm (sclerotia) và sợi nấm trên tàn dư thực vật.\n• Tài liệu tham khảo: Trung tâm Khuyến nông Quốc gia (khuyennongvn.gov.vn), Cục Bảo vệ Thực vật.",
            'images' => $savedImages,
            'image' => $savedImages[0] ?? null,
            'crop_name' => 'Sầu riêng, Cà phê, Hồ tiêu, Cà chua & Họ cà, Dưa leo & Bầu bí, Cây có múi, Chanh dây',
        ];

        $disease = Disease::updateOrCreate(
            ['folder_code' => 'CD-01'],
            $diseaseData
        );

        // 4. Gắn các cây trồng mẫn cảm trong hệ thống
        $targetCropNames = ['Sầu riêng', 'Cà phê', 'Hồ tiêu', 'Cà chua & Họ cà', 'Dưa leo & Bầu bí', 'Cây có múi', 'Chanh dây'];
        $linkedCropIds = Crop::whereIn('name', $targetCropNames)->pluck('id')->toArray();
        if (!empty($linkedCropIds)) {
            $disease->crops()->sync($linkedCropIds);
        }

        // 5. GẮN CÁC SẢN PHẨM THUỐC ĐÃ CÓ SẴN TRONG KHO (KHÔNG TỰ TẠO SẢN PHẨM MỚI!)
        $existingWarehousePesticideIds = Pesticide::where(function($q) {
            $q->where('active_ingredient', 'like', '%Validamycin%')
              ->orWhere('active_ingredient', 'like', '%Azoxystrobin%')
              ->orWhere('active_ingredient', 'like', '%Hexaconazole%')
              ->orWhere('active_ingredient', 'like', '%Trichoderma%')
              ->orWhere('name', 'like', '%VALIDACIN%')
              ->orWhere('name', 'like', '%ASMILTATOP%')
              ->orWhere('name', 'like', '%ANVIL%')
              ->orWhere('name', 'like', '%TRICHODERMA%');
        })->pluck('id')->toArray();

        if (!empty($existingWarehousePesticideIds)) {
            $disease->pesticides()->sync($existingWarehousePesticideIds);
        }
    }
}
