<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function private()
    {
        $user = auth()->user();

        $reviewsCount = Review::where('userID', $user->id)->count();
        $moviesLiked = $user->moviesLiked()->count();
        $followers = $user->followers()->count();
        $following = $user->following()->count();

        // Example: Retrieve recent activity
        $recentActivity = Review::where('userID', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->pluck('description');

        // Retrieve the user's lists
        $lists = $user->savedLists()
            ->join('lists', 'saved_lists.list_id', '=', 'lists.id')
            ->select('lists.*')
            ->get();

        // Retrieve the user's logs (diary entries)
        $diaryEntries = $user->logs()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile.private', compact('user', 'reviewsCount', 'moviesLiked', 'followers', 'following', 'recentActivity', 'lists', 'diaryEntries'));
    }

    public function public(User $user)
    {
        $reviewsCount = Review::where('userID', $user->id)->count();
        $moviesLiked = $user->moviesLiked()->count();
        $followers = $user->followers()->count();
        $following = $user->following()->count();

        // Retrieve public lists for the user by joining the lists table
        $publicLists = $user->savedLists()
            ->join('lists', 'saved_lists.list_id', '=', 'lists.id')
            ->where('lists.is_private', false)
            ->select('lists.*') // Select fields from the lists table
            ->get();

        return view('profile.public', compact('user', 'reviewsCount', 'moviesLiked', 'followers', 'following', 'publicLists'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'pfp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;

        if ($request->hasFile('pfp')) {
            $path = $request->file('pfp')->store('profile_pictures', 'public');
            $user->pfp = '/storage/' . $path;
        }

        $user->save();

        return redirect()->route('profile.private')->with('success', 'Profile updated successfully.');
    }
}
