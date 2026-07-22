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

# 4. Run standard installation and prepare database directory structure
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-interaction --optimize-autoloader \
    && mkdir -p database storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs \
    && touch database/database.sqlite

# 5. Fix permissions completely so the webserver owns everything before running tasks
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# 6. Expose dynamic web traffic lines
EXPOSE 80

# 7. Start Apache as the absolute master process first, bypassing console exit locks entirely
CMD ["apache2-foreground"]
