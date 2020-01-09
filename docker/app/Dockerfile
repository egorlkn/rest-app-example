FROM php:7.3.13-fpm-alpine3.11

RUN apk update && \
    apk upgrade && \
    apk add icu-dev && \
    docker-php-ext-install intl opcache

RUN wget https://getcomposer.org/installer -O composer-setup.php && \
    php composer-setup.php --version=1.9.1 && \
    rm -f composer-setup.php && \
    chmod +x composer.phar && \
    mv composer.phar /usr/bin/composer

EXPOSE 9000
