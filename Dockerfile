FROM php:7.4.4-fpm

RUN docker-php-ext-install pdo_mysql

RUN mkdir /app
WORKDIR /app
ADD . /app
EXPOSE 9000
