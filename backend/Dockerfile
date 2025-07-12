FROM php:8.2-cli

# Dependências
RUN apt-get update && apt-get install -y \
    libpng-dev zip unzip git curl libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring bcmath

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Pasta de trabalho
WORKDIR /var/www

# Copiar arquivos e instalar dependências
COPY . .
RUN composer install
