web: php -S 0.0.0.0:${PORT} -t public
worker: php artisan queue:work --verbose --tries=3 --timeout=90 --sleep=3

