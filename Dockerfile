# Use official PHP image as base image
FROM php:8.1-fpm

# Install system dependencies for Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www/html

# Copy the Laravel application files into the container
COPY . .

# Install the PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port 8000 to access the application
EXPOSE 8000

# Run PHP-FPM server
CMD ["php-fpm"]
