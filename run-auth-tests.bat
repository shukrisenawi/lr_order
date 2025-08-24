@echo off
echo Running Authentication Tests...
echo.

echo Running Feature Tests...
php artisan test tests/Feature/AuthenticationTest.php

echo.
echo Running Unit Tests...
php artisan test tests/Unit/AuthValidationTest.php

echo.
echo Running Quick Login Tests...
php artisan test tests/Feature/QuickLoginTest.php

echo.
echo Running Database Tests...
php artisan test tests/Feature/DatabaseTest.php

echo.
echo All authentication tests completed!
pause
