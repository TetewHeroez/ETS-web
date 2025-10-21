@echo off
echo =======================================
echo    ETS Web - Setup Development
echo =======================================
echo.

echo [1/4] Installing NPM dependencies...
call npm install
if errorlevel 1 (
    echo Error: Failed to install NPM dependencies
    pause
    exit /b 1
)

echo.
echo [2/4] Running database migrations...
call php artisan migrate --force
if errorlevel 1 (
    echo Error: Failed to run migrations
    pause
    exit /b 1
)

echo.
echo [3/4] Running database seeders...
call php artisan db:seed --force
if errorlevel 1 (
    echo Error: Failed to run seeders
    pause
    exit /b 1
)

echo.
echo [4/4] Building assets...
call npm run build
if errorlevel 1 (
    echo Error: Failed to build assets
    pause
    exit /b 1
)

echo.
echo =======================================
echo     Setup completed successfully!
echo =======================================
echo.
echo Default login credentials:
echo Email: admin@ets.com
echo Password: password123
echo.
echo or
echo.
echo Email: test@example.com  
echo Password: password
echo.
echo To start development server:
echo - Run: php artisan serve
echo - Open: http://localhost:8000
echo.
pause