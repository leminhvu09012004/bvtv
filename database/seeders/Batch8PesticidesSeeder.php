<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class Batch8PesticidesSeeder extends Seeder
{
    public function run(): void
    {
        $catSau = Category::where('slug', 'thuoc-sau')->first() ?? Category::firstOrCreate(['name' => 'thuốc sâu', 'slug' => 'thuoc-sau']);
        $catBenh = Category::where('slug', 'thuoc-tru-benh')->first() ?? Category::firstOrCreate(['name' => 'thuốc trừ bệnh', 'slug' => 'thuoc-tru-benh']);
        $catLa = Category::where('slug', 'phan-bon-la')->first() ?? Category::firstOrCreate(['name' => 'phân bón lá', 'slug' => 'phan-bon-la']);

        // Update existing packaging images
        $p54 = Pesticide::find(54);
        if ($p54) {
            $p54->image = 'pesticides/bu-to-npk-21-21-21.jpg';
            $p54->save();
        }

        $p28 = Pesticide::find(28);
        if ($p28) {
            $p28->image = 'pesticides/anlien-annong-800wp.jpg';
            $p28->save();
        }

        $items = [
            [
                'category_id' => $catLa->id,
                'name' => 'AUXIN 18 (KÉO HOA - GIỮ TRÁI)',
                'image' => 'pesticides/auxin-18-keo-hoa-giu-trai.jpg',
                'active_ingredient' => 'Auxin tổng hợp (Alpha-NAA 1.8% + Auxin sinh học) + Phức hợp vi lượng chống rụng hoa & giữ trái non',
                'concentration' => '100% Soluble in water (Hũ 100g)',
                'form_type' => 'SP',
                'water_volume' => '200 - 400 lít nước (1 - 2 phuy)',
                'usage' => 'Chế phẩm điều hòa sinh trưởng sinh học AUXIN 18 (tan 100% trong nước). Xanh lá, mập bông, tròn trái, chống méo trái, ngăn ngừa hình thành tầng rời giúp chống rụng hoa và rụng trái non tức thì, điều hòa dinh dưỡng, chống sốc nhiệt và sốc nước do mưa bất chợt.',
                'target' => 'Kéo hoa mập bông, chống rụng hoa, chống rụng trái non, dưỡng tròn trái, chống méo trái',
                'crops' => 'Sầu riêng, cam sành, bưởi, xoài, mít, nhãn, thanh long, tiêu, cà phê',
                'manufacturer' => 'Công nghệ hoạt hóa Auxin chuyên dùng cây ăn trái',
                'registration_number' => 'AUXIN18-100G',
                'isolation_period' => 'Không áp dụng',
                'notes' => 'Pha 1 hũ 100g cho 200 - 400 lít nước (1 - 2 phuy) phun ướt đều tán lá và chùm hoa/trái non.',
            ],
            [
                'category_id' => $catBenh->id,
                'name' => 'Headline 250EC (BASF AgCelence)',
                'image' => 'pesticides/headline-250ec.jpg',
                'active_ingredient' => 'Pyraclostrobin 250 g/L (Nhóm Strobilurin - FRAC 11)',
                'concentration' => 'Nhũ dầu 250 g/L (Chai 100 mL)',
                'form_type' => 'EC',
                'water_volume' => '200 - 250 lít nước (1 phuy)',
                'usage' => 'Thuốc trừ bệnh và điều hòa sinh trưởng cao cấp của BASF. Hiệu ứng AgCelence độc quyền: kích hoạt cây trồng quang hợp tối ưu, lá xanh dày, bóng mượt, thân khỏe, tăng khả năng đồng hóa đạm; phòng trừ triệt để nấm bệnh thán thư, đốm lá, rỉ sắt và đạo ôn lúa.',
                'target' => 'Thán thư, rỉ sắt, đốm lá, đạo ôn, lem lép hạt; Tăng năng suất và chất lượng nông sản',
                'crops' => 'Lúa, ngô (bắp), sầu riêng, xoài, cà phê, cam bưởi, rau màu',
                'manufacturer' => 'BASF SE (Cộng hòa Liên bang Đức / BASF Việt Nam)',
                'registration_number' => 'HEADLINE-250EC-100ML',
                'isolation_period' => '7 ngày',
                'notes' => 'Pha 1 chai 100ml cho 200 - 250 lít nước (1 phuy) phun ướt đều tán cây khi bệnh chớm xuất hiện hoặc định kỳ dưỡng cây.',
            ],
            [
                'category_id' => $catLa->id,
                'name' => 'MKP 0-52-34 (MONYKA KOREA)',
                'image' => 'pesticides/mkp-0-52-34-monyka.jpg',
                'active_ingredient' => 'Lân hữu hiệu (P2O5): 52%, Kali hữu hiệu (K2O): 34% (Mono Potassium Phosphate tinh khiết 100% Natural Powder)',
                'concentration' => 'Bột mịn hòa tan 100% (Gói 1 kg)',
                'form_type' => 'Powder (SP)',
                'water_volume' => '400 - 500 lít nước (2 - 2.5 phuy)',
                'usage' => 'Phân bón lá MKP 0-52-34 MONYKA nhập khẩu nguyên liệu Hàn Quốc. Hàm lượng Lân 52% và Kali 34% siêu cao không chứa đạm (N): giúp nhanh già lá non, hãm đọt non sầu riêng cực mạnh, phân hóa mầm hoa tập trung, tăng tỷ lệ ra hoa đậu trái, ngăn sương mai phấn trắng.',
                'target' => 'Nhanh già lá non, phân hóa mầm hoa cực mạnh, hoa tập trung, chặn đọt non sầu riêng',
                'crops' => 'Sầu riêng, thanh long, xoài, nhãn, cam bưởi, mít, chôm chôm, lúa',
                'manufacturer' => 'MONYKA (Nguyên liệu nhập khẩu 100% từ Hàn Quốc)',
                'registration_number' => 'MKP-0-52-34-1KG',
                'isolation_period' => 'Không áp dụng',
                'notes' => 'Pha 1 gói 1kg cho 400 - 500 lít nước (2 - 2.5 phuy) phun tán lá giai đoạn tạo mầm hoặc chặn đọt.',
            ],
            [
                'category_id' => $catLa->id,
                'name' => 'NK 13-0-46 (MONYKA KOREA - Kali Hữu Cơ)',
                'image' => 'pesticides/nk-13-0-46-monyka.jpg',
                'active_ingredient' => 'Đạm tổng số (Nts): 13%, Kali hữu hiệu (K2O): 46% (Nguồn Kali hữu cơ 100% không chứa gốc Clo)',
                'concentration' => 'Bột tinh khiết hòa tan 100% (Gói 1 kg)',
                'form_type' => 'Powder (SP)',
                'water_volume' => '400 - 500 lít nước (2 - 2.5 phuy)',
                'usage' => 'Phân bón lá NK 13-0-46 MONYKA Kali hữu cơ không Clo. Giúp cây đứng lá, cứng thân, chống đổ ngã; thúc trái lớn nhanh, nặng ký, lên màu trái đẹp mắt, dày múi, tăng độ ngọt brix, tăng tinh bột, giúp hạt lúa chắc mẩy sáng mẩy, cơm sầu riêng vàng ươm không bị sượng.',
                'target' => 'Đứng lá, cứng thân, trái to, nặng ký, tăng hương vị, lên màu đẹp trái, dày múi, tăng độ ngọt, chắc hạt',
                'crops' => 'Sầu riêng, lúa, thanh long, cam bưởi, xoài, mít, hồ tiêu, cà phê',
                'manufacturer' => 'MONYKA (Mix materials & material made in Korea)',
                'registration_number' => 'NK-13-0-46-1KG',
                'isolation_period' => 'Không áp dụng',
                'notes' => 'Pha 1 gói 1kg cho 400 - 500 lít nước (2 - 2.5 phuy) phun nuôi trái hoặc giai đoạn lúa ngậm sữa, đỏ đuôi.',
            ],
            [
                'category_id' => $catLa->id,
                'name' => 'Siêu Thấm - Siêu Loang Trãi',
                'image' => 'pesticides/sieu-tham-sieu-loang-trai.jpg',
                'active_ingredient' => 'Polyether Polymethylsiloxane Copolymer (Chất trợ lực sinh học) + Phụ gia loang trải siêu thẩm thấu',
                'concentration' => 'Dung dịch trợ lực hữu cơ (Chai 500 ml)',
                'form_type' => 'SL',
                'water_volume' => '800 - 1000 lít nước (4 - 5 phuy)',
                'usage' => 'Kích thích mở khí khổng - Thấm sâu cực nhanh - Loang trải mạnh - Lưu dẫn kéo dài - Tăng hiệu lực tối đa của thuốc bảo vệ thực vật và phân bón lá. Chống mưa rửa trôi, giảm thất thoát thuốc do bốc hơi nắng nóng.',
                'target' => 'Tăng bám dính, mở khí khổng, loang trải 2 mặt lá, chống mưa rửa trôi, dẫn truyền thuốc BVTV',
                'crops' => 'Sầu riêng, cây ăn trái, lúa, hồ tiêu, cà phê, rau màu, hoa kiểng',
                'manufacturer' => 'Công ty TNHH Nông Nghiệp Xanh Việt Nam',
                'registration_number' => 'STLT-500ML',
                'isolation_period' => 'Không áp dụng',
                'notes' => 'Pha 20 - 25ml cho bình 25 lít, hoặc 1 chai 500ml pha cho 800 - 1000 lít nước (4 - 5 phuy) dùng chung với thuốc BVTV.',
            ],
            [
                'category_id' => $catSau->id,
                'name' => 'NOFARA 35WG (Hạ Gục Nhanh - Ung Trứng)',
                'image' => 'pesticides/nofara-35wg.jpg',
                'active_ingredient' => 'Thiamethoxam 35% w/w + Phụ gia cao cấp 65% w/w (Nhóm Neonicotinoid - IRAC 4A)',
                'concentration' => 'Cốm phân tán trong nước 35% (Gói 100 g)',
                'form_type' => 'WG',
                'water_volume' => '200 - 400 lít nước (1 - 2 phuy)',
                'usage' => 'Hạ gục nhanh - Ung trứng - Lưu dẫn kéo dài. Thuốc có tác động tiếp xúc, vị độc và lưu dẫn mạnh mẽ, nhanh chóng phong bế hệ thần kinh trung ương của côn trùng chích hút, làm ung cả ổ trứng rầy bọ trĩ, bảo vệ đọt non toàn diện.',
                'target' => 'Bọ trĩ, rầy xanh, rầy phấn trắng, rầy mềm, rệp sáp, rầy nâu hại cây',
                'crops' => 'Sầu riêng, lúa, xoài, cam bưởi, hồ tiêu, cà phê, ớt, dưa hấu',
                'manufacturer' => 'Nông Dược Nofara Việt Nam',
                'registration_number' => 'NOFARA-35WG-100G',
                'isolation_period' => '7 ngày',
                'notes' => 'Pha 1 gói 100g cho 200 - 400 lít nước (1 - 2 phuy) phun khi rầy bọ trĩ vừa xuất hiện giai đoạn nhú đọt non.',
            ],
            [
                'category_id' => $catBenh->id,
                'name' => 'Antracol 70WP Zinc++ (Bayer Áo Giáp Kẽm)',
                'image' => 'pesticides/antracol-70wp-bayer.jpg',
                'active_ingredient' => 'Propineb 700 g/kg (70% w/w) + Vi lượng Kẽm tinh khiết (Zinc++ 300 g/kg phụ gia - Nhóm FRAC M03)',
                'concentration' => 'Bột thấm nước 70% (Gói 100 g)',
                'form_type' => 'WP',
                'water_volume' => '200 - 250 lít nước (1 phuy)',
                'usage' => '"Bảo vệ cây bằng áo giáp kẽm!" - Thuốc trừ nấm bệnh phổ rộng hàng đầu thế giới của Bayer. Cơ chế tiếp xúc đa điểm ngăn chặn nấm bệnh xâm nhiễm, đồng thời bổ sung vi lượng Kẽm (Zinc++) thiết yếu giúp cây cứng cáp, lá xanh bóng và dày khỏe.',
                'target' => 'Thán thư, đốm lá, sương mai, khô vằn, rỉ sắt, mốc sương, đốm nâu',
                'crops' => 'Sầu riêng, hồ tiêu, thanh long, xoài, nho, chè, lúa, cà chua, dưa hấu',
                'manufacturer' => 'Bayer CropScience (CHLB Đức / Bayer Việt Nam)',
                'registration_number' => 'ANTRACOL-70WP-100G',
                'isolation_period' => '7 ngày',
                'notes' => 'Pha 1 gói 100g cho 200 - 250 lít nước (1 phuy) phun ướt đều tán lá khi bệnh chớm xuất hiện.',
            ],
            [
                'category_id' => $catBenh->id,
                'name' => 'Aliette 800WG (Bayer - Lưu Dẫn 2 Chiều)',
                'image' => 'pesticides/aliette-800wg-bayer.jpg',
                'active_ingredient' => 'Fosetyl Aluminium 800 g/kg (Nhóm FRAC P07 - Kích kháng sinh học)',
                'concentration' => 'Cốm hòa tan 80% (Gói 100 g)',
                'form_type' => 'WG',
                'water_volume' => '200 - 250 lít nước (1 phuy)',
                'usage' => 'Lưu dẫn hai chiều cực mạnh - Bảo vệ toàn diện. Thuốc di chuyển cả hướng ngọn và hướng rễ, tiêu diệt trực tiếp nấm Phytophthora đồng thời kích thích cơ chế đề kháng tự nhiên (phytoalexin) của cây trồng giúp cô lập và làm lành nhanh vết bệnh nứt thân xì mủ thối rễ.',
                'target' => 'Đặc trị Phytophthora gây nứt thân xì mủ sầu riêng, lở cổ rễ, chết nhanh hồ tiêu, thối rễ vàng lá',
                'crops' => 'Sầu riêng, hồ tiêu, cây có múi, dưa hấu, cao su, ca cao, hoa kiểng',
                'manufacturer' => 'Bayer CropScience (Cộng hòa Pháp / Bayer Việt Nam)',
                'registration_number' => 'ALIETTE-800WG-100G',
                'isolation_period' => '14 ngày',
                'notes' => 'Pha 1 gói 100g cho 200 - 250 lít nước phun lá hoặc tưới quanh gốc sầu riêng.',
            ],
            [
                'category_id' => $catSau->id,
                'name' => 'SHA CHONG JING 95WP (PADANG JAPAN)',
                'image' => 'pesticides/sha-chong-jing-95wp.jpg',
                'active_ingredient' => 'Thiosultap-sodium (Nereistoxin) 95% w/w + Phụ gia vừa đủ 100% (Nhóm IRAC 14)',
                'concentration' => 'Bột hòa tan 95% (Gói 100 g)',
                'form_type' => 'WP',
                'water_volume' => '200 - 400 lít nước (1 - 2 phuy)',
                'usage' => 'Siêu công phá - Diệt trừ sâu kháng thuốc - Đặc trị sâu đục thân. Hoạt chất Thiosultap-sodium tác động tiếp xúc, vị độc và nội hấp cực mạnh ngấm sâu vào lõi gỗ thân cây, diệt sạch sâu đục thân, sâu đục cành và sâu non đang ẩn nấp.',
                'target' => 'Sâu đục thân, sâu đục ngọn, sâu cuốn lá, sâu đục trái, bọ trĩ, dòi đục lá',
                'crops' => 'Lúa, sầu riêng, bắp (ngô), mía, cây ăn trái, đậu tương',
                'manufacturer' => 'Công nghệ Padang Japan (Nhật Bản)',
                'registration_number' => 'SCJ-PADANG-95WP',
                'isolation_period' => '14 ngày',
                'notes' => 'Pha 1 gói 100g cho 200 - 400 lít nước (1 - 2 phuy) phun khi phát hiện vết đục hoặc bướm nở rộ.',
            ],
            [
                'category_id' => $catLa->id,
                'name' => 'STAR FISH (Canxi Bo Hữu Cơ Sao Biển Hàn Quốc)',
                'image' => 'pesticides/star-fish-korea.jpg',
                'active_ingredient' => 'Canxi hữu cơ chiết xuất từ sao biển (Starfish Organic Calcium) + Bo (Boron): 10.000 ppm (1%) + Chất thẩm thấu sâu 침투제',
                'concentration' => 'Dung dịch hữu cơ thẩm thấu sâu (Chai 500 ml)',
                'form_type' => 'SL',
                'water_volume' => '400 - 500 lít nước (2 - 2.5 phuy)',
                'usage' => 'Phân bón lá hữu cơ sinh học Star Fish nhập khẩu Hàn Quốc. Chiết xuất canxi hữu cơ từ sao biển kết hợp Bo 1% và hoạt chất thấm sâu thẩm thấu nhanh vào mô tế bào, giúp cuống hoa và cuống trái non dẻo dai chắc khỏe, hạt phấn sống lâu, chống rụng hoa và trái non, ngăn nứt gai sầu riêng.',
                'target' => 'Chống rụng hoa, rụng trái non sầu riêng; cứng cuống, chống nứt gai, dưỡng tròn đều trái',
                'crops' => 'Sầu riêng, cam, bưởi, thanh long, xoài, nhãn, ớt, dưa hấu',
                'manufacturer' => 'FM Agtech (INNO-BIZ Hàn Quốc / Giải thưởng Thủ tướng Hàn Quốc)',
                'registration_number' => 'STARFISH-KOREA-500ML',
                'isolation_period' => 'Không áp dụng',
                'notes' => 'Pha 1 chai 500ml cho 400 - 500 lít nước (2 - 2.5 phuy) phun định kỳ giai đoạn nuôi hoa và đậu trái non.',
            ],
            [
                'category_id' => $catSau->id,
                'name' => 'MOVENTO 150OD (Bayer - Đặc Trị Rệp Sáp)',
                'image' => 'pesticides/movento-150od-bayer.jpg',
                'active_ingredient' => 'Spirotetramat 150 g/L (Nhóm Ketoenol / Tetramic acid - IRAC 23)',
                'concentration' => 'Huyền phù dầu 150 g/L (Chai 240 ml)',
                'form_type' => 'OD',
                'water_volume' => '400 - 500 lít nước (2 - 2.5 phuy)',
                'usage' => 'Thuốc trừ sâu lưu dẫn 2 chiều duy nhất thế giới của Bayer. Hoạt chất Spirotetramat vận chuyển 2 chiều theo mạch mộc và mạch rây đến đọt non và chóp rễ, tiêu diệt triệt để các loài chích hút ẩn nấp như rệp sáp rễ, rệp sáp trái, bọ trĩ, bảo vệ cây trồng kéo dài 3-4 tuần.',
                'target' => 'Đặc trị rệp sáp (rệp sáp rễ, rệp sáp trái), bọ trĩ, rầy phấn trắng, rầy mềm, rệp vảy',
                'crops' => 'Sầu riêng, cà phê, hồ tiêu, cam bưởi, xoài, nho, rau màu',
                'manufacturer' => 'Bayer CropScience (CHLB Đức / Bayer Việt Nam)',
                'registration_number' => 'MOVENTO-150OD-240ML',
                'isolation_period' => '7 ngày',
                'notes' => 'Pha 1 chai 240ml cho 400 - 500 lít nước (2 - 2.5 phuy, tức 12-16ml/bình 25L) phun kỹ nơi rệp bám.',
            ],
            [
                'category_id' => $catLa->id,
                'name' => 'WeyZym-A TỬZ-A (Chống Rụng Tức Thì Thụy Sỹ)',
                'image' => 'pesticides/weyzym-a-multiagro.jpg',
                'active_ingredient' => 'Phân bón hữu cơ chiết xuất Enzyme thực vật + Canxi Chelate, Bo, Kẽm và Axit Amin thiết yếu (Bí quyết Thụy Sỹ - Cam kết 100% không chứa Paclobutrazol)',
                'concentration' => 'Dung dịch hấp thụ siêu nhanh (Chai 500 ml)',
                'form_type' => 'SL',
                'water_volume' => '400 - 500 lít nước (2 - 2.5 phuy)',
                'usage' => 'Phân bón hữu cơ thế hệ mới WeyZym-A: "Thế hệ mới: Ngạc Nhiên Chưa! - Chống rụng tức thì". Hấp thụ siêu nhanh qua biểu bì lá, không chứa Paclo. Dập tắt hiện tượng rụng hoa và trái non tức thì khi gặp sốc nhiệt, sốc nước hoặc mưa bão kéo dài.',
                'target' => 'Chống rụng hoa, chống rụng trái non tức thì, chống tầng rời cuống, phục hồi cây sau sốc',
                'crops' => 'Sầu riêng, bưởi da xanh, xoài, thanh long, cam, hồ tiêu, cà phê',
                'manufacturer' => 'Multiagro (Công nghệ độc quyền Thụy Sỹ)',
                'registration_number' => 'WEYZYM-A-500ML',
                'isolation_period' => 'Không áp dụng',
                'notes' => 'Pha 1 chai 500ml cho 400 - 500 lít nước (2 - 2.5 phuy) phun ngay khi cây có dấu hiệu rụng sinh lý.',
            ],
            [
                'category_id' => $catSau->id,
                'name' => 'SACHNHEN-ETO 110SC (Nhện Chúa)',
                'image' => 'pesticides/sachnhen-eto-110sc-nhen-chua.jpg',
                'active_ingredient' => 'Etoxazole 110 g/L + Special Additives: 890 g/L (Nhóm IRAC 10B - Diphenyl oxazoline)',
                'concentration' => 'Huyền phù đậm đặc 110 g/L (Chai 240 ml)',
                'form_type' => 'SC',
                'water_volume' => '400 - 500 lít nước (2 - 2.5 phuy)',
                'usage' => 'Thuốc trừ sâu thế hệ mới SACHNHEN-ETO 110SC (Nhện Chúa). Diệt cả trứng, nhện non và nhện trưởng thành; mát bông mát trái non, không gây kháng thuốc; hiệu lực phòng trừ nhện đỏ bảo vệ tán lá kéo dài lên đến 30 ngày.',
                'target' => 'Đặc trị nhện đỏ, nhện vàng, nhện trắng hại lá và vỏ trái',
                'crops' => 'Sầu riêng, cam, bưởi, chanh, xoài, hoa hồng, chè, dưa lưới',
                'manufacturer' => 'Công ty Nông Dược Quốc Tế',
                'registration_number' => 'SACHNHEN-110SC-240ML',
                'isolation_period' => '7 ngày',
                'notes' => 'Pha 1 chai 240ml cho 400 - 500 lít nước (2 - 2.5 phuy) phun ướt đều 2 mặt tán lá.',
            ],
        ];

        foreach ($items as $item) {
            Pesticide::updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}
