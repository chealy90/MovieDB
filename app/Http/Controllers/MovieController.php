<?php

namespace App\Http\Controllers;

use App\Models\Movie;
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
        $movies = Movie::orderBy('created_at', 'desc')->paginate(24);
        return view('movies.index', compact('movies'));
    }

    public function show($id)
    {
        // Check if the movie exists in the database
        $movie = Movie::where('tmdb_id', $id)->first();

        if (!$movie) {
            // Fetch the movie details from TMDB API
            $movieDetails = $this->tmdbService->getMovieDetails($id);

            // Save the movie to the database
            $movie = Movie::create([
                'title' => $movieDetails['title'],
                'tmdb_id' => $movieDetails['id'],
                'release_year' => isset($movieDetails['release_date']) ? substr($movieDetails['release_date'], 0, 4) : null,
                'poster_path' => $movieDetails['poster_path'] ?? null,
                'rating' => $movieDetails['vote_average'] ?? null,
            ]);
        }

        // Get detailed movie data from TMDB
        $movieDetails = $this->tmdbService->getMovieDetails($id);

        // Get similar movies
        $similarMovies = $this->tmdbService->getSimilarMovies($id);

        return view('movies.show', [
            'movie' => $movieDetails,
            'similarMovies' => $similarMovies
        ]);
    }
}
