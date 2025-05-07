<?php

namespace App\Http\Controllers;

use App\Models\MovieLike;
use Illuminate\Http\Request;

class MovieLikeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'movie_id' => 'required|exists:movies,id',
        ]);

        MovieLike::create($request->only('user_id', 'movie_id'));

        return response()->json(['message' => 'Movie liked successfully.']);
    }
}
