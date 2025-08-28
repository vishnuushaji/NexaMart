# =========================
# NexaMart - Laravel 11
# Dockerfile for Production
# =========================

# Stage 1 - PHP & Composer
FROM php:8.2-fpm AS php

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libpq-dev \
    libzip-dev \
    zip \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip bcmath gd

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Create app directory
WORKDIR /var/www/html

# Copy composer files & install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader

# Copy application files
COPY . .

# Set Laravel permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Optimize Laravel
RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# =========================
# Stage 2 - Node & Build Assets
# =========================
FROM node:20 AS node

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm install
COPY . .
RUN npm run build

# =========================
# Stage 3 - Final Nginx + PHP
# =========================
FROM nginx:1.25

# Copy built assets from node stage
COPY --from=node /app/public /var/www/html/public

# Copy PHP app from php stage
COPY --from=php /var/www/html /var/www/html

# Remove default Nginx config and add ours
RUN rm /etc/nginx/conf.d/default.conf
COPY ./docker/nginx.conf /etc/nginx/conf.d/default.conf

# Expose HTTP port
EXPOSE 80

# Start Nginx (Render runs CMD automatically)
CMD ["nginx", "-g", "daemon off;"]