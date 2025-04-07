<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Popular Movies</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
<div class="max-w-7xl mx-auto">
    <h1 class="text-3xl font-bold mb-6 text-center">Popular Movies</h1>

    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
        @foreach ($movies as $movie)
            <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:scale-105 transition">
                @if ($movie->poster_path)
                    <img
                        src="{{ asset($movie->poster_path) }}"
                        alt="{{ $movie->title }}"
                        class="w-full h-72 object-cover"
                    >
                @else
                    <div class="w-full h-72 bg-gray-300 flex items-center justify-center text-gray-500">
                        No Image
                    </div>
                @endif
                <div class="p-4">
                    <h2 class="text-lg font-semibold">{{ $movie->title }}</h2>
                    <p class="text-sm text-gray-600">Released: {{ $movie->release_year ?? 'N/A' }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
