# syntax=docker/dockerfile:1
FROM php:8.5.12-fpm AS base

COPY src/be/php.ini /usr/local/etc/php/conf.d/security.ini

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
    libicu-dev \
    && docker-php-ext-install pdo pdo_mysql mysqli mbstring exif pcntl bcmath gd zip intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html/be

COPY src/be/ /var/www/html/be/

FROM base AS runtime
USER www-data
EXPOSE 9000
HEALTHCHECK --interval=30s --timeout=3s --start-period=10s --retries=3 \
    CMD php -r "copy('http://localhost:9000/health/live', '/dev/null');" || exit 1
CMD ["php-fpm"]

FROM base AS test
RUN cp .env.example .env 2>/dev/null || true
RUN composer install --no-interaction --prefer-dist --optimize-autoloader
RUN php artisan key:generate 2>/dev/null || true
ENTRYPOINT ["/var/www/html/be/vendor/bin/phpunit"]
