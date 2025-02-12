# Usa una imagen oficial de PHP con Apache
FROM php:8.1-apache

# Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libonig-dev \
    unzip \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql

# Configura el directorio de trabajo
WORKDIR /var/www/html

# Copia el archivo de configuración de Apache (Opcional si necesitas .htaccess)
COPY public /var/www/html

# Copia los archivos del microservicio
COPY . /var/www/html

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

#Crear la carpeta "storage" antes de aplicar permisos
RUN mkdir -p /var/www/html/storage && chmod -R 777 /var/www/html/storage

# Expone el puerto definido en el .env
EXPOSE 5001

# Comando para iniciar Apache
CMD ["apache2-foreground"]
