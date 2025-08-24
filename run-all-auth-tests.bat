@echo off
echo Running All Authentication Tests...
echo ==================================
echo.

echo 1. Running Authentication Tests...
php artisan test tests/Feature/AuthenticationTest.php
echo.

echo 2. Running Email Verification Tests...
php artisan test tests/Feature/EmailVerificationTest.php
echo.

echo 3. Running Quick Login Tests...
php artisan test tests/Feature/QuickLoginTest.php
echo.

echo 4. Running Database Tests...
php artisan test tests/Feature/DatabaseTest.php
echo.

echo 5. Running Validation Tests...
php artisan test tests/Unit/AuthValidationTest.php
echo.

echo ==================================
echo All authentication tests completed!
echo.
pause
