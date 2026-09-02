FROM php:8.3.33-apache-bookworm

RUN docker-php-ext-install pdo_mysql

WORKDIR /var/www/html

COPY ./src/ /var/www/html/

RUN chown -R www-data:www-data /var/www/html
