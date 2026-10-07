FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-progress --ignore-platform-reqs

FROM node:22-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json* ./
RUN npm ci
COPY . .
RUN npm run build

FROM php:8.4-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
        git curl zip unzip mariadb-client-compat \
        libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql mbstring zip exif pcntl bcmath gd calendar \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN { \
        echo 'opcache.enable=1'; \
        echo 'opcache.memory_consumption=256'; \
        echo 'opcache.max_accelerated_files=20000'; \
        echo 'opcache.validate_timestamps=0'; \
        echo 'display_errors=Off'; \
        echo 'log_errors=On'; \
    } > /usr/local/etc/php/conf.d/production.ini

RUN echo '[client]\nskip-ssl = true' > /etc/my.cnf

WORKDIR /var/www

COPY --chown=www-data:www-data . /var/www
COPY --chown=www-data:www-data --from=vendor /app/vendor /var/www/vendor
COPY --chown=www-data:www-data --from=assets /app/public/build /var/www/public/build

RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]
