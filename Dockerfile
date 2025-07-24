FROM php:8.2-cli

# Instalar dependencias de sistema
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    libpq-dev \
    git \
    zip \
    && docker-php-ext-install pdo pdo_pgsql

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Crear carpeta y setear permisos
WORKDIR /var/www

COPY . .

RUN composer install

# Exponer el puerto 8000
EXPOSE 8000

# Servidor Laravel escuchando desde cualquier IP
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
