<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TmdbService
{
    protected $baseUrl = 'https://api.themoviedb.org/3';

    public function getPopularMovies($page = 1)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->get("{$this->baseUrl}/movie/popular", [
            'api_key' => env('TMDB_API_KEY'),
            'page' => $page,
            'language' => 'en-US'
        ]);

        if (!$response->successful()) {
            Log::error('TMDB API Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            throw new \Exception("API request failed with status: {$response->status()}");
        }

        $data = $response->json();

        if (!isset($data['results'])) {
            Log::error('TMDB Unexpected Response', ['response' => $data]);
            throw new \Exception("Unexpected API response format");
        }

        return $data['results'];
    }
}
