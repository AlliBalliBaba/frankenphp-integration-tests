FROM dunglas/frankenphp:static-builder AS build

WORKDIR /go/src/app/dist/app

COPY . .

RUN chmod -R 775 ./bootstrap/cache
RUN chmod -R 775 ./storage

RUN php artisan optimize

WORKDIR /go/src/app/

# RUN apt-get update && apt-get install -y git

# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ARG FRANKENPHP_VERSION=static-builder
ARG PHP_VERSION=8.3
ENV APP_NAME=Laravel
ENV APP_ENV=dev

RUN EMBED=dist/app/ \
    PHP_VERSION=${PHP_VERSION} \
    FRANKENPHP_VERSION=${FRANKENPHP_VERSION} \
    PHP_EXTENSIONS=zip,gd,pdo,pdo_mysql,opcache,phar,filter,iconv,libxml,openssl,dom,simplexml,mbstring,tokenizer,bcmath,ctype \
    PHP_EXTENSION_LIBS=bzip2,libxml2,libiconv,icu,xz,zlib \
    NO_COMPRESS=1 ./build-static.sh


RUN ls /go/src/app/dist/

FROM alpine:3.19.0

WORKDIR /app

COPY --from=build /go/src/app/dist/frankenphp-linux-x86_64 laravel-php

RUN ls

EXPOSE 80

CMD ["./laravel-php","php-server"]
