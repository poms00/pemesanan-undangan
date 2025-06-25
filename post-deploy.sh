#!/bin/bash

echo "🔧 Post deploy tasks..."

npm install
npm run build

php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
