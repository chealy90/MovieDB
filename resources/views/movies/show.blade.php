@extends('layouts.app')

@section('title', $movie['title'])

@section('content')
    <div class="max-w-7xl mx-auto">
        <a href="{{ route('movies.index') }}" class="inline-block mb-6 text-blue-600 hover:text-blue-800">
            &larr; Back to Popular Movies
        </a>

        <div class="bg-white rounded-2xl shadow-md overflow-hidden">
            <div class="md:flex">
                <!-- Movie Poster -->
                <div class="md:w-1/3">
                    @if ($movie['poster_path'])
                        <img
                            src="https://image.tmdb.org/t/p/w500{{ $movie['poster_path'] }}"
                            alt="{{ $movie['title'] }}"
                            class="w-full h-auto object-cover"
                        >
                    @else
                        <div class="w-full h-96 bg-gray-300 flex items-center justify-center text-gray-500">
                            No Image Available
                        </div>
                    @endif
                </div>

                <!-- Movie Details -->
                <div class="p-6 md:w-2/3">
                    <h1 class="text-3xl font-bold mb-2">{{ $movie['title'] }}</h1>

                    <div class="flex items-center mb-4">
                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                        {{ $movie['release_date'] ? substr($movie['release_date'], 0, 4) : 'N/A' }}
                    </span>
                        <span class="mx-2">•</span>
                        <span>{{ $movie['runtime'] ?? 'N/A' }} mins</span>
                        <span class="mx-2">•</span>
                        <span>
                        @foreach ($movie['genres'] as $genre)
                                {{ $genre['name'] }}@if (!$loop->last), @endif
                            @endforeach
                    </span>
                    </div>

                    <div class="flex items-center mb-4">
                    <span class="text-yellow-500 text-xl font-bold">
                        ★ {{ number_format($movie['vote_average'], 1) }}/10
                    </span>
                        <span class="text-gray-600 ml-2">({{ $movie['vote_count'] }} votes)</span>
                    </div>

                    <h2 class="text-xl font-semibold mb-2">Overview</h2>
                    <p class="text-gray-700 mb-6">{{ $movie['overview'] ?? 'No overview available.' }}</p>

                    @if (!empty($movie['credits']['crew']))
                        <h2 class="text-xl font-semibold mb-2">Director</h2>
                        <p class="text-gray-700 mb-6">
                            @foreach ($movie['credits']['crew'] as $crew)
                                @if ($crew['job'] === 'Director')
                                    {{ $crew['name'] }}@if (!$loop->last), @endif
                                @endif
                            @endforeach
                        </p>
                    @endif

                    @if (!empty($movie['credits']['cast']))
                        <h2 class="text-xl font-semibold mb-2">Cast</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @foreach (array_slice($movie['credits']['cast'], 0, 8) as $cast)
                                <div>
                                    <p class="font-medium">{{ $cast['name'] }}</p>
                                    <p class="text-sm text-gray-600">{{ $cast['character'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
