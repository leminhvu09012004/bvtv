<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class Batch6PesticidesSeeder extends Seeder
{
    public function run(): void
    {
        $catPhanBon = Category::where('slug', 'phan-bon-la')->first();

        $items = [
            [
                'category_id' => $catPhanBon->id,
                'name' => 'BỰ TỔ - NPK 21-21-21 PREMIUM TE',
                'image' => 'pesticides/bu-to-npk-21-21-21.jpg',
                'active_ingredient' => 'Đạm (N): 21%, Lân (P2O5): 21%, Kali (K2O): 21% + Vi lượng TE Chelate (Zn, Bo, Fe, Cu, Mn...)',
                'concentration' => '21-21-21 TE (Gói 1 Kg)',
                'form_type' => 'SP',
                'water_volume' => '400 - 500 lít nước (2 - 2.5 phuy)',
                'usage' => 'Dinh dưỡng cân đối - Tăng trưởng toàn diện. Dưỡng cây, dưỡng đọt, dưỡng hoa, dưỡng trái; giúp cây con phát triển mạnh, mau bén rễ; hình thành bông nhiều, tỷ lệ đậu quả cao; chống rụng trái, thối trái, thúc trái lớn nhanh, trái phát triển cân đối, nhân to, chín đồng loạt; tăng năng suất và sức chống chịu thời tiết bất lợi.',
                'target' => 'Dưỡng cây con, thúc đọt mập, nuôi trái lớn nhanh, chống rụng hoa và trái non',
                'crops' => 'Sầu riêng, cam sành, bưởi, mít, xoài, thanh long, lúa, rau màu',
                'manufacturer' => 'Monyka',
                'registration_number' => 'MNK-BUTO-212121',
                'isolation_period' => 'Không áp dụng',
                'notes' => 'Gói 1kg pha cho 400 - 500 lít nước. Phun đều tán lá định kỳ 7 - 10 ngày/lần trong giai đoạn cây con, trước ra hoa và nuôi trái.',
            ],
            [
                'category_id' => $catPhanBon->id,
                'name' => 'FLOWER - 95 0.3SL',
                'image' => 'pesticides/flower-95-03sl.jpg',
                'active_ingredient' => 'Alpha-Naphthyl Acetic Acid (Alpha-NAA) 0.3% w/v (3g/l)',
                'concentration' => '0.3SL (Chai 500 ml)',
                'form_type' => 'SL',
                'water_volume' => '400 - 500 lít nước (2 phuy)',
                'usage' => 'Thuốc điều hòa sinh trưởng chất lượng cao của TOBA. Tác động 3 nhanh - mạnh - hiệu quả: Kích thích phân hóa mầm hoa cực mạnh, hoa ra nhiều và đồng loạt, tăng sức sống hạt phấn, tăng tỷ lệ thụ phấn đậu trái, chống rụng hoa và trái non.',
                'target' => 'Kích ra hoa đồng loạt, tăng đậu trái, chống rụng hoa và trái non',
                'crops' => 'Sầu riêng, nhãn, xoài, cam quýt, lúa, rau màu, cây ăn trái',
                'manufacturer' => 'TOBA',
                'registration_number' => 'TOBA-FLOWER95-500ML',
                'isolation_period' => '7 ngày',
                'notes' => 'Pha 1 chai 500ml cho 400 - 500 lít nước (2 phuy). Phun ướt đều tán lá trước thời điểm ra hoa dự kiến 15 - 20 ngày.',
            ],
            [
                'category_id' => $catPhanBon->id,
                'name' => 'LEAF & SHOOT RESTRICT',
                'image' => 'pesticides/leaf-and-shoot-restrict.jpg',
                'active_ingredient' => 'Lân hữu hiệu (P2O5), Kali hữu hiệu (K2O) cao + Phụ gia ức chế sinh trưởng (Chặn đọt, già lá nhanh)',
                'concentration' => 'Dạng lỏng đậm đặc (Chai 500 ml)',
                'form_type' => 'SL',
                'water_volume' => '200 - 400 lít nước (1 - 2 phuy)',
                'usage' => 'Chế phẩm chuyên dùng chặn đọt non, hãm đọt sầu riêng và cây ăn trái. Ép đọt non đứng bánh tẻ, chuyển lụa già lá cực nhanh, hạn chế tối đa rụng hoa và rụng trái non do hiện tượng đi đọt cạnh tranh dinh dưỡng.',
                'target' => 'Chặn đọt non, già lá nhanh, chống rụng trái non do đi đọt, đứng đọt',
                'crops' => 'Sầu riêng, bưởi, cam, xoài, nhãn, thanh long',
                'manufacturer' => 'Chuyên dùng Sầu Riêng',
                'registration_number' => 'LSR-RESTRICT-500ML',
                'isolation_period' => 'Không áp dụng',
                'notes' => 'Pha 500ml cho 200 - 400 lít nước tùy mức độ phát triển của cơi đọt. Phun phủ ngoài tán lá khi đọt non vừa nhú mũi giáo.',
            ],
            [
                'category_id' => $catPhanBon->id,
                'name' => 'BUD & LEAF CO',
                'image' => 'pesticides/bud-and-leaf-co.jpg',
                'active_ingredient' => 'Đồng Chelate (Cu - EDTA) 2 chiều + Phụ gia sát khuẩn (Two Way Systemic)',
                'concentration' => 'Cu-EDTA Lưu dẫn 2 chiều (Chai 500 ml)',
                'form_type' => 'SL',
                'water_volume' => '400 - 500 lít nước (2 - 2.5 phuy)',
                'usage' => 'Phân bón vi lượng lưu dẫn 2 chiều rễ - ngọn cao cấp nhập khẩu từ Thổ Nhĩ Kỳ (Turkey). Cung cấp vi lượng Đồng hữu hiệu cao dạng Chelate, sát khuẩn vết thương, tăng tính đề kháng vỏ thân, phòng thối đọt, khô cành, nấm khuẩn gây hại.',
                'target' => 'Bổ sung vi lượng Đồng, sát trùng vết thương, chống thối đọt, khô cành, tăng đề kháng',
                'crops' => 'Sầu riêng, cam quýt, xoài, mít, tiêu, cà phê, cây ăn trái',
                'manufacturer' => 'Material Imported from Turkey (Thổ Nhĩ Kỳ)',
                'registration_number' => 'TURKEY-BUDLEAF-500ML',
                'isolation_period' => 'Không áp dụng',
                'notes' => 'Chai 500ml pha 400 - 500 lít nước. Lưu dẫn 2 chiều rễ - lá, mát bông, mát lá, không gây nóng hoa non.',
            ],
            [
                'category_id' => $catPhanBon->id,
                'name' => 'HPC - 22HXN (RA HOA XANH)',
                'image' => 'pesticides/hpc-22hxn-ra-hoa-xanh.jpg',
                'active_ingredient' => 'Đạm (N), Lân hữu hiệu (P2O5), Kali (K2O), Bo, Kẽm + Phức hợp kích thích phân hóa mầm hoa',
                'concentration' => 'Dạng lỏng đậm đặc (Chai 500 ml)',
                'form_type' => 'SL',
                'water_volume' => '400 - 500 lít nước (2 - 2.5 phuy)',
                'usage' => 'Phân bón lá thúc đẩy ra hoa đồng loạt - Ra Hoa Xanh HPC Phú Đông. Kích thích sự phân hóa mầm hoa mạnh mẽ, phá vỡ miên trạng mầm ngủ, hoa ra nhiều, phát hoa dài mập, chống nghẹn hoa, tăng tỷ lệ hoa cái thụ phấn.',
                'target' => 'Phân hóa mầm hoa, kích ra hoa đồng loạt, chống nghẹn bông, tăng thụ phấn đậu trái',
                'crops' => 'Vải, nhãn, thơm, mận, điều, sầu riêng, xoài, cây ăn trái',
                'manufacturer' => 'HPC Phú Đông (TP. Hồ Chí Minh)',
                'registration_number' => 'HPC-22HXN-500ML',
                'isolation_period' => 'Không áp dụng',
                'notes' => 'Pha 1 chai 500ml cho 400 - 500 lít nước phun đều tán lá trước thời điểm xử lý ra hoa.',
            ],
        ];

        foreach ($items as $data) {
            $pesticide = Pesticide::updateOrCreate(
                ['name' => $data['name']],
                $data
            );

            echo "Đã thêm/cập nhật thuốc: {$pesticide->name}\n";
        }
    }
}
