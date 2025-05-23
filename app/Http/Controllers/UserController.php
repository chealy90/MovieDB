<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;
use App\Models\User;
use App\Models\Playlist;
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
        $watchedMovies = auth()->user()->watchedList;
        $playlists = Playlist::where('userID', auth()->user()->id)->get();

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

        return view('profile.private', compact('user', 'reviewsCount', 'moviesLiked', 'followers', 'following', 'recentActivity', 'lists', 'diaryEntries', 'watchedMovies', 'playlists'));
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

    public function follow(User $user)
    {
        $authUser = auth()->user();

        // Prevent following yourself
        if ($authUser->id === $user->id) {
            return redirect()->back()->with('error', 'You cannot follow yourself.');
        }

        // Check if already following
        if ($authUser->following()->where('followed_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'You are already following this user.');
        }

        // Add follow relationship
        $authUser->following()->attach($user->id, ['following_since' => now()]);

        return redirect()->back()->with('success', 'You are now following ' . $user->name . '.');
    }

    public function unfollow(User $user)
    {
        $authUser = auth()->user();

        // Check if the user is following the profile owner
        if (!$authUser->following()->where('followed_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'You are not following this user.');
        }

        // Remove the follow relationship
        $authUser->following()->detach($user->id);

        return redirect()->back()->with('success', 'You have unfollowed ' . $user->name . '.');
    }


    //watch list functions
    public function addToWatchlist($movieId)
    {
        // Ensure you're attaching the movie by its primary key (id)
        $movie = Movie::where('tmdb_id', $movieId)->first();

        if ($movie) {
            auth()->user()->watchlist()->attach($movie->id); // Attach using movie->id
        } else {
            // Handle movie not found case
            return response()->json(['error' => 'Movie not found'], 404);
        }

        return redirect("/movies/{$movie->tmdb_id}");
    }

    public function removeFromWatchlist($movieId)
    {
        $movie = Movie::where('tmdb_id', $movieId)->first();

        if ($movie) {
            auth()->user()->watchlist()->detach($movie->id); // Detach using movie->id
        } else {
            // Handle movie not found case
            return response()->json(['error' => 'Movie not found'], 404);
        }

        return redirect("/movies/{$movie->tmdb_id}");
    }

    public function displayWatchlist(){
        $watchlistMovies = auth()->user()->watchlist()->get();
        return view('movies.watchlist', ['watchlistMovies'=>$watchlistMovies]);
    }




    public function setWatched($movieId){
        // Ensure you're attaching the movie by its primary key (id)
        $movie = Movie::where('tmdb_id', $movieId)->first();

        if ($movie) {
            auth()->user()->watchedList()->attach($movie->id); // Attach using movie->id
        } else {
            // Handle movie not found case
            return response()->json(['error' => 'Movie not found'], 404);
        }

        return redirect("/movies/{$movie->tmdb_id}");
    }

    public function setUnwatched($movieId){
        $movie = Movie::where('tmdb_id', $movieId)->first();

        if ($movie) {
            auth()->user()->watchedList()->detach($movie->id); // Detach using movie->id
        } else {
            // Handle movie not found case
            return response()->json(['error' => 'Movie not found'], 404);
        }

        return redirect("/movies/{$movie->tmdb_id}");
    }

    
}
