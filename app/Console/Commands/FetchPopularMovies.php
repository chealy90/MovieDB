<?php

namespace App\Console\Commands;

use App\Models\Movie;
use App\Services\TmdbService;
use Illuminate\Console\Command;

class FetchPopularMovies extends Command
{
    protected $signature = 'tmdb:fetch-popular {pages=10 : Number of pages to fetch}';
    protected $description = 'Fetch popular movies using Laravel HTTP client';

    public function handle()
    {
        if (empty(env('TMDB_API_KEY'))) {
            $this->error('TMDB_API_KEY is not set in .env');
            return;
        }

        $tmdb = new TmdbService();
        $pages = (int)$this->argument('pages');
        $totalSaved = 0;
        $skipped = 0;

        $this->info("Fetching {$pages} pages of popular movies...");

        $bar = $this->output->createProgressBar($pages);

        for ($page = 1; $page <= $pages; $page++) {
            try {
                $movies = $tmdb->getPopularMovies($page);

                foreach ($movies as $movie) {
                    // Check for required fields
                    if (!$this->validateMovie($movie)) {
                        $skipped++;
                        continue;
                    }

                    try {
                        $movieData = [
                            'title' => $movie['title'],
                            'tmdb_id' => $movie['id']
                        ];

                        // Add optional fields only if they exist and are valid
                        if (!empty($movie['release_date'])) {
                            $movieData['release_year'] = (int)substr($movie['release_date'], 0, 4);
                        }

                        if (!empty($movie['poster_path'])) {
                            $movieData['poster_path'] = $movie['poster_path'];
                        }

                        if (!empty($movie['genre_ids']) && is_array($movie['genre_ids'])) {
                            $movieData['genre_ids'] = $movie['genre_ids'];
                        }

                        if (isset($movie['vote_average']) && is_numeric($movie['vote_average'])) {
                            $movieData['rating'] = $movie['vote_average'];
                        }

                        Movie::updateOrCreate(
                            ['tmdb_id' => $movie['id']],
                            $movieData
                        );
                        $totalSaved++;
                    } catch (\Exception $e) {
                        $this->warn("Skipped movie {$movie['id']}: " . $e->getMessage());
                        $skipped++;
                        continue;
                    }
                }

                $bar->advance();

                // Rate limiting
                if ($page % 4 === 0) sleep(1);
            } catch (\Exception $e) {
                $this->error("Page {$page} failed: " . $e->getMessage());
                sleep(5);
            }
        }

        $bar->finish();
        $this->newLine();
        $this->info("Done! Successfully saved {$totalSaved} movies.");
        $this->info("Skipped {$skipped} movies due to missing or invalid data.");
    }

    protected function validateMovie($movie): bool
    {
        // Required fields must exist and not be empty
        if (empty($movie['id']) || empty($movie['title'])) {
            return false;
        }

        // ID must be numeric
        if (!is_numeric($movie['id'])) {
            return false;
        }

        // Title must be a string
        if (!is_string($movie['title'])) {
            return false;
        }

        return true;
    }
}
