FROM dunglas/frankenphp:latest

RUN install-php-extensions \
    pdo_mysql \
    pdo_pgsql gd \
    intl \
    zip \
    opcache \
    bcmath \
    redis \
    calendar \
    exif \
    sockets

RUN apt-get update && apt-get install -y \
    nodejs \
    npm


WORKDIR /app
