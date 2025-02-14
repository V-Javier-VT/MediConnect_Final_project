# Usa la imagen oficial de PHP con CLI
FROM php:8.1-cli

# Instala extensiones necesarias para PDO (PostgreSQL y MySQL)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libpq-dev \
    default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configura el directorio de trabajo en el contenedor
WORKDIR /var/www/html

# Copia todos los archivos del microservicio al contenedor
COPY . .

# Instala las dependencias de Composer
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Asegura que el archivo .env esté presente y con permisos adecuados
COPY .env /var/www/html/.env
RUN chmod 644 /var/www/html/.env

# Desactiva la visualización de warnings en producción
RUN echo "error_reporting = E_ALL & ~E_WARNING & ~E_NOTICE" >> /usr/local/etc/php/php.ini
RUN echo "display_errors = Off" >> /usr/local/etc/php/php.ini

# Exponer el puerto en el contenedor
EXPOSE 5002

# Comando para iniciar el servidor embebido de PHP en el puerto 5001
CMD ["php", "-S", "0.0.0.0:5001", "-t", "public"]
