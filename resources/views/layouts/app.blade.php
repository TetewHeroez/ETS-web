<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MyPH')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v={{ time() }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tailwind Config -->
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Poppins', 'Inter', 'system-ui', 'sans-serif'],
                        'heading': ['Poppins', 'system-ui', 'sans-serif'],
                        'body': ['Inter', 'system-ui', 'sans-serif'],
                        'mono': ['JetBrains Mono', 'Menlo', 'Monaco', 'monospace'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>

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
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark')
                localStorage.theme = 'light'
            } else {
                document.documentElement.classList.add('dark')
                localStorage.theme = 'dark'
            }
        }
    </script>

    @stack('styles')
    <style>
        /* Main content wrapper */
        .main-content-wrapper {
            padding-top: 4rem;
        }

        /* Desktop sidebar margin */
        @media (min-width: 768px) {
            .main-content-wrapper {
                margin-left: 16rem;
            }
        }

        /* Geometric decorations */
        .geometric-bg {
            background-image:
                radial-gradient(circle at 25% 25%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(139, 92, 246, 0.1) 0%, transparent 50%);
        }

        .geometric-pattern {
            background-image:
                linear-gradient(45deg, transparent 25%, rgba(59, 130, 246, 0.05) 25%, rgba(59, 130, 246, 0.05) 50%, transparent 50%, transparent 75%, rgba(59, 130, 246, 0.05) 75%),
                linear-gradient(-45deg, transparent 25%, rgba(139, 92, 246, 0.05) 25%, rgba(139, 92, 246, 0.05) 50%, transparent 50%, transparent 75%, rgba(139, 92, 246, 0.05) 75%);
            background-size: 20px 20px;
        }
    </style>

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
