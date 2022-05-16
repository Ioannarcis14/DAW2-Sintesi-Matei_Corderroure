#FROM php:8.1-apache
FROM php:7.4-apache
RUN apt-get update
RUN apt-get install -y apt-utils
RUN apt-get install -y nano procps
RUN apt-get install -y libmcrypt-dev
RUN apt-get install -y libicu-dev
RUN apt-get install -y git
RUN apt-get install -y zip
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-enable mysqli
RUN docker-php-ext-install intl
RUN docker-php-ext-configure intl
RUN docker-php-ext-enable intl
RUN apt-get upgrade -y
RUN a2enmod rewrite
RUN cd ~
RUN curl -sS https://getcomposer.org/installer -o /tmp/composer-setup.php
RUN HASH=`curl -sS https://composer.github.io/installer.sig`
RUN php -r "if (hash_file('SHA384', '/tmp/composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
EXPOSE 80
ADD apache.conf /etc/apache2/sites-available/000-default.conf
ADD php.ini-development /usr/local/etc/php/php.ini-development
ADD php.ini-production /usr/local/etc/php/php.ini-production