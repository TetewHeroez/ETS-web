# MyHIMATIKA - Padamu HIMATIKA ITS

**HIMATIKA ITS** stands for _Himpunan Mahasiswa Matematika ITS_ (Mathematics Student Association, Institut Teknologi Sepuluh Nopember, Indonesia). This is a comprehensive information management system for Cadreritation/Regeneration of HIMATIKA ITS, providing full-featured tools to manage member data, attendance, assignments, and scoring.

[![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind-v4-38bdf8.svg)](https://tailwindcss.com)
[![Cloudinary](https://img.shields.io/badge/Cloudinary-Enabled-3448c5.svg)](https://cloudinary.com)

---

## 📋 Table of Contents

-   [Key Features](#key-features)
-   [Tech Stack](#tech-stack)
-   [Installation](#installation)
-   [Configuration](#configuration)
-   [Cloudinary Upload (Photo/PDF)](#cloudinary-upload-photopdf)
-   [Troubleshooting](#troubleshooting)
-   [Deployment](#deployment)
-   [Contributing](#contributing)

---

## 🚀 Key Features

### 📊 Dashboard & Analytics

-   Interactive dashboard with real-time statistics
-   Visual charts for attendance, assignments, and member performance
-   Full dark mode support

### 👥 User Management

-   **Member**: Complete profile (personal data, address, parents, health)
-   **Admin**: Member data management, Excel import
-   **Superadmin**: Full system control

### 📸 Cloudinary Upload

-   ✅ Profile photo upload to Cloudinary CDN
-   ✅ Real-time validation (size, format)
-   ✅ Status indicators (loading, success, failure)
-   ✅ Auto-resize & optimization (500x500, auto-quality, WebP/AVIF)
-   ✅ Auto-delete old photos
-   📄 Ready to extend for PDF uploads (report cards, transcripts, etc.)

### 📅 Attendance Management

-   Check-in/check-out system
-   Attendance history per member
-   Export attendance reports

### 📝 Assignment & Submission

-   Assignment management with weighted scores
-   Submission upload with deadlines
-   Automatic scoring system

### 🎯 GDK (Cadreritation Grand Design)

-   Contract system
-   Flowchart of Methods
-   Visual hierarchy for task prioritization
-   Progress tracking

---

## 🛠️ Tech Stack

| Category            | Technology                                  |
| ------------------- | ------------------------------------------- |
| **Backend**         | Laravel 11.x (PHP 8.2+)                     |
| **Frontend**        | Blade Templates, Tailwind CSS v4, Alpine.js |
| **Database**        | MySQL (Aiven Cloud, PlanetScale, Railway)   |
| **Storage**         | Cloudinary CDN                              |
| **Icons**           | Feather Icons                               |
| **Package Manager** | Composer, npm                               |
| **Dev Tools**       | Laravel Tinker, Vite                        |

### Main Dependencies

````json
{
    "laravel/framework": "^11.0",
    "maatwebsite/excel": "^3.1",
    "cloudinary-labs/cloudinary-laravel": "^2.0"
}
````

## 📦 Installation

### Requirements

- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL
- Cloudinary Account (Free tier)

### Step-by-Step

1. **Clone the Repository**

```bash
git clone https://github.com/TetewHeroez/ETS-web.git
cd ETS-web


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

4. **Configure Database & Cloudinary** (edit `.env`)

```env
# Database (Aiven Cloud, PlanetScale, Railway, or Local)
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

5. **Run Migrations & Seeders**

```bash
php artisan migrate --seed
```

6. **Build Frontend Assets**

```bash
npm run build
# For development:
Member:
```

7. **Start the Server**

```bash
php artisan serve
```

8. **Access the Application**

```
http://localhost:8000
```

### Default Login Credentials

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

-   Email: member@himatika.its.ac.id
-   Password: member123

````

---


## ⚙️ Configuration

### Cloudinary Setup

1. **Create a Cloudinary Account** (Free Tier)
    - Register: https://cloudinary.com/users/register_free
    - Dashboard: https://cloudinary.com/console
2. **Get Your Credentials**
    - Cloud Name: Shown in dashboard
    - API Key: Settings → Security → API Keys
    - API Secret: Settings → Security → API Keys
3. **Add to `.env`**

```env
CLOUDINARY_CLOUD_NAME=your-cloud-name
CLOUDINARY_API_KEY=your-api-key
CLOUDINARY_API_SECRET=your-api-secret
CLOUDINARY_URL=cloudinary://api_key:api_secret@cloud_name
````

4. **Clear Config Cache**

```bash
php artisan config:clear
```

5. **Test Connection**

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

## 📤 Cloudinary Upload (Photo/PDF)

### Implemented Upload Features

#### ✅ Real-time Status Indicators

**1. File Validation (On File Selection)**

```
✅ Ready to upload: profile.jpg (256 KB) - Click "Save Changes" to upload to Cloudinary
❌ Failed: File too large (3.5MB). Maximum 2MB.
❌ Failed: Invalid file format. Only JPG, PNG, or GIF allowed.
```

**2. Upload Status (On Submit)**

```
⏳ Uploading to Cloudinary... Please wait, do not close this page.
[Button: 🔄 Uploading to Cloudinary...] (disabled)
```

**3. Upload Result**

-   **Success**: Redirects to profile page with new photo
-   **Failure**: Detailed error message with alert icon:
    ```
    ⚠️ Failed to upload photo to Cloudinary: Connection timeout
    ⚠️ Failed to upload photo to Cloudinary: Cloudinary configuration not found
    ⚠️ Failed to upload photo to Cloudinary: Invalid credentials
    ```

### How to Test Upload

#### 1. Test Configuration

```
http://localhost:8000/test-cloudinary.php
```

**Expected Output:**

-   ✅ Cloudinary Config OK!
-   ✅ Successfully connected to Cloudinary API!

#### 2. Test Upload in Edit Profile

**Step 1: Select File**

-   Open: http://localhost:8000/profile/edit
-   Click "Choose File" in the Profile Photo form
-   Select a photo (max 2MB, JPG/PNG/GIF)

**Step 2: View Validation**

-   ✅ Valid file → Green status: "✅ Ready to upload..."
-   ❌ Invalid file → Red status: "❌ Failed: ..." + input auto-cleared

**Step 3: Submit Form**

-   Click "Save Changes"
-   Button changes: Disabled + Spinner + "Uploading to Cloudinary..."
-   Status text: "⏳ Uploading to Cloudinary..."

**Step 4: Check Result**

-   **Success**: Redirects to `/profile` with new photo
-   **Failure**: Remains on page with error message

#### 3. Check Logs (If Failed)

**Windows PowerShell:**

```powershell
Get-Content "storage/logs/laravel.log" -Tail 50
```

**Linux/Mac:**

```bash
tail -f storage/logs/laravel.log
```

**Look for keywords:**

-   `Cloudinary config loaded` → Config loaded successfully
-   `Profile photo upload started` → Info about uploaded file
-   `Profile photo uploaded successfully` → Cloudinary URL
-   `Failed to upload profile photo` → Error details + stack trace

### Involved Files

```
resources/views/profile/edit.blade.php
├── Input file with ID: profile_photo_member / profile_photo_admin
├── Status element: <p id="file-info-member">
└── Error display: @error('profile_photo')

public/js/profile-upload.js
├── validateAndPreviewFile() → Size & format validation
└── Form submit handler → Loading state

app/Http/Controllers/ProfileController.php
├── Validation: 'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
├── Upload to Cloudinary with transformation
├── Auto-delete old photo
└── Enhanced logging & error handling

public/test-cloudinary.php
└── Test page to verify config & connection
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

````

'rapor_pdf' => 'nullable|mimes:pdf|max:5120', // 5MB

## 🚀 Deployment

### Pre-Deployment Checklist

```bash
# 1. Update .env for production
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
# Open: https://your-domain.com/test-cloudinary.php
````

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

CLOUDINARY_CLOUD_NAME=your-cloud-name
CLOUDINARY_API_KEY=your-api-key
CLOUDINARY_API_SECRET=your-api-secret
CLOUDINARY_URL=cloudinary://api_key:api_secret@cloud_name

SESSION_DRIVER=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
```

### Deploy to cPanel

1. **Upload Files**
    - Zip project: `zip -r myhimatika.zip . -x "node_modules/*" -x ".git/*"`
    - Upload via File Manager or FTP
    - Extract in `public_html/myhimatika`
2. **Setup Database**
    - Create database in cPanel → MySQL Databases
    - Import SQL or run migration:
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
    - Open: `https://your-domain.com/test-cloudinary.php`
    - Test photo upload at `/profile/edit`

### Deploy to VPS (Ubuntu)

```bash
# 1. Clone repository

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

````bash
# Check error log
```php

# Check Nginx/Apache log
// Handle PDF upload

# Monitor upload
if ($request->hasFile('rapor_pdf') && $request->file('rapor_pdf')->isValid()) {

# Check Cloudinary usage
# Login: https://cloudinary.com/console
````

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

````

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
````

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

### Quota Saving Tips

-   Compress photos before uploading
-   Use transformations (auto-quality, auto-format)
-   Delete unused old photos:

```bash
php artisan profile:clean-old-photos
```

-   Set auto-delete for temporary files

### Upgrade Plan (If Needed)

-   **Plus Plan**: $99/month → 100 GB storage, 100 GB bandwidth
-   **Advanced Plan**: $249/month → 300 GB storage, 300 GB bandwidth
-   More info: https://cloudinary.com/pricing

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

### Deploy to cPanel

1. **Upload Files**
    - Zip the project: `zip -r myhimatika.zip . -x "node_modules/*" -x ".git/*"`
    - Upload via File Manager or FTP
    - Extract in `public_html/myhimatika`
2. **Setup Database**
    - Create a database in cPanel → MySQL Databases
    - Import SQL or run migration:
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
    - Open: `https://your-domain.com/test-cloudinary.php`
    - Test photo upload at `/profile/edit`

### Deploy to VPS (Ubuntu)

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
# Check error log
tail -f storage/logs/laravel.log

# Check Nginx/Apache log
tail -f /var/log/nginx/error.log

# Monitor upload
grep "Profile photo upload" storage/logs/laravel.log

# Check Cloudinary usage
# Login: https://cloudinary.com/console
```

---

## 🤝 Contributing

Contributions are very welcome! To contribute:

1. Fork this repository
2. Create a feature branch: `git checkout -b feature/AmazingFeature`
3. Commit your changes: `git commit -m 'Add some AmazingFeature'`
4. Push to the branch: `git push origin feature/AmazingFeature`
5. Open a Pull Request

### Coding Standards

-   Follow the PSR-12 coding standard
-   Write clear commit messages
-   Add comments for complex code
-   Test before pushing

---

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
-   HIMATIKA ITS 2024/2025 (Mathematics Student Association, ITS)

---

**Last Updated**: October 28, 2025
**Version**: 1.0.0
**Status**: Production Ready ✅

## Code of Conduct

To ensure the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
