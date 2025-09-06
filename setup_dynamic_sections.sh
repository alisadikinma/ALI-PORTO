#!/bin/bash

# Script untuk menjalankan migration dan setup
echo "🚀 Starting setup for dynamic About Section..."

# Menjalankan migration
echo "📦 Running migration..."
php artisan migrate

# Clear cache
echo "🧹 Clearing cache..."
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Set permissions untuk folder images/about
echo "🔐 Setting permissions..."
chmod 755 public/images/about

echo "✅ Setup complete!"
echo ""
echo "📋 What's new:"
echo "1. Added dynamic About Section fields to CMS"
echo "2. Added dynamic Award Section titles"
echo "3. Added image upload for About Section"
echo "4. Updated homepage to use dynamic content"
echo ""
echo "🎯 Next steps:"
echo "1. Access CMS: /setting"
echo "2. Fill in the new About Section fields"
echo "3. Upload an image for About Section"
echo "4. Check homepage to see changes"
