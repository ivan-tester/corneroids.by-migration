FROM php:8.2-apache
RUN apt-get update \
    && apt-get install -y --no-install-recommends libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libonig-dev unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install mysqli gd mbstring zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*
COPY php.ini /usr/local/etc/php/conf.d/corneroids.ini
