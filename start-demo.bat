@echo off

docker-compose down
docker-compose up -d --build

if %ERRORLEVEL% EQU 0 (
    echo.
    echo   Vulnerable Bank: http://localhost:8080/login.php
    echo   Protected Bank:  http://localhost:8081/login.php
    echo   Attack Demo:     http://localhost:8082/index.html
    echo.
    echo   Login: user / password
    echo.
    timeout /t 2 >nul
    start http://localhost:8080/login.php
    start http://localhost:8081/login.php
    start http://localhost:8082/index.html
    echo.
    echo Container is running in background.
    echo Run 'docker-compose down' to stop.
) else (
    echo.
    echo ERROR: Failed to start containers.
    echo Please check Docker logs for details.
)

echo.
pause
