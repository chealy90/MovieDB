<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TmdbService
{
    protected $baseUrl = 'https://api.themoviedb.org/3';
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.tmdb.key'); // Better to use config instead of env directly
        if (empty($this->apiKey)) {
            throw new \RuntimeException('TMDB API key is not configured');
        }
    }

    public function getPopularMovies($page = 1)
    {
        return $this->makeRequest("/movie/popular", ['page' => $page])['results'] ?? [];
    }

    public function getMovieDetails($id)
    {
        return $this->makeRequest("/movie/{$id}", [
            'append_to_response' => 'credits,videos,similar,images'
        ]);
    }

    public function getSimilarMovies($id)
    {
        $movies = $this->makeRequest("/movie/{$id}/similar")['results'] ?? [];
        return array_slice($movies, 0, 10);
    }

    public function searchMovies($query, $page = 1)
    {
        if (empty(trim($query))) {
            return [];
        }

        return $this->makeRequest("/search/movie", [
            'query' => $query,
            'page' => $page,
            'include_adult' => false
        ]);
    }

    protected function makeRequest($endpoint, $params = [])
    {
        try {
            $url = $this->baseUrl . $endpoint;
            $defaultParams = [
                'api_key' => $this->apiKey,
                'language' => 'en-US',
                'region' => 'US' // Optional: set default region
            ];

            $response = Http::retry(3, 100) // Retry up to 3 times
            ->withHeaders([
                'Accept' => 'application/json',
            ])
                ->timeout(15) // 15 second timeout
                ->get($url, array_merge($defaultParams, $params));

            if (!$response->successful()) {
                Log::error('TMDB API Error', [
                    'url' => $url,
                    'status' => $response->status(),
                    'response' => $response->json()
                ]);
                throw new \Exception("TMDB API request failed with status: {$response->status()}");
            }

            return $response->json();
        } catch (\Exception $e) {
            Log::error('TMDB API Connection Error', [
                'endpoint' => $endpoint,
                'error' => $e->getMessage()
            ]);
            throw new \Exception("TMDB API connection failed: " . $e->getMessage());
        }
    }


    public function getPersonDetails($id)
    {
        return $this->makeRequest("/person/{$id}");
    }

    public function getPersonMovies($id)
    {
        return $this->makeRequest("/person/{$id}/movie_credits")['cast'] ?? [];
    }
}
