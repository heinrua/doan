@echo off
echo ========================================
echo RUNNING ALL TESTS FOR CALAMITY MANAGER
echo ========================================

REM Tạo thư mục reports nếu chưa có
if not exist "reports" mkdir reports

REM Chạy tất cả test và xuất báo cáo
echo Running all tests...
php artisan test --testdox > reports/all_tests_report.txt

REM Chạy từng file test riêng lẻ để có báo cáo chi tiết
echo.
echo ========================================
echo DETAILED TEST REPORTS
echo ========================================

echo Running User Management Tests...
php artisan test tests/Feature/UserManagementTest.php --testdox >> reports/detailed_report.txt

echo Running City Management Tests...
php artisan test tests/Feature/CityManagementTest.php --testdox >> reports/detailed_report.txt

echo Running District Management Tests...
php artisan test tests/Feature/DistrictManagementTest.php --testdox >> reports/detailed_report.txt

echo Running Commune Management Tests...
php artisan test tests/Feature/CommuneManagementTest.php --testdox >> reports/detailed_report.txt

echo Running Type of Calamity Management Tests...
php artisan test tests/Feature/TypeOfCalamityManagementTest.php --testdox >> reports/detailed_report.txt

echo Running Administrative Management Tests...
php artisan test tests/Feature/AdministrativeManagementTest.php --testdox >> reports/detailed_report.txt

echo Running Calamity Management Tests...
php artisan test tests/Feature/CalamityManagementTest.php --testdox >> reports/detailed_report.txt

echo Running Incident Report Tests...
php artisan test tests/Feature/IncidentReportTest.php --testdox >> reports/detailed_report.txt


echo Running Integration Tests...
php artisan test tests/Feature/IntegrationTest.php --testdox >> reports/detailed_report.txt

echo Running Simple Tests...
php artisan test tests/Feature/SimpleTest.php --testdox >> reports/detailed_report.txt

echo.
echo ========================================
echo TEST REPORTS GENERATED
echo ========================================
echo Reports saved in:
echo - reports/all_tests_report.txt (Tổng hợp)
echo - reports/detailed_report.txt (Chi tiết từng file)
echo.
echo ========================================
echo TEST SUMMARY
echo ========================================
php artisan test --testdox

echo.
echo ========================================
echo ALL TESTS COMPLETED
echo ========================================
pause 