@echo off
echo Running Email Verification Tests...
echo ================================
echo.

REM Run email verification tests
php artisan test tests/Feature/EmailVerificationTest.php

echo.
echo ================================
echo Email verification tests completed!
pause
