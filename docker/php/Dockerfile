FROM php:7.1-fpm

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        mysql-client \
        libpng-dev \
    && docker-php-ext-install -j$(nproc) iconv mcrypt mbstring mysqli pdo_mysql pcntl zip \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini

WORKDIR /var/www