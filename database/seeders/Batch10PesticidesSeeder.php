<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class Batch10PesticidesSeeder extends Seeder
{
    /**
     * Run the database seeds for the 5 newly added root fertilizers (Phân bón gốc).
     */
    public function run(): void
    {
        $catGoc = Category::where('slug', 'phan-bon-goc')->first();
        if (! $catGoc) {
            $catGoc = Category::create([
                'name' => 'phân bón gốc',
                'slug' => 'phan-bon-goc',
                'description' => 'Các loại phân bón rải gốc, tưới gốc, cải tạo đất, nuôi trái và kích thích rễ',
                'icon' => '🌱',
            ]);
        }

        $items = [
            [
                'category_id' => $catGoc->id,
                'name' => 'KANBA - 3 Số NPK Cân Bằng Ú Nu (Xô 10KG)',
                'image' => 'pesticides/kanba-u-nu-10kg.jpg',
                'active_ingredient' => 'Đạm (N), Lân (P2O5), Kali (K2O) 3 số cân bằng + Phức hợp vi lượng chelate (TE) hòa tan 100%',
                'concentration' => '100% soluble in water (Nguyên liệu nhập khẩu)',
                'water_volume' => '1 xô 10kg pha 2.000 - 3.000 lít nước (10 - 15 phuy 200L) tưới gốc hoặc bón 100 - 200g/gốc',
                'stains_fruit' => false,
                'usage' => 'Tưới gốc hoặc bón rải quanh tán cây định kỳ 10 - 15 ngày/lần. Tan 100% trong nước, thích hợp hệ thống tưới tự động hoặc tưới xả.',
                'target' => 'Thúc lớn nhanh, mập nụ, to búp, lớn lá, lớn thân, lớn trái non, lớn củ, kích ra rễ cực mạnh, giúp nuôi trái mau lớn đều.',
                'crops' => 'Sầu riêng, Mít, Cam, Quýt, Bưởi, Thanh long, Bơ, Chanh dây, Cà phê, Tiêu, Cây ăn trái, Rau màu và Cây lấy củ',
                'form_type' => 'Xô 10 KG (Tan hoàn toàn)',
                'manufacturer' => 'MONYKA',
                'registration_number' => null,
                'isolation_period' => 'Không áp dụng (Phân bón dinh dưỡng)',
                'notes' => 'Công thức cải tiến mới bổ sung NPK cân đối cao cấp. Giúp nuôi trái lớn nhanh, bộ lá dày xanh mướt, nở bụi to nụ.',
            ],
            [
                'category_id' => $catGoc->id,
                'name' => 'NPK 12-11-18 MONYKA (Xô 20KG - Thắt Chặt Tầng Rời - Tròn Trái Xanh Gai)',
                'image' => 'pesticides/npk-12-11-18-monyka-20kg.jpg',
                'active_ingredient' => 'N: 12%, P2O5 hữu hiệu: 11%, K2O hữu hiệu: 18% + Phụ gia đặc biệt vừa đủ 100%',
                'concentration' => '12-11-18 (100% soluble in water)',
                'water_volume' => '1 xô 20kg pha 4.000 - 5.000 lít nước (20 - 25 phuy 200L) tưới gốc hoặc bón 200 - 400g/gốc',
                'stains_fruit' => false,
                'usage' => 'Sử dụng từ giai đoạn sau đậu trái non đến trước thu hoạch 15 - 20 ngày. Định kỳ 10 - 15 ngày tưới/bón một lần.',
                'target' => 'Thắt chặt tầng rời, hạn chế rụng trái non, tròn trái, xanh gai, to trái, đều trái, bóng đẹp, nặng ký, hạn chế thối nứt trái, xóa lem trái, nhiều nước, ngọt nước, chống teo múi.',
                'crops' => 'Sầu riêng, Bơ, Cây có múi (Cam, Quýt, Bưởi), Thanh long, Xoài, Nhãn, Mãng cầu, Vải, Dưa hấu, Cà phê, Hồ tiêu',
                'form_type' => 'Xô 20 KG (Tan 100%)',
                'manufacturer' => 'MONYKA',
                'registration_number' => null,
                'isolation_period' => 'Không áp dụng (Phân bón nuôi trái)',
                'notes' => '100% soluble in water. Hàm lượng Kali cao 18% giúp vào cơm nhanh, múi vàng óng, dày cơm nặng hạt và xanh gai.',
            ],
            [
                'category_id' => $catGoc->id,
                'name' => 'CANXI NITRAT + BO (MONEY FISH 25KG)',
                'image' => 'pesticides/canxi-nitrat-bo-money-fish-25kg.jpg',
                'active_ingredient' => 'Canxi Nitrat (Calcium Nitrate) hòa tan + Bo (Boron) cao cấp',
                'concentration' => 'Dạng hạt tan nhanh 100%',
                'water_volume' => 'Bón gốc 200 - 500g/gốc hoặc pha 1kg cho 200 - 400 lít nước tưới gốc',
                'stains_fruit' => false,
                'usage' => 'Bón lót hoặc bón thúc trước ra hoa, giai đoạn đậu trái non và nuôi trái. Rải quanh vùng tán rễ rồi tưới ẩm.',
                'target' => 'Cung cấp Canxi và Bo hòa tan tức thì: chống rụng hoa và rụng trái non, dầy thành tế bào, hạ phèn nhanh, chống nứt trái, ngừa thối đít trái, giải độc rễ phèn mặn.',
                'crops' => 'Sầu riêng, Cam, Quýt, Bưởi, Mãng cầu, Thanh long, Ớt, Cà chua, Dưa hấu, Cây ăn trái và hoa màu các loại',
                'form_type' => 'Bao 25 KG',
                'manufacturer' => 'MONEY FISH (Hotline: 02733.951.889)',
                'registration_number' => null,
                'isolation_period' => 'Không áp dụng (Phân bón dinh dưỡng trung vi lượng)',
                'notes' => 'Tan hoàn toàn trong nước, cung cấp đạm Nitrat và Canxi Bo giúp cây hấp thu tức thì không bị xót rễ hay chua đất.',
            ],
            [
                'category_id' => $catGoc->id,
                'name' => 'KALI SULPHAT APROMACO 52% (Made in Korea 25KG)',
                'image' => 'pesticides/kali-sulphat-apromaco-korea-25kg.jpg',
                'active_ingredient' => 'Kali Sulphat (K2SO4): K2O hữu hiệu 52%, Lưu huỳnh (S) 18% (Kali trắng không chứa Clo/Chloride Free)',
                'concentration' => 'K2O: 52% - S: 18% (Nhập khẩu Hàn Quốc)',
                'water_volume' => 'Bón gốc 200 - 500g/gốc hoặc hòa 1kg cho 300 - 400 lít nước tưới đẫm vùng rễ',
                'stains_fruit' => false,
                'usage' => 'Dùng bón gốc hoặc tưới nhỏ giọt giai đoạn nuôi trái lớn, vào đường, lên cơm, lên màu và trước thu hoạch 20 - 30 ngày.',
                'target' => 'Kali tinh khiết tan hoàn toàn không chứa Clo: giúp lên cơm vàng mịn, ngọt lịm, dậy mùi thơm đặc trưng, chống sượng cơm nhão múi ở sầu riêng; trái chắc nặng ký, tồn trữ lâu.',
                'crops' => 'Sầu riêng, Cà phê, Hồ tiêu, Bơ, Thanh long, Dưa hấu, Khoai lang, Chanh dây, Bưởi da xanh, Mãng cầu gai',
                'form_type' => 'Bao 25 KG (Water Soluble Fertilizer)',
                'manufacturer' => 'APROMACO (Agricultural Products and Materials J.S.C - Nhập Khẩu Korea)',
                'registration_number' => null,
                'isolation_period' => 'Không áp dụng (Phân bón dinh dưỡng tinh khiết)',
                'notes' => 'Kali trắng cao cấp nhập khẩu Hàn Quốc. Tuyệt đối không cháy lá, không sượng cơm, thích hợp nhất cho sầu riêng xuất khẩu.',
            ],
            [
                'category_id' => $catGoc->id,
                'name' => 'COMBI NUTRIENT - SIÊU KẼM GOLD (MONEY FISH 25KG)',
                'image' => 'pesticides/sieu-kem-gold-money-fish-25kg.jpg',
                'active_ingredient' => 'Kẽm (Zn): 15.000 ppm + Bo + Magie (MgO) + Canxi (CaO) + Silic (SiO) + Phụ gia đặc biệt',
                'concentration' => 'Kẽm (Zn) 15.000 ppm + Bo, MgO, CaO, SiO (Mix materials High End)',
                'water_volume' => 'Bón gốc 200 - 400g/gốc hoặc hòa 1kg cho 300 - 500 lít nước tưới đẫm tán rễ',
                'stains_fruit' => false,
                'usage' => 'Bón hoặc hòa nước tưới vùng gốc đầu mùa mưa, sau thu hoạch phục hồi rễ, trước khi ra hoa và giai đoạn nuôi trái non.',
                'target' => 'Chống rụng bông - rụng trái non tức thì, tăng tỷ lệ đậu trái thụ phấn, già lá nhanh, vỏ cơm dầy; hạ phèn giảm mặn giải độc hữu cơ; chống nứt thối trái rụng trái non.',
                'crops' => 'Sầu riêng, Mít, Cam, Quýt, Bưởi, Ớt, Thanh long, Cây ăn trái, Rau màu, Cây có củ, Cà phê, Tiêu',
                'form_type' => 'Bao 25 KG',
                'manufacturer' => 'MONEY FISH (Mix materials High and material import Korea)',
                'registration_number' => null,
                'isolation_period' => 'Không áp dụng (Phân bón dinh dưỡng trung vi lượng cao cấp)',
                'notes' => 'Kích thích bộ rễ phát triển cực mạnh, đẻ nhiều chồi nhánh hữu hiệu, tăng khả năng chống chịu phèn chua mặn và thời tiết khắc nghiệt.',
            ]
        ];

        foreach ($items as $item) {
            Pesticide::updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}
