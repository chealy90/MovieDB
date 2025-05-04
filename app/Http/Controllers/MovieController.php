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

    public function index(Request $request)
    {
        $query = Movie::query();

        // Apply genre filter
        if ($request->filled('genre')) {
            $genreId = $request->input('genre');
            $query->whereRaw('JSON_CONTAINS(genre_ids, ?)', [json_encode((int) $genreId)]);
        }

        // Apply release year filter
        if ($request->filled('year')) {
            $query->where('release_year', $request->input('year'));
        }

        // Apply sorting
        if ($request->filled('sort')) {
            switch ($request->input('sort')) {
                case 'popularity':
                    $query->orderBy('popularity', 'desc');
                    break;
                case 'rating':
                    $query->orderBy('rating', 'desc');
                    break;
                case 'release_date':
                    $query->orderBy('release_year', 'desc');
                    break;
            }
        } else {
            $query->orderBy('created_at', 'desc'); // Default sorting
        }

        $movies = $query->paginate(24);

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
            // Fetch search results from TMDB
            $results = $tmdbService->searchMovies($query, $request->get('page', 1));

            // Filter by genre
            if ($request->filled('genre')) {
                $genreId = $request->input('genre');
                $results['results'] = array_filter($results['results'], function ($movie) use ($genreId) {
                    return isset($movie['genre_ids']) && in_array((int) $genreId, $movie['genre_ids']);
                });
            }

            // Filter by release year
            if ($request->filled('year')) {
                $year = $request->input('year');
                $results['results'] = array_filter($results['results'], function ($movie) use ($year) {
                    return isset($movie['release_date']) && substr($movie['release_date'], 0, 4) == $year;
                });
            }

            // Sort results only if a sort parameter is provided
            if ($request->filled('sort')) {
                $sort = $request->input('sort');
                usort($results['results'], function ($a, $b) use ($sort) {
                    if ($sort === 'rating') {
                        return $b['vote_average'] <=> $a['vote_average'];
                    } elseif ($sort === 'release_date') {
                        return strcmp($b['release_date'] ?? '', $a['release_date'] ?? '');
                    }
                    return 0;
                });
            }

            return view('movies.search', [
                'movies' => $results['results'] ?? [],
                'query' => $query,
                'total_results' => $results['total_results'] ?? 0,
                'total_pages' => $results['total_pages'] ?? 1,
                'current_page' => $request->get('page', 1),
            ]);
        } catch (\Exception $e) {
            Log::error('Movie search failed:', [
                'query' => $query,
                'error' => $e->getMessage(),
            ]);

            return view('movies.search', [
                'movies' => [],
                'query' => $query,
                'error' => 'An error occurred while searching. Please try again.',
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
