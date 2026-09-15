@echo off
echo Starting Laravel server...
start "Laravel Server" cmd /k "php artisan serve --host=127.0.0.1 --port=8000"

echo.
echo The local app is available at: http://127.0.0.1:8000
echo For phone testing, use the Railway deployment URL or configure your own tunnel.
pause
