FROM serversideup/php:8.5-fpm-nginx AS vendor
USER root
RUN install-php-extensions gd exif calendar
USER www-data
COPY --chown=www-data:www-data composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-autoloader --no-scripts

FROM serversideup/php:8.5-fpm-nginx AS assets
USER root
RUN install-php-extensions gd exif calendar
USER www-data
COPY --from=node:26-slim /usr/local/bin /usr/local/bin
COPY --from=node:26-slim /usr/local/lib/node_modules /usr/local/lib/node_modules

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci --ignore-scripts
COPY . .
COPY --from=vendor /var/www/html/vendor ./vendor
ARG VITE_APP_NAME
RUN npm run build

FROM serversideup/php:8.5-fpm-nginx

USER root
RUN install-php-extensions gd exif calendar
USER www-data

ENV PHP_OPCACHE_ENABLE=1

COPY --chown=www-data:www-data --from=vendor /var/www/html/vendor ./vendor
COPY --chown=www-data:www-data . .
COPY --chown=www-data:www-data --from=assets /app/public/build ./public/build
RUN composer dump-autoload --no-dev --optimize

#FROM node:26-slim AS frontend-installer
#COPY package*.json ./
#RUN npm ci --ignore-scripts
#
#FROM composer:latest AS backend-installer
#COPY composer.json composer.lock ./
#RUN composer install \
#    --ignore-platform-reqs \
#    --no-scripts
#
#FROM php:8.5-cli AS frontend-builder
#COPY composer.lock ./composer.lock
#
#RUN apt-get update && apt-get install -y --no-install-recommends \
#    zlib1g-dev libpng-dev libzip-dev
#
#RUN docker-php-ext-configure gd \
#    && docker-php-ext-install -j$(nproc) gd exif calendar sockets zip
#
#COPY --from=node:26-slim /usr/local/bin /usr/local/bin
#COPY --from=node:26-slim /usr/local/lib/node_modules /usr/local/lib/node_modules
#
#COPY --from=frontend-installer /node_modules /node_modules
#COPY --from=backend-installer /app/vendor /vendor
#
#WORKDIR /app
#COPY . .
#RUN php artisan wayfinder:generate --with-form
#RUN npm run build --if-present
#
#FROM serversideup/php:8.5-fpm-nginx AS vendor
#COPY --chown=www-data:www-data composer.json composer.lock ./
#RUN composer install --no-dev --no-interaction --no-autoloader --no-scripts
#
#FROM serversideup/php:8.5-fpm-nginx
#ENV PHP_OPCACHE_ENABLE=1
#COPY --chown=www-data:www-data --from=vendor /var/www/html/vendor ./vendor
#COPY --chown=www-data:www-data . .
#COPY --chown=www-data:www-data --from=assets /app/public/build ./public/build
#RUN composer dump-autoload --no-dev --optimize
#
##COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
##
##COPY . .
##RUN npm ci --ignore-scripts
##RUN npm run build --if-present
#
##FROM node:26.12.1-alpine3.24 AS builder
##WORKDIR /app
##
##COPY package*.json ./
##
##COPY resources ./resources
##COPY vite.config.js ./vite.config.js
##COPY tsconfig.json ./tsconfig.json
##COPY tailwind.config.js ./tailwind.config.js
##
##RUN npm ci --ignore-scripts
##RUN npm run build --if-present
