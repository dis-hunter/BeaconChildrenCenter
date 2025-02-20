# Use an official PHP image with Apache
FROM php:8.2-apache

# Install PHP extensions needed for Laravel, including PostgreSQL, intl, and zip
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    zip \
    git \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql pdo_pgsql intl zip

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www

# Copy Laravel app
COPY . .

# Point Apache to Laravel's public directory
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/public|' /etc/apache2/sites-available/000-default.conf

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create the cache directory and set permissions
RUN mkdir -p storage/framework/views && chmod -R 775 storage/framework/views



# Install Laravel dependencies with platform requirements ignored
RUN composer update 

# Expose port 8000
EXPOSE 8000
