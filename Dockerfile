FROM php:8.1.27-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install mysqli

# Set working directory
WORKDIR /var/www

# Install composer
COPY --from=composer:2.6.6 /usr/bin/composer /usr/bin/composer

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www

# Install production dependencies only
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Change current user to www-data
USER www-data

# Expose port 9000
EXPOSE 9000

# Start php-fpm server
CMD ["php-fpm"] 