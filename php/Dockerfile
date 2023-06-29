FROM php:8.1-fpm

RUN apt-get update

RUN apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev

# RUN echo "\e[1;33mInstall important docker dependencies\e[0m"
# RUN docker-php-ext-install \
#      pcntl \
#      ctype \
#     curl \
#      conv \
#      xml \
#      soap \
#      mbstring \
#      tokenizer \
#     bz2 \
#      zip \
#      ntl

# Install Postgre PDO
RUN apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql