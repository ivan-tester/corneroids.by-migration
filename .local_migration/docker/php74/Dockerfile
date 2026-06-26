FROM php:7.4-apache
RUN sed -i 's/deb.debian.org/archive.debian.org/g; s/security.debian.org/archive.debian.org/g; /stretch-updates/d; /buster-updates/d' /etc/apt/sources.list 2>/dev/null || true \
    && apt-get update \
    && apt-get install -y --no-install-recommends libpng-dev libjpeg-dev libfreetype6-dev libzip-dev unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install mysqli gd mbstring zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*
COPY php.ini /usr/local/etc/php/conf.d/corneroids.ini
