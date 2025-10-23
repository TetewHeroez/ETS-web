# Dark Mode Implementation Guide

## ✅ Completed:

### 1. **Font Setup**

-   ✅ Added Google Fonts: Inter (body) & Poppins (headings)
-   ✅ Configured in `layouts/app.blade.php`

### 2. **Dark Mode Core**

-   ✅ Added dark mode script in `layouts/app.blade.php`
-   ✅ LocalStorage persistence
-   ✅ Auto-detect system preference
-   ✅ Toggle function `toggleDarkMode()`

### 3. **Background Colors**

-   ✅ Changed from `bg-gray-50` to `bg-slate-50 dark:bg-slate-900`
-   ✅ Text colors: `text-slate-900 dark:text-slate-100`

### 4. **Components Updated**

-   ✅ Navbar: Added dark mode toggle button + geometric patterns
-   ✅ Sidebar: Added geometric background + dark mode colors
-   ✅ Login page: Slate background + dark mode support

## 📝 Pattern untuk Update Views:

### Background Classes:

```blade
<!-- OLD -->
bg-white
bg-gray-50
bg-gray-100

<!-- NEW -->
bg-white dark:bg-slate-800
bg-slate-50 dark:bg-slate-900
bg-slate-100 dark:bg-slate-800
```

### Text Classes:

```blade
<!-- OLD -->
text-gray-900
text-gray-700
text-gray-600

<!-- NEW -->
text-slate-900 dark:text-slate-100
text-slate-700 dark:text-slate-300
text-slate-600 dark:text-slate-400
```

### Border Classes:

```blade
<!-- OLD -->
border-gray-200
border-gray-300

<!-- NEW -->
border-slate-200 dark:border-slate-700
border-slate-300 dark:border-slate-600
```

### Card/Container Classes:

```blade
<!-- Standard Card -->
bg-white dark:bg-slate-800 shadow-lg dark:shadow-slate-900/50 rounded-lg

<!-- Gradient Cards -->
bg-gradient-to-r from-blue-500 to-blue-600 dark:from-slate-700 dark:to-slate-800
```

## 🎨 Recommended Color Palette:

### Primary Actions:

-   Light: `bg-blue-600 hover:bg-blue-700`
-   Dark: `dark:bg-blue-500 dark:hover:bg-blue-600`

### Success/Info:

-   Light: `bg-green-500`, `bg-cyan-400`
-   Dark: `dark:bg-green-600`, `dark:bg-cyan-600`

### Cards/Surfaces:

-   Light: `bg-white`
-   Dark: `dark:bg-slate-800`

### Background:

-   Light: `bg-slate-50`
-   Dark: `dark:bg-slate-900`

## 🔧 Files to Update:

### High Priority:

-   [x] `layouts/app.blade.php` - Core layout
-   [x] `components/navbar.blade.php` - Navigation bar
-   [x] `components/sidebar.blade.php` - Sidebar menu
-   [x] `auth/login.blade.php` - Login page
-   [ ] `dashboard.blade.php` - Main dashboard
-   [ ] `profile/show.blade.php` - Profile view
-   [ ] `profile/edit.blade.php` - Profile edit
-   [ ] `kpi/index.blade.php` - KPI page

### Medium Priority:

-   [ ] `attendances/index.blade.php`
-   [ ] `assignments/index.blade.php`
-   [ ] `submissions/table.blade.php`
-   [ ] `users/index.blade.php`

### Components:

-   [ ] All card components
-   [ ] All table components
-   [ ] All form components

## 🚀 Quick Implementation:

Add to any view file:

```blade
@section('content')
<div class="bg-slate-50 dark:bg-slate-900 min-h-screen transition-colors duration-300">
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <!-- Content with dark mode -->
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg p-6">
            <h1 class="text-2xl font-bold font-display text-slate-900 dark:text-slate-100">
                Title
            </h1>
            <p class="text-slate-600 dark:text-slate-400">Description</p>
        </div>
    </div>
</div>
@endsection
```

## 📱 Testing:

1. Check light mode (default)
2. Click dark mode toggle in navbar
3. Refresh page (should persist)
4. Check all components visibility
5. Test on mobile/tablet/desktop
