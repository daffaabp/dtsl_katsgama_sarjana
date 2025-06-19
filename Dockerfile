FROM php:8.2.28-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    icu-dev \
    mysql-client \
    nodejs \
    npm \
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
RUN addgroup -g 1000 www && \
    adduser -u 1000 -G www -h /home/www -s /bin/sh -D www

# Copy package.json and package-lock.json
COPY package*.json ./

# Install Node.js dependencies
RUN npm install

# Copy existing application directory
COPY . /var/www

# Build assets
RUN npm run build

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