# 🌥️ Cloudinary Setup untuk ETS-web

## Langkah Setup

### 1. Daftar/Login ke Cloudinary

1. Buka https://cloudinary.com
2. Login atau Sign Up (Gratis)
3. Setelah login, kamu akan masuk ke **Dashboard**

### 2. Ambil Credentials dari Dashboard

Di Dashboard Cloudinary, kamu akan melihat:

```
Cloud name: your_cloud_name
API Key: 123456789012345
API Secret: abcdefghijklmnopqrstuvwxyz123
```

### 3. Update File `.env`

Buka file `.env` di root project, lalu ganti nilai berikut:

```env
# Cloudinary Configuration
CLOUDINARY_CLOUD_NAME=your_cloud_name        # Ganti dengan Cloud Name kamu
CLOUDINARY_API_KEY=123456789012345           # Ganti dengan API Key kamu
CLOUDINARY_API_SECRET=abcdefghijklmnopqrstu  # Ganti dengan API Secret kamu
CLOUDINARY_URL=cloudinary://API_KEY:API_SECRET@CLOUD_NAME
```

**Contoh lengkap:**

```env
CLOUDINARY_CLOUD_NAME=democloud123
CLOUDINARY_API_KEY=123456789012345
CLOUDINARY_API_SECRET=abcdefgh123456xyz
CLOUDINARY_URL=cloudinary://123456789012345:abcdefgh123456xyz@democloud123
```

### 4. Clear Config Cache

Jalankan di terminal:

```bash
php artisan config:clear
```

### 5. Test Upload

1. Login sebagai member di http://ets-web.test
2. Pergi ke menu "Kumpulkan Tugas"
3. Pilih tugas, upload file PDF atau foto
4. Cek di Dashboard Cloudinary → Media Library
5. File kamu akan muncul di folder `ets-submissions/`

## ✅ Fitur yang Sudah Diimplementasi

-   ✅ Upload PDF ke Cloudinary
-   ✅ Upload Image (JPG, PNG) ke Cloudinary
-   ✅ Auto detect file type (image/pdf)
-   ✅ Custom folder: `ets-submissions/`
-   ✅ Secure URL (HTTPS)
-   ✅ Unique filename dengan user_id + timestamp

## 📦 File yang Sudah Diubah

### 1. `.env`

Tambah credentials Cloudinary

### 2. `app/Http/Controllers/SubmissionController.php`

```php
// Before (Local Storage)
$path = $file->storeAs('submissions', $fileName, 'public');

// After (Cloudinary)
$uploadedFile = Cloudinary::upload($file->getRealPath(), [
    'folder' => 'ets-submissions',
    'public_id' => 'submission_' . auth()->id() . '_' . time(),
    'resource_type' => 'auto'
]);
$content = $uploadedFile->getSecurePath();
```

## 🎯 Free Tier Limits

-   **Storage**: 25 GB
-   **Bandwidth**: 25 GB/bulan
-   **Transformations**: 25,000/bulan

Lebih dari cukup untuk aplikasi tugas kuliah! 🚀

## 🔗 URL File yang Tersimpan

File akan tersimpan dengan format URL seperti:

```
https://res.cloudinary.com/democloud123/image/upload/v1234567890/ets-submissions/submission_3_1234567890.jpg
```

URL ini disimpan di database kolom `submissions.content`

## ⚠️ Catatan Penting

1. **Jangan commit file `.env`** ke GitHub (sudah ada di `.gitignore`)
2. **Simpan credentials** di tempat aman
3. **Untuk production**, gunakan environment variables di hosting platform
4. File di Cloudinary **tidak akan hilang** meskipun deploy ulang aplikasi

## 🆘 Troubleshooting

### Error: "Cloudinary credentials not found"

-   Pastikan `.env` sudah diisi dengan benar
-   Jalankan `php artisan config:clear`

### Upload gagal / Error 401

-   Cek kembali API Key dan API Secret
-   Pastikan tidak ada spasi di awal/akhir credentials

### File tidak muncul di Cloudinary

-   Cek internet connection
-   Cek quota free tier belum habis
-   Cek di Dashboard Cloudinary → Media Library → folder `ets-submissions`

## 📚 Resources

-   Cloudinary Dashboard: https://console.cloudinary.com
-   Laravel Package: https://github.com/cloudinary-labs/cloudinary-laravel
-   Cloudinary Docs: https://cloudinary.com/documentation/laravel_integration
