<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        .bg-movie-dark {
            background-color: #0f172a;
        }
        .bg-movie-primary {
            background-color: #1e293b;
        }
        .text-movie-accent {
            color: #f59e0b;
        }
        .hover\:text-movie-accent:hover {
            color: #f59e0b;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen antialiased leading-none font-sans">
<div id="app" x-data="{ mobileMenuOpen: false, userMenuOpen: false }">
    <!-- Header -->
    <header class="bg-movie-dark shadow-lg sticky top-0 z-50">
        @include('layouts.header')
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-movie-dark text-white py-8">
       @include('layouts.footer')
    </footer>
</div>
</body>
</html>
