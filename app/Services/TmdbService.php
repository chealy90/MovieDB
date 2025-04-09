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
        $this->apiKey = env('TMDB_API_KEY');
        if (empty($this->apiKey)) {
            throw new \RuntimeException('TMDB_API_KEY is not set in .env');
        }
    }

    public function getPopularMovies($page = 1)
    {
        return $this->makeRequest("/movie/popular", ['page' => $page])['results'] ?? [];
    }

    public function getMovieDetails($id)
    {
        return $this->makeRequest("/movie/{$id}", [
            'append_to_response' => 'credits,videos,similar'
        ]);
    }

    public function getSimilarMovies($id)
    {
        $movies = $this->makeRequest("/movie/{$id}/similar")['results'] ?? [];
        return array_slice($movies, 0, 10);
    }

    protected function makeRequest($endpoint, $params = [])
    {
        $defaultParams = [
            'api_key' => $this->apiKey,
            'language' => 'en-US'
        ];

        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get($this->baseUrl . $endpoint, array_merge($defaultParams, $params));

        if (!$response->successful()) {
            Log::error('TMDB API Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            throw new \Exception("TMDB API request failed: {$response->status()}");
        }

        return $response->json();
    }
}
