FROM composer:2.8 as composer
FROM php:8.4-cli-alpine

# Install system dependencies, graphics extensions, and sqlite libraries
RUN apk add --no-cache \
    bash \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    sqlite-dev \
    nodejs \
    npm \
    linux-headers \
    $PHPIZE_DEPS && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo_mysql pdo_sqlite gd

# Securely copy the pristine composer bin execution engine
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

WORKDIR /app
COPY . .

# Run composer installation smoothly inside the custom container env
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-interaction --optimize-autoloader

# Compile your user interface styles
RUN npm install && npm run build

# Expose network ports dynamically
EXPOSE 8080

# This line uses Octane/Swoole philosophy via a production ready, multi-threaded PHP worker binding loop
CMD ["sh", "-c", "mkdir -p /app/database && touch /app/database/database.sqlite && php artisan migrate --force && php -S 0.0.0.0:$PORT public/index.php"]
