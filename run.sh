#!/bin/sh

# Run the fresh migration to clear duplicate data
php artisan migrate:fresh --seed --force

# Start your web server (using Nginx/PHP-FPM based on your visible log steps)
php-fpm & nginx -g "daemon off;"
