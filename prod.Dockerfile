FROM php:8.5-cli AS frontend-builder

COPY composer.lock ./composer.lock
COPY composer.json ./composer.json

COPY --from=node:26-slim /usr/local/bin /usr/local/bin
COPY --from=node:26-slim /usr/local/lib/node_modules /usr/local/lib/node_modules

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y --no-install-recommends \
    zlib1g-dev libpng-dev libzip-dev

RUN docker-php-ext-configure gd \
    && docker-php-ext-install -j$(nproc) gd exif calendar sockets zip

RUN composer install --no-scripts

COPY . .
RUN npm ci --ignore-scripts
RUN npm run build --if-present

#FROM node:26.12.1-alpine3.24 AS builder
#WORKDIR /app
#
#COPY package*.json ./
#
#COPY resources ./resources
#COPY vite.config.js ./vite.config.js
#COPY tsconfig.json ./tsconfig.json
#COPY tailwind.config.js ./tailwind.config.js
#
#RUN npm ci --ignore-scripts
#RUN npm run build --if-present
