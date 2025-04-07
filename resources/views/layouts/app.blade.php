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

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Poppins', sans-serif;
        }
        .bg-movie-dark {
            background-color: #0f0c29;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
        }
        .bg-movie-primary {
            background-color: #1a1a2e;
        }
        .text-movie-accent {
            color: #00dbde;
        }
        .hover\:text-movie-accent:hover {
            color: #00dbde;
        }
        .gradient-text {
            background: linear-gradient(90deg, #00dbde 0%, #fc00ff 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .search-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .nav-link {
            position: relative;
        }
        .nav-link:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background: linear-gradient(90deg, #00dbde 0%, #fc00ff 100%);
            transition: width 0.3s ease;
        }
        .nav-link:hover:after {
            width: 100%;
        }
        .user-avatar {
            transition: all 0.3s ease;
        }
        .user-avatar:hover {
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(0, 219, 222, 0.5);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen antialiased leading-none">
<div id="app" x-data="{ mobileMenuOpen: false, userMenuOpen: false }">
    <!-- Header -->
    <header class="bg-movie-dark shadow-xl sticky top-0 z-50">
        @include('layouts.header')
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-movie-dark text-white">
        @include('layouts.footer')
    </footer>
</div>
</body>
</html>
