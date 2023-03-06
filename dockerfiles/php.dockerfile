FROM php:8.2-rc-fpm

WORKDIR /var/www/html
    
RUN docker-php-ext-install pdo pdo_mysql

RUN chown -R www-data:www-data /var/www/html

# RUN chmod o+w ./storage/ -R