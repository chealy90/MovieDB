@extends('layouts.app')

@section('title', 'Search Results: ' . $query)

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-white mb-2">Search Results for "{{ $query }}"</h2>
            <p class="text-gray-400">{{ $total_results }} {{ Str::plural('movie', $total_results) }} found</p>

            @if($total_results > 0)
                <!-- Filters -->
                <form action="{{ route('movies.search') }}" method="GET" class="mt-4 flex flex-wrap gap-4 items-center">
                    <input type="hidden" name="query" value="{{ $query }}">

                    <!-- Genre Filter -->
                    <select name="genre" class="appearance-none bg-movie-primary text-white px-4 py-2 pr-8 rounded-full focus:outline-none focus:ring-1 focus:ring-cyan-500 text-sm">
                        <option value="">All Genres</option>
                        <option value="28" {{ request('genre') == '28' ? 'selected' : '' }}>Action</option>
                        <option value="12" {{ request('genre') == '12' ? 'selected' : '' }}>Adventure</option>
                        <option value="16" {{ request('genre') == '16' ? 'selected' : '' }}>Animation</option>
                        <option value="35" {{ request('genre') == '35' ? 'selected' : '' }}>Comedy</option>
                        <option value="80" {{ request('genre') == '80' ? 'selected' : '' }}>Crime</option>
                        <option value="99" {{ request('genre') == '99' ? 'selected' : '' }}>Documentary</option>
                        <option value="18" {{ request('genre') == '18' ? 'selected' : '' }}>Drama</option>
                        <option value="10751" {{ request('genre') == '10751' ? 'selected' : '' }}>Family</option>
                        <option value="14" {{ request('genre') == '14' ? 'selected' : '' }}>Fantasy</option>
                        <option value="36" {{ request('genre') == '36' ? 'selected' : '' }}>History</option>
                        <option value="27" {{ request('genre') == '27' ? 'selected' : '' }}>Horror</option>
                        <option value="10402" {{ request('genre') == '10402' ? 'selected' : '' }}>Music</option>
                        <option value="9648" {{ request('genre') == '9648' ? 'selected' : '' }}>Mystery</option>
                        <option value="10749" {{ request('genre') == '10749' ? 'selected' : '' }}>Romance</option>
                        <option value="878" {{ request('genre') == '878' ? 'selected' : '' }}>Science Fiction</option>
                        <option value="10770" {{ request('genre') == '10770' ? 'selected' : '' }}>TV Movie</option>
                        <option value="53" {{ request('genre') == '53' ? 'selected' : '' }}>Thriller</option>
                        <option value="10752" {{ request('genre') == '10752' ? 'selected' : '' }}>War</option>
                        <option value="37" {{ request('genre') == '37' ? 'selected' : '' }}>Western</option>
                    </select>

                    <!-- Release Year Filter -->
                    <select name="year" class="appearance-none bg-movie-primary text-white px-4 py-2 pr-8 rounded-full focus:outline-none focus:ring-1 focus:ring-cyan-500 text-sm">
                        <option value="">All Years</option>
                        @for ($i = date('Y'); $i >= 2000; $i--)
                            <option value="{{ $i }}" {{ request('year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>

                    <!-- Sorting Options -->
                    <select name="sort" class="appearance-none bg-movie-primary text-white px-4 py-2 pr-8 rounded-full focus:outline-none focus:ring-1 focus:ring-cyan-500 text-sm">
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Sort by Rating</option>
                        <option value="release_date" {{ request('sort') == 'release_date' ? 'selected' : '' }}>Sort by Release Date</option>
                    </select>

                    <button type="submit" class="px-4 py-2 rounded-full bg-cyan-500 text-white hover:bg-cyan-600 transition-all">
                        Apply Filters
                    </button>
                </form>
            @endif
        </div>

        @if($total_results > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @foreach($movies as $movie)
                    <div class="group relative rounded-xl overflow-hidden transition-all duration-300 hover:transform hover:scale-105 hover:shadow-2xl">
                        <a href="{{ route('movies.show', $movie['id']) }}" class="block">
                            <div class="relative pb-[150%]">
                                @if($movie['poster_path'])
                                    <img
                                            src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}"
                                            alt="{{ $movie['title'] }}"
                                            class="absolute h-full w-full object-cover"
                                            loading="lazy"
                                    >
                                @else
                                    <div class="absolute h-full w-full bg-gray-700 flex items-center justify-center text-gray-500">
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
                                    {{ isset($movie['release_date']) ? substr($movie['release_date'], 0, 4) : 'N/A' }}
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
                                    {{ isset($movie['release_date']) ? substr($movie['release_date'], 0, 4) : 'N/A' }}
                                </span>
                                        </div>
                                        <button class="w-full py-1.5 bg-gradient-to-r from-cyan-500 to-blue-500 text-white rounded-full text-sm font-medium hover:opacity-90 transition-opacity">
                                            <i class="fas fa-plus mr-1"></i> Watchlist
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-gray-800 rounded-xl p-8 text-center max-w-2xl mx-auto">
                <i class="fas fa-search text-4xl text-gray-600 mb-4"></i>
                <h3 class="text-xl font-semibold text-white mb-2">No Movies Found</h3>
                <p class="text-gray-400 mb-6">We couldn't find any movies matching "{{ $query }}". Try adjusting your search terms.</p>

                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('movies.index') }}" class="px-6 py-2 bg-gradient-to-r from-cyan-500 to-blue-500 text-white rounded-full hover:opacity-90 transition-opacity">
                        Browse Popular Movies
                    </a>
                    <button onclick="window.history.back()" class="px-6 py-2 bg-gray-700 text-white rounded-full hover:bg-gray-600 transition-colors">
                        Go Back
                    </button>
                </div>
            </div>
        @endif
    </div>
@endsection
