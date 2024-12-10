# Base image
FROM php:8.3-fpm

# Set environment to noninteractive to avoid debconf issues
ENV DEBIAN_FRONTEND=noninteractive

# Set working directory
WORKDIR /var/www/service

# Install system dependencies
RUN apt-get update && apt-get install -y apt-utils && \
    apt-get install -y -q \
    libfreetype-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    zip unzip git curl nginx && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd && \
    docker-php-ext-install pdo_mysql && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy application code
COPY ./ /var/www/service

# Install PHP dependencies using Composer
RUN composer install --optimize-autoloader --no-dev

# Set permissions for storage and cache
RUN mkdir -p /var/www/service/storage/logs && \
    chown -R www-data:www-data /var/www/service/storage /var/www/service/bootstrap/cache && \
    chmod -R 775 /var/www/service/storage /var/www/service/bootstrap/cache

# Copy Nginx configuration
COPY ./default.conf /etc/nginx/sites-available/default

# Expose application port
EXPOSE 81

# Start services
CMD ["sh", "-c", "php-fpm & nginx -g 'daemon off;'"]
