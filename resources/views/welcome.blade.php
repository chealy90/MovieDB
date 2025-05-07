@extends('layouts.app')

@section('title', 'MovieDB - Home')

@section('content')
<!-- Background Video -->
    <div class="relative h-screen w-full overflow-hidden">
        <video autoplay muted loop playsinline class="absolute top-0 left-0 w-full h-full object-cover">
            <source src="/movieClip.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <!-- Overlay -->
        <div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-50"></div>

        <!-- Centered Content -->
        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
            <h1 class="text-4xl text-gray-50 md:text-6xl font-bold mb-6 drop-shadow-lg">Discover Your Next Favorite Movie</h1>

            <form action="{{ route('movies.search') }}" method="GET" class="w-full max-w-xl">
                <input 
                    type="text" 
                    name="query" 
                    placeholder="Search for movies..." 
                    class="w-full px-6 py-3 rounded-full bg-white text-black text-lg shadow-md focus:outline-none focus:ring-2 focus:ring-red-600"
                >
            </form>
        </div>
    </div>
@endsection
