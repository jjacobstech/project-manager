# Build Stage
FROM composer:2 as build

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

COPY . .

# Production Stage
FROM php:8.3-fpm-alpine

WORKDIR /var/www/html

# Install necessary PHP extensions and system dependencies
RUN apk add --no-cache \
    nginx \
    mysql-client \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    icu-dev \
    oniguruma-dev \
    && docker-php-ext-install pdo_mysql zip gd intl mbstring exif pcntl bcmath opcache

# Copy application files from build stage
COPY --from=build /app .

# Set permissions for Laravel storage and cache directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Copy Nginx configuration (if using Nginx)
# COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

EXPOSE 80

CMD ["php-fpm"]
