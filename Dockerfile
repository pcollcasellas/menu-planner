FROM php:8.3-fpm

WORKDIR /var/www/service

RUN apt-get update && apt-get install -y \
    libfreetype-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql;

RUN apt-get update && \
    apt-get install -y -q nginx


COPY ./ /var/www/service

COPY ./default.conf /etc/nginx/sites-available/default

# RUN php artisan optimize

RUN mkdir -p /var/www/html/storage/logs \
    && chown -R www-data:www-data /var/www/html/storage \
    && chmod -R 775 /var/www/html/storage

CMD ["sh", "-c", "php-fpm & nginx -g 'daemon off;'"]
