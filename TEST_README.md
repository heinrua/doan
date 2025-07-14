# Báo Cáo Test Laravel Calamity Manager

## Tổng Quan

Dự án đã được tạo đầy đủ test cho tất cả các chức năng **thêm, sửa, xóa** trong hệ thống quản lý thiên tai.

## Các File Test Đã Tạo

### 1. **Authentication Tests** (`tests/Feature/Auth/`)
- `AuthenticationTest.php` - Test đăng nhập/đăng xuất
- `RegistrationTest.php` - Test đăng ký tài khoản

### 2. **User Management Tests** (`tests/Feature/`)
- `UserManagementTest.php` - Test quản lý người dùng (CRUD)

### 3. **Location Management Tests** (`tests/Feature/`)
- `CityManagementTest.php` - Test quản lý thành phố (CRUD)
- `DistrictManagementTest.php` - Test quản lý quận/huyện (CRUD)
- `CommuneManagementTest.php` - Test quản lý xã/phường (CRUD)

### 4. **Calamity Management Tests** (`tests/Feature/`)
- `TypeOfCalamityManagementTest.php` - Test quản lý loại thiên tai (CRUD)
- `CalamityManagementTest.php` - Test quản lý thiên tai (CRUD)

### 5. **Administrative Management Tests** (`tests/Feature/`)
- `AdministrativeManagementTest.php` - Test quản lý trường học, y tế, trung tâm (CRUD)

### 6. **Incident Report Tests** (`tests/Feature/`)
- `IncidentReportTest.php` - Test báo cáo sự cố (CRUD)

### 7. **Dashboard & Integration Tests** (`tests/Feature/`)
- `DashboardTest.php` - Test dashboard thống kê
- `IntegrationTest.php` - Test tích hợp workflow
- `SimpleTest.php` - Test cơ bản

## Cách Chạy Test

### 1. **Chạy tất cả test:**
```bash
php artisan test
```

### 2. **Chạy test với báo cáo chi tiết:**
```bash
php artisan test --testdox
```

### 3. **Chạy từng file test riêng lẻ:**
```bash
# Test authentication
php artisan test tests/Feature/Auth/AuthenticationTest.php

# Test user management
php artisan test tests/Feature/UserManagementTest.php

# Test city management
php artisan test tests/Feature/CityManagementTest.php

# Test district management
php artisan test tests/Feature/DistrictManagementTest.php

# Test commune management
php artisan test tests/Feature/CommuneManagementTest.php

# Test type of calamity management
php artisan test tests/Feature/TypeOfCalamityManagementTest.php

# Test administrative management
php artisan test tests/Feature/AdministrativeManagementTest.php

# Test calamity management
php artisan test tests/Feature/CalamityManagementTest.php

# Test incident report
php artisan test tests/Feature/IncidentReportTest.php
```

### 4. **Chạy script tự động (Windows):**
```bash
run_all_tests.bat
```

## Xuất Báo Cáo Test

### 1. **Báo cáo tổng hợp:**
```bash
php artisan test --testdox > reports/all_tests_report.txt
```

### 2. **Báo cáo chi tiết từng chức năng:**
```bash
# Tạo thư mục reports
mkdir reports

# Chạy từng test và xuất báo cáo
php artisan test tests/Feature/Auth/AuthenticationTest.php --testdox >> reports/detailed_report.txt
php artisan test tests/Feature/UserManagementTest.php --testdox >> reports/detailed_report.txt
# ... và các test khác
```

## Cấu Trúc Test

Mỗi file test bao gồm các test case sau:

### **Test CRUD cơ bản:**
- ✅ **Create** - Test tạo mới dữ liệu
- ✅ **Read** - Test xem danh sách và chi tiết
- ✅ **Update** - Test cập nhật dữ liệu
- ✅ **Delete** - Test xóa dữ liệu
- ✅ **Delete Multiple** - Test xóa nhiều dữ liệu cùng lúc

### **Test Validation:**
- ✅ **Duplicate Check** - Test trùng lặp dữ liệu
- ✅ **Required Fields** - Test trường bắt buộc
- ✅ **Format Validation** - Test định dạng dữ liệu

### **Test Authorization:**
- ✅ **Guest Access** - Test quyền truy cập của khách
- ✅ **Authenticated Access** - Test quyền truy cập của user đã đăng nhập

### **Test Search & Filter:**
- ✅ **Search Functionality** - Test chức năng tìm kiếm
- ✅ **Filter by Type** - Test lọc theo loại

## Factory Files

Các factory đã được tạo để hỗ trợ test:

- `UserFactory.php` - Tạo dữ liệu user test
- `CityFactory.php` - Tạo dữ liệu thành phố test
- `DistrictFactory.php` - Tạo dữ liệu quận/huyện test
- `CommuneFactory.php` - Tạo dữ liệu xã/phường test
- `TypeOfCalamitiesFactory.php` - Tạo dữ liệu loại thiên tai test
- `SubTypeOfCalamitiesFactory.php` - Tạo dữ liệu loại phụ thiên tai test
- `RiskLevelFactory.php` - Tạo dữ liệu mức độ rủi ro test
- `CalamitiesFactory.php` - Tạo dữ liệu thiên tai test
- `AdministrativeFactory.php` - Tạo dữ liệu hành chính test
- `IncidentReportFactory.php` - Tạo dữ liệu báo cáo sự cố test

## Kết Quả Test

Sau khi chạy test, bạn sẽ nhận được:

1. **Báo cáo tổng hợp** - Tổng số test pass/fail
2. **Báo cáo chi tiết** - Kết quả từng test case
3. **File báo cáo** - Lưu trong thư mục `reports/`

## Lưu Ý

- Tất cả test sử dụng database test riêng biệt
- Dữ liệu test được tạo tự động bằng Factory
- Test được thiết kế để chạy độc lập
- Có thể chạy từng test riêng lẻ hoặc tất cả cùng lúc

## Troubleshooting

Nếu gặp lỗi khi chạy test:

1. **Kiểm tra database:** Đảm bảo database test được cấu hình đúng
2. **Chạy migration:** `php artisan migrate --env=testing`
3. **Xóa cache:** `php artisan config:clear`
4. **Kiểm tra routes:** Đảm bảo tất cả routes tồn tại
5. **Kiểm tra models:** Đảm bảo models có đúng relationships

---

**Tác giả:** AI Assistant  
**Ngày tạo:** 2024  
**Phiên bản:** 1.0 