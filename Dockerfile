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

# Configure apt for better performance
RUN echo "Acquire::http::Pipeline-Depth 0;" > /etc/apt/apt.conf.d/99custom && \
      echo "Acquire::http::No-Cache true;" >> /etc/apt/apt.conf.d/99custom && \
      echo "Acquire::BrokenProxy true;" >> /etc/apt/apt.conf.d/99custom

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
      php8.4-redis \
      php8.4-memcached \
      && curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \
      && apt-get clean \
      && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Remove default ubuntu user for security (if it exists)
RUN userdel -r ubuntu 2>/dev/null || true

# Ensure www-data user exists with proper configuration
RUN usermod -d /var/www www-data 2>/dev/null || true

# Create necessary directories with proper ownership
RUN mkdir -p /var/www/html/storage/logs \
      && mkdir -p /var/www/html/storage/framework/{cache,sessions,views} \
      && mkdir -p /var/www/html/bootstrap/cache \
      && mkdir -p /var/www/html/public/build \
      && chown -R www-data:www-data /var/www/html

# Copy composer files first for better layer caching
COPY --chown=www-data:www-data composer.json composer.lock ./

# Install PHP dependencies before copying source code
RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction --no-progress --prefer-dist

# Copy application source code
COPY --chown=www-data:www-data . .

# Copy built assets from builder stage
COPY --from=asset-builder --chown=www-data:www-data /app/public/build ./public/build

# Finalize composer installation with optimized autoloader
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
      && chmod -R 755 /var/www/html \
      && chmod -R 775 /var/www/html/storage \
      && chmod -R 775 /var/www/html/bootstrap/cache

# Create configuration files inline
RUN cat > /etc/nginx/sites-available/default << 'EOF'
server {
listen 8000;
server_name _;
root /var/www/html/public;
index index.php index.html;

client_max_body_size 100M;
client_body_timeout 120s;

# Handle health checks
location /health {
access_log off;
return 200 "healthy\n";
add_header Content-Type text/plain;
}

location / {
try_files $uri $uri/ /index.php?$query_string;
}

location ~ \.php$ {
fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
fastcgi_index index.php;
fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
fastcgi_read_timeout 120s;
include fastcgi_params;
}

location ~ /\.ht {
deny all;
}

# Static assets caching
location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$ {
expires 1y;
add_header Cache-Control "public, immutable";
add_header Vary Accept-Encoding;
access_log off;
}
}
EOF

# Create PHP configuration
RUN cat > /etc/php/8.4/fpm/conf.d/99-laravel.ini << 'EOF'
; Laravel optimized PHP configuration
memory_limit = 512M
upload_max_filesize = 100M
post_max_size = 100M
max_execution_time = 120
max_input_time = 120
max_input_vars = 3000

; OPcache settings for production
opcache.enable = 1
opcache.memory_consumption = 256
opcache.interned_strings_buffer = 16
opcache.max_accelerated_files = 10000
opcache.revalidate_freq = 0
opcache.validate_timestamps = 0

; Error handling
display_errors = Off
log_errors = On
error_log = /var/log/php_errors.log

; Session configuration
session.cookie_secure = 1
session.cookie_httponly = 1
EOF

# Create Supervisor configuration
RUN cat > /etc/supervisor/conf.d/supervisord.conf << 'EOF'
[supervisord]
nodaemon=true
user=root
loglevel=info
pidfile=/var/run/supervisord.pid

[unix_http_server]
file=/var/run/supervisor.sock

[supervisorctl]
serverurl=unix:///var/run/supervisor.sock

[rpcinterface:supervisor]
supervisor.rpcinterface_factory = supervisor.rpcinterface:make_main_rpcinterface

[program:nginx]
command=/usr/sbin/nginx -g "daemon off;"
autostart=true
autorestart=true
stdout_logfile=/dev/stdout
stdout_logfile_maxbytes=0
stderr_logfile=/dev/stderr
stderr_logfile_maxbytes=0
user=root

[program:php-fpm]
command=/usr/sbin/php-fpm8.4 -F
autostart=true
autorestart=true
stdout_logfile=/dev/stdout
stdout_logfile_maxbytes=0
stderr_logfile=/dev/stderr
stderr_logfile_maxbytes=0
user=root
EOF

# Create start container script
RUN cat > /usr/local/bin/start-container << 'EOF'
#!/usr/bin/env bash

set -e

# Set PORT environment variable (Render provides this)
export PORT=${PORT:-8000}

echo "Starting Laravel application on port $PORT..."

# Update nginx configuration to use the PORT from environment
sed -i "s/listen 8000;/listen $PORT;/" /etc/nginx/sites-available/default

# Ensure directories exist with proper permissions
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/storage/framework/{cache,sessions,views}
mkdir -p /var/www/html/bootstrap/cache

# Set permissions
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage
chmod -R 775 /var/www/html/bootstrap/cache

# Wait for database connection (optional, don't fail if DB not ready)
echo "Checking database connection..."
php artisan tinker --execute="try { DB::connection()->getPdo(); echo 'Database connected'; } catch(Exception \$e) { echo 'Database not ready: ' . \$e->getMessage(); }" 2>/dev/null || echo "Database check failed, continuing..."

# Laravel optimizations
echo "Optimizing Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Only run migrations if we can connect to database and migrations table doesn't exist
if php artisan migrate:status 2>/dev/null | grep -q "Migration table not found"; then
echo "Running initial migrations..."
php artisan migrate --force
else
echo "Migration table exists, skipping auto-migration"
fi

# Start supervisor
echo "Starting services..."
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
EOF

# Configure nginx and make start script executable
RUN rm -f /etc/nginx/sites-enabled/default \
      && ln -s /etc/nginx/sites-available/default /etc/nginx/sites-enabled/ \
      && chmod +x /usr/local/bin/start-container \
      && nginx -t

# Expose port 8000 as default (Render will override with PORT env var)
EXPOSE 8000

# Health check for Render
HEALTHCHECK --interval=30s --timeout=10s --start-period=60s --retries=3 \
      CMD curl -f http://localhost:${PORT:-8000}/health || exit 1

ENTRYPOINT ["/usr/local/bin/start-container"]
