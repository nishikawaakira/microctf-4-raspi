FROM php:7.4-fpm-buster

RUN apt-get update && apt-get upgrade -y \
  && docker-php-ext-install pdo_mysql mysqli \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

EXPOSE 80