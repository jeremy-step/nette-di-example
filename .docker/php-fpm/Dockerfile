FROM php:8.4-fpm-alpine AS base

WORKDIR /var/www/html/

RUN mkdir "/usr/local/logs" && chmod 777 "/usr/local/logs"

COPY ./.docker/php-fpm/conf/* /usr/local/etc/php/conf.d

RUN apk add --update linux-headers && apk add --no-cache $PHPIZE_DEPS && \
    docker-php-ext-install pdo pdo_mysql

RUN printf "sendmail_path = /usr/local/bin/mailpit sendmail\n" > /usr/local/etc/php/conf.d/php-sendmail.ini

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN curl --silent --show-error https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

RUN pecl install xdebug && \
    docker-php-ext-enable xdebug

FROM base AS with-node

RUN apk add --update nodejs-current pnpm
