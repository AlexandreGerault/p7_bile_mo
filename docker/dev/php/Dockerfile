FROM php:fpm

WORKDIR /apps/api

RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    libmagickwand-dev \
    libpng-dev \
    libjpeg-dev \
    libssl-dev \
    libfreetype6-dev

RUN pecl install apcu \
    pecl install imagick \
    install xdebug

RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install bcmath exif pdo_mysql mysqli zip gd

RUN docker-php-ext-enable apcu imagick xdebug

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN mkdir /.composer && chown -R 1000:1000 /.composer && chmod -R 774 /.composer

RUN PATH=$PATH:/apps/api/vendor/bin:bin
RUN rm -rf /var/lib/apt/lists/*
