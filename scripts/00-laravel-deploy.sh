#!/usr/bin/env bash
# Ensure Composer 2 is used
echo "Running composer"
# composer global require hirak/prestissimo
composer install --working-dir=/var/www/html

echo "generating application key..."
php artisan key:generate --show

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force

echo "Running seeders..."
php artisan db:seed --force

echo "Linking storage..."
php artisan storage:link

# echo "Running queue..."
# php artisan queue:work --daemon --sleep=3 --tries=3
