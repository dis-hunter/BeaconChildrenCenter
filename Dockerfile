# Use official PHP image with Apache
FROM php:8.2-apache

# Install system dependencies and PHP extensions for Laravel & Redis
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    zip \
    git \
    libpq-dev \
    redis-server \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql pdo_pgsql intl zip \
    && pecl install redis && docker-php-ext-enable redis

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www

# Copy Laravel app files
COPY . .

# Set Apache to serve from Laravel's public directory
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/public|' /etc/apache2/sites-available/000-default.conf

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create the cache directory and set permissions
RUN mkdir -p storage/framework/views && chmod -R 775 storage/framework/views

RUN composer config --global process-timeout 2000


# Install Laravel dependencies
RUN composer update

# Set proper permissions for Laravel directories
RUN chown -R www-data:www-data /var/www && \
    chmod -R 775 storage bootstrap/cache



# Expose ports for Apache and Redi
EXPOSE 80 6379

# Start both Redis and Apache when the container runs
CMD service redis-server start && apache2-foreground
