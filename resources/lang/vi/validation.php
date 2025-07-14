<?php
return [
    'required' => 'Trường :attribute là bắt buộc.',
    'unique' => ':attribute đã tồn tại.',
    'min' => [
        'string' => 'Trường :attribute phải có ít nhất :min ký tự.',
    ],
    'max' => [
        'string' => 'Trường :attribute không được vượt quá :max ký tự.',
    ],
    'numeric' => 'Trường :attribute phải là số.',
    'exists' => 'Giá trị của :attribute không hợp lệ.',
    'array' => 'Trường :attribute phải là một mảng.',
    'confirmed' => 'Mật khẩu xác nhận không khớp.',
    // Tuỳ chỉnh tên field
    'attributes' => [
        'name' => 'tên',
        'code' => 'mã',
        'city_id' => 'tỉnh/thành',
        'coordinates' => 'tọa độ',
        'district_id' => 'quận/huyện',
        'password' => 'mật khẩu',
        'group_user_id' => 'nhóm người dùng',
        'type_of_calamity_id'=> 'loại hình thiên tai',
        'sub_type_of_calamity_id'=> 'loại hình thiên tai',
        'risk_level_id' => 'cấp độ thiên tai',
        'type_of_construction_id' => 'loại công trình',
        'sub_type_of_calamity_ids' => 'các loại hình thiên tai phụ',
        'user_name' => 'Tên đăng nhập',
        'commune_ids' => 'các địa phương ảnh hưởng',
        'email' => 'Địa chỉ email',
        'phone' => 'Số điện thoại',
        'address' => 'Địa chỉ',
        'description' => 'Mô tả',
        'status' => 'Trạng thái',
        'created_at' => 'Ngày tạo',
        'updated_at' => 'Ngày cập nhật',
        'password_confirmation' => 'mật khẩu xác nhận',
        'old_password' => 'mật khẩu cũ',

    ],
];
