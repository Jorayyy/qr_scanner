FROM composer:2.8 as composer
FROM php:8.4-fpm-alpine

# 1. Install system development libraries for QR codes, SQLite, and System Fonts
RUN apk add --no-cache \
    nginx \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    sqlite-dev \
    zip \
    unzip \
    git \
    ttf-dejavu \
    fontconfig \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql pdo_sqlite gd

# 2. Securely copy the official Composer binary engine
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html
COPY . .

# 3. Inject our custom Nginx port configuration mapping file
RUN mkdir -p /run/nginx \
    && cp nginx.conf /etc/nginx/http.d/default.conf

# 4. THE SYSTEM USER ALIGNMENT FIX: Force Nginx to run as www-data globally
RUN sed -i 's/user nginx;/user www-data;/g' /etc/nginx/nginx.conf || true

# 5. Run standard installation and prepare database directory structure explicitly
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-interaction --optimize-autoloader \
    && mkdir -p database storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs \
    && rm -f database/database.sqlite \
    && touch database/database.sqlite

# 6. Fix permissions so www-data owns absolutely everything cleanly
RUN chown -R www-data:www-data /var/www/html /run/nginx /var/lib/nginx /var/log/nginx \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database \
    && chmod 664 /var/www/html/database/database.sqlite

# 7. Expose custom container network line
EXPOSE 8080

# 8. THE SEQUENCE FIX: Migrate the database FIRST to create the cache tables before flushing them
CMD php artisan migrate --force && \
    php artisan config:clear && \
    php artisan cache:clear && \
    php-fpm -D && \
    nginx -g "daemon off;"
