#!/bin/bash

echo "🚀 Running Dynamic Section Migration..."

# Run the migration
php artisan migrate --path=database/migrations/2024_12_21_000001_add_section_visibility_to_setting_table.php

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

echo "✅ Migration completed successfully!"
echo ""
echo "📋 What's new:"
echo "- Added section visibility controls to settings table"
echo "- All sections are active by default"
echo "- Visit /setting/sections/manage to control section visibility"
echo ""
echo "🎯 Features:"
echo "- About Section: Can be hidden/shown"
echo "- Services Section: Can be hidden/shown"
echo "- Portfolio Section: Can be hidden/shown"
echo "- Testimonials Section: Can be hidden/shown"
echo "- Gallery Section: Can be hidden/shown"
echo "- Articles Section: Can be hidden/shown"
echo "- Awards Section: Can be hidden/shown"
echo "- Contact Section: Can be hidden/shown"
echo ""
echo "📝 How to use:"
echo "1. Go to Dashboard > Settings"
echo "2. Click 'Manage Sections' button"
echo "3. Toggle sections on/off as needed"
echo "4. Save changes"
echo ""
echo "Ready to use! 🎉"
