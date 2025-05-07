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
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
           
            @foreach($watchlistMovies as $movie)
                <div class="bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <a href="{{ route('movies.show', ['id'=>$movie['tmdb_id']]) }}">
                        <img src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}" alt="{{ $movie['title'] }}" class="w-full h-72 object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-white truncate">{{ $movie['title'] }}</h3>
                            <p class="text-sm text-gray-400 mt-1">{{ \Carbon\Carbon::parse($movie['release_date'])->format('Y') }}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
