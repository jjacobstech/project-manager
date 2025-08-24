# Multi-stage build optimized for Render
FROM node:22-alpine AS asset-builder

WORKDIR /app

# Copy package files first for better Docker layer caching
COPY package*.json ./

# Install ALL dependencies (including dev dependencies for build)
RUN npm ci

# Copy source code
COPY . .

# Build assets
RUN npm run build

# Production stage
FROM ubuntu:24.04

WORKDIR /var/www/html

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=UTC

# Set timezone
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Install system dependencies
RUN apt-get update && apt-get upgrade -y \
      && mkdir -p /etc/apt/keyrings \
      && apt-get install -y \
      gnupg \
      curl \
      ca-certificates \
      nginx \
      supervisor \
      unzip \
      libpng16-16 \
      libzip4 \
      libxml2 \
      libpq5 \
      libonig5 \
      && curl -sS 'https://keyserver.ubuntu.com/pks/lookup?op=get&search=0xb8dc7e53946656efbce4c1dd71daeaab4ad4cab6' | gpg --dearmor | tee /etc/apt/keyrings/ppa_ondrej_php.gpg > /dev/null \
      && echo "deb [signed-by=/etc/apt/keyrings/ppa_ondrej_php.gpg] https://ppa.launchpadcontent.net/ondrej/php/ubuntu noble main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
      && apt-get update \
      && apt-get install -y \
      php8.4-fpm \
      php8.4-cli \
      php8.4-pgsql \
      php8.4-mysql \
      php8.4-gd \
      php8.4-curl \
      php8.4-mbstring \
      php8.4-xml \
      php8.4-zip \
      php8.4-bcmath \
      php8.4-intl \
      php8.4-opcache \
      && curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \
      && apt-get clean \
      && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Create www-data user if it doesn't exist and set proper home directory
RUN if ! id -u www-data >/dev/null 2>&1; then \
      useradd -r -s /bin/false -d /var/www www-data; \
      fi

# Create necessary directories first
RUN mkdir -p /var/www/html/storage/logs \
      && mkdir -p /var/www/html/storage/framework/{cache,sessions,views} \
      && mkdir -p /var/www/html/bootstrap/cache \
      && mkdir -p /var/www/html/public/build

# Copy composer files first for better layer caching
COPY --chown=www-data:www-data composer.json composer.lock ./

# Install PHP dependencies before copying source code
RUN composer install --no-dev --no-scripts --no-autoloader --optimize-autoloader --no-interaction --no-progress --prefer-dist

# Copy application source code
COPY --chown=www-data:www-data . .

# Copy built assets from builder stage (only if build directory exists)
COPY --from=asset-builder --chown=www-data:www-data /app/public/build ./public/build

# Finalize composer installation with autoloader
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
      && chmod -R 755 /var/www/html \
      && chmod -R 775 /var/www/html/storage \
      && chmod -R 775 /var/www/html/bootstrap/cache

# Copy configuration files
COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/php.ini /etc/php/8.4/fpm/conf.d/99-laravel.ini
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/start-container.sh /usr/local/bin/start-container

# Configure nginx
RUN rm -f /etc/nginx/sites-enabled/default \
      && ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/ \
      && chmod +x /usr/local/bin/start-container \
      && nginx -t

# Expose port 8000 as default (Render will override with PORT env var)
EXPOSE 8000

# Health check for Render (use port 8000 as fallback)
HEALTHCHECK --interval=30s --timeout=10s --start-period=60s --retries=3 \
      CMD curl -f http://localhost:${PORT:-8000}/health || exit 1

ENTRYPOINT ["/usr/local/bin/start-container"]
