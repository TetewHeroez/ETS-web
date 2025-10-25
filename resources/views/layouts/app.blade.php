<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MyHIMATIKA')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v={{ time() }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap"
        rel="stylesheet">

    <!-- Use local compiled assets via Vite (ensures resources/css/app.css is loaded) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])



    <!-- Feather Icons CDN -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- Dark Mode Script -->
    <script>
        // Check for saved theme preference or default to 'light'
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }

        // Theme toggle function
        function toggleTheme() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark')
                localStorage.theme = 'light'
            } else {
                html.classList.add('dark')
                localStorage.theme = 'dark'
            }

            // Update feather icons after theme change
            if (typeof feather !== 'undefined') {
                setTimeout(() => feather.replace(), 50);
            }
        }
    </script>

    @stack('styles')

</head>

<body class="@yield('body-class', 'bg-slate-50 dark:bg-slate-900 min-h-screen font-body text-slate-900 dark:text-slate-100 transition-colors duration-300')">
    @yield('content')

    <!-- Initialize Feather Icons -->
    <script>
        feather.replace()
    </script>

    @stack('scripts')
</body>

</html>
