FROM composer:1.9.1 AS composer
FROM php:7.4.1-fpm-alpine3.11

ARG XDEBUG_HOST

RUN apk update \
    && apk upgrade \
    && apk add icu-dev $PHPIZE_DEPS \
    && docker-php-ext-install intl opcache \
    && pecl install xdebug-2.9.1 \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.remote_host=$XDEBUG_HOST" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

COPY --from=composer /usr/bin/composer /usr/bin/composer

ARG USER_ID
ARG GROUP_ID

RUN apk add shadow && usermod -u ${USER_ID} www-data && groupmod -g ${GROUP_ID} www-data

USER "${USER_ID}:${GROUP_ID}"

EXPOSE 9000
