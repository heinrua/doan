@echo off
echo ========================================
echo    CHAY SIMPLE TEST - CALAMITY MANAGER
echo ========================================
echo.

echo [1/3] Kiem tra va cai dat dependencies...
composer install --no-interaction

echo.
echo [2/3] Tao database test...
php artisan migrate:fresh --env=testing

echo.
echo [3/3] Chay simple test...
php artisan test tests/Feature/SimpleTest.php

echo.
echo ========================================
echo    HOAN THANH SIMPLE TEST!
echo ========================================
pause 