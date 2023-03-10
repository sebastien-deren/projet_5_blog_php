FROM php:8.2-apache
RUN a2enmod rewrite
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get upgrade -y
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip
COPY ./apache2.conf /etc/apache2/sites-available/000-default.conf
WORKDIR /var/www/blog/
