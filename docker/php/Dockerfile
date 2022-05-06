FROM php:8.1-apache
RUN apt-get update
RUN apt-get install -y apt-utils
RUN apt-get install -y nano procps
RUN apt-get install -y libmcrypt-dev
RUN apt-get install -y libicu-dev
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-enable mysqli
RUN docker-php-ext-install intl
RUN docker-php-ext-configure intl
RUN docker-php-ext-enable intl
RUN apt-get upgrade -y
RUN a2enmod rewrite
EXPOSE 80
ADD apache.conf /etc/apache2/sites-available/000-default.conf
ADD php.ini-development /usr/local/etc/php/php.ini-development
ADD php.ini-production /usr/local/etc/php/php.ini-production