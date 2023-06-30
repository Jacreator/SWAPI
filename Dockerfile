FROM php:8.1-fpm

RUN apt-get update

RUN apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev

# Install Postgre PDO
RUN apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

COPY ./src /var/www

COPY ./docker /var/www/docker

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# change mod for storage
RUN chmod -R ugo+rw /var/www/storage

# change mod for Laravel storage
RUN chmod -R 755 /var/www/bootstrap/
RUN chmod -R 777 /var/www/storage/
RUN chmod -R 777 /var/www/public/

# WORKDIR '/var/www/'

# CMD ["php" ,"artisan", "serve"]