# Usa una imagen de PHP con Apache
FROM php:8.1-apache

# Instala dependencias necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zlib1g-dev \
    git \
    unzip \
    libmariadb-dev-compat \
    libmariadb-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia la configuración personalizada de Apache
COPY ./docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Habilita el módulo de reescritura en Apache
RUN a2enmod rewrite

# Copia los archivos del proyecto
COPY . .

# Instala las dependencias del proyecto
RUN composer install --no-dev --optimize-autoloader

# Configura los permisos correctos
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expone el puerto 80
EXPOSE 80