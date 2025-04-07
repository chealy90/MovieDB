@extends('layouts.app')

@section('title', 'Popular Movies')

@section('content')
    <div class="py-8">
        <!-- Page Header -->
        <div class="container mx-auto px-4 mb-10">
            <h1 class="text-4xl font-bold text-white text-center md:text-left">
                <span class="gradient-text">Popular Movies</span>
            </h1>

            <!-- Sorting/Filtering Options -->
            <div class="flex flex-col md:flex-row justify-between items-center mt-6 gap-4">
                <div class="flex space-x-3">
                    <button class="px-4 py-2 rounded-full bg-movie-primary text-white hover:bg-opacity-80 transition-all flex items-center">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                    <div class="relative">
                        <select class="appearance-none bg-movie-primary text-white px-4 py-2 pr-8 rounded-full focus:outline-none focus:ring-1 focus:ring-cyan-500 text-sm">
                            <option>Sort by Popularity</option>
                            <option>Sort by Rating</option>
                            <option>Sort by Release Date</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400 text-xs pointer-events-none"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Movie Grid -->
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-6">
                @foreach ($movies as $movie)
                    <a href="{{ route('movies.show', $movie['id']) }}" class="group relative rounded-xl overflow-hidden transition-all duration-300 hover:transform hover:scale-105 hover:shadow-2xl">
                        <div class="relative pb-[150%]">
                            @if ($movie['poster_path'])
                                <img
                                    src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}"
                                    alt="{{ $movie['title'] }}"
                                    class="absolute h-full w-full object-cover"
                                    loading="lazy"
                                >
                            @else
                                <div class="absolute h-full w-full bg-gray-800 flex items-center justify-center text-gray-500">
                                    <i class="fas fa-image text-4xl"></i>
                                </div>
                            @endif

                            <!-- Mobile: Always show basic info -->
                            <div class="md:hidden absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent">
                                <div class="absolute bottom-0 left-0 right-0 p-3">
                                    <h3 class="text-white font-bold text-sm truncate">{{ $movie['title'] }}</h3>
                                    <div class="flex justify-between items-center text-xs">
                                <span class="text-movie-accent font-medium">
                                    <i class="fas fa-star mr-1"></i>{{ number_format($movie['vote_average'], 1) }}
                                </span>
                                        <span class="text-gray-300">
                                    {{ $movie['release_date'] ? substr($movie['release_date'], 0, 4) : 'N/A' }}
                                </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Desktop: Full details on hover only -->
                            <div class="hidden md:flex absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 items-end p-4">
                                <div class="w-full transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                                    <h3 class="text-white font-bold text-lg mb-1">{{ $movie['title'] }}</h3>
                                    <div class="flex justify-between items-center text-sm mb-3">
                                <span class="text-movie-accent font-medium">
                                    <i class="fas fa-star mr-1"></i>{{ number_format($movie['vote_average'], 1) }}
                                </span>
                                        <span class="text-gray-300">
                                    {{ $movie['release_date'] ? substr($movie['release_date'], 0, 4) : 'N/A' }}
                                </span>
                                    </div>
                                    <button class="w-full py-1.5 bg-gradient-to-r from-cyan-500 to-blue-500 text-white rounded-full text-sm font-medium hover:opacity-90 transition-opacity">
                                        <i class="fas fa-plus mr-1"></i> Watchlist
                                    </button>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Pagination -->
        <div class="container mx-auto px-4 mt-12">
            <div class="flex justify-center">
                <nav class="flex items-center space-x-2">
                    <a href="#" class="px-4 py-2 rounded-full bg-movie-primary text-white hover:bg-opacity-80">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <a href="#" class="px-4 py-2 rounded-full bg-gradient-to-r from-cyan-500 to-blue-500 text-white">1</a>
                    <a href="#" class="px-4 py-2 rounded-full bg-movie-primary text-white hover:bg-opacity-80">2</a>
                    <a href="#" class="px-4 py-2 rounded-full bg-movie-primary text-white hover:bg-opacity-80">3</a>
                    <span class="px-2 text-gray-400">...</span>
                    <a href="#" class="px-4 py-2 rounded-full bg-movie-primary text-white hover:bg-opacity-80">10</a>
                    <a href="#" class="px-4 py-2 rounded-full bg-movie-primary text-white hover:bg-opacity-80">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </nav>
            </div>
        </div>
    </div>
@endsection
