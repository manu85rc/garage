FROM php:8.2-fpm-alpine

# Instalar dependencias necesarias para Composer y extensiones PHP comunes
RUN apk add --no-cache \
    git \
    zip \
    unzip \
    curl

# Instalar extensiones PHP comunes para proyectos web
RUN docker-php-ext-install pdo pdo_mysql

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www/html

CMD ["php-fpm"]