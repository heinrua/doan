<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'Tạo điểm neo đậu', 'slug' => 'create-anchorage-points'],
            ['name' => 'Tạo thiên tai ngập lụt', 'slug' => 'create-calamity-flooding'],
            ['name' => 'Tạo thiên tai sạt lở', 'slug' => 'create-calamity-river-bank'],
            ['name' => 'Tạo thiên tai bão', 'slug' => 'create-calamity-storm'],
            ['name' => 'Tạo thành phố', 'slug' => 'create-city'],
            ['name' => 'Tạo xã', 'slug' => 'create-commune'],
            ['name' => 'Tạo công trình ngập lụt', 'slug' => 'create-construction-flooding'],
            ['name' => 'Tạo công trình sạt lở', 'slug' => 'create-construction-river-bank'],
            ['name' => 'Tạo công trình bão', 'slug' => 'create-construction-storm'],
            ['name' => 'Tạo huyện', 'slug' => 'create-district'],
            ['name' => 'Tạo cảng tránh trú bão', 'slug' => 'create-harbors'],
            ['name' => 'Tạo cấp độ rủi ro', 'slug' => 'create-risk-level'],
            ['name' => 'Tạo phương án ứng phó', 'slug' => 'create-scenarios'],
            ['name' => 'Tạo loại hình thiên tai', 'slug' => 'create-sub-type-of-calamity'],
            ['name' => 'Tạo loại công trình', 'slug' => 'create-type-of-construction'],
            ['name' => 'Tạo loại thiên tai', 'slug' => 'create-type-of-calamity'],
            ['name' => 'Tạo người dùng', 'slug' => 'create-user'],
            ['name' => 'Tạo vai trò', 'slug' => 'create-role'],
            ['name' => 'Xem điểm neo đậu', 'slug' => 'view-anchorage-points'],
            ['name' => 'Xem thiên tai ngập lụt', 'slug' => 'view-calamity-flooding'],
            ['name' => 'Xem thiên tai sạt lở', 'slug' => 'view-calamity-river-bank'],
            ['name' => 'Xem thiên tai bão', 'slug' => 'view-calamity-storm'],
            ['name' => 'Xem thành phố', 'slug' => 'view-city'],
            ['name' => 'Xem xã', 'slug' => 'view-commune'],
            ['name' => 'Xem công trình ngập lụt', 'slug' => 'view-construction-flooding'],
            ['name' => 'Xem công trình sạt lở', 'slug' => 'view-construction-river-bank'],
            ['name' => 'Xem công trình bão', 'slug' => 'view-construction-storm'],
            ['name' => 'Xem huyện', 'slug' => 'view-district'],
            ['name' => 'Xem cảng tránh trú bão', 'slug' => 'view-harbors'],
            ['name' => 'Xem bản đồ ngập lụt', 'slug' => 'view-map-flooding'],
            ['name' => 'Xem bản đồ sạt lở', 'slug' => 'view-map-river-bank'],
            ['name' => 'Xem bản đồ bão', 'slug' => 'view-map-storm'],
            ['name' => 'Xem cấp độ rủi ro', 'slug' => 'view-risk-level'],
            ['name' => 'Xem phương án ứng phó', 'slug' => 'view-scenarios'],
            ['name' => 'Xem loại hình thiên tai', 'slug' => 'view-sub-type-of-calamity'],
            ['name' => 'Xem loại công trình', 'slug' => 'view-type-of-construction'],
            ['name' => 'Xem loại thiên tai', 'slug' => 'view-type-of-calamity'],
            ['name' => 'Xem người dùng', 'slug' => 'view-user'],
            ['name' => 'Xem vai trò', 'slug' => 'view-role'],
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->updateOrInsert(
                ['slug' => $permission['slug']],
                [
                    'name' => $permission['name'],
                    'slug' => $permission['slug'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}
