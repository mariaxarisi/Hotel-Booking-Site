# Use official PHP image with Apache
FROM php:8.2-apache

# Install necessary PHP extensions and dependencies
RUN apt-get update && apt-get install -y libzip-dev git \
    && docker-php-ext-install mysqli pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy only composer files first (optimizes build caching)
COPY composer.json composer.lock /var/www/html/

# Install Composer dependencies
RUN composer install --no-dev --optimize-autoloader

# Now copy the rest of the application
COPY . /var/www/html/

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80 for Apache
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]