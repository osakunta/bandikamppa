FROM php:5.6-apache

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pgsql pdo pdo_pgsql

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
RUN echo 'date.timezone = "Europe/Helsinki"' > $PHP_INI_DIR/php.ini
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

COPY bandikamppa/ /var/www/html
