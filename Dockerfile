# Use the official PHP image with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Copy all project files into the container
COPY . .

# Enable Apache mod_rewrite for .htaccess support
RUN a2enmod rewrite

# Install the MySQLi extension for database connection
RUN docker-php-ext-install mysqli

# Expose port 80 (default for web traffic)
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
