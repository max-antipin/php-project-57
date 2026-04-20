FROM composer:2.9 AS composer_image

FROM php:8.4-cli AS base
RUN set -eu; \
    apt-get update && apt-get install -y --no-install-recommends libzip-dev libpq-dev unzip; \
    docker-php-ext-install zip pcntl pdo pdo_pgsql; \
    rm -rf /var/lib/apt/lists/*
ENV PORT=8000
WORKDIR /app

FROM base AS dev
COPY --from=composer_image --link /usr/bin/composer /usr/local/bin/composer
RUN set -eu; \
    curl -sL https://deb.nodesource.com/setup_24.x | bash -; \
    apt-get install -y nodejs

FROM base AS pre_prod
ENV APP_ENV=production
ENV APP_DEBUG=false
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY --link composer.* ./
RUN --mount=type=bind,from=composer_image,source=/usr/bin/composer,target=/usr/local/bin/composer \
    set -eu; \
    composer install --no-dev --no-autoloader --no-progress --no-scripts --classmap-authoritative
COPY --link --exclude=composer.* --exclude=vite.config.js --exclude=package*.json . .
RUN --mount=type=bind,from=composer_image,source=/usr/bin/composer,target=/usr/local/bin/composer \
    set -eu; \
    composer dump-autoload --no-dev --classmap-authoritative --strict-psr --strict-ambiguous; \
    php artisan view:cache

FROM node:24-alpine AS frontend_prod
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY vite.config.js ./
COPY resources/ ./resources/
RUN --mount=type=bind,from=pre_prod,source=/app/storage/framework/,target=/app/storage/framework/ \
    --mount=type=bind,from=pre_prod,source=/app/vendor/laravel/framework/src/,target=/app/vendor/laravel/framework/src/ \
    npm run build

FROM pre_prod AS prod
COPY --from=frontend_prod --link /app/public/build/ /app/public/build/
CMD ["bash", "-c", "php artisan migrate:refresh --force && php artisan serve --host=0.0.0.0 --port=$PORT"]
