#!/bin/sh

# 1. Clear application caches safely
php artisan config:clear
php artisan cache:clear

# 2. Run your database migrations safely in the background
php artisan migrate --force &

# 3. Hand over control to Apache as the main foreground process
exec apache2-foreground
