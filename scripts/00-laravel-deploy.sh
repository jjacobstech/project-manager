#!/usr/bin/env bash

echo "Running npm installations..."
npm install

echo "Running npm asset bundling.."
npm run build

echo "Running composer"
composer install --no-dev --working-dir=/var/www/html

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force

echo "Optimizing Build..."
php artisan optimize
