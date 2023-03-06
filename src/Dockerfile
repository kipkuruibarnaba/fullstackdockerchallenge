FROM php:8.2-rc-fpm

WORKDIR ./
    
RUN docker-php-ext-install pdo pdo_mysql

# RUN chown -R www-data:www-data /
# RUN chmod o+w ./storage/ -R