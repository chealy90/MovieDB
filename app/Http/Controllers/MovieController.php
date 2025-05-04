<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;
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
        try {
            $movieDetails = $this->tmdbService->getMovieDetails($id);

            // Store or update movie in local database
            $movie = Movie::updateOrCreate(
                ['tmdb_id' => $id],
                [
                    'title' => $movieDetails['title'],
                    'release_year' => substr($movieDetails['release_date'] ?? '', 0, 4),
                    'poster_path' => $movieDetails['poster_path'],
                    'rating' => $movieDetails['vote_average'],
                    'backdrop_path' => $movieDetails['backdrop_path'] ?? null,
                    'overview' => $movieDetails['overview'] ?? null,
                ]
            );

            $similarMovies = $this->tmdbService->getSimilarMovies($id);
            $reviews = Review::where('movieID', $id)->get();

            return view('movies.show', [
                'movie' => $movieDetails,
                'similarMovies' => $similarMovies,
                'reviews' => $reviews,
                'dbMovie' => $movie // Pass the local DB record too
            ]);

        } catch (\Exception $e) {
            return redirect()->route('movies.index')
                ->with('error', 'Movie not found: ' . $e->getMessage());
        }
    }

    public function search(Request $request, TmdbService $tmdbService)
    {
        $query = $request->get('query');

        if (empty(trim($query))) {
            return redirect()->route('movies.index');
        }

        try {
            $results = $tmdbService->searchMovies($query);
            return view('movies.search', [
                'movies' => $results['results'] ?? [],
                'query' => $query,
                'total_results' => $results['total_results'] ?? 0,
                'total_pages' => $results['total_pages'] ?? 1,
                'current_page' => $request->get('page', 1)
            ]);
        } catch (\Exception $e) {
            Log::error('Movie search failed:', [
                'query' => $query,
                'error' => $e->getMessage()
            ]);

            return view('movies.search', [
                'movies' => [],
                'query' => $query,
                'error' => 'An error occurred while searching. Please try again.'
            ]);
        }
    }

    protected function storeSearchResults(array $movies)
    {
        foreach ($movies as $movieData) {
            try {
                Movie::updateOrCreate(
                    ['tmdb_id' => $movieData['id']],
                    [
                        'title' => $movieData['title'],
                        'release_year' => substr($movieData['release_date'] ?? '', 0, 4),
                        'poster_path' => $movieData['poster_path'],
                        'rating' => $movieData['vote_average'],
                        'backdrop_path' => $movieData['backdrop_path'] ?? null,
                    ]
                );
            } catch (\Exception $e) {
                Log::error('Failed to store movie', [
                    'tmdb_id' => $movieData['id'] ?? null,
                    'error' => $e->getMessage()
                ]);
                continue;
            }
        }
    }
}
