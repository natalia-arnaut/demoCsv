FROM php:8.2-apache

RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

#RUN composer install

