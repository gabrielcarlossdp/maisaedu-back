FROM php:8.1-fpm-alpine

WORKDIR /var/www/html

COPY . .

# Update Alpine package repository
RUN apk update

### apk add is the package manager for Alpine Linux
RUN apk add \
  supervisor \
  # Development dependencies
  zlib-dev \
  libzip-dev \
  unzip \
  libpng-dev \
  postgresql-dev \
  libxml2-dev

RUN docker-php-ext-install pdo_mysql mysqli zip

RUN chmod 777 -R storage

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./docker/supervisord/supervisord.conf /etc/supervisor/supervisord.conf

COPY ./docker/php/extra-php.ini "$PHP_INI_DIR/99_extra.ini"
COPY ./docker/php/extra-php-fpm.conf /etc/php8/php-fpm.d/www.conf

RUN apk add nginx
RUN rm -rf /etc/nginx/sites-enabled/* && rm -rf /etc/nginx/sites-available/*
COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/nginx/error.html /var/www/html/error.html

EXPOSE 8080

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]