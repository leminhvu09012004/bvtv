<?php

namespace Database\Seeders;

use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class FixProductVariantPricesSeeder extends Seeder
{
    /**
     * Chuẩn hóa quy cách và giá bán chính xác cho các sản phẩm đa biến thể.
     */
    public function run(): void
    {
        // 1. Fix Product 58: 1.0.16 Huỳnh Lâm
        $p58 = Pesticide::find(58);
        if ($p58) {
            $p58->price = 90000;
            $p58->variants = [
                [
                    'size' => 'Chai 240ml',
                    'price' => 90000,
                    'image' => 'pesticides/6PDRWHNG5xfBKykImKNnRRJhVi5fMImq9qldsjba.png',
                    'water_volume' => 'Pha 1 chai 240ml cho 200 lít nước (1 phuy) phun ướt đều tán lá sầu riêng',
                ],
                [
                    'size' => 'Chai 946.3ml',
                    'price' => 300000,
                    'image' => 'pesticides/gro-power-1-0-16-huynh-lam-946ml.jpg',
                    'water_volume' => 'Pha 1 chai 946.3ml cho 600 - 800 lít nước (3 - 4 phuy)',
                ],
            ];
            $p58->save();
        }

        // 2. Fix Product 96: Great 8 Huỳnh Lâm
        $p96 = Pesticide::find(96);
        if ($p96) {
            $p96->price = 70000;
            $p96->variants = [
                [
                    'size' => 'Chai 240ml',
                    'price' => 70000,
                    'image' => 'pesticides/great-8-gro-power-240ml.jpg',
                    'water_volume' => 'Pha 240ml cho 200 lít nước (1 phuy)',
                ],
                [
                    'size' => 'Chai 946.3ml',
                    'price' => 300000,
                    'image' => 'pesticides/great-8-gro-power-946ml.jpg',
                    'water_volume' => 'Pha 946.3ml cho 800 lít nước (4 phuy)',
                ],
            ];
            $p96->save();
        }

        // 3. Fix Product 93: Golf & Turf Huỳnh Lâm
        $p93 = Pesticide::find(93);
        if ($p93) {
            $p93->price = 90000;
            $p93->variants = [
                [
                    'size' => 'Chai 240ml',
                    'price' => 90000,
                    'image' => 'pesticides/golf-turf-huynh-lam-240ml.jpg',
                    'water_volume' => 'Pha 1 chai 240ml cho 200 lít nước (1 phuy) phun ướt đều tán lá sầu riêng',
                ],
                [
                    'size' => 'Chai 946.3ml',
                    'price' => 300000,
                    'image' => 'pesticides/golf-turf-huynh-lam-946ml.jpg',
                    'water_volume' => 'Pha 1 lít cho 800 lít nước (4 phuy)',
                ],
            ];
            $p93->save();
        }

        // 4. Fix Product 83: Combi EDTA
        $p83 = Pesticide::find(83);
        if ($p83) {
            $p83->price = 85000;
            $p83->variants = [
                [
                    'size' => 'Chai 220g (240ml)',
                    'price' => 85000,
                    'image' => 'pesticides/bgnMJPYKgT7Lfih3p8xIDCEK7JiWmMw4mRFqiH5H.jpg',
                    'water_volume' => 'Pha 220g cho 200 lít nước (1 phuy)',
                ],
                [
                    'size' => 'Chai 880g (960ml)',
                    'price' => 290000,
                    'image' => 'pesticides/iW4x3DVieIUJwWbpGylfrOAKsqDhV6kHNluCq5JY.jpg',
                    'water_volume' => 'Pha 880g cho 800 lít nước (4 phuy)',
                ],
            ];
            $p83->save();
        }

        // 5. Fix Product 54: Xô NPK 15-15-15 EDTA
        $p54 = Pesticide::find(54);
        if ($p54) {
            $p54->price = 950000;
            $p54->variants = [
                [
                    'size' => 'Xô 10kg',
                    'price' => 950000,
                    'image' => 'pesticides/xo-npk-15-15-edta.jpg',
                    'water_volume' => 'Pha 1kg cho 100 - 150 lít nước tưới gốc hoặc 1 xô cho 2.000 - 3.000 lít nước',
                ],
                [
                    'size' => 'Xô 20kg',
                    'price' => 1800000,
                    'image' => 'pesticides/xo-npk-15-15-edta.jpg',
                    'water_volume' => 'Pha 1kg cho 100 - 150 lít nước tưới gốc hoặc 1 xô cho 2.000 - 3.000 lít nước',
                ],
                [
                    'size' => 'Chai 240ml',
                    'price' => 85000,
                    'image' => null,
                    'water_volume' => 'Pha 240ml cho 200 lít nước (1 phuy)',
                ],
                [
                    'size' => 'Chai 960ml',
                    'price' => 290000,
                    'image' => null,
                    'water_volume' => 'Pha 960ml cho 800 lít nước (4 phuy)',
                ],
            ];
            $p54->save();
        }

        // 6. Fix Product 7 (Antracol 70WP Bayer): Gói 100g = 32k, Gói 1kg = 295k
        $p7 = Pesticide::find(7);
        if ($p7) {
            $p7->price = 32000;
            $p7->variants = [
                [
                    'size' => 'Gói 100g',
                    'price' => 32000,
                    'image' => 'pesticides/antracol-70wp-bayer.jpg',
                    'water_volume' => '200 - 250 lít nước (1 phuy)',
                ],
                [
                    'size' => 'Gói 1kg',
                    'price' => 295000,
                    'image' => 'pesticides/antracol-70wp-bayer.jpg',
                    'water_volume' => '200 - 250 lít nước (1 phuy)',
                ],
            ];
            $p7->save();
        }

        // 7. Fix Product 497 (10.10.10): 240ml = 90k, 960ml = 300k
        $p497 = Pesticide::find(497);
        if ($p497) {
            $p497->price = 90000;
            $p497->variants = [
                [
                    'size' => '240ML',
                    'price' => 90000,
                    'image' => null,
                    'water_volume' => null,
                ],
                [
                    'size' => '960ml',
                    'price' => 300000,
                    'image' => null,
                    'water_volume' => null,
                ],
            ];
            $p497->save();
        }

        // 8. Fix Product 507 (RONG BIỂN ETA): 240ML = 85k, 960ML = 290k
        $p507 = Pesticide::find(507);
        if ($p507) {
            $p507->price = 85000;
            $p507->variants = [
                [
                    'size' => '240ML',
                    'price' => 85000,
                    'image' => null,
                    'water_volume' => null,
                ],
                [
                    'size' => '960ML',
                    'price' => 290000,
                    'image' => null,
                    'water_volume' => null,
                ],
            ];
            $p507->save();
        }

        // 9. Fix Product 149 & 151 (TĂNG TRƯỞNG EDTA): 240ML = 85k, 500ML = 150k, 960ML = 290k
        foreach ([149, 151] as $id) {
            $p = Pesticide::find($id);
            if ($p) {
                $p->price = 85000;
                $p->variants = [
                    [
                        'size' => 'Chai 240ml',
                        'price' => 85000,
                        'image' => 'pesticides/tang-truong-edta-parow.jpg',
                        'water_volume' => '200 lít nước (1 phuy)',
                    ],
                    [
                        'size' => 'Chai 500ml',
                        'price' => 150000,
                        'image' => 'pesticides/tang-truong-edta-parow.jpg',
                        'water_volume' => '400 lít nước (2 phuy)',
                    ],
                    [
                        'size' => 'Chai 960ml',
                        'price' => 290000,
                        'image' => 'pesticides/tang-truong-edta-parow.jpg',
                        'water_volume' => '800 lít nước (4 phuy)',
                    ],
                ];
                $p->save();
            }
        }
    }
}
