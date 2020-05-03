FROM php:7.4.4-fpm
RUN mkdir /app
WORKDIR /app
ADD . /app
EXPOSE 9000
