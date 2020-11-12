FROM php:7.3-fpm-stretch

# PHP extensions
RUN apt-get -qq update && apt-get -qq install libxml2-dev

RUN apt-get update -y\
    && apt-get install -y\
    && apt-get clean -y \
    && docker-php-ext-configure soap --enable-soap \
    && docker-php-ext-install soap
RUN docker-php-ext-install pdo_mysql

# Composer
RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /var/www
COPY . /var/www
