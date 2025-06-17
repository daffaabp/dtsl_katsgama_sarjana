FROM php:8.4-fpm-alpine3.22

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
    libicu-dev \
    default-mysql-client \
    && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-configure gd \
    && docker-php-ext-configure intl

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    mysqli \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    intl \
    zip

# Get latest Composer
COPY --from=composer:2.6.6 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Add user for application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Set COMPOSER_ALLOW_SUPERUSER
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install dependencies
RUN composer install --no-dev --no-interaction --prefer-dist

# Change current user to www
USER www

# Expose port 9000
EXPOSE 9000

CMD ["php-fpm"] 