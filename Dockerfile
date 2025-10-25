# STAGE 1: Build Frontend Assets (Vite + Tailwind)
# Kita pakai image node resmi untuk build
FROM node:18-alpine AS frontend
WORKDIR /app

# Copy file package dan install dependensi
COPY package.json package-lock.json ./
RUN npm install

# Copy file konfigurasi frontend
COPY vite.config.js tailwind.config.js postcss.config.js ./

# Copy semua file source frontend
COPY resources/css ./resources/css
COPY resources/js ./resources/js

# Jalankan build
RUN npm run build

# ---

# STAGE 2: Build Aplikasi Final (PHP + Nginx)
# Kita pakai image yang sudah ada Nginx + PHP-FPM untuk produksi
# Ini jauh lebih baik daripada 'artisan serve'
FROM webdevops/php-nginx:8.2-alpine
WORKDIR /var/www/html

# Setel environment (agar tidak interaktif)
ENV DEBIAN_FRONTEND=noninteractive

# Install ekstensi PHP yang umum untuk Laravel
# (Tambahkan ekstensi lain jika perlu)
RUN install-php-extensions pdo_mysql bcmath gd exif zip

# Copy file composer
COPY composer.json composer.lock ./
# Install dependensi PHP (production)
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Copy semua file aplikasi Laravel
COPY . .

# Copy aset yang sudah di-build dari stage 'frontend'
COPY --from=frontend /app/public/build ./public/build

# Setel kepemilikan file agar server Nginx/PHP-FPM bisa menulis
# ke folder storage dan cache
RUN chown -R application:application storage bootstrap/cache

# Port yang diekspos oleh image ini adalah 80
EXPOSE 80