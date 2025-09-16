FROM php:8.2-apache

ARG APP_DIR=/var/www/html

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    zip \
    libzip-dev \
    zlib1g-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    procps \
    curl \
    ca-certificates \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql zip intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN a2enmod rewrite

WORKDIR ${APP_DIR}

COPY . ${APP_DIR}

RUN composer install --prefer-dist --no-interaction

EXPOSE 80