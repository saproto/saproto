FROM serversideup/php:8.5-fpm-nginx AS vendor

USER root
RUN install-php-extensions gd exif calendar
USER www-data

COPY --chown=www-data:www-data composer.json composer.lock ./
RUN composer install \
    --no-interaction \
    --no-dev \
    --no-autoloader \
    --no-scripts \
    --prefer-dist

FROM serversideup/php:8.5-fpm-nginx AS assets
USER root
RUN install-php-extensions gd exif calendar sockets

COPY --from=node:26-slim /usr/local/bin /usr/local/bin
COPY --from=node:26-slim /usr/local/lib/node_modules /usr/local/lib/node_modules

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci --ignore-scripts

COPY . .

COPY --from=vendor /var/www/html/vendor ./vendor
RUN composer dump-autoload --no-interaction

RUN php artisan wayfinder:generate --with-form
RUN npm run build

FROM serversideup/php:8.5-fpm-nginx

USER root
RUN install-php-extensions gd exif calendar bcmath
USER www-data

ENV PHP_OPCACHE_ENABLE=1

COPY --chown=www-data:www-data . .
COPY --chown=www-data:www-data --from=vendor /var/www/html/vendor ./vendor
COPY --chown=www-data:www-data --from=assets /app/public/build ./public/build
RUN composer dump-autoload --no-dev --optimize --classmap-authoritative
