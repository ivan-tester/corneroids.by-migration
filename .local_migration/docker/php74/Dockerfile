FROM php:7.4-apache
RUN printf 'Acquire::Check-Valid-Until "false";\n' > /etc/apt/apt.conf.d/99archive \
    && (sed -i \
        -e 's|deb.debian.org/debian|archive.debian.org/debian|g' \
        -e 's|security.debian.org/debian-security|archive.debian.org/debian-security|g' \
        -e '/bullseye-security/d' \
        -e '/stretch-updates/d' \
        -e '/buster-updates/d' \
        /etc/apt/sources.list 2>/dev/null || true) \
    && printf 'deb http://archive.debian.org/debian bullseye main\n' > /etc/apt/sources.list \
    && apt-get update \
    && apt-get install -y --no-install-recommends libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libonig-dev unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install mysqli gd mbstring zip \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*
COPY php.ini /usr/local/etc/php/conf.d/corneroids.ini
