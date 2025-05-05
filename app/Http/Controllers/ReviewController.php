<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\User;
use App\Models\Movie;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create($movie, $user, Request $request){
        $validatedData = $request->validate([
            'rating' => 'required|integer|min:1|max:5', // Rating must be between 1 and 5
            'description' => 'required|string|max:1000', // Description must be text
        ]);


        Review::create(
            [
                'movieID'=>$movie,
                'userID'=>$user,
                'username'=> User::where('id', $user)->first()->name,
                'rating'=>$request->input('rating'),
                'description'=>$request->input('description')
            ]
        );

        return redirect("/movies/{$movie}");
    }

    public function findByMovie($movieID){
        $reviews = Review::where('movieID', $movieID)
        ->orderBy('created_at', 'asc')
        ->paginate(15);

        $movie = Movie::where('tmdb_id', $movieID)->first();
        

        return view('movies.reviews', ['reviews' => $reviews, 'movie'=>$movie]);    }
}
