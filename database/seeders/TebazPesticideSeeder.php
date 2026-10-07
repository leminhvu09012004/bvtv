<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class TebazPesticideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cat = Category::where('slug', 'thuoc-tru-benh')->first() ?? Category::find(30);

        Pesticide::updateOrCreate(
            ['name' => 'TEBAZ 400SC (Hiệu AGoldTar)'],
            [
                'category_id'         => $cat ? $cat->id : 30,
                'image'               => 'pesticides/tebaz_400sc.jpg',
                'active_ingredient'   => 'Azoxystrobin 200g/l + Tebuconazole 200g/l (Phụ gia: 600g/l)',
                'concentration'       => '400SC (400 g/l)',
                'form_type'           => 'CHAI 240ML - Huyền phù SC',
                'water_volume'        => '200 - 400 lít nước (1 - 2 phuy)',
                'stains_fruit'        => false,
                'target'              => 'Đặc trị đạo ôn, lem lép hạt, khô vằn (lúa); thán thư, rỉ sắt, nấm hồng, đốm lá, lở cổ rễ, nứt thân xì mủ, thối trái (sầu riêng, xoài, cam quýt, thanh long, cà phê, tiêu, rau màu).',
                'crops'               => 'Sầu riêng, lúa, xoài, cam, quýt, bưởi, thanh long, cà phê, hồ tiêu, rau màu',
                'usage'               => "Pha 20 - 30ml cho bình 25 lít nước hoặc 1 chai 240ml cho 200 - 400 lít nước (1 - 2 phuy 200L).\nPhun khi bệnh chớm xuất hiện hoặc định kỳ phòng ngừa cơi đọt non, giai đoạn nuôi hoa và dưỡng trái non.\nThích hợp cho cả phun bình máy và máy bay không người lái (Drone).",
                'manufacturer'        => 'AGoldTar - Công thức cải tiến bảo vệ cây trồng tối đa',
                'isolation_period'    => '7 - 14 ngày',
                'notes'               => "Thuốc trừ bệnh phổ rộng công thức cải tiến kết hợp hoàn hảo 2 hoạt chất hàng đầu:\n- Azoxystrobin (200g/l): Phòng bệnh phổ rộng, lưu dẫn mạnh, giúp cây xanh lá, dày lá và tăng cường quang hợp.\n- Tebuconazole (200g/l): Nội hấp cực mạnh, tiêu diệt nhanh sợi nấm và chặn đứng mầm bệnh phát triển.\n- Dạng huyền phù đậm đặc (SC) hạt siêu mịn, mát bông, mát trái non, không gây nóng hay lem trái.\n- Tối ưu cho thiết bị bay không người lái (phun Drone).",
            ]
        );
    }
}
