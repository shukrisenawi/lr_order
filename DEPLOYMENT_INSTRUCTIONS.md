# Instruksi Deployment untuk Upload Gambar Tenaga Pengajar

## Masalah: Upload gambar tidak berfungsi di server live

### Langkah-langkah Perbaikan:

#### 1. Buat Symlink Storage
```bash
php artisan storage:link
```

#### 2. Set Permission Direktori Storage
```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
chown -R www-data:www-data storage/
chown -R www-data:www-data bootstrap/cache/
```

#### 3. Buat Direktori untuk Gambar Tenaga Pengajar
```bash
mkdir -p storage/app/public/tenaga-pengajar
chmod 775 storage/app/public/tenaga-pengajar
```

#### 4. Periksa Konfigurasi PHP
Pastikan di `php.ini`:
```
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
```

#### 5. Clear Cache Laravel
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

#### 6. Restart Web Server
```bash
# Untuk Apache
sudo systemctl restart apache2

# Untuk Nginx + PHP-FPM
sudo systemctl restart nginx
sudo systemctl restart php8.1-fpm
```

#### 7. Verifikasi
- Akses URL: `https://domain.com/storage/tenaga-pengajar/`
- Jika 404, symlink belum berhasil
- Jika 403, permission belum benar

### Catatan Tambahan:
- Pastikan user web server (www-data/apache) memiliki akses write ke direktori storage
- Jika menggunakan shared hosting, mungkin perlu menggunakan FTP untuk set permission
- Untuk cPanel hosting, gunakan File Manager untuk set permission 755/775