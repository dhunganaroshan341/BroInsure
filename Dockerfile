
FROM php:8.1-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    unzip \
    curl \
    libpq-dev \
    libonig-dev \
    libzip-dev \
    libwebp-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_pgsql mbstring zip exif pcntl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j "$(nproc)" gd opcache \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && groupadd -g 1000 www-insurance \
    && useradd -u 1000 -ms /bin/bash -g www-insurance www-insurance

COPY --chown=www-insurance:www-insurance . /var/www

RUN chmod -R 775 /var/www/storage

USER www-insurance

CMD ["php-fpm"]
