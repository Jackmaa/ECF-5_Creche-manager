FROM php:8.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl zip libicu-dev libpq-dev libzip-dev libonig-dev \
    libxml2-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libmcrypt-dev libssl-dev \
    && docker-php-ext-install intl pdo pdo_mysql zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
