FROM composer:2.8 as composer
FROM php:8.4-apache

# 1. Install system development libraries for QR codes and SQLite
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libsqlite3-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql pdo_sqlite gd \
    && a2enmod rewrite

# 2. Securely copy the official Composer binary engine
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html
COPY . .

# 3. Clean up default Apache configs and inject our custom port mapping configuration
RUN rm -f /etc/apache2/sites-enabled/* /etc/apache2/ports.conf \
    && cp apache.conf /etc/apache2/sites-available/laravel.conf \
    && a2ensite laravel.conf

# 4. THE ABSOLUTE MPM FIX: Hard-comment out any alternative module loads in the root config files
RUN sed -i 's/^LoadModule mpm_event_module/# LoadModule mpm_event_module/' /etc/apache2/mods-available/mpm_event.load || true \
    && sed -i 's/^LoadModule mpm_worker_module/# LoadModule mpm_worker_module/' /etc/apache2/mods-available/mpm_worker.load || true \
    && a2dismod mpm_event mpm_worker || true \
    && a2enmod mpm_prefork || true

# 5. Run standard installation and prepare database directory structure
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-interaction --optimize-autoloader \
    && mkdir -p database storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs \
    && touch database/database.sqlite

# 6. Fix permissions completely so the webserver owns everything
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# 7. Expose dynamic web traffic lines
EXPOSE 80

# 8. Run migrations on boot and start Apache cleanly
CMD php artisan config:clear && php artisan cache:clear && php artisan migrate --force && apache2-foreground
