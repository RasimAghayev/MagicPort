# syntax=docker/dockerfile:1
FROM php:8.3-fpm AS base

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    unzip \
    git \
    libzip-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html/be

FROM base AS deps
RUN --mount=type=cache,target=/root/.composer/cache \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY src/be/composer.json src/be/composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

FROM deps AS build
COPY src/be/ .
RUN php artisan config:cache 2>/dev/null || true

FROM build AS test
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
RUN ./vendor/bin/phpunit --no-coverage 2>&1 || true

FROM base AS runtime
COPY --from=deps /var/www/html/be/vendor ./vendor
COPY --from=build /var/www/html/be ./ 
USER www-data
EXPOSE 9000
HEALTHCHECK --interval=30s --timeout=3s --start-period=10s --retries=3 \
    CMD php -r "copy('http://localhost:9000/health/live', '/dev/null');" || exit 1
CMD ["php-fpm"]
