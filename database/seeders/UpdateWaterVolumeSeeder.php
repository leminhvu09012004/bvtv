<?php

namespace Database\Seeders;

use App\Models\Pesticide;
use Illuminate\Database\Seeder;

class UpdateWaterVolumeSeeder extends Seeder
{
    public function run(): void
    {
        $waterVolumes = [
            'AGRI-FOS 400SL' => '400 - 500 lít nước (2 - 2.5 phuy)',
            'ANLIEN ANNONG 400SC' => '400 - 500 lít nước (2 - 2.5 phuy)',
            'ANLIEN ANNONG 800WP' => '400 - 500 lít nước (2 - 2.5 phuy)',
            'ASMILTATOP SUPER 400SC' => '200 - 300 lít nước (1 - 1.5 phuy)',
            'DIMETHOR 500SC' => '400 - 500 lít nước (2 phuy)',
            'KASUGACIN 3SL' => '300 - 400 lít nước (1.5 - 2 phuy)',
            'NUÔI TRÁI EDTA' => '400 - 500 lít nước (2 phuy)',
            'OR - SIK' => '400 lít nước (2 phuy)',
            'BLACK - O' => '400 lít nước (2 phuy)',
            'XANH UM - AMINO SEAWEED' => '400 - 500 lít nước (2 - 2.5 phuy)',
            'LEDAN 95SP' => '200 lít nước (1 phuy)',
            'LEDAN 4GR' => 'Rải gốc 20 - 30g/cây hoặc pha 200L',
            'VỌT DỮ - NPK 30-14-5 TE' => '400 lít nước (2 phuy)',
            'VELUM PRIME 400 SC' => '200 lít nước (1 phuy tưới gốc)',
            'TRICHODERMA AC (MEN Ủ SINH HỌC)' => '400 - 600 lít nước tưới gốc',
            'DANJIRI 10SC' => '200 - 300 lít nước',
            'ZORVEC ENCANTIA 330SE' => '200 lít nước (1 phuy)',
            'RIDOMIL GOLD 68WG' => '400 - 500 lít nước (2 - 2.5 phuy)',
            'THIPRO 550EC' => '400 - 500 lít nước (2 phuy)',
            'BO 150.000' => '400 - 500 lít nước (2 phuy)',
            'KANBA 15-15-15 EDTA' => '400 lít nước (2 phuy)',
            'CANXI BO EDTA (MONYKA)' => '400 - 500 lít nước (2 phuy)',
            'OR - CA - BO' => '400 lít nước (2 phuy)',
            'GRO - RIN' => '400 - 500 lít nước',
            'TĂNG TRƯỞNG EDTA PAROW' => '400 lít nước (2 phuy)',
            'TILT SUPER 300EC' => '200 - 250 lít nước',
            'FULLKILL 50EC' => '400 lít nước (2 phuy)',
            'NPK 6-34-34 PREMIUM TE' => '400 lít nước (2 phuy)',
            'PHONIX DRAGON 999' => '400 - 500 lít nước (2 phuy)',
            'EDDY 72WP' => '400 - 500 lít nước (2 - 2.5 phuy)',
            'RỬA CÀNH KHÁNG KHUẨN' => '400 - 500 lít nước (2 - 2.5 phuy)',
            'Aliette 800WG' => '400 - 500 lít nước',
            'Ridomil Gold 68WG' => '400 - 500 lít nước',
            'Amistar Top 325SC' => '200 - 250 lít nước',
            'Anvil 5SC' => '400 - 500 lít nước',
            'Kasu 2SL' => '400 - 500 lít nước',
            'Movento 150OD' => '200 lít nước (1 phuy)',
            'Chess 50WG' => '200 lít nước',
            'Tervigo 020SC' => '200 lít nước tưới gốc',
            'Confidor 200SL' => '200 - 250 lít nước',
            'Ortus 5SC' => '200 lít nước',
            'Glufosinate Ammonium 150SL' => '200 - 400 lít nước',
            'Progibb 40SG' => '200 - 400 lít nước',
            'Bordeaux M 25WP (Đồng Bordeaux)' => '400 lít nước (2 phuy)',
        ];

        foreach ($waterVolumes as $name => $volume) {
            Pesticide::where('name', $name)->update(['water_volume' => $volume]);
        }

        // Set default for any remaining pesticides
        Pesticide::whereNull('water_volume')->update(['water_volume' => '200 - 400 lít nước']);
    }
}
