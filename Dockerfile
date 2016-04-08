FROM php:7.0-apache

#RUN docker-php-ext-install pdo pdo-mysql

RUN a2enmod rewrite

WORKDIR /var/www/html
