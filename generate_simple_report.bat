@echo off
echo ========================================
echo GENERATING SIMPLE TEST REPORT
echo ========================================

REM Tạo thư mục reports nếu chưa có
if not exist "reports" mkdir reports

REM Chạy test và xuất báo cáo HTML
echo Running tests and generating HTML report...
php artisan test --testdox-html=reports/test_report.html

REM Chạy test và xuất báo cáo text
echo Running tests and generating text report...
php artisan test --testdox > reports/test_report.txt

REM Chạy test từng file và xuất báo cáo chi tiết
echo Creating detailed report...
echo TEST REPORT - %date% %time% > reports/detailed_report.txt
echo ======================================== >> reports/detailed_report.txt
echo. >> reports/detailed_report.txt

echo Running Simple Tests... >> reports/detailed_report.txt
php artisan test tests/Feature/SimpleTest.php --testdox >> reports/detailed_report.txt 2>&1
echo. >> reports/detailed_report.txt

echo Running User Management Tests... >> reports/detailed_report.txt
php artisan test tests/Feature/UserManagementTest.php --testdox >> reports/detailed_report.txt 2>&1
echo. >> reports/detailed_report.txt

echo Running Incident Report Tests... >> reports/detailed_report.txt
php artisan test tests/Feature/IncidentReportTest.php --testdox >> reports/detailed_report.txt 2>&1
echo. >> reports/detailed_report.txt

echo Running Integration Tests... >> reports/detailed_report.txt
php artisan test tests/Feature/IntegrationTest.php --testdox >> reports/detailed_report.txt 2>&1
echo. >> reports/detailed_report.txt

echo ========================================
echo Test reports generated in reports/ folder:
echo - test_report.html (HTML report)
echo - test_report.txt (Text report)
echo - detailed_report.txt (Detailed text report)
echo ========================================

echo.
echo Opening reports folder...
start reports

pause 