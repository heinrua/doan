<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\IncidentReport;
use App\Notifications\IncidentReportCreated;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo một số báo cáo sự cố test
        $incidentReports = [
            [
                'reporter_name' => 'Nguyễn Văn A',
                'contact_number' => '0123456789',
                'coordinates' => '10.123456, 105.123456',
                'commune_id' => 1,
                'sub_type_of_calamity_id' => 1,
                'description' => 'Có sạt lở bờ sông tại khu vực này',
            ],
            [
                'reporter_name' => 'Trần Thị B',
                'contact_number' => '0987654321',
                'coordinates' => '10.234567, 105.234567',
                'commune_id' => 2,
                'sub_type_of_calamity_id' => 2,
                'description' => 'Nước lũ dâng cao tại khu vực này',
            ],
            [
                'reporter_name' => 'Lê Văn C',
                'contact_number' => '0369852147',
                'coordinates' => '10.345678, 105.345678',
                'commune_id' => 3,
                'sub_type_of_calamity_id' => 3,
                'description' => 'Gió mạnh làm đổ cây tại khu vực này',
            ],
        ];

        foreach ($incidentReports as $reportData) {
            $incidentReport = IncidentReport::create($reportData);
            
            // Gửi thông báo cho tất cả người dùng
            $users = User::all();
            foreach ($users as $user) {
                $user->notify(new IncidentReportCreated($incidentReport));
            }
        }
    }
} 