<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display the private profile of the authenticated user.
     */
    public function private(Request $request)
    {
        $user = $request->user();

        // Example data for stats and sections
        $moviesWatched = 120; // Replace with actual logic
        $moviesLiked = 45; // Replace with actual logic
        $followers = 300; // Replace with actual logic
        $following = 150; // Replace with actual logic
        $recentActivity = ['Watched "Inception"', 'Liked "The Dark Knight"']; // Replace with actual logic
        $lists = []; // Replace with actual logic
        $diaryEntries = []; // Replace with actual logic

        return view('profile.private', compact(
            'user',
            'moviesWatched',
            'moviesLiked',
            'followers',
            'following',
            'recentActivity',
            'lists',
            'diaryEntries'
        ));
    }

    /**
     * Display the public profile of a specific user.
     */
    public function public(User $user)
    {
        // Example data for stats and public sections
        $moviesWatched = 120; // Replace with actual logic
        $moviesLiked = 45; // Replace with actual logic
        $followers = 300; // Replace with actual logic
        $publicLists = []; // Replace with actual logic

        return view('profile.public', compact(
            'user',
            'moviesWatched',
            'moviesLiked',
            'followers',
            'publicLists'
        ));
    }
}
