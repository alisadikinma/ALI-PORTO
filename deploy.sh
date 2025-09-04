#!/bin/bash

echo "🚀 Starting Portfolio Deployment..."

# Navigate to project directory
cd /var/www/portfolio

echo "📦 Pulling latest changes from Git..."
git stash
git pull origin main

echo "🔧 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

echo "📱 Installing NPM dependencies..."
npm ci --production=false

echo "🏗️ Building frontend assets..."
npm run build

echo "🗃️ Running database migrations..."
php artisan migrate --force

echo "🧹 Clearing all caches..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "🔐 Setting proper permissions..."
sudo chown -R www-data:www-data .
sudo chmod -R 755 .
sudo chmod -R 775 storage bootstrap/cache public/storage

echo "🔄 Restarting services..."
sudo systemctl reload php8.1-fpm
sudo systemctl reload nginx

echo "✅ Deployment completed successfully!"
echo "🌐 Your portfolio is live at: https://alisadikinma.com"
echo "👤 Profile page: https://alisadikinma.com/user/profile"

# Test the endpoints
echo ""
echo "🧪 Testing endpoints..."
echo "Main site:"
curl -I https://alisadikinma.com/ 2>/dev/null | head -n 1

echo "Profile page (redirects to login if not authenticated):"
curl -I https://alisadikinma.com/user/profile 2>/dev/null | head -n 1

echo ""
echo "🎉 Deployment finished! Please test the profile page after logging in."
