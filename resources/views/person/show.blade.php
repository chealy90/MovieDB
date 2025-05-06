@extends('layouts.app')

@section('title', $person['name'])

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="md:flex md:gap-8">
            <!-- Movies Section -->
            <div class="md:w-2/3">
                <h2 class="text-2xl font-bold text-white mb-6">Movies</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                    @foreach ($movies as $movie)
                        <div class="group relative rounded-xl overflow-hidden transition-all duration-300 hover:transform hover:scale-105 hover:shadow-2xl">
                            <a href="{{ route('movies.show', $movie['id']) }}" class="block">
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
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>

                                    <!-- Mobile: Always show basic info -->
                                    <div
                                        class="md:hidden absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent">
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
                                    <div
                                        class="hidden md:flex absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 items-end p-4">
                                        <div
                                            class="w-full transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                                            <h3 class="text-white font-bold text-lg mb-1">{{ $movie['title'] }}</h3>
                                            <div class="flex justify-between items-center text-sm mb-3">
                                                <span class="text-movie-accent font-medium">
                                                    <i class="fas fa-star mr-1"></i>{{ number_format($movie['vote_average'], 1) }}
                                                </span>
                                                <span class="text-gray-300">
                                                    {{ $movie['release_date'] ? substr($movie['release_date'], 0, 4) : 'N/A' }}
                                                </span>
                                            </div>
                                            <button
                                                class="w-full py-1.5 bg-gradient-to-r from-cyan-500 to-blue-500 text-white rounded-full text-sm font-medium hover:opacity-90 transition-opacity">
                                                <i class="fas fa-plus mr-1"></i> Watchlist
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Person Details Section -->
            <div class="md:w-1/3 mt-8 md:mt-0">
                <div class="bg-gray-800 rounded-2xl shadow-xl p-6 border border-gray-700">
                    <div class="w-full h-64 rounded-lg bg-gray-700 flex items-center justify-center text-gray-500 mb-6">
                        @if ($person['profile_path'])
                            <img
                                src="https://image.tmdb.org/t/p/w500{{ $person['profile_path'] }}"
                                alt="{{ $person['name'] }}"
                                class="w-full h-full rounded-lg object-cover">
                        @else
                            <i class="fas fa-user text-6xl"></i>
                        @endif
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-4">{{ $person['name'] }}</h1>
                    <p class="text-gray-400 leading-relaxed">{{ $person['biography'] ?? 'Biography not available.' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
