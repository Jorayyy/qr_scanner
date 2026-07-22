FROM composer:2.8 as composer
FROM php:8.4-fpm-alpine

# Install system dependencies, graphics extensions, sqlite libraries, and node compiler
RUN apk add --no-cache \
    nginx \
    supervisor \
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

# Securely copy the pristine composer bin execution engine from stage 1
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

WORKDIR /app
COPY . .

# Run composer installation smoothly inside the custom container env
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-interaction --optimize-autoloader

# Compile your user interface styles
RUN npm install && npm run build

# Expose network ports
EXPOSE 8080
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8080"]