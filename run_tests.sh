#!/bin/bash

echo "========================================"
echo "    CHAY AUTO TEST - CALAMITY MANAGER"
echo "========================================"
echo

echo "[1/4] Kiem tra va cai dat dependencies..."
composer install --no-interaction

echo
echo "[2/4] Tao database test..."
php artisan migrate:fresh --env=testing

echo
echo "[3/4] Chay tat ca test..."
php artisan test

echo
echo "[4/4] Chay test voi coverage (neu co xdebug)..."
php artisan test --coverage --min=80

echo
echo "========================================"
echo "    HOAN THANH CHAY TEST!"
echo "========================================" 