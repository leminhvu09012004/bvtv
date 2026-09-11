<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class PesticideSeeder extends Seeder
{
    /**
     * Dữ liệu thuốc BVTV chuyên biệt cho vùng Tây Nguyên:
     * Chủ lực: Sầu riêng, Cà phê, Hồ tiêu, Chanh dây, Bơ, Mắc ca.
     */
    public function run(): void
    {
        $demoNote = '[Dữ liệu thực tế cho vùng trồng Tây Nguyên]';

        $sau = Category::where('slug', 'thuoc-tru-sau')->first();
        $benh = Category::where('slug', 'thuoc-tru-benh')->first();
        $co = Category::where('slug', 'thuoc-tru-co')->first();
        $nhen = Category::where('slug', 'thuoc-tru-nhen')->first();
        $oc = Category::where('slug', 'thuoc-tru-oc')->first();
        $dieuHoa = Category::where('slug', 'dieu-hoa-sinh-truong')->first();
        $sinhHoc = Category::where('slug', 'sinh-hoc-vi-sinh')->first();
        $phanBon = Category::where('slug', 'phan-bon-ho-tro')->first();
        $khac = Category::where('slug', 'khac')->first();

        $demos = [
            // 1. Thuốc trừ bệnh Sầu riêng & Tiêu
            [
                'category_id' => $benh?->id,
                'name' => 'Aliette 800WG',
                'active_ingredient' => 'Fosetyl Aluminium',
                'concentration' => '800g/kg',
                'usage' => 'Đặc trị nứt thân xì mủ, thối rễ, lở cổ rễ Phytophthora. Quét gốc hoặc sục rễ phục hồi cây.',
                'target' => 'Nấm Phytophthora sp.',
                'crops' => 'Sầu riêng, Hồ tiêu, Cà phê',
                'form_type' => 'WG',
                'manufacturer' => 'Bayer CropScience',
                'isolation_period' => '14 ngày',
                'notes' => 'Lưu dẫn 2 chiều cực mạnh từ ngọn xuống rễ và ngược lại. Rất chuộng tại Tây Nguyên.',
            ],
            // 2. Thuốc trừ nấm Phytophthora & Chết nhanh
            [
                'category_id' => $benh?->id,
                'name' => 'Ridomil Gold 68WG',
                'active_ingredient' => 'Metalaxyl-M + Mancozeb',
                'concentration' => '68% (40g/kg + 640g/kg)',
                'usage' => 'Trị xì mủ sầu riêng, bệnh chết nhanh hồ tiêu, vàng lá thối rễ cà phê, sương mai chanh dây.',
                'target' => 'Phytophthora palmivora, Pythium, sương mai',
                'crops' => 'Sầu riêng, Hồ tiêu, Cà phê, Chanh dây',
                'form_type' => 'WG',
                'manufacturer' => 'Syngenta',
                'isolation_period' => '10 ngày',
                'notes' => 'Thuốc phòng trị nấm phổ rộng, có thể tưới gốc hoặc phun qua lá.',
            ],
            // 3. Thán thư, rỉ sắt Cà phê, thán thư Sầu riêng
            [
                'category_id' => $benh?->id,
                'name' => 'Amistar Top 325SC',
                'active_ingredient' => 'Azoxystrobin + Difenoconazole',
                'concentration' => '325g/L (200g/L + 125g/L)',
                'usage' => 'Trừ thán thư sầu riêng làm cháy đọt rụng lá, rỉ sắt đốm mắt cua trên cà phê, thán thư tiêu, bã trầu chanh dây.',
                'target' => 'Colletotrichum gloeosporioides, Hemileia vastatrix',
                'crops' => 'Sầu riêng, Cà phê, Hồ tiêu, Chanh dây',
                'form_type' => 'SC',
                'manufacturer' => 'Syngenta',
                'isolation_period' => '14 ngày',
                'notes' => 'Giúp bộ lá xanh mướt, bóng lá, quản lý tốt nấm bệnh giai đoạn nuôi trái non.',
            ],
            // 4. Rỉ sắt, nấm hồng Cà phê, đốm rong Sầu riêng
            [
                'category_id' => $benh?->id,
                'name' => 'Anvil 5SC',
                'active_ingredient' => 'Hexaconazole',
                'concentration' => '50g/L',
                'usage' => 'Đặc trị rỉ sắt cà phê, nấm hồng cành tiêu và cà phê, thán thư đốm mắt cua sầu riêng.',
                'target' => 'Corticium salmonicolor, nấm rỉ sắt',
                'crops' => 'Cà phê, Hồ tiêu, Sầu riêng',
                'form_type' => 'SC',
                'manufacturer' => 'Syngenta',
                'isolation_period' => '7 ngày',
                'notes' => 'Tác dụng nội hấp và thấm sâu mạnh. Giá thành hợp lý cho rẫy cà phê diện tích lớn.',
            ],
            // 5. Vi khuẩn đốm dầu Chanh dây & xì mủ vi khuẩn Sầu riêng
            [
                'category_id' => $benh?->id,
                'name' => 'Kasu 2SL',
                'active_ingredient' => 'Kasugamycin',
                'concentration' => '2%',
                'usage' => 'Kháng sinh đặc trị bệnh đốm dầu vi khuẩn chanh dây, xì mủ thối thân vi khuẩn sầu riêng.',
                'target' => 'Vi khuẩn Xanthomonas campestris, Pseudomonas',
                'crops' => 'Chanh dây, Sầu riêng',
                'form_type' => 'SL',
                'manufacturer' => 'Hokko Chemical (Hợp Trí)',
                'isolation_period' => '7 ngày',
                'notes' => 'Không gây nóng bông, an toàn giai đoạn đậu trái chanh dây và sầu riêng.',
            ],
            // 6. Rệp sáp hại rễ & chùm quả Cà phê, Hồ tiêu, Sầu riêng
            [
                'category_id' => $sau?->id,
                'name' => 'Movento 150OD',
                'active_ingredient' => 'Spirotetramat',
                'concentration' => '150g/L',
                'usage' => 'Lưu dẫn 2 chiều diệt rệp sáp gốc và chùm quả cà phê, rệp sáp cuống trái sầu riêng, rệp sáp tiêu, rầy bông.',
                'target' => 'Pseudococcus, rệp sáp, rầy phấn trắng',
                'crops' => 'Sầu riêng, Cà phê, Hồ tiêu, Chanh dây',
                'form_type' => 'OD',
                'manufacturer' => 'Bayer CropScience',
                'isolation_period' => '14 ngày',
                'notes' => 'Lưu dẫn 2 chiều duy nhất diệt cả rệp nằm ẩn sâu trong kẽ lá và dưới gốc.',
            ],
            // 7. Rầy xanh hại đọt non Sầu riêng, Bọ xít muỗi
            [
                'category_id' => $sau?->id,
                'name' => 'Chess 50WG',
                'active_ingredient' => 'Pymetrozine',
                'concentration' => '50%',
                'usage' => 'Đặc trị rầy xanh (rầy nhảy) phá cơi đọt sầu riêng, rầy bông, bọ xít muỗi chanh dây.',
                'target' => 'Rầy xanh, rầy phấn trắng, rầy bông',
                'crops' => 'Sầu riêng, Chanh dây',
                'form_type' => 'WG',
                'manufacturer' => 'Syngenta',
                'isolation_period' => '7 ngày',
                'notes' => 'Cơ chế khóa vòi hút làm rầy ngừng chích hút ngay sau khi trúng thuốc.',
            ],
            // 8. Tuyến trùng rễ hại Tiêu, Cà phê, Sầu riêng
            [
                'category_id' => $sau?->id,
                'name' => 'Tervigo 020SC',
                'active_ingredient' => 'Abamectin',
                'concentration' => '20g/L',
                'usage' => 'Thuốc sinh học đặc trị tuyến trùng hại rễ gây chết chậm hồ tiêu, vàng lá thối rễ cà phê và sầu riêng.',
                'target' => 'Tuyến trùng nốt sưng Meloidogyne sp., Radopholus',
                'crops' => 'Hồ tiêu, Cà phê, Sầu riêng',
                'form_type' => 'SC',
                'manufacturer' => 'Syngenta',
                'isolation_period' => '14 ngày',
                'notes' => 'Công nghệ hạt chelate giúp thuốc phân tán đều trong tầng rễ, không bị cố định bởi keo đất đỏ bazan.',
            ],
            // 9. Mọt đục cành, ve sầu, rệp sáp Cà phê
            [
                'category_id' => $sau?->id,
                'name' => 'Confidor 200SL',
                'active_ingredient' => 'Imidacloprid',
                'concentration' => '200g/L',
                'usage' => 'Trừ rệp sáp, mọt đục cành cà phê, bọ xít lưới hại tiêu, rầy mềm chanh dây.',
                'target' => 'Xylosandrus compactus, bọ xít lưới, rệp sáp',
                'crops' => 'Cà phê, Hồ tiêu, Chanh dây',
                'form_type' => 'SL',
                'manufacturer' => 'Bayer CropScience',
                'isolation_period' => '14 ngày',
                'notes' => 'Hiệu lực lưu dẫn kéo dài, rất phù hợp xử lý sâu hại thân cành vùng đất đỏ Tây Nguyên.',
            ],
            // 10. Nhện đỏ kháng thuốc Sầu riêng, Chanh dây
            [
                'category_id' => $nhen?->id,
                'name' => 'Ortus 5SC',
                'active_ingredient' => 'Fenpyroximate',
                'concentration' => '50g/L',
                'usage' => 'Đặc trị nhện đỏ, nhện lông nhung, nhện trắng hại lá và quả sầu riêng, chanh dây mùa khô.',
                'target' => 'Tetranychus urticae, Panonychus citri',
                'crops' => 'Sầu riêng, Chanh dây, Cà phê',
                'form_type' => 'SC',
                'manufacturer' => 'Nihon Nohyaku',
                'isolation_period' => '7 ngày',
                'notes' => 'Diệt cả trứng, nhện non và nhện trưởng thành. Rất hiệu quả vào mùa khô Tây Nguyên.',
            ],
            // 11. Diệt cỏ rẫy cà phê, vườn sầu riêng
            [
                'category_id' => $co?->id,
                'name' => 'Glufosinate Ammonium 150SL',
                'active_ingredient' => 'Glufosinate Ammonium',
                'concentration' => '150g/L',
                'usage' => 'Trừ cỏ dại, cỏ lá hẹp, cỏ tranh, cỏ chỉ trong vườn sầu riêng, vườn cà phê, rẫy tiêu.',
                'target' => 'Cỏ tranh, cỏ mần trầu, cỏ gấu',
                'crops' => 'Cà phê, Sầu riêng, Hồ tiêu',
                'form_type' => 'SL',
                'manufacturer' => 'Hợp Trí / An Nông',
                'isolation_period' => 'Không áp dụng',
                'notes' => 'Thuốc trừ cỏ tiếp xúc không chọn lọc, dùng phễu chụp để không dính vào lá cây ăn trái.',
            ],
            // 12. Kích đọt, lớn trái, chống rụng hoa Sầu riêng & Chanh dây
            [
                'category_id' => $dieuHoa?->id,
                'name' => 'Progibb 40SG',
                'active_ingredient' => 'Gibberellic Acid (GA3)',
                'concentration' => '40%',
                'usage' => 'Kích đọt đồng loạt sầu riêng, kéo dài cuống trái, hạn chế rụng trái non trên chanh dây và sầu riêng.',
                'target' => 'Điều hòa sinh trưởng, chống rụng sinh lý',
                'crops' => 'Sầu riêng, Chanh dây, Cà phê',
                'form_type' => 'SG',
                'manufacturer' => 'Valent BioSciences',
                'isolation_period' => '3 ngày',
                'notes' => 'Dùng đúng liều lượng chỉ dẫn, tránh phun khi cây đang thiếu dưỡng chất.',
            ],
            // 13. Rửa vườn, nấm hồng, rong rêu Cà phê & Tiêu
            [
                'category_id' => $benh?->id,
                'name' => 'Bordeaux M 25WP (Đồng Bordeaux)',
                'active_ingredient' => 'Copper Hydroxide + Bordeaux',
                'concentration' => '25%',
                'usage' => 'Rửa vườn sau thu hoạch, trừ nấm hồng, rong rêu, tảo đỏ bám thân cành cà phê, hồ tiêu, sầu riêng.',
                'target' => 'Corticium salmonicolor, tảo Cephaleuros virescens',
                'crops' => 'Cà phê, Hồ tiêu, Sầu riêng',
                'form_type' => 'WP',
                'manufacturer' => 'Vipesco',
                'isolation_period' => '7 ngày',
                'notes' => 'Phun sát khuẩn rửa vườn đầu mùa mưa hoặc sau khi cạo vỏ nứt thân xì mủ.',
            ],
        ];

        // Xóa các dữ liệu thuốc demo cũ
        Pesticide::truncate();

        foreach ($demos as $demo) {
            Pesticide::create($demo);
        }
    }
}
