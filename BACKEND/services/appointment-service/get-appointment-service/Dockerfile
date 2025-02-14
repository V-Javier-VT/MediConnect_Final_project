# Usa la imagen oficial de PHP con CLI
FROM php:8.1-cli

# Instalar extensiones necesarias para PDO (PostgreSQL y MySQL) y herramientas para Composer
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libpq-dev \
    default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Instala Composer correctamente desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos del microservicio ANTES de instalar Composer
COPY composer.json composer.lock ./

# Instala las dependencias de Composer antes de copiar todo el código
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Luego copia el resto del código
COPY . .

# Asegura que el archivo .env esté presente y con permisos adecuados
COPY .env /var/www/html/.env
RUN chmod 644 /var/www/html/.env

# Desactiva la visualización de warnings en producción
RUN echo "error_reporting = E_ALL & ~E_WARNING & ~E_NOTICE" >> /usr/local/etc/php/php.ini
RUN echo "display_errors = OFF" >> /usr/local/etc/php/php.ini

# Exponer el puerto en el contenedor
EXPOSE 5002

# Comando para iniciar el servidor embebido de PHP en el puerto 5002
CMD ["php", "-S", "0.0.0.0:5002", "-t", "public"]
