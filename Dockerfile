FROM php:8.2-apache

# Menginstal dependensi sistem yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev

# Membersihkan cache apt untuk memperkecil ukuran image
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Menginstal ekstensi PHP yang dibutuhkan Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Mengaktifkan Apache mod_rewrite dan memastikan MPM prefork digunakan
RUN a2dismod mpm_event mpm_worker || true \
    && a2enmod mpm_prefork rewrite

# Menginstal Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Menginstal Node.js & npm (untuk proses build Vite/Tailwind)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Mengatur direktori kerja
WORKDIR /var/www/html

# Menyalin seluruh file project ke dalam container
COPY . .

# Mengubah konfigurasi DocumentRoot Apache agar mengarah ke folder /public milik Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Menginstal dependensi PHP dan Node.js, lalu membuild aset frontend
RUN composer install --no-dev --optimize-autoloader \
    && npm install \
    && npm run build

# Mengatur hak akses folder storage dan bootstrap/cache agar bisa ditulisi
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Render otomatis meneruskan trafik HTTP. Apache secara default berjalan di port 80.
EXPOSE 80

# Menjalankan migrasi, mengatur port Apache sesuai $PORT dari Railway, dan menjalankan Apache
CMD php artisan migrate --force && sed -i "s/80/$PORT/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf && apache2-foreground
