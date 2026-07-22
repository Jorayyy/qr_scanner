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
    curl \
    $PHPIZE_DEPS && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo_mysql pdo_sqlite gd

# Force cache invalidation to download the binary installer smoothly
ADD "https://getcomposer.org" /tmp/composer-setup.php
RUN php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer && rm /tmp/composer-setup.php

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