<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;

class UserController extends Controller
{
    //
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
}
