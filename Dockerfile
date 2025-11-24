FROM php:8.2-apache

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache modules
RUN a2enmod rewrite

# ⚠ IMPORTANT: Allow .htaccess to override Apache configs
RUN sed -i 's|AllowOverride None|AllowOverride All|' /etc/apache2/apache2.conf

# Set correct DocumentRoot to root directory (where your index.php is)
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html|' /etc/apache2/sites-available/000-default.conf

# Optional: Composer + tools
RUN apt-get update && apt-get install -y git unzip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy project files
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

# Ensure proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose HTTP port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
