FROM php:8.3-apache

RUN docker-php-ext-install mysqli pdo_mysql 

COPY  /src /var/www/html

EXPOSE 80