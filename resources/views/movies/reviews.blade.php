@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <h2 class="text-2xl font-semibold text-white mb-6">Reviews for {{ $movie->title }}</h2>

    @if($reviews->count())
        <div class="space-y-6">
            @foreach($reviews as $review)
                <div class="bg-gray-800 p-5 rounded-lg shadow">
                    <div class="flex justify-between items-center mb-2">
                        <h4 class="text-white font-semibold">{{ $review->userName }}</h4>
                        <span class="text-yellow-400">
                            @for($i = 0; $i < $review->rating; $i++)
                                ★
                            @endfor
                        </span>
                    </div>
                    <p class="text-gray-300">{{ $review->description }}</p>
                    <p class="text-sm text-gray-500 mt-2">{{ $review->created_at->diffForHumans() }}</p>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $reviews->links() }}
        </div>
    @else
        <p class="text-gray-400 italic">No reviews yet for this movie.</p>
    @endif

    <div class="mt-6">
        <a href="{{ url("/movies/{$movie->tmdb_id}") }}" class="text-cyan-400 hover:underline">&larr; Back to Movie</a>
    </div>
</div>
@endsection
