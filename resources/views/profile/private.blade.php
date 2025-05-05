@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Profile Header -->
        <div class="flex items-center justify-between gap-6 mb-8">
            <div class="flex items-center gap-6">
                <img src="{{ $user->pfp }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full object-cover">
                <div>
                    <h1 class="text-3xl font-bold text-white">{{ $user->name }}</h1>
                    <a href="#" class="px-4 py-2 mt-2 inline-block bg-cyan-500 text-white rounded-full hover:bg-cyan-600 transition-all">
                        Edit Profile
                    </a>
                </div>
            </div>
            <!-- Stats -->
            <div class="flex gap-4">
                <div class="text-center">
                    <h2 class="text-xl font-bold text-white">{{ $moviesWatched }}</h2>
                    <p class="text-gray-400 text-sm">Movies Watched</p>
                </div>
                <div class="text-center">
                    <h2 class="text-xl font-bold text-white">{{ $moviesLiked }}</h2>
                    <p class="text-gray-400 text-sm">Movies Liked</p>
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

        <!-- Recent Activity -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-white mb-4">Recent Activity</h2>
            <ul class="space-y-4">
                @foreach ($recentActivity as $activity)
                    <li class="bg-gray-800 p-4 rounded-lg">
                        <p class="text-white">{{ $activity }}</p>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Lists -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-white mb-4">My Lists</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($lists as $list)
                    <div class="bg-gray-800 p-4 rounded-lg">
                        <h3 class="text-white font-bold">{{ $list->name }}</h3>
                        <p class="text-gray-400">{{ $list->description }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Diary -->
        <div>
            <h2 class="text-2xl font-bold text-white mb-4">My Diary</h2>
            <ul class="space-y-4">
                @foreach ($diaryEntries as $entry)
                    <li class="bg-gray-800 p-4 rounded-lg">
                        <h3 class="text-white font-bold">{{ $entry->title }}</h3>
                        <p class="text-gray-400">{{ $entry->content }}</p>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
