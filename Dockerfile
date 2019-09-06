FROM php:5.6-apache

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pgsql pdo pdo_pgsql

#COPY php.ini $PHP_INI_DIR/php.ini

COPY bandikamppa/ /var/www/html
