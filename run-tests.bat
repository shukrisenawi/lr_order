@echo off
echo Running Laravel Authentication Tests...
echo =====================================

REM Run all tests
echo.
echo Running all tests...
vendor\bin\phpunit

echo.
echo Running only authentication tests...
vendor\bin\phpunit tests\Feature\AuthenticationTest.php

echo.
echo Running unit tests...
vendor\bin\phpunit tests\Unit\AuthValidationTest.php

echo.
echo Running quick login tests...
vendor\bin\phpunit tests\Feature\QuickLoginTest.php

echo.
echo All tests completed!
pause
