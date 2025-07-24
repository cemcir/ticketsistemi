# Laravel için PHP Image
FROM php:8.2-fpm

# Gerekli system paketleri ve PHP extensiyonları yükleniyor, ayrıca opcache kuruluyor
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim unzip git curl libzip-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath gd opcache \
    && rm -rf /var/lib/apt/lists/*

# PHP'nin yapılandırma dosyasına opcache ayarlarını ekliyoruz
RUN { \
    echo "opcache.enable=1"; \
    echo "opcache.enable_cli=1"; \
    echo "opcache.memory_consumption=128"; \
    echo "opcache.interned_strings_buffer=8"; \
    echo "opcache.max_accelerated_files=10000"; \
    echo "opcache.validate_timestamps=1"; \
    echo "opcache.revalidate_freq=0"; \
} > /usr/local/etc/php/conf.d/opcache.ini

# Özel php.ini dosyasını container içine kopyalıyoruz
COPY ./php.ini /usr/local/etc/php/conf.d/custom.ini

# Composer kurulumu
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Çalışma dizini ve izinler ayarlanıyor
WORKDIR /var/www
COPY . /var/www

# Storage ve cache klasör izinleri
RUN mkdir -p /var/www/storage /var/www/bootstrap/cache \
    && chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Geliştirme ortamı için Composer kurulumunu tam yapıyoruz
RUN composer install --no-interaction --prefer-dist

# Laravel için gerekli işlemler
RUN php artisan key:generate

# Portları açıyoruz ve container çalıştırma komutunu ekliyoruz
EXPOSE 9000
CMD ["php-fpm"]
