#!/bin/bash

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install
npm run build

# Run database migrations
php artisan migrate --force

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Set proper permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache
