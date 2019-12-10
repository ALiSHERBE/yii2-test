FROM php:7.1-cli

RUN apt-get update && apt-get install -y libmcrypt-dev zlib1g-dev mysql-client \
    && docker-php-ext-install mcrypt pdo_mysql pcntl zip

WORKDIR /var/www

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin && \
        echo "alias composer='composer'" >> /root/.bashrc && \
        composer