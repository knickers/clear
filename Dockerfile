FROM php:7.0-apache

RUN a2enmod rewrite

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html
