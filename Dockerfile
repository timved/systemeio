FROM php:8.3-cli-alpine as sio_test
RUN apk add --no-cache git zip bash

# Setup php extensions
RUN apk add --no-cache postgresql-dev \
    && docker-php-ext-install pdo_pgsql pdo_mysql

# xdebug
RUN apk add --no-cache linux-headers \
    && apk add --update --no-cache --virtual .build-dependencies $PHPIZE_DEPS\
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && pecl clear-cache \
    && apk del .build-dependencies

COPY ./docker/php/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

ENV COMPOSER_CACHE_DIR=/tmp/composer-cache
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Setup php app user
ARG USER_ID=1000
RUN adduser -u ${USER_ID} -D -H app
USER app

COPY --chown=app . /app
WORKDIR /app

EXPOSE 8337

CMD ["php", "-S", "0.0.0.0:8337", "-t", "public"]
