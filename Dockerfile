FROM php:8.3-cli-alpine AS composer-stage

COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

ARG APP_ENV=production

WORKDIR /app

COPY composer.json composer.lock ./

RUN if [ "$APP_ENV" = "production" ]; then \
        composer install --no-dev --no-scripts --no-autoloader --prefer-dist; \
    else \
        composer install --no-scripts --no-autoloader --prefer-dist; \
    fi
COPY . .
RUN if [ "$APP_ENV" = "production" ]; then \
        composer dump-autoload --optimize --no-dev; \
    else \
        composer dump-autoload --optimize; \
    fi


FROM node:20-alpine AS node-stage

WORKDIR /app

RUN apk add --no-cache python3 make g++

COPY package*.json ./

RUN npm ci

COPY . .

RUN npm run build


FROM php:8.3-fpm-alpine

LABEL maintainer="Daya Company Profile"
LABEL version="1.0"
LABEL description="Daya Company Profile Laravel Application"

RUN apk add --no-cache \
    nginx \
    supervisor \
    tzdata \
    curl \
    ca-certificates \
    postgresql-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    freetype-dev \
    libzip-dev \
    oniguruma-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) \
    pdo_pgsql \
    pgsql \
    gd \
    zip \
    mbstring \
    opcache \
    pcntl \
    && rm -rf /var/cache/apk/*

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps

# Set timezone to Asia/Jakarta
ENV TZ=Asia/Jakarta
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Create non-root user and group
RUN addgroup -S appgroup && adduser -S appuser -G appgroup

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY --chown=appuser:appgroup . .
COPY --from=composer-stage --chown=appuser:appgroup /app/vendor ./vendor
COPY --from=node-stage --chown=appuser:appgroup /app/public/build ./public/build

# Configure PHP-FPM
RUN echo "upload_max_filesize = 100M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size = 100M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit = 512M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "max_execution_time = 300" >> /usr/local/etc/php/conf.d/uploads.ini

# Configure OPcache for production
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=256" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.interned_strings_buffer=16" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_accelerated_files=10000" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.validate_timestamps=0" >> /usr/local/etc/php/conf.d/opcache.ini

# Configure PHP-FPM to run as appuser
RUN sed -i 's/user = www-data/user = appuser/g' /usr/local/etc/php-fpm.d/www.conf \
    && sed -i 's/group = www-data/group = appgroup/g' /usr/local/etc/php-fpm.d/www.conf

# Configure Nginx
COPY ./.docker/nginx.conf /etc/nginx/nginx.conf
COPY ./.docker/default.conf /etc/nginx/http.d/default.conf

# Configure Supervisor
COPY ./.docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Set proper permissions
RUN chown -R appuser:appgroup /var/www/html \
    && mkdir -p /var/www/html/storage/logs \
    && mkdir -p /var/www/html/storage/framework/{cache,sessions,views} \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache \
    && mkdir -p /var/log/supervisor \
    && chown -R appuser:appgroup /var/log/supervisor \
    && mkdir -p /run/nginx \
    && chown -R appuser:appgroup /run/nginx \
    && chown -R appuser:appgroup /var/lib/nginx \
    && chown -R appuser:appgroup /var/log/nginx

# Clear bootstrap cache
RUN rm -f /var/www/html/bootstrap/cache/packages.php && \
    rm -f /var/www/html/bootstrap/cache/services.php

# Expose port 8080 (nginx)
EXPOSE 8080

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD curl -f http://localhost:8080/health || exit 1

# Run supervisor to manage nginx and php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
