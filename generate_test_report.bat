@echo off
echo ========================================
echo GENERATING TEST REPORT
echo ========================================

REM Tạo thư mục reports nếu chưa có
if not exist "reports" mkdir reports

REM Chạy test và xuất báo cáo HTML
echo Running tests and generating HTML report...
php artisan test --testdox-html=reports/test_report.html

REM Chạy test và xuất báo cáo XML (cho CI/CD)
echo Running tests and generating XML report...
php artisan test --testdox-xml=reports/test_report.xml

REM Chạy test với coverage report (nếu có PHPUnit coverage)
echo Running tests with coverage report...
php artisan test --coverage-html=reports/coverage

REM Chạy test từng file và xuất báo cáo chi tiết
echo Running individual test files...
echo. > reports/detailed_report.txt
echo TEST REPORT - %date% %time% >> reports/detailed_report.txt
echo ======================================== >> reports/detailed_report.txt

REM Test Authentication
echo Running Authentication Tests... >> reports/detailed_report.txt
php artisan test tests/Feature/BasicTest.php --testdox >> reports/detailed_report.txt 2>&1
echo. >> reports/detailed_report.txt

REM Test Dashboard
echo Running Dashboard Tests... >> reports/detailed_report.txt
php artisan test tests/Feature/DashboardTest.php --testdox >> reports/detailed_report.txt 2>&1
echo. >> reports/detailed_report.txt

REM Test Incident Reports
echo Running Incident Report Tests... >> reports/detailed_report.txt
php artisan test tests/Feature/IncidentReportTest.php --testdox >> reports/detailed_report.txt 2>&1
echo. >> reports/detailed_report.txt

REM Test Integration
echo Running Integration Tests... >> reports/detailed_report.txt
php artisan test tests/Feature/IntegrationTest.php --testdox >> reports/detailed_report.txt 2>&1
echo. >> reports/detailed_report.txt

REM Test Simple
echo Running Simple Tests... >> reports/detailed_report.txt
php artisan test tests/Feature/SimpleTest.php --testdox >> reports/detailed_report.txt 2>&1
echo. >> reports/detailed_report.txt

echo ========================================
echo Test reports generated in reports/ folder:
echo - test_report.html (HTML report)
echo - test_report.xml (XML report for CI/CD)
echo - detailed_report.txt (Detailed text report)
echo - coverage/ (Coverage report)
echo ========================================

pause 