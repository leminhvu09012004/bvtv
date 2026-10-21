<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            Batch16ExactInventorySKUsSeeder::class,
            MergeProductSizesSeeder::class,
            CropsSeeder::class,
            ConsolidateDiseasesAndLinkCropsSeeder::class,
            TebazPesticideSeeder::class,
            RuoiVangDucQuaSeeder::class,
            BenhLoCoReSeeder::class,
            BoXitMuoiSeeder::class,
            KhamXoanVirusSeeder::class,
            BenhDomDauBaTrauSeeder::class,
            DomRongTaoDoSeeder::class,
            BenhPhanTrangSeeder::class,
            BenhNamHongSeeder::class,
            BenhLasiodiplodiaSeeder::class,
            BenhPhomopsisSeeder::class,
            BenhSeptoriaSeeder::class,
            TuyenTrungSauDatSeeder::class,
            BenhAlternariaSeeder::class,
            NhenHaiCaySeeder::class,
            RepVaySeeder::class,
            BenhThanThuSeeder::class,
            SauDucTraiSeeder::class,
            BenhChayLaRhizoctoniaSeeder::class,
            RepSapSeeder::class,
            SauDucCanhSeeder::class,
            RayXanhRayNhaySeeder::class,
            BenhFusariumSeeder::class,
            SauAnLaSeeder::class,
            BenhPythiumSeeder::class,
            SauAnBongSeeder::class,
            BenhPhytophthoraSeeder::class,
            BoTriSeeder::class,
            RepMuoiSeeder::class,
        ]);
    }
}
