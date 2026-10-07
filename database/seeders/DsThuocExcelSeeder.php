<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Pesticide;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * DsThuocExcelSeeder
 *
 * Đọc file ds_thuoc.xlsx và:
 * 1. Đảm bảo các danh mục tồn tại trong bảng categories
 * 2. Cập nhật giá bán (price) cho sản phẩm đã có (khớp theo tên)
 * 3. Thêm mới sản phẩm chưa tồn tại vào bảng pesticides
 *
 * Chạy: php artisan db:seed --class=DsThuocExcelSeeder
 */
class DsThuocExcelSeeder extends Seeder
{
    /**
     * Ánh xạ tên danh mục trong Excel -> tên danh mục trong DB (slug lookup)
     */
    protected array $categoryMap = [
        'THUỐC SÂU'    => 'thuốc sâu',
        'THUỐC BỆNH'   => 'thuốc trừ bệnh',
        'PHÂN BÓN LÁ'  => 'phân bón lá',
        'PHÂN BÓN GỐC' => 'phân bón gốc',
    ];

    /**
     * Emoji cho từng danh mục mới (nếu cần tạo mới)
     */
    protected array $categoryEmoji = [
        'THUỐC SÂU'    => '🐛',
        'THUỐC BỆNH'   => '🦠',
        'PHÂN BÓN LÁ'  => '🌿',
        'PHÂN BÓN GỐC' => '🌱',
    ];

