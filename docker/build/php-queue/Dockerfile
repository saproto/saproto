FROM php:7.4-cli

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    mariadb-client \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libgmp-dev \
    libmcrypt-dev \
    libzip-dev \
    libonig-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl gmp
RUN docker-php-ext-configure gd --enable-gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ 
#--with-png=/usr/include/
RUN docker-php-ext-install gd
RUN pecl install mcrypt-1.0.4 && docker-php-ext-enable mcrypt

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./php.ini /usr/local/etc/php/

CMD ["php", "/var/www/artisan", "queue:work", "--verbose", "--tries=3", "--timeout=90", "--queue=low,medium,high"]