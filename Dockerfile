FROM php:7.0-apache
COPY application /var/www/application
COPY public /var/www/public
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

RUN a2enmod headers
RUN rm -rf /var/www/html
RUN apt-get update && apt-get install -y libmcrypt-dev mysql-client
RUN docker-php-ext-install mysqli mcrypt mbstring pdo_mysql