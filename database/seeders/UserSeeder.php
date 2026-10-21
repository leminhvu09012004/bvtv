<?php

namespace Database\Seeders;

use App\Models\CustomerProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tài khoản Quản Trị Viên (username: admin / pass: 1)
        User::updateOrCreate(
            ['email' => 'admin@bvtvtaynguyen.vn'],
            [
                'username' => 'admin',
                'name' => 'Quản Trị Viên',
                'phone' => '0988888888',
                'password' => Hash::make('1'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // 2. Tài khoản Thu Ngân Quầy POS (username: pos / pass: 1)
        User::updateOrCreate(
            ['email' => 'pos@bvtvtaynguyen.vn'],
            [
                'username' => 'pos',
                'name' => 'Thu Ngân Quầy POS',
                'phone' => '0977777777',
                'password' => Hash::make('1'),
                'role' => 'staff',
                'is_active' => true,
            ]
        );

        // 3. Tài khoản Khách Hàng Nông Hộ (username: customer / pass: 1)
        $customer = User::updateOrCreate(
            ['email' => 'customer@bvtvtaynguyen.vn'],
            [
                'username' => 'customer',
                'name' => 'Bà Con Nông Dân',
                'phone' => '0912345678',
                'password' => Hash::make('1'),
                'role' => 'customer',
                'is_active' => true,
            ]
        );
        CustomerProfile::updateOrCreate(
            ['user_id' => $customer->id],
            [
                'customer_code' => 'KH-001',
                'full_name' => 'Bà Con Nông Dân',
                'phone' => '0912345678',
                'crop_type' => 'Sầu riêng, Cà phê',
                'farm_area_hectares' => 2.5,
                'loyalty_tier' => 'gold',
            ]
        );

        // Tài khoản Khách hàng phụ: nongdan@gmail.com / pass: 1
        $nongDan = User::updateOrCreate(
            ['email' => 'nongdan@gmail.com'],
            [
                'username' => 'nongdan',
                'name' => 'Nguyễn Văn Nông Dân',
                'phone' => '0933456789',
                'password' => Hash::make('1'),
                'role' => 'customer',
                'is_active' => true,
            ]
        );
        CustomerProfile::updateOrCreate(
            ['user_id' => $nongDan->id],
            [
                'customer_code' => 'KH-002',
                'full_name' => 'Nguyễn Văn Nông Dân',
                'phone' => '0933456789',
                'crop_type' => 'Hồ tiêu, Sầu riêng',
                'farm_area_hectares' => 1.8,
                'loyalty_tier' => 'standard',
            ]
        );

        // 4. Tài khoản Kỹ Sư / Học Thuật Tra Cứu (username: user / pass: 1)
        User::updateOrCreate(
            ['email' => 'user@bvtvtaynguyen.vn'],
            [
                'username' => 'user',
                'name' => 'Kỹ Sư Nông Nghiệp BVTV',
                'phone' => '0966666666',
                'password' => Hash::make('1'),
                'role' => 'engineer',
                'is_active' => true,
            ]
        );
    }
}
