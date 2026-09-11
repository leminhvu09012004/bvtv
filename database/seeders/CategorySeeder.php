<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Thuốc trừ sâu', 'slug' => 'thuoc-tru-sau', 'emoji' => '💊', 'sort_order' => 1],
            ['name' => 'Thuốc trừ bệnh', 'slug' => 'thuoc-tru-benh', 'emoji' => '🍂', 'sort_order' => 2],
            ['name' => 'Thuốc trừ cỏ', 'slug' => 'thuoc-tru-co', 'emoji' => '🌿', 'sort_order' => 3],
            ['name' => 'Thuốc trừ nhện', 'slug' => 'thuoc-tru-nhen', 'emoji' => '🕷️', 'sort_order' => 4],
            ['name' => 'Thuốc trừ ốc / nhuyễn thể', 'slug' => 'thuoc-tru-oc', 'emoji' => '🐌', 'sort_order' => 5],
            ['name' => 'Thuốc điều hòa sinh trưởng', 'slug' => 'dieu-hoa-sinh-truong', 'emoji' => '🌱', 'sort_order' => 6],
            ['name' => 'Thuốc sinh học / vi sinh', 'slug' => 'sinh-hoc-vi-sinh', 'emoji' => '🦠', 'sort_order' => 7],
            ['name' => 'Phân bón / sản phẩm hỗ trợ', 'slug' => 'phan-bon-ho-tro', 'emoji' => '🌾', 'sort_order' => 8],
            ['name' => 'Khác', 'slug' => 'khac', 'emoji' => '📦', 'sort_order' => 9],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
