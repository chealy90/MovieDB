@extends('layouts.app')

@section('title', $user->name . "'s Profile")

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Profile Header -->
        <div class="flex items-center justify-between gap-6 mb-8">
            <div class="flex items-center gap-6">
                <div class="w-24 h-24 rounded-full bg-gray-700 flex items-center justify-center text-gray-500">
                    @if ($user->pfp)
                        <img
                            src="{{ $user->pfp }}"
                            alt="{{ $user->name }}"
                            class="w-full h-full rounded-full object-cover">
                    @else
                        <i class="fas fa-user text-4xl"></i>
                    @endif
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-white">{{ $user->name }}</h1>
                    @if (auth()->check() && auth()->id() !== $user->id)
                        @if (auth()->user()->following->contains($user->id))
                            <!-- Unfollow Button -->
                            <form action="{{ route('profile.unfollow', ['user' => $user->id]) }}" method="POST" class="inline-block mt-2">
                                @csrf
                                <button
                                    type="submit"
                                    class="px-4 py-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition-all">
                                    Unfollow
                                </button>
                            </form>
                        @else
                            <!-- Follow Button -->
                            <form action="{{ route('profile.follow', ['user' => $user->id]) }}" method="POST" class="inline-block mt-2">
                                @csrf
                                <button
                                    type="submit"
                                    class="px-4 py-2 bg-cyan-500 text-white rounded-full hover:bg-cyan-600 transition-all">
                                    Follow
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
            <!-- Stats -->
            <div class="flex gap-4">
                <div class="text-center">
                    <h2 class="text-xl font-bold text-white">{{ $moviesLiked }}</h2>
                    <p class="text-gray-400 text-sm">Movies Liked</p>
                </div>
                <div class="text-center">
                    <h2 class="text-xl font-bold text-white">{{ $reviewsCount }}</h2>
                    <p class="text-gray-400 text-sm">Reviews</p>
                </div>
                <div class="text-center">
                    <h2 class="text-xl font-bold text-white">{{ $followers }}</h2>
                    <p class="text-gray-400 text-sm">Followers</p>
                </div>
                <div class="text-center">
                    <h2 class="text-xl font-bold text-white">{{ $following }}</h2>
                    <p class="text-gray-400 text-sm">Following</p>
                </div>
            </div>
        </div>

        <!-- Public Lists -->
        <div>
            <h2 class="text-2xl font-bold text-white mb-4">Public Lists</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($publicLists as $list)
                    <div class="bg-gray-800 p-4 rounded-lg">
                        <h3 class="text-white font-bold">{{ $list->name }}</h3>
                        <p class="text-gray-400">{{ $list->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
