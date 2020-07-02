FROM php:7.3-fpm

RUN apt-get update && apt-get install -y \
    ssh \
    git \
    zip \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libsodium-dev \
    libpng-dev \
    libicu-dev \
    libxml2-dev \
    libsqlite3-dev \
    libzip-dev

RUN docker-php-ext-install -j$(nproc) iconv intl xml soap sodium opcache pdo pdo_mysql mysqli mbstring bcmath pdo_sqlite pcntl pcntl sockets zip
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


WORKDIR /app/test1

RUN	mkdir -p var/cache var/log storage \
 && chmod -R 777 var \
 && chown -R www-data:www-data var \
 && chown -R www-data:www-data /var/www


COPY php-fpm.conf /etc/php-fpm.conf
COPY php.ini /usr/local/etc/php/

