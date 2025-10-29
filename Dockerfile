FROM php:8.2-fpm

# Instalar dependencias del sistema y extensiones de PHP
RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libpng-dev libonig-dev libxml2-dev zip \
    nodejs npm \
    && docker-php-ext-install pdo_pgsql mbstring bcmath gd

# Instalar Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www