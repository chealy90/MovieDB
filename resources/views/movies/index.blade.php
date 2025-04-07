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
            <a href="{{ route('movies.show', $movie['id']) }}" class="block">
                <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:scale-105 transition">
                    @if ($movie['poster_path'])
                        <img
                            src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}"
                            alt="{{ $movie['title'] }}"
                            class="w-full h-72 object-cover"
                        >
                    @else
                        <div class="w-full h-72 bg-gray-300 flex items-center justify-center text-gray-500">
                            No Image
                        </div>
                    @endif
                    <div class="p-4">
                        <h2 class="text-lg font-semibold">{{ $movie['title'] }}</h2>
                        <p class="text-sm text-gray-600">Released: {{ $movie['release_date'] ? substr($movie['release_date'], 0, 4) : 'N/A' }}</p>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
</body>
</html>
