<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ETS Web')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v={{ time() }}">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Feather Icons CDN -->
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }
    </style>

    @stack('styles')
</head>

<body class="@yield('body-class', 'bg-gray-50 min-h-screen')">
    @yield('content')

    <!-- Initialize Feather Icons -->
    <script>
        feather.replace()
    </script>

    @stack('scripts')
</body>

</html>
