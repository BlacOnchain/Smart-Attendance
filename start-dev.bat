@echo off
echo Starting Laravel server...
start "Laravel Server" cmd /k "php artisan serve --host=127.0.0.1 --port=8000"

timeout /t 2 /nobreak >nul

echo Starting ngrok tunnel...
start "Ngrok Tunnel" cmd /k "ngrok http --domain=eternal-dominion-backboard.ngrok-free.dev 8000"

echo.
echo Both are starting in separate windows.
echo DO NOT CLOSE either window while testing on your phone.
echo Your app is at: https://eternal-dominion-backboard.ngrok-free.dev
pause