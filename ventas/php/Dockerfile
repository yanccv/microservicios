FROM php:8.0-fpm
RUN apt-get update && apt-get install -y \
		libfreetype-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
        libzip-dev \
        zip \
        git \
        nano \
        curl \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
	&& docker-php-ext-configure pcntl --enable-pcntl \
	&& docker-php-ext-install -j$(nproc) gd pdo_mysql exif zip pcntl sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN mv /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini
RUN sed -i 's\memory_limit = 128M\memory_limit = 512M\g' /usr/local/etc/php/php.ini
#COPY php.ini /usr/local/etc/php/php.ini


RUN chmod -R 775 /var/www
RUN chown -R www-data:www-data /var/www

#RUN rm -rf html
#USER www-data
#WORKDIR /var/www/html
#RUN composer create-project laravel/laravel html && cd html && php artisan install:api --quiet
# Instalamos dependendencias de composer
#RUN composer install --no-ansi --no-dev --no-interaction --no-progress --optimize-autoloader --no-scripts

#composer create-project laravel/laravel html && cd html && php artisan install:api --quiet && composer install && composer require vladimir-yuldashev/laravel-queue-rabbitmq


# Copiamos todos los archivos de la carpeta actual de nuestra 
# computadora (los archivos de laravel) a /var/www/

# Exponemos el puerto 9000 a la network
EXPOSE 9000

# Corremos el comando php-fpm para ejecutar PHP
CMD ["php-fpm"]