<?php

namespace Database\Seeders;

use App\Models\Pesticide;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MergeProductSizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mergeGroups = [
            [
                'clean_name' => '12.4.8 Huỳnh Lâm (Kéo đọt, mập đọt)',
                'ids' => [63, 64],
                'sizes' => ['Chai 240ml', 'Chai 946.3ml'],
            ],
            [
                'clean_name' => 'Achieve CaBo Huỳnh Lâm (Canxi Bo sữa)',
                'ids' => [78, 79],
                'sizes' => ['Chai 240ml', 'Chai 946ml'],
            ],
            [
                'clean_name' => 'Alien An Nông 800WP (Đặc trị nấm khuẩn)',
                'ids' => [4, 5],
                'sizes' => ['Gói 100g', 'Gói 1kg'],
            ],
            [
                'clean_name' => 'Amino EDTA (Axit Amin mát bông, mát trái)',
                'ids' => [67, 69],
                'sizes' => ['Chai 250ml', 'Chai 500ml'],
            ],
            [
                'clean_name' => 'Antracol 70WP Bayer (Áo giáp kẽm bảo vệ cây)',
                'ids' => [7, 8],
                'sizes' => ['Gói 100g', 'Gói 1kg'],
            ],
            [
                'clean_name' => 'Bio-Phos NPK 20-20 (Lân hữu hiệu ra rễ)',
                'ids' => [43, 44],
                'sizes' => ['Xô 10 Lít', 'Xô 20 Lít'],
            ],
            [
                'clean_name' => 'Bo 150.000 Mekong Agro (Chống rụng hoa, đậu trái)',
                'ids' => [74, 75],
                'sizes' => ['Chai 250ml', 'Chai 500ml'],
            ],
            [
                'clean_name' => 'CanxiBo EDTA (Dẻo dai cuống, chống nứt méo trái)',
                'ids' => [80, 82],
                'sizes' => ['Chai 240ml', 'Chai 960ml'],
            ],
            [
                'clean_name' => 'Combi EDTA (Vi lượng Chelate toàn diện)',
                'ids' => [83, 84],
                'sizes' => ['Chai 220g', 'Chai 880g'],
            ],
            [
                'clean_name' => 'Cú Đấm Rồng (Kích phát đọt cực mạnh)',
                'ids' => [86, 87],
                'sizes' => ['Chai 250ml', 'Chai 500ml'],
            ],
            [
                'clean_name' => 'Dimethor 500SC (Đặc trị nấm sương mai, thối rễ)',
                'ids' => [15, 16],
                'sizes' => ['Chai 240ml', 'Chai 450ml'],
            ],
            [
                'clean_name' => 'Fullkill 50EC (Đặc trị sâu, rầy, bọ trĩ)',
                'ids' => [166, 167],
                'sizes' => ['Chai 240ml', 'Chai 450ml'],
            ],
            [
                'clean_name' => 'Great 8 Huỳnh Lâm (8 khoáng chất vi lượng thiết yếu)',
                'ids' => [96, 97],
                'sizes' => ['Chai 240ml', 'Chai 946.3ml'],
            ],
            [
                'clean_name' => 'K-RO EDTA (Kali tinh khiết lên màu ngọt trái)',
                'ids' => [107, 108],
                'sizes' => ['Chai 240ml', 'Chai 960ml'],
            ],
            [
                'clean_name' => 'Kẽm EDTA (Trị vàng lá gân xanh, dày lá)',
                'ids' => [102, 103],
                'sizes' => ['Chai 240ml', 'Chai 960ml'],
            ],
            [
                'clean_name' => 'Loang Trải Siêu Thấm (Trợ lực bám dính)',
                'ids' => [25, 24],
                'sizes' => ['Chai 50ml', 'Chai 100ml'],
            ],
            [
                'clean_name' => 'MgO - Kẽm EDTA (Dạng sữa chống cháy chóp lá)',
                'ids' => [111, 112],
                'sizes' => ['Chai 220g', 'Chai 880g'],
            ],
            [
                'clean_name' => 'NPK 12.11.18 EDTA (Nuôi trái, nở gai, chắc múi)',
                'ids' => [123, 124],
                'sizes' => ['Chai 240ml', 'Chai 960ml'],
            ],
            [
                'clean_name' => 'NPK 15.15.15 EDTA (Dinh dưỡng nuôi trái phì to)',
                'ids' => [127, 128],
                'sizes' => ['Chai 240ml', 'Chai 960ml'],
            ],
            [
                'clean_name' => 'NPK 4.5.44 Hợp Trí (Vào cơm, ngọt cơm, nặng ký)',
                'ids' => [135, 134],
                'sizes' => ['Gói 250g', 'Gói 1kg'],
            ],
            [
                'clean_name' => 'Nuôi Trái EDTA (NPK Chelate vi lượng nuôi trái)',
                'ids' => [136, 138],
                'sizes' => ['Chai 240ml', 'Chai 960ml'],
            ],
            [
                'clean_name' => 'Ridomil Gold 68WG (Đặc trị nấm Phytophthora)',
                'ids' => [32, 31],
                'sizes' => ['Gói 100g', 'Gói 1kg'],
            ],
            [
                'clean_name' => 'Rong Biển EDTA (Hạ nhiệt tán lá, mát cây)',
                'ids' => [145, 146],
                'sizes' => ['Chai 240ml', 'Chai 960ml'],
            ],
            [
                'clean_name' => 'Vọt Đọt Monyka (Kéo cơi đọt bung rộ)',
                'ids' => [157, 156],
                'sizes' => ['Gói 250g', 'Gói 1kg'],
            ],
            [
                'clean_name' => 'Xanh Um Monyka (Dưỡng lá dày, xanh mướt)',
                'ids' => [159, 160],
                'sizes' => ['Gói 250g', 'Gói 1kg'],
            ],
            [
                'clean_name' => 'Xô NPK 15-15-15 (Tan hoàn toàn nuôi trái lớn nhanh)',
                'ids' => [54, 56],
                'sizes' => ['Xô 10kg', 'Xô 20kg'],
            ],
            [
                'clean_name' => 'Xô Roots Humic (Phục hồi rễ, giải độc phèn)',
                'ids' => [55, 57],
                'sizes' => ['Xô 10kg', 'Xô 20kg'],
            ],
        ];

        foreach ($mergeGroups as $group) {
            $p1 = Pesticide::with('diseases')->find($group['ids'][0]);
            $p2 = Pesticide::with('diseases')->find($group['ids'][1]);

            if ($p1 && $p2) {
                $primary = $p1->image ? $p1 : ($p2->image ? $p2 : $p1);
                $secondary = ($primary->id === $p1->id) ? $p2 : $p1;

                $idx1 = array_search($primary->id, $group['ids']);
                $idx2 = array_search($secondary->id, $group['ids']);

                $variants = [
                    [
                        'size' => $group['sizes'][$idx1],
                        'image' => $primary->image,
                        'water_volume' => $primary->water_volume,
                    ],
                    [
                        'size' => $group['sizes'][$idx2],
                        'image' => $secondary->image,
                        'water_volume' => $secondary->water_volume,
                    ],
                ];

                $secDiseaseIds = $secondary->diseases->pluck('id')->toArray();
                if (!empty($secDiseaseIds)) {
                    $primary->diseases()->syncWithoutDetaching($secDiseaseIds);
                }

                $primary->name = $group['clean_name'];
                $primary->variants = $variants;
                if (!$primary->image && $secondary->image) {
                    $primary->image = $secondary->image;
                }
                $primary->save();

                $secondary->delete();
            }
        }

        // Fill remaining single products
        foreach (Pesticide::all() as $p) {
            if (empty($p->variants)) {
                $size = $p->form_type ?: ($p->concentration ?: 'Tiêu chuẩn');
                if (preg_match('/(\d+[\.,]?\d*\s*(?:ml|l|lit|kg|g|gram|gra)\b|\((?:chai|goi|bao|xo|can)\))/i', $p->name, $m)) {
                    $size = trim($m[0], ' ()');
                }
                $p->variants = [
                    [
                        'size' => $size,
                        'image' => $p->image,
                        'water_volume' => $p->water_volume,
                    ]
                ];
                $p->save();
            }
        }
    }
}
