# Use an official PHP image with Apache
FROM php:8.2-apache

# Install PHP extensions needed for Laravel, including PostgreSQL extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql pdo_pgsql

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set working directory to /var/www
WORKDIR /var/www

# Copy the Laravel app into the container
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Laravel dependencies
RUN composer install

# Expose port 80
EXPOSE 80
