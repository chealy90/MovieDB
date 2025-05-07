@extends('layouts.app')

@section('title', $playlist->playlist_name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Playlist Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">{{ $playlist->playlist_name }}</h1>
        <p class="text-gray-400 text-sm mt-1">Created by <span class="text-white">{{ $user->name }}</span> on {{ $playlist->created_at->format('jS M Y') }}</p>
        @if ($playlist->description)
            <p class="text-gray-300 mt-4">{{ $playlist->description }}</p>
        @endif
    </div>

    <!-- Movie Cards -->
    <h2 class="text-2xl font-bold text-white mb-4">Movies in this Playlist</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
        @forelse ($movies as $movie)
            
            <div class="bg-gray-800 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200">
                <a href="{{ route('movies.show', ['id' => $movie->tmdb_id]) }}">
                    <img
                        src="https://image.tmdb.org/t/p/w500{{ $movie->poster_path }}"
                        alt="{{ $movie->title }}"
                        class="rounded-t-lg w-full h-72 object-cover">
                    <div class="p-4">
                        <h3 class="text-white text-lg font-semibold">{{ $movie->title }}</h3>
                        <p class="text-gray-400 text-sm mt-1">{{ \Carbon\Carbon::parse($movie->release_year)->format('Y') }}</p>
                    </div>
                </a>
            </div>
        @empty
            <p class="text-gray-400">This playlist doesn't have any movies yet.</p>
        @endforelse
    </div>
</div>
@endsection
