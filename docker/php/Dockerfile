FROM php:8.2-fpm-alpine

# Instalar dependências do sistema
RUN apk add --no-cache \
    postgresql-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    icu-dev \
    oniguruma-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    pdo \
    pdo_pgsql \
    pgsql \
    gd \
    intl \
    mbstring \
    zip \
    opcache

# Configuração do PHP
COPY php.ini /usr/local/etc/php/conf.d/custom.ini

# Configurar permissões
RUN chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html

EXPOSE 9000
