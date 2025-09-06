@echo off
echo Checking Award Table Data...
cd /d "C:\xampp\htdocs\ALI-PORTO"

echo.
echo 🔍 DEBUGGING AWARD TABLE:
echo.

echo Creating debug route to check award data...
echo.

echo To check if awards exist in database:
echo 1. Open browser: localhost/ALI-PORTO/public
echo 2. Add this to routes/web.php temporarily:
echo.
echo Route::get('/debug-awards', function() {
echo     $awards = DB::table('award')-^>get();
echo     dd([
echo         'count' =^> $awards-^>count(),
echo         'data' =^> $awards
echo     ]);
echo });
echo.
echo 3. Visit: localhost/ALI-PORTO/public/debug-awards
echo.

echo 📊 OR check via phpMyAdmin:
echo 1. Open: localhost/phpmyadmin
echo 2. Database: portfolio_db
echo 3. Table: award
echo 4. Browse tab to see all records
echo.

echo ❓ POSSIBLE ISSUES:
echo • No records in award table
echo • Database connection issues
echo • Cache not clearing properly
echo • Table structure missing
echo.

echo 🔧 SOLUTIONS:
echo • Add test awards via CMS: localhost/ALI-PORTO/public/award
echo • Check database connection in .env
echo • Verify table exists in phpMyAdmin
echo.

pause
