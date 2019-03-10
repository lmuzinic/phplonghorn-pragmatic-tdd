FROM php:7.3-alpine

RUN apk --update add git openssh bash $PHPIZE_DEPS && \
    rm -rf /var/lib/apt/lists/* && \
    rm /var/cache/apk/*

RUN pecl install xdebug-2.7.0

RUN echo "memory_limit=-1" > "$PHP_INI_DIR/conf.d/memory-limit.ini" \
 && echo "date.timezone=${PHP_TIMEZONE:-UTC}" > "$PHP_INI_DIR/conf.d/date_timezone.ini"

COPY --from=composer:1.8 /usr/bin/composer /usr/bin/composer

WORKDIR /app
