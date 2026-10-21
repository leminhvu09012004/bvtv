<?php

namespace Database\Seeders;

use App\Models\Crop;
use Illuminate\Database\Seeder;

class CropsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $crops = [
            [
                'name' => 'Sầu riêng',
                'slug' => 'sau-rieng',
                'emoji' => '🍈',
                'description' => 'Vua cây ăn trái — Nhạy cảm nấm Oomycetes, rầy nhảy, sâu đục thân cành',
                'sort_order' => 1,
            ],
            [
                'name' => 'Chanh dây',
                'slug' => 'chanh-day',
                'emoji' => '🍋',
                'description' => 'Đặc sản xuất khẩu Đắk Lắk & Tây Nguyên — Nhạy cảm nấm Oomycetes, Virus khảm',
                'sort_order' => 2,
            ],
            [
                'name' => 'Cà phê',
                'slug' => 'ca-phe',
                'emoji' => '☕',
                'description' => 'Cây công nghiệp chủ lực Tây Nguyên — Rỉ sắt, nấm hồng, lở cổ rễ',
                'sort_order' => 3,
            ],
            [
                'name' => 'Hồ tiêu',
                'slug' => 'ho-tieu',
                'emoji' => '🌿',
                'description' => 'Hạt ngọc đen — Chết nhanh Phytophthora, chết chậm tuyến trùng',
                'sort_order' => 4,
            ],
            [
                'name' => 'Cây có múi',
                'slug' => 'cay-co-mui',
                'emoji' => '🍊',
                'description' => 'Cam, Quýt, Bưởi — Ghẻ loét vi khuẩn, vàng lá gân xanh Greening',
                'sort_order' => 5,
            ],
        ];

        foreach ($crops as $data) {
            Crop::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
