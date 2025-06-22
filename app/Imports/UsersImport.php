<?php
namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Bỏ qua dòng không có user_name
        if (empty($row['tên_đăng_nhập'])) return null;

        return new User([
            'user_name' => $row['tên_đăng_nhập'],
            'full_name' => $row['họ_tên'] ?? '',
            'email'     => $row['email'] ?? '',
            'password'  => Hash::make('12345678'), // Gán password mặc định
        ]);
    }
}

