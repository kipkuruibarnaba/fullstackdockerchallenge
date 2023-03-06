FROM php:8.2-rc-fpm

WORKDIR /var/www/html
    
RUN docker-php-ext-install pdo pdo_mysql

RUN chown -R www-data:www-data /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    vim

RUN apt-get update

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
# RUN chmod o+w ./storage/ -R