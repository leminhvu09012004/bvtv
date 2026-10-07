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
            Batch16ExactInventorySKUsSeeder::class,
            MergeProductSizesSeeder::class,
            DurianDiseasesSeeder::class,
            TebazPesticideSeeder::class,
        ]);
    }
}
