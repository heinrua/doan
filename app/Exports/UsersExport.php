<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class UsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
     public function collection()
    {
        return User::select('user_name', 'full_name', 'email',)->get();
    }

    public function headings(): array
    {
        return [
            'Tên đăng nhập',
            'Họ tên',
            'Email'
        ];
    }
    
}