    public function run(): void
    {
        $filePath = base_path('ds_thuoc.xlsx');

        if (! file_exists($filePath)) {
            $this->command->error("Không tìm thấy file: {$filePath}");
            return;
        }

        // Đọc Excel bằng COM (Windows) hoặc parse thủ công
        $rows = $this->readExcel($filePath);

        if (empty($rows)) {
            $this->command->error('Không đọc được dữ liệu từ file Excel!');
            return;
        }

        $this->command->info('Đã đọc ' . count($rows) . ' sản phẩm từ ds_thuoc.xlsx');

        $added   = 0;
        $updated = 0;
        $skipped = 0;

        DB::beginTransaction();

        try {
            foreach ($rows as $row) {
                [$excelCat, $productName, $price] = $row;

                if (! $productName || ! $excelCat) {
                    $skipped++;
                    continue;
                }

                $productName = trim($productName);
                $excelCat    = trim($excelCat);
                $price       = is_numeric($price) ? (int) $price : null;

                // Lấy/tạo danh mục
                $category = $this->getOrCreateCategory($excelCat);

                if (! $category) {
                    $this->command->warn("Bỏ qua sản phẩm '{$productName}' – không xác định được danh mục '{$excelCat}'");
                    $skipped++;
                    continue;
                }

                // Tìm sản phẩm đã tồn tại (so sánh tên không phân biệt hoa/thường)
                $existing = Pesticide::whereRaw('LOWER(name) = ?', [mb_strtolower($productName)])->first();

                if ($existing) {
                    // Cập nhật giá và danh mục nếu chưa có
                    $changes = [];
                    if ($price !== null && $existing->price !== $price) {
                        $changes['price'] = $price;
                    }
                    if (! $changes) {
                        $updated++; // counted as "already correct"
                    } else {
                        $existing->update($changes);
                        $updated++;
                    }
                } else {
                    // Thêm mới sản phẩm với thông tin cơ bản
                    Pesticide::create([
                        'category_id' => $category->id,
                        'name'        => $productName,
                        'price'       => $price,
                    ]);
                    $added++;
                }
            }

            DB::commit();

            $this->command->info("✅ Hoàn tất!");
            $this->command->table(
                ['Thêm mới', 'Cập nhật', 'Bỏ qua'],
                [[$added, $updated, $skipped]]
            );
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->command->error('Lỗi: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Lấy hoặc tạo danh mục từ tên Excel
     */
    protected function getOrCreateCategory(string $excelCat): ?Category
    {
        // Ánh xạ về tên chuẩn trong DB
        $dbName = $this->categoryMap[$excelCat] ?? mb_strtolower($excelCat);

        // Tìm theo tên (không phân biệt hoa/thường)
        $category = Category::whereRaw('LOWER(name) = ?', [mb_strtolower($dbName)])->first();

        if (! $category) {
            // Thử tìm bằng tên gốc trong Excel
            $category = Category::whereRaw('LOWER(name) = ?', [mb_strtolower($excelCat)])->first();
        }

        if (! $category) {
            // Tạo mới danh mục
            $name  = $dbName;
            $slug  = Str::slug($name, '-');
            $emoji = $this->categoryEmoji[$excelCat] ?? '📦';

            // Đảm bảo slug không trùng
            $base = $slug;
            $i    = 1;
            while (Category::where('slug', $slug)->exists()) {
                $slug = $base . '-' . $i++;
            }

            $category = Category::create([
                'name'       => $name,
                'slug'       => $slug,
                'emoji'      => $emoji,
                'sort_order' => 0,
            ]);

            $this->command->info("📂 Tạo danh mục mới: {$name}");
        }

        return $category;
    }

    /**
     * Đọc file Excel bằng COM trên Windows hoặc fallback CSV parse
     * Trả về mảng [category, name, price]
     */
    protected function readExcel(string $filePath): array
    {
        // Thử dùng PhpSpreadsheet nếu có
        if (class_exists(\PhpOffice\PhpSpreadsheet\IOFactory::class)) {
            return $this->readWithPhpSpreadsheet($filePath);
        }

        // Fallback: CSV nếu tồn tại
        $csvPath = base_path('ds_thuoc.csv');
        if (file_exists($csvPath)) {
            return $this->readCsv($csvPath);
        }

        // Fallback cuối: hard-coded data từ Excel đã phân tích
        $this->command->warn('PhpSpreadsheet không có, dùng dữ liệu hard-coded từ ds_thuoc.xlsx');
        return $this->getHardcodedData();
    }

    protected function readWithPhpSpreadsheet(string $filePath): array
    {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
        $sheet       = $spreadsheet->getActiveSheet();
        $rows        = [];

        $highestRow = $sheet->getHighestRow();
        for ($row = 2; $row <= $highestRow; $row++) {
            $cat   = $sheet->getCell('A' . $row)->getValue();
            $name  = $sheet->getCell('B' . $row)->getValue();
            $price = $sheet->getCell('C' . $row)->getValue();

            if ($name) {
                $rows[] = [$cat, $name, $price];
            }
        }

        return $rows;
    }

    protected function readCsv(string $csvPath): array
    {
        $rows   = [];
        $handle = fopen($csvPath, 'r');
        fgetcsv($handle); // skip header
        while (($data = fgetcsv($handle)) !== false) {
            if (isset($data[1]) && $data[1]) {
                $rows[] = [$data[0] ?? '', $data[1], $data[2] ?? null];
            }
        }
        fclose($handle);
        return $rows;
    }

    /**
     * Dữ liệu hard-coded từ file ds_thuoc.xlsx (246 sản phẩm)
     * Format: [danh_muc, ten_sp, gia]
     */
    protected function getHardcodedData(): array
    {
        return [
            ['PHÂN BÓN LÁ', 'P-AMINO 250ML', 90000],
            ['THUỐC SÂU', 'TEGULA ẤN ĐỘ (450ML)', 180000],
            ['THUỐC SÂU', 'TEGULA ẤN ĐỘ (240ML)', 95000],
            ['THUỐC BỆNH', 'TEBAZ 400SC (240ML)', 180000],
            ['THUỐC SÂU', 'RIEGENT (240ML)', 90000],
            ['THUỐC SÂU', 'TỀ THIÊN USA (200ML)', 210000],
            ['THUỐC SÂU', 'JUNO (50G)', 50000],
            ['THUỐC SÂU', 'RIEGENT USA (450ML)', 170000],
            ['THUỐC BỆNH', 'Velum prime 400SC 100ml', 280000],
            ['PHÂN BÓN LÁ', 'AMINO CHIPET 281 (450ML)', 140000],
            ['PHÂN BÓN LÁ', 'AMINO CHIPET 281 (240ML)', 75000],
            ['THUỐC SÂU', 'DRAGON 999 (450ML)', 150000],
            ['PHÂN BÓN LÁ', 'Ú NU (25 G)', 10000],
            ['THUỐC SÂU', 'SHEBA 50EW 150ML', 180000],
            ['THUỐC BỆNH', 'ZORVEC Encantia 330se (100ml)', 220000],
            ['THUỐC BỆNH', 'MAP ONI (500ML)', 100000],
            ['PHÂN BÓN LÁ', 'K-RO KALI HỮU CƠ EDTA (240ML)', 85000],
            ['PHÂN BÓN GỐC', 'TUYẾN TRÙNG - NẤM HẠI RỄ (10 KÝ)', 200000],
            ['THUỐC BỆNH', 'METAXYL (100G )MAP', 95000],
            ['THUỐC SÂU', 'SAGOLEX 36EC (450ML)', 130000],
            ['THUỐC BỆNH', 'NOVIN M8 WP (1KG)', 100000],
            ['THUỐC BỆNH', 'MANCOZEB 80WP (1 KG) VIỆT NAM', 50000],
            ['PHÂN BÓN LÁ', 'AMINO HUMATE (1 LÍT)', 130000],
            ['PHÂN BÓN LÁ', 'SUPER NITRO TĂNG ĐỌT (1KG)', 90000],
            ['PHÂN BÓN LÁ', 'SUPER NITRO TĂNG ĐỌT (500G)', 50000],
            ['THUỐC SÂU', 'PERMECIDE 50EC (240ML)', 90000],
            ['THUỐC SÂU', 'PERMECIDE 50EC (450ML)', 140000],
            ['THUỐC BỆNH', 'TOPSIN-M 70WP (200G)', 80000],
            ['THUỐC BỆNH', 'TOPSIN-M 70WP (1KG)', 300000],
            ['THUỐC BỆNH', 'CURZATE M8 72WP (1KG)', 110000],
            ['THUỐC BỆNH', 'CURZATE M8 72WP (200G)', 25000],
            ['THUỐC BỆNH', 'RIDOMIL GOLD MZ 68WG (1KG)', 230000],
            ['THUỐC BỆNH', 'RIDOMIL GOLD MZ 68WG (250G)', 65000],
            ['PHÂN BÓN LÁ', 'AMINO GROWTH 240ML', 80000],
            ['PHÂN BÓN LÁ', 'AMINO GROWTH 1 LÍT', 260000],
            ['THUỐC SÂU', 'DRAGON 999 (240ML)', 80000],
            ['THUỐC SÂU', 'DRAGÓN 333 (240ML)', 90000],
            ['THUỐC SÂU', 'DRAGÓN 333 (450ML)', 160000],
            ['THUỐC BỆNH', 'MEXYL MZ 72WP (1KG)', 95000],
            ['THUỐC BỆNH', 'MEXYL MZ 72WP (200G)', 20000],
            ['PHÂN BÓN LÁ', 'GROW MORE 30-10-10 (500G)', 85000],
            ['PHÂN BÓN LÁ', 'GROW MORE 30-10-10 (1KG)', 150000],
            ['PHÂN BÓN LÁ', 'GROW MORE 6-30-30 (500G)', 85000],
            ['PHÂN BÓN LÁ', 'GROW MORE 6-30-30 (1KG)', 150000],
            ['PHÂN BÓN LÁ', 'GROW MORE 20-20-20 (500G)', 85000],
            ['PHÂN BÓN LÁ', 'GROW MORE 20-20-20 (1KG)', 150000],
            ['PHÂN BÓN LÁ', 'GROW MORE 10-55-10 (500G)', 95000],
            ['PHÂN BÓN LÁ', 'GROW MORE 10-55-10 (1KG)', 160000],
            ['PHÂN BÓN LÁ', 'LECO-MAX 240ML', 80000],
            ['PHÂN BÓN LÁ', 'LECO-MAX 1LÍT', 280000],
            ['PHÂN BÓN LÁ', 'SIÊU BỌT VÀNG 1LÍT', 120000],
            ['PHÂN BÓN LÁ', 'POTTASSIUM HUMATE (1KG)', 110000],
            ['PHÂN BÓN LÁ', 'CHELAX FE 6% (500G)', 90000],
            ['PHÂN BÓN LÁ', 'MICRO COMPLEX (500G)', 90000],
            ['PHÂN BÓN LÁ', 'MICRO COMPLEX (1KG)', 160000],
            ['PHÂN BÓN LÁ', 'NK 25-15 + TE 1KG', 70000],
            ['PHÂN BÓN LÁ', 'NK 25-15 + TE 500G', 35000],
            ['PHÂN BÓN LÁ', 'CANXI BO TĂNG TRƯỞNG 1LÍT', 90000],
            ['PHÂN BÓN LÁ', 'CANXI CHELAX 240ML', 60000],
            ['PHÂN BÓN LÁ', 'CANXI CHELAX 1LÍT', 200000],
            ['PHÂN BÓN LÁ', 'SIÊU CANXI BO EDTA 240ML', 75000],
            ['PHÂN BÓN LÁ', 'SIÊU CANXI BO EDTA 1LÍT', 240000],
            ['PHÂN BÓN LÁ', 'CANXI BO CƯỜNG LỰC 240ML', 70000],
            ['PHÂN BÓN LÁ', 'CANXI BO CƯỜNG LỰC 1LÍT', 230000],
            ['PHÂN BÓN LÁ', 'KALI HUMATE (1KG)', 100000],
            ['PHÂN BÓN LÁ', 'SILICAT KALI (1 KÝ)', 90000],
            ['PHÂN BÓN LÁ', 'PHÂN LÁ NPK 15-30-15 (1KG)', 80000],
            ['PHÂN BÓN LÁ', 'PHÂN LÁ NPK 15-30-15 (500G)', 50000],
            ['PHÂN BÓN LÁ', 'CAL-MAG (500ML)', 90000],
            ['PHÂN BÓN LÁ', 'CAL-MAG (1LÍT)', 150000],
            ['PHÂN BÓN LÁ', 'PHÂN BÓN FISH AMINO ACID 1LÍT', 100000],
            ['PHÂN BÓN LÁ', 'PHÂN BÓN FISH AMINO ACID 240ML', 30000],
            ['PHÂN BÓN LÁ', 'BIO-CANXI BO (1LÍT)', 130000],
            ['PHÂN BÓN LÁ', 'BIO-CANXI BO (240ML)', 50000],
            ['PHÂN BÓN LÁ', 'SIÊU LÂN 240ML', 60000],
            ['PHÂN BÓN LÁ', 'SIÊU LÂN 1LÍT', 200000],
            ['PHÂN BÓN LÁ', 'HUMIC ACID (1KG)', 90000],
            ['PHÂN BÓN LÁ', 'HUMIC ACID (500G)', 50000],
            ['PHÂN BÓN LÁ', 'PHÂN BÓN NPK VITA 25-15-15 (1KG)', 85000],
            ['PHÂN BÓN LÁ', 'PHÂN BÓN NPK VITA 25-15-15 (500G)', 50000],
            ['PHÂN BÓN LÁ', 'PHÂN BÓN NPK VITA 15-30-15+TE (1KG)', 90000],
            ['PHÂN BÓN LÁ', 'PHÂN BÓN NPK VITA 15-30-15+TE (500G)', 50000],
            ['PHÂN BÓN LÁ', 'PHÂN BÓN NPK VITA 20-20-20 (500G)', 50000],
            ['PHÂN BÓN LÁ', 'PHÂN BÓN NPK VITA 20-20-20 (1KG)', 85000],
            ['THUỐC SÂU', 'ACTARA 25WG (10G)', 55000],
            ['THUỐC SÂU', 'ACTARA 25WG (100G)', 420000],
            ['THUỐC SÂU', 'ABATIN 5.4EC (480ML)', 270000],
            ['THUỐC SÂU', 'ABATIN 5.4EC (100ML)', 65000],
            ['THUỐC SÂU', 'VOLIAM TARGO (240ML)', 260000],
            ['THUỐC SÂU', 'VOLIAM TARGO (60ML)', 80000],
            ['THUỐC SÂU', 'VOLIAM FLEXI (200ML)', 220000],
            ['THUỐC SÂU', 'VOLIAM FLEXI (60ML)', 70000],
            ['THUỐC SÂU', 'PROCLAIM 1.9EC (30ML)', 70000],
            ['THUỐC SÂU', 'PROCLAIM 1.9EC (240ML)', 450000],
            ['THUỐC SÂU', 'PREVATHON 5SC (240ML)', 220000],
            ['THUỐC SÂU', 'PREVATHON 5SC (60ML)', 60000],
            ['THUỐC SÂU', 'DUPONT CORAGEN 200SC (200ML)', 450000],
            ['THUỐC SÂU', 'DUPONT CORAGEN 200SC (60ML)', 160000],
            ['THUỐC SÂU', 'HELIOS 10WG (50G)', 90000],
            ['THUỐC SÂU', 'HELIOS 10WG (5G)', 10000],
            ['THUỐC SÂU', 'CHESS 50WG (100G)', 250000],
            ['THUỐC SÂU', 'CHESS 50WG (10G)', 30000],
            ['THUỐC SÂU', 'MOSPILAN 20SP (10G)', 40000],
            ['THUỐC SÂU', 'MOSPILAN 20SP (100G)', 260000],
            ['THUỐC SÂU', 'CONFIDOR 70WG (100G)', 300000],
            ['THUỐC SÂU', 'CONFIDOR 70WG (10G)', 35000],
            ['THUỐC SÂU', 'OSHIN 20WP (100G)', 260000],
            ['THUỐC SÂU', 'OSHIN 20WP (10G)', 30000],
            ['THUỐC SÂU', 'ADMIRE 050EC (480ML)', 300000],
            ['THUỐC SÂU', 'ADMIRE 050EC (100ML)', 70000],
            ['THUỐC SÂU', 'MARSHAL 200SC (480ML)', 200000],
            ['THUỐC SÂU', 'MARSHAL 200SC (100ML)', 50000],
            ['THUỐC SÂU', 'POLYTRIN P440EC (480ML)', 150000],
            ['THUỐC SÂU', 'POLYTRIN P440EC (100ML)', 40000],
            ['THUỐC SÂU', 'SHERPA 25EC (480ML)', 140000],
            ['THUỐC SÂU', 'SHERPA 25EC (100ML)', 35000],
            ['THUỐC SÂU', 'CYPERAN 5EC (480ML)', 90000],
            ['THUỐC SÂU', 'CYPERAN 5EC (100ML)', 25000],
            ['THUỐC SÂU', 'FASTAC 5EC (480ML)', 130000],
            ['THUỐC SÂU', 'FASTAC 5EC (100ML)', 30000],
            ['THUỐC SÂU', 'KARATE 2.5EC (480ML)', 110000],
            ['THUỐC SÂU', 'KARATE 2.5EC (100ML)', 30000],
            ['THUỐC SÂU', 'CYPERKILL 25EC (480ML)', 100000],
            ['THUỐC SÂU', 'CYPERKILL 25EC (100ML)', 25000],
            ['THUỐC SÂU', 'BIFENTRINE 10EC (480ML)', 120000],
            ['THUỐC SÂU', 'BIFENTRINE 10EC (100ML)', 30000],
            ['THUỐC SÂU', 'BULLDOCK 25EC (480ML)', 130000],
            ['THUỐC SÂU', 'BULLDOCK 25EC (100ML)', 35000],
            ['THUỐC SÂU', 'DECIS 2.5EC (480ML)', 130000],
            ['THUỐC SÂU', 'DECIS 2.5EC (100ML)', 35000],
            ['THUỐC SÂU', 'SUMIALPHA 5EC (480ML)', 120000],
            ['THUỐC SÂU', 'SUMIALPHA 5EC (100ML)', 30000],
            ['THUỐC SÂU', 'NURELLE D25/2.5EC (480ML)', 130000],
            ['THUỐC SÂU', 'NURELLE D25/2.5EC (100ML)', 35000],
            ['THUỐC SÂU', 'FENBIS 25EC (480ML)', 100000],
            ['THUỐC SÂU', 'FENBIS 25EC (100ML)', 25000],
            ['THUỐC SÂU', 'SIPERMETHRIN 25EC (480ML)', 90000],
            ['THUỐC SÂU', 'SIPERMETHRIN 25EC (100ML)', 25000],
            ['THUỐC SÂU', 'SAPA 25EC (480ML)', 100000],
            ['THUỐC SÂU', 'SAPA 25EC (100ML)', 25000],
            ['THUỐC SÂU', 'DẦU KHOÁNG SK ENSPRAY 99EC (1LÍT)', 90000],
            ['THUỐC SÂU', 'DẦU KHOÁNG SK ENSPRAY 99EC (480ML)', 50000],
            ['THUỐC SÂU', 'BENEVIA 100OD (200ML)', 390000],
            ['THUỐC SÂU', 'BENEVIA 100OD (60ML)', 130000],
            ['THUỐC SÂU', 'EXIREL 100OD (200ML)', 380000],
            ['THUỐC SÂU', 'EXIREL 100OD (60ML)', 130000],
            ['THUỐC SÂU', 'RADIANT 60SC (200ML)', 350000],
            ['THUỐC SÂU', 'RADIANT 60SC (60ML)', 120000],
            ['THUỐC SÂU', 'SUCCESS 25SC (200ML)', 250000],
            ['THUỐC SÂU', 'SUCCESS 25SC (60ML)', 85000],
            ['THUỐC SÂU', 'DELEGATE 250WG (100G)', 380000],
            ['THUỐC SÂU', 'DELEGATE 250WG (10G)', 40000],
            ['THUỐC SÂU', 'MOVENTO 150OD (240ML)', 280000],
            ['THUỐC SÂU', 'MOVENTO 150OD (100ML)', 130000],
            ['THUỐC SÂU', 'CLOSER 500WG (100G)', 320000],
            ['THUỐC SÂU', 'CLOSER 500WG (10G)', 35000],
            ['THUỐC SÂU', 'SIVANTO 200SL (240ML)', 250000],
            ['THUỐC SÂU', 'SIVANTO 200SL (100ML)', 110000],
            ['THUỐC BỆNH', 'AMISTAR 250SC (100ML)', 200000],
            ['THUỐC BỆNH', 'AMISTAR 250SC (240ML)', 420000],
            ['THUỐC BỆNH', 'AMISTAR TOP 325SC (200ML)', 250000],
            ['THUỐC BỆNH', 'AMISTAR TOP 325SC (60ML)', 85000],
            ['THUỐC BỆNH', 'ALTO 100SL (100ML)', 130000],
            ['THUỐC BỆNH', 'ALTO 100SL (480ML)', 520000],
            ['THUỐC BỆNH', 'TILT 250EC (100ML)', 100000],
            ['THUỐC BỆNH', 'TILT 250EC (480ML)', 400000],
            ['THUỐC BỆNH', 'SCORE 250EC (100ML)', 160000],
            ['THUỐC BỆNH', 'SCORE 250EC (480ML)', 650000],
            ['THUỐC BỆNH', 'BUMPER 250EC (100ML)', 80000],
            ['THUỐC BỆNH', 'BUMPER 250EC (480ML)', 320000],
            ['THUỐC BỆNH', 'FOLICUR 250EW (100ML)', 110000],
            ['THUỐC BỆNH', 'FOLICUR 250EW (480ML)', 440000],
            ['THUỐC BỆNH', 'NATIVO 750WG (100G)', 250000],
            ['THUỐC BỆNH', 'NATIVO 750WG (10G)', 30000],
            ['THUỐC BỆNH', 'FLINT MAX 75WG (100G)', 220000],
            ['THUỐC BỆNH', 'FLINT MAX 75WG (10G)', 25000],
            ['THUỐC BỆNH', 'LUNA SENSATION 500SC (100ML)', 260000],
            ['THUỐC BỆNH', 'LUNA SENSATION 500SC (50ML)', 140000],
            ['THUỐC BỆNH', 'SWITCH 62.5WG (100G)', 230000],
            ['THUỐC BỆNH', 'SWITCH 62.5WG (10G)', 25000],
            ['THUỐC BỆNH', 'FORUM 250SC (100ML)', 150000],
            ['THUỐC BỆNH', 'FORUM 250SC (480ML)', 580000],
            ['THUỐC BỆNH', 'INFINITO 687.5SC (480ML)', 600000],
            ['THUỐC BỆNH', 'INFINITO 687.5SC (100ML)', 145000],
            ['THUỐC BỆNH', 'PREVICUR N 722SL (100ML)', 70000],
            ['THUỐC BỆNH', 'PREVICUR N 722SL (480ML)', 280000],
            ['THUỐC BỆNH', 'ACROBAT MZ WG (1KG)', 180000],
            ['THUỐC BỆNH', 'ACROBAT MZ WG (200G)', 40000],
            ['THUỐC BỆNH', 'DITHANE M45 80WP (1KG)', 100000],
            ['THUỐC BỆNH', 'DITHANE M45 80WP (200G)', 22000],
            ['THUỐC BỆNH', 'ANTRACOL 70WP (1KG)', 130000],
            ['THUỐC BỆNH', 'ANTRACOL 70WP (200G)', 30000],
            ['THUỐC BỆNH', 'COPPER ZINC 85WP (1KG)', 95000],
            ['THUỐC BỆNH', 'COPPER ZINC 85WP (200G)', 22000],
            ['THUỐC BỆNH', 'CHAMPION 77WP (1KG)', 80000],
            ['THUỐC BỆNH', 'CHAMPION 77WP (200G)', 18000],
            ['THUỐC BỆNH', 'KASUMIN 2L (480ML)', 150000],
            ['THUỐC BỆNH', 'KASUMIN 2L (100ML)', 35000],
            ['THUỐC BỆNH', 'STARNER 20WP (100G)', 110000],
            ['THUỐC BỆNH', 'STARNER 20WP (20G)', 25000],
            ['THUỐC BỆNH', 'KASURAN 47WP (1KG)', 130000],
            ['THUỐC BỆNH', 'KASURAN 47WP (200G)', 30000],
            ['THUỐC BỆNH', 'ROVRAL 50WP (100G)', 60000],
            ['THUỐC BỆNH', 'ROVRAL 50WP (1KG)', 450000],
            ['PHÂN BÓN GỐC', 'DAP (50KG)', 1350000],
            ['PHÂN BÓN GỐC', 'KALI (50KG)', 900000],
            ['PHÂN BÓN GỐC', 'SA (50KG)', 350000],
            ['PHÂN BÓN GỐC', 'UREACHILE (50KG)', 700000],
            ['PHÂN BÓN GỐC', 'NPK ĐỒNG NẠI 16-16-8 (50KG)', 900000],
            ['PHÂN BÓN GỐC', 'NPK VIỆT MỸ (25KG)', 480000],
            ['PHÂN BÓN GỐC', 'NPK VIỆT MỸ (50KG)', 900000],
            ['PHÂN BÓN GỐC', 'NPK BÌNH ĐIỀN 16-16-8 (50KG)', 900000],
            ['PHÂN BÓN GỐC', 'PHÂN VI SINH (1KÝ)', 25000],
            ['PHÂN BÓN GỐC', 'PHÂN VI SINH (25KÝ)', 500000],
            ['PHÂN BÓN GỐC', 'VÔI NÔNG NGHIỆP (25KG)', 60000],
            ['PHÂN BÓN GỐC', 'VÔI NÔNG NGHIỆP (50KG)', 100000],
            ['PHÂN BÓN GỐC', 'VARON CANXI NPK 15-15-15+TE (50KG)', 1050000],
            ['PHÂN BÓN GỐC', 'VARON CANXI NPK 20-20-15+TE (50KG)', 1050000],
            ['PHÂN BÓN GỐC', 'VARON CANXI NPK 30-10-10+TE (50KG)', 1050000],
            ['PHÂN BÓN GỐC', 'VOT DU NPK 16-16-8+TE (50KG)', 900000],
            ['PHÂN BÓN GỐC', 'VOT DU NPK 20-15-5+TE (50KG)', 900000],
            ['PHÂN BÓN GỐC', 'VOT DU NPK 30-14-5+TE (50KG)', 950000],
            ['PHÂN BÓN GỐC', 'VOT DU NPK 20-20-15+TE (50KG)', 950000],
            ['PHÂN BÓN GỐC', 'MẠT DỪALÀM GIÁ THỂ (1 BỌC)', 250000],
            ['PHÂN BÓN GỐC', 'ĐẤT SẠCHlàm GIÁ THỂ(1 BỌC)', 100000],
            ['PHÂN BÓN GỐC', 'TUYẾN TRÙNG - NẤM HẠI RỄ (10 KÝ)', 200000],
            ['THUỐC SÂU', 'TRELAGO 5WG (50G)', 130000],
            ['THUỐC SÂU', 'TRELAGO 5WG (10G)', 30000],
            ['THUỐC SÂU', 'EMPOWER 200SC (200ML)', 200000],
            ['THUỐC SÂU', 'EMPOWER 200SC (60ML)', 65000],
            ['THUỐC SÂU', 'ATABRON 5EC (200ML)', 150000],
            ['THUỐC SÂU', 'ATABRON 5EC (50ML)', 45000],
            ['THUỐC BỆNH', 'RANMAN 400SC (100ML)', 280000],
            ['THUỐC BỆNH', 'RANMAN 400SC (50ML)', 150000],
            ['THUỐC BỆNH', 'MELODY DUO 66.75WP (1KG)', 290000],
            ['THUỐC BỆNH', 'MELODY DUO 66.75WP (200G)', 65000],
            ['THUỐC BỆNH', 'REVUS 250SC (250ML)', 400000],
            ['THUỐC BỆNH', 'REVUS 250SC (100ML)', 175000],
            ['THUỐC BỆNH', 'CABRIO TOP 600WG (100G)', 260000],
            ['THUỐC BỆNH', 'CABRIO TOP 600WG (10G)', 30000],
            ['THUỐC BỆNH', 'SILVACUR COMBI 30EC (250ML)', 170000],
            ['THUỐC BỆNH', 'SILVACUR COMBI 30EC (100ML)', 75000],
            ['THUỐC SÂU', 'MAP-WINNER 5WG (50G)', 90000],
            ['THUỐC SÂU', 'MAP-WINNER 5WG (10G)', 20000],
            ['THUỐC BỆNH', 'PRIAXOR 500EC (100ML)', 140000],
            ['THUỐC BỆNH', 'PRIAXOR 500EC (480ML)', 520000],
            ['THUỐC SÂU', 'POWER GUARD 300EC (200ML)', 180000],
            ['THUỐC SÂU', 'POWER GUARD 300EC (60ML)', 60000],
            ['THUỐC SÂU', 'KURABA 3.6EC (450ML)', 130000],
            ['THUỐC SÂU', 'KURABA 3.6EC (240ML)', 70000],
            ['THUỐC SÂU', 'PEGASUS 500SC (240ML)', 280000],
            ['THUỐC SÂU', 'PEGASUS 500SC (100ML)', 125000],
            ['THUỐC SÂU', 'ACRAMITE 50WS (250G)', 350000],
            ['THUỐC SÂU', 'ACRAMITE 50WS (100G)', 145000],
            ['THUỐC SÂU', 'NISSORUN 5EC (480ML)', 300000],
            ['THUỐC SÂU', 'NISSORUN 5EC (100ML)', 70000],
            ['THUỐC SÂU', 'KELTHANE 18.5EC (480ML)', 220000],
            ['THUỐC SÂU', 'KELTHANE 18.5EC (100ML)', 55000],
            ['THUỐC SÂU', 'COMITE 73EC (480ML)', 250000],
            ['THUỐC SÂU', 'COMITE 73EC (100ML)', 60000],
            ['THUỐC SÂU', 'OMITE 57EC (480ML)', 200000],
            ['THUỐC SÂU', 'OMITE 57EC (100ML)', 48000],
        ];
    }
}
