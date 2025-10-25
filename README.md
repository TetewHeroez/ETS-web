# MyHIMATIKA - Padamu HIMATIKA ITS 2024/2025

Sistem informasi manajemen anggota HIMATIKA (Himpunan Mahasiswa Teknik Informatika) ITS dengan fitur lengkap untuk mengelola data member, presensi, tugas, dan nilai.

[![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-v4-38bdf8.svg)](https://tailwindcss.com)
[![Cloudinary](https://img.shields.io/badge/Cloudinary-Enabled-3448c5.svg)](https://cloudinary.com)

---

## 📋 Daftar Isi

-   [Fitur Utama](#-fitur-utama)
-   [Tech Stack](#-tech-stack)
-   [Instalasi](#-instalasi)
-   [Konfigurasi](#-konfigurasi)
-   [Upload Foto/PDF ke Cloudinary](#-upload-fotopdf-ke-cloudinary)
-   [Troubleshooting](#-troubleshooting)
-   [Deployment](#-deployment)
-   [Contributing](#-contributing)

---

## 🚀 Fitur Utama

### 📊 Dashboard & Analytics

-   Dashboard interaktif dengan statistik real-time
-   Grafik kehadiran, tugas, dan performa member
-   Dark mode support

### 👥 Manajemen User

-   **Member**: Profile lengkap (data pribadi, alamat, orang tua, kesehatan)
-   **Admin**: Manajemen data member, import Excel
-   **Superadmin**: Full control system

### 📸 Upload Cloudinary

-   ✅ Upload foto profil ke Cloudinary CDN
-   ✅ Validasi real-time (ukuran, format)
-   ✅ Status indicator (loading, sukses, gagal)
-   ✅ Auto-resize & optimization (500x500, auto-quality, WebP/AVIF)
-   ✅ Auto-delete foto lama
-   📄 Siap extend untuk upload PDF (rapor, transkrip, dll)

### 📅 Presensi & Attendance

-   Sistem check-in/check-out
-   Riwayat kehadiran per member
-   Export laporan kehadiran

### 📝 Assignment & Submission

-   Manajemen tugas dengan bobot nilai
-   Upload submission dengan deadline
-   Scoring system otomatis

### 🎯 GDK (Gugus Depan Kampus)

-   Sistem kontrak GDK
-   Visual hierarchy untuk prioritas tugas
-   Progress tracking

---

## 🛠️ Tech Stack

| Category            | Technology                                  |
| ------------------- | ------------------------------------------- |
| **Backend**         | Laravel 11.x (PHP 8.2+)                     |
| **Frontend**        | Blade Templates, Tailwind CSS v4, Alpine.js |
| **Database**        | MySQL (Aiven Cloud)                         |
| **Storage**         | Cloudinary CDN                              |
| **Icons**           | Feather Icons                               |
| **Package Manager** | Composer, npm                               |
| **Dev Tools**       | Laravel Tinker, Vite                        |

### Dependencies Utama

```json
{
    "laravel/framework": "^11.0",
    "maatwebsite/excel": "^3.1",
    "cloudinary-labs/cloudinary-laravel": "^2.0"
}
```

---

## 📦 Instalasi

### Requirements

-   PHP >= 8.2
-   Composer
-   Node.js & npm
-   MySQL
-   Cloudinary Account (Free tier)

### Step-by-Step

1. **Clone Repository**

```bash
git clone https://github.com/TetewHeroez/ETS-web.git
cd ETS-web
```

2. **Install Dependencies**

```bash
composer install
npm install
```

3. **Setup Environment**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi Database & Cloudinary** (edit `.env`)

```env
# Database (Aiven Cloud atau Local)
DB_CONNECTION=mysql
DB_HOST=your-host.aivencloud.com
DB_PORT=13530
DB_DATABASE=defaultdb
DB_USERNAME=your-username
DB_PASSWORD=your-password

# Cloudinary Configuration
CLOUDINARY_CLOUD_NAME=your-cloud-name
CLOUDINARY_API_KEY=your-api-key
CLOUDINARY_API_SECRET=your-api-secret
CLOUDINARY_URL=cloudinary://api_key:api_secret@cloud_name
```

5. **Run Migration & Seeder**

```bash
php artisan migrate --seed
```

6. **Build Assets**

```bash
npm run build
# atau untuk development:
npm run dev
```

7. **Start Server**

```bash
php artisan serve
```

8. **Akses Aplikasi**

```
http://localhost:8000
```

### Default Login

```
Superadmin:
- Email: superadmin@himatika.its.ac.id
- Password: superadmin123

Admin:
- Email: admin@himatika.its.ac.id
- Password: admin123

Member:
- Email: member@himatika.its.ac.id
- Password: member123
```

---

## ⚙️ Konfigurasi

### Cloudinary Setup

1. **Buat Akun Cloudinary** (Free Tier)

    - Daftar: https://cloudinary.com/users/register_free
    - Dashboard: https://cloudinary.com/console

2. **Dapatkan Credentials**

    - Cloud Name: Terlihat di dashboard
    - API Key: Settings → Security → API Keys
    - API Secret: Settings → Security → API Keys

3. **Tambahkan ke `.env`**

```env
CLOUDINARY_CLOUD_NAME=dg71hpqya
CLOUDINARY_API_KEY=943565982761512
CLOUDINARY_API_SECRET=6-rASrAKEmaqPXa52wWwnn_IPNQ
CLOUDINARY_URL=cloudinary://943565982761512:6-rASrAKEmaqPXa52wWwnn_IPNQ@dg71hpqya
```

4. **Clear Config Cache**

```bash
php artisan config:clear
```

5. **Test Koneksi**

```
http://localhost:8000/test-cloudinary.php
```

### Database Configuration

#### Aiven Cloud (Production)

```env
DB_CONNECTION=mysql
DB_HOST=padamu-himatika-2024-tetewheroez.i.aivencloud.com
DB_PORT=13530
DB_DATABASE=defaultdb
DB_USERNAME=avnadmin
DB_PASSWORD=your-password
```

#### Local Development

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=myhimatika_db
DB_USERNAME=root
DB_PASSWORD=
```

---

## 📤 Upload Foto/PDF ke Cloudinary

### Fitur Upload yang Sudah Terimplementasi

#### ✅ Status Indicator Real-time

**1. Validasi File (Saat Pilih File)**

```
✅ Siap diupload: profile.jpg (256 KB) - Klik "Simpan Perubahan" untuk upload ke Cloudinary
❌ Gagal: File terlalu besar (3.5MB). Maksimal 2MB.
❌ Gagal: Format file tidak valid. Hanya JPG, PNG, atau GIF yang diizinkan.
```

**2. Status Upload (Saat Submit)**

```
⏳ Sedang mengupload ke Cloudinary... Mohon tunggu, jangan tutup halaman ini.
[Tombol: 🔄 Mengupload ke Cloudinary...] (disabled)
```

**3. Hasil Upload**

-   **Berhasil**: Redirect ke halaman profil dengan foto baru
-   **Gagal**: Error message detail dengan icon alert:
    ```
    ⚠️ Gagal upload foto ke Cloudinary: Connection timeout
    ⚠️ Gagal upload foto ke Cloudinary: Cloudinary configuration not found
    ⚠️ Gagal upload foto ke Cloudinary: Invalid credentials
    ```

### Cara Testing Upload

#### 1. Test Konfigurasi

```
http://localhost:8000/test-cloudinary.php
```

**Harus muncul:**

-   ✅ Cloudinary Config OK!
-   ✅ Koneksi ke Cloudinary API Berhasil!

#### 2. Test Upload di Edit Profil

**Step 1: Pilih File**

-   Buka: http://localhost:8000/profile/edit
-   Klik "Choose File" di form Foto Profil
-   Pilih foto (max 2MB, format JPG/PNG/GIF)

**Step 2: Lihat Validasi**

-   ✅ File valid → Status hijau: "✅ Siap diupload..."
-   ❌ File invalid → Status merah: "❌ Gagal: ..." + input clear otomatis

**Step 3: Submit Form**

-   Klik tombol "Simpan Perubahan"
-   Tombol berubah: Disabled + Spinner + "Mengupload ke Cloudinary..."
-   Status text: "⏳ Sedang mengupload ke Cloudinary..."

**Step 4: Cek Hasil**

-   **Berhasil**: Redirect ke `/profile` dengan foto baru
-   **Gagal**: Tetap di halaman dengan error message

#### 3. Cek Log (Jika Gagal)

**Windows PowerShell:**

```powershell
Get-Content "storage/logs/laravel.log" -Tail 50
```

**Linux/Mac:**

```bash
tail -f storage/logs/laravel.log
```

**Cari keyword:**

-   `Cloudinary config loaded` → Config berhasil dimuat
-   `Profile photo upload started` → Info file yang diupload
-   `Profile photo uploaded successfully` → URL Cloudinary
-   `Failed to upload profile photo` → Error detail + stack trace

### File-File yang Terlibat

```
resources/views/profile/edit.blade.php
├── Input file dengan ID: profile_photo_member / profile_photo_admin
├── Status element: <p id="file-info-member">
└── Error display: @error('profile_photo')

public/js/profile-upload.js
├── validateAndPreviewFile() → Validasi ukuran & format
└── Form submit handler → Loading state

app/Http/Controllers/ProfileController.php
├── Validasi: 'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
├── Upload ke Cloudinary dengan transformasi
├── Auto-delete foto lama
└── Enhanced logging & error handling

public/test-cloudinary.php
└── Test page untuk verify config & koneksi
```

---

## 🐛 Troubleshooting

### ❌ "Gagal upload foto ke Cloudinary: Trying to access array offset on null"

**Penyebab**: Cloudinary config tidak dimuat atau response invalid

**Solusi**:

```bash
# 1. Cek .env
cat .env | grep CLOUDINARY

# 2. Clear cache
php artisan config:clear
php artisan cache:clear

# 3. Restart server
php artisan serve

# 4. Test config
php artisan tinker
>>> config('cloudinary.cloud_name')
=> "dg71hpqya"
```

**Jika masih null, pastikan `.env` ada:**

```env
CLOUDINARY_CLOUD_NAME=dg71hpqya
CLOUDINARY_API_KEY=943565982761512
CLOUDINARY_API_SECRET=6-rASrAKEmaqPXa52wWwnn_IPNQ
```

### ❌ "Gagal upload foto ke Cloudinary: Connection timeout"

**Penyebab**: Internet lambat atau Cloudinary down

**Solusi**:

1. Cek koneksi internet
2. Test ping: `ping api.cloudinary.com`
3. Coba upload file lebih kecil
4. Cek status Cloudinary: https://status.cloudinary.com

### ❌ "Gagal upload foto ke Cloudinary: Invalid credentials"

**Penyebab**: API Key atau Secret salah

**Solusi**:

1. Login ke Cloudinary Dashboard
2. Settings → Security → API Keys
3. Copy credentials yang benar
4. Update `.env`:

```env
CLOUDINARY_API_KEY=your-correct-api-key
CLOUDINARY_API_SECRET=your-correct-api-secret
```

5. Run: `php artisan config:clear`
6. Restart server

### ❌ "Gagal upload foto ke Cloudinary: Cloudinary configuration not found"

**Penyebab**: File `config/cloudinary.php` tidak ada atau corrupt

**Solusi**:

```bash
# Reinstall package
composer remove cloudinary-labs/cloudinary-laravel
composer require cloudinary-labs/cloudinary-laravel

# Publish config
php artisan vendor:publish --provider="CloudinaryLabs\CloudinaryLaravel\CloudinaryServiceProvider"

# Clear cache
php artisan config:clear
```

### ❌ File terlalu besar

**Penyebab**: File > 2MB

**Solusi**:

-   Compress foto (tinypng.com, squoosh.app)
-   Atau ubah limit di `ProfileController.php`:

```php
'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120' // 5MB
```

### ❌ Status indicator tidak muncul

**Penyebab**: JavaScript tidak load

**Solusi**:

1. Cek console browser (F12)
2. Pastikan `public/js/profile-upload.js` exists
3. Hard refresh: Ctrl+Shift+R (Windows) / Cmd+Shift+R (Mac)
4. Clear Laravel cache: `php artisan cache:clear`

### ❌ Upload sukses tapi foto tidak muncul

**Penyebab**: Old local storage URL masih di database

**Solusi**:

```bash
php artisan profile:clean-old-photos
```

### ❌ Error 500 saat upload

**Penyebab**: PHP memory limit atau timeout

**Solusi**:

**Edit `php.ini`:**

```ini
upload_max_filesize = 10M
post_max_size = 10M
memory_limit = 256M
max_execution_time = 300
```

**Atau tambah di `.htaccess`:**

```apache
php_value upload_max_filesize 10M
php_value post_max_size 10M
php_value memory_limit 256M
```

---

## 📚 Extend untuk Upload PDF

Untuk menambahkan upload PDF (rapor, transkrip, surat, dll):

### 1. Migration

```bash
php artisan make:migration add_documents_to_users_table
```

```php
// database/migrations/xxxx_add_documents_to_users_table.php
public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('rapor_pdf')->nullable();
        $table->string('transkrip_pdf')->nullable();
        $table->string('ktp_pdf')->nullable();
    });
}
```

Run: `php artisan migrate`

### 2. Update Model

```php
// app/Models/User.php
protected $fillable = [
    'rapor_pdf',
    'transkrip_pdf',
    'ktp_pdf',
    // ... existing fields
];
```

### 3. Update Controller Validation

```php
// app/Http/Controllers/ProfileController.php
'rapor_pdf' => 'nullable|mimes:pdf|max:5120', // 5MB
'transkrip_pdf' => 'nullable|mimes:pdf|max:5120',
```

### 4. Upload Logic

```php
// Handle PDF upload
if ($request->hasFile('rapor_pdf') && $request->file('rapor_pdf')->isValid()) {
    try {
        $uploadedFile = Cloudinary::upload($request->file('rapor_pdf')->getRealPath(), [
            'folder' => 'myhimatika/documents',
            'resource_type' => 'raw', // PENTING: untuk PDF/DOC
            'format' => 'pdf'
        ]);

        $validated['rapor_pdf'] = $uploadedFile->getSecurePath();
    } catch (\Exception $e) {
        \Log::error('Failed to upload PDF: ' . $e->getMessage());
        return redirect()->back()->withErrors(['rapor_pdf' => 'Gagal upload PDF: ' . $e->getMessage()]);
    }
}
```

### 5. Update View

```blade
{{-- resources/views/profile/edit.blade.php --}}
<div>
    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">
        Rapor (PDF)
    </label>
    <input type="file" name="rapor_pdf" id="rapor_pdf" accept=".pdf"
        class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg ..."
        onchange="validateAndPreviewPDF(this, 'rapor')">
    <p id="pdf-info-rapor" class="text-xs text-slate-500 dark:text-slate-400 mt-1">
        PDF (max 5MB)
    </p>
    @error('rapor_pdf')
        <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
            <i data-feather="alert-circle" class="w-4 h-4"></i>
            {{ $message }}
        </p>
    @enderror
</div>
```

### 6. Update JavaScript

```javascript
// public/js/profile-upload.js
function validateAndPreviewPDF(input, section) {
    const file = input.files[0];
    const fileInfo = document.getElementById(`pdf-info-${section}`);

    if (!file) {
        fileInfo.textContent = "PDF (max 5MB)";
        fileInfo.className = "text-xs text-slate-500 dark:text-slate-400 mt-1";
        return;
    }

    const maxSize = 5 * 1024 * 1024; // 5MB
    if (file.size > maxSize) {
        fileInfo.innerHTML =
            "❌ <strong>Gagal:</strong> File terlalu besar. Maksimal 5MB.";
        fileInfo.className =
            "text-xs text-red-600 dark:text-red-400 mt-1 font-medium";
        input.value = "";
        return;
    }

    if (file.type !== "application/pdf") {
        fileInfo.innerHTML =
            "❌ <strong>Gagal:</strong> Hanya file PDF yang diizinkan.";
        fileInfo.className =
            "text-xs text-red-600 dark:text-red-400 mt-1 font-medium";
        input.value = "";
        return;
    }

    const sizeKB = (file.size / 1024).toFixed(2);
    fileInfo.innerHTML =
        "✅ <strong>Siap diupload:</strong> " +
        file.name +
        " (" +
        sizeKB +
        " KB)";
    fileInfo.className =
        "text-xs text-green-600 dark:text-green-400 mt-1 font-medium";
}
```

---

## 📊 Cloudinary Quota Monitor

### Free Tier Limits

-   ✅ Storage: 25 GB
-   ✅ Bandwidth: 25 GB/month
-   ✅ Transformations: 25,000 credits/month

### Cara Cek Usage

1. Login: https://cloudinary.com/console
2. Dashboard → Usage
3. Monitor:
    - Storage used (GB)
    - Bandwidth (GB/month)
    - Transformation credits

### Tips Hemat Quota

-   Compress foto sebelum upload
-   Gunakan transformations (auto-quality, auto-format)
-   Hapus foto lama yang tidak terpakai:

```bash
php artisan profile:clean-old-photos
```

-   Set auto-delete untuk file temporary

### Upgrade Plan (Jika Perlu)

-   **Plus Plan**: $99/bulan → 100 GB storage, 100 GB bandwidth
-   **Advanced Plan**: $249/bulan → 300 GB storage, 300 GB bandwidth
-   Info: https://cloudinary.com/pricing

---

## 🚀 Deployment

### Pre-Deployment Checklist

```bash
# 1. Update .env untuk production
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# 2. Clear & cache config
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 3. Optimize autoloader
composer install --optimize-autoloader --no-dev

# 4. Build assets
npm run build

# 5. Set permissions (Linux)
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# 6. Test upload
# Buka: https://your-domain.com/test-cloudinary.php
```

### Environment Variables (Production)

```env
APP_NAME="MyHIMATIKA"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://myhimatika.himatika.its.ac.id

DB_CONNECTION=mysql
DB_HOST=your-prod-host.aivencloud.com
DB_PORT=13530
DB_DATABASE=myhimatika_production
DB_USERNAME=your-prod-user
DB_PASSWORD=your-prod-password

CLOUDINARY_CLOUD_NAME=dg71hpqya
CLOUDINARY_API_KEY=943565982761512
CLOUDINARY_API_SECRET=6-rASrAKEmaqPXa52wWwnn_IPNQ

SESSION_DRIVER=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
```

### Deploy ke cPanel

1. **Upload Files**

    - Zip project: `zip -r myhimatika.zip . -x "node_modules/*" -x ".git/*"`
    - Upload via File Manager atau FTP
    - Extract di `public_html/myhimatika`

2. **Setup Database**

    - Create database di cPanel → MySQL Databases
    - Import SQL atau run migration:

    ```bash
    php artisan migrate --force
    ```

3. **Configure .env**

    - Copy `.env.example` to `.env`
    - Update database credentials
    - Generate key: `php artisan key:generate`

4. **Set Public Directory**

    - cPanel → Domains → Setup
    - Document Root: `/home/username/public_html/myhimatika/public`

5. **Test Upload**
    - Buka: `https://your-domain.com/test-cloudinary.php`
    - Test upload foto di `/profile/edit`

### Deploy ke VPS (Ubuntu)

```bash
# 1. Clone repository
git clone https://github.com/TetewHeroez/ETS-web.git
cd ETS-web

# 2. Install dependencies
composer install --optimize-autoloader --no-dev
npm install && npm run build

# 3. Setup .env
cp .env.example .env
nano .env  # Edit database & cloudinary config

# 4. Generate key
php artisan key:generate

# 5. Run migration
php artisan migrate --force

# 6. Set permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# 7. Setup Nginx/Apache
sudo nano /etc/nginx/sites-available/myhimatika
# Configure virtual host

# 8. Restart services
sudo systemctl restart nginx
sudo systemctl restart php8.2-fpm

# 9. Test upload
curl https://your-domain.com/test-cloudinary.php
```

### Monitoring Production

```bash
# Cek error log
tail -f storage/logs/laravel.log

# Cek Nginx/Apache log
tail -f /var/log/nginx/error.log

# Monitor upload
grep "Profile photo upload" storage/logs/laravel.log

# Check Cloudinary usage
# Login: https://cloudinary.com/console
```

---

## 🤝 Contributing

Kontribusi sangat diterima! Untuk berkontribusi:

1. Fork repository ini
2. Buat branch fitur: `git checkout -b feature/AmazingFeature`
3. Commit changes: `git commit -m 'Add some AmazingFeature'`
4. Push ke branch: `git push origin feature/AmazingFeature`
5. Buat Pull Request

### Coding Standards

-   Follow PSR-12 coding standard
-   Write clear commit messages
-   Add comments untuk kode kompleks
-   Test sebelum push

---

## 📞 Support & Contact

**Developer**: Teosofi Hidayah Agung (Tetew)
**Organization**: HIMATIKA ITS 2024/2025
**Repository**: https://github.com/TetewHeroez/ETS-web

### Useful Links

-   Cloudinary Dashboard: https://cloudinary.com/console
-   Laravel Docs: https://laravel.com/docs/11.x
-   Tailwind CSS: https://tailwindcss.com/docs
-   Feather Icons: https://feathericons.com

---

## 📜 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 🙏 Acknowledgments

-   Laravel Framework
-   Cloudinary for CDN storage
-   Aiven for MySQL hosting
-   HIMATIKA ITS 2024/2025

---

**Last Updated**: October 24, 2025  
**Version**: 1.0.0  
**Status**: Production Ready ✅

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
