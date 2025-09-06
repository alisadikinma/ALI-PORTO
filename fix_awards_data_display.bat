@echo off
echo Fixing Awards & Recognition Data Display...
cd /d "C:\xampp\htdocs\ALI-PORTO"

echo [1/6] Clearing application cache...
php artisan cache:clear

echo [2/6] Clearing configuration cache...
php artisan config:clear

echo [3/6] Clearing view cache...
php artisan view:clear

echo [4/6] Clearing route cache...
php artisan route:clear

echo [5/6] Clearing compiled views...
php artisan view:cache

echo [6/6] Optimizing configuration...
php artisan config:cache

echo.
echo ✅ Awards Data Query Fixed!
echo.
echo 🔧 ISSUE RESOLVED:
echo    ❌ Previous: Overly restrictive filtering excluded all awards
echo    ✅ Current: Displays all awards from tabel award
echo.
echo 📊 DATA SOURCE:
echo    🗃️ Table: award
echo    📋 Fields: nama_award, gambar_award, keterangan_award
echo    🔄 Order: created_at DESC (newest first)
echo    🚫 Filter: REMOVED (was blocking all data)
echo.
echo 🎯 WHAT SHOULD HAPPEN NOW:
echo    • Awards section shows actual data from database
echo    • No more "No Awards Yet" message (if data exists)
echo    • All awards display with proper styling
echo    • Dynamic color coding still works
echo.
echo 🔍 TO CHECK DATABASE CONTENT:
echo    1. Open phpMyAdmin
echo    2. Go to portfolio_db database
echo    3. Check 'award' table
echo    4. Verify records exist
echo.
echo 💾 CACHE CLEARED:
echo    • Application cache
echo    • View cache  
echo    • Route cache
echo    • Configuration cache
echo.
echo 🚀 Refresh your website to see awards data!
echo    URL: localhost/ALI-PORTO/public
echo.
pause
