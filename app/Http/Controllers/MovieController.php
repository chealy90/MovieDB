<?php

namespace App\Http\Controllers;

use App\Services\TmdbService;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected $tmdbService;

    public function __construct(TmdbService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }

    public function index()
    {
        $movies = $this->tmdbService->getPopularMovies();
        return view('movies.index', ['movies' => $movies]);
    }

    public function show($id)
    {
        $movie = $this->tmdbService->getMovieDetails($id);
        return view('movies.show', compact('movie'));
    }
}
