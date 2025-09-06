@echo off
echo Balancing About Section Image Height...
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
echo ✅ About Section Height Balance Applied!
echo.
echo 📐 HEIGHT BALANCE IMPROVEMENTS:
echo.
echo 🎯 LEFT CONTENT (flex-1):
echo    • Dynamic height based on content
echo    • Title + subtitle + description + awards
echo    • Natural content flow
echo.
echo 🖼️ RIGHT IMAGE (flex-1):
echo    • Matches left content height automatically
echo    • min-height: 450px (mobile), 550px (desktop)
echo    • Full height utilization with flex items-stretch
echo.
echo 📱 RESPONSIVE DESIGN:
echo    Mobile:  min-height: 450px
echo    Desktop: min-height: 550px
echo    Auto:    Adjusts to content height
echo.
echo 🎨 IMAGE STYLING:
echo    ✅ object-cover for full coverage
echo    ✅ rounded-xl for modern look
echo    ✅ Perfect aspect ratio maintenance
echo    ✅ No distortion or stretching
echo.
echo 🔄 FALLBACK IMPROVEMENTS:
echo    Award Grid: aspect-square cards, centered placement
echo    Logo:       max-height constraint, centered
echo    Grid:       place-content-center for perfect alignment
echo.
echo ⚖️ BALANCE FEATURES:
echo    • Both sides use flex-1 (equal width)
echo    • Image container matches content height
echo    • Responsive min-heights for different screens
echo    • Proper spacing and padding throughout
echo.
echo 🚀 Result: Perfect visual balance between content and image!
echo.
pause
