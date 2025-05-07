@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-white mb-8 border-b border-cyan-500 pb-2">🎬 My Watchlist</h1>

        @if($watchlistMovies->isEmpty())
            <div class="text-center text-gray-400 mt-10">
                <p>Your watchlist is currently empty.</p>
                <p class="mt-2">Start adding movies to keep track of what you want to watch!</p>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach($watchlistMovies as $movie)
                    <div class="group relative rounded-xl overflow-hidden transition-all duration-300 hover:transform hover:scale-105 hover:shadow-2xl">
                        <a href="{{ route('movies.show', ['id' => $movie->tmdb_id]) }}" class="block">
                            <div class="relative pb-[150%]">
                                @if ($movie->poster_path)
                                    <img
                                        src="https://image.tmdb.org/t/p/w500{{ $movie->poster_path }}"
                                        alt="{{ $movie->title }}"
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
                                        <h3 class="text-white font-bold text-sm truncate">{{ $movie->title }}</h3>
                                        <div class="flex justify-between items-center text-xs">
                                        <span class="text-movie-accent font-medium">
                                            <i class="fas fa-star mr-1"></i>{{ number_format($movie->rating, 1) }}
                                        </span>
                                            <span class="text-gray-300">
                                            {{ $movie->release_year ?? 'N/A' }}
                                        </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Desktop: Full details on hover only -->
                                <div class="hidden md:flex absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 items-end p-4">
                                    <div class="w-full transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                                        <h3 class="text-white font-bold text-lg mb-1">{{ $movie->title }}</h3>
                                        <div class="flex justify-between items-center text-sm mb-3">
                                        <span class="text-movie-accent font-medium">
                                            <i class="fas fa-star mr-1"></i>{{ number_format($movie->rating, 1) }}
                                        </span>
                                            <span class="text-gray-300">
                                            {{ $movie->release_year ?? 'N/A' }}
                                        </span>
                                        </div>
                                        <p class="text-gray-400 text-sm mb-2">Added on: {{ \Carbon\Carbon::parse($movie->pivot->created_at)->format('M d, Y') }}</p>

                                        <!-- Remove from Watchlist Button -->
                                        <form action="{{ route('watchlist.remove', ['movie' => $movie->tmdb_id, 'user' => auth()->user()->id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full py-1.5 bg-gradient-to-r from-red-500 to-pink-500 text-white rounded-full text-sm font-medium hover:opacity-90 transition-opacity">
                                                <i class="fas fa-minus mr-1"></i> Remove from Watchlist
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
