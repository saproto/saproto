# -----------------------------
# Step 1: Setup PHP environment
# -----------------------------
FROM php:8.4-fpm-alpine as phpenv

WORKDIR /var/www/html

# -----------------------------
# Step 2: Install PHP extensions
# -----------------------------

# System deps for PHP extensions
RUN apk add \
    nginx \
    bash \
    curl \
    git \
    zip \
    unzip \
    linux-headers \
    oniguruma-dev \
    libxml2-dev \
    curl-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev

# PHP extensions (match your platform reqs)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j"$(nproc)" \
    pdo \
    pdo_mysql \
    mbstring \
    gd \
    exif \
    sockets \
    calendar \
    xml \
    dom \
    simplexml \
    xmlreader \
    xmlwriter \
    opcache

COPY staging/nginx.conf /etc/nginx/http.d/default.conf

# -----------------------------
# Step 3: Composer install
# -----------------------------
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer
COPY . .
RUN git config --global --add safe.directory /var/www/html
RUN composer install --no-dev 
RUN php artisan key:generate
RUN php artisan wayfinder:generate --with-form

# -----------------------------
# Step 4: Build frontend assets
# -----------------------------
FROM node:22-alpine AS node-build

WORKDIR /app

# Create a stub php binary that does nothing, to skip php calls during npm install
RUN echo -e '#!/bin/sh\necho "php stub: skipped"\nexit 0' > /usr/local/bin/php \
 && chmod +x /usr/local/bin/php

COPY --from=phpenv /var/www/html /app
RUN npm ci

RUN npm run build

RUN rm -rf node_modules

# -----------------------------
# Step 5: Cleanup and final image
# -----------------------------
FROM phpenv as final

COPY --from=node-build /app .
RUN php artisan storage:link
RUN chown -R www-data:www-data .

EXPOSE 80

CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]