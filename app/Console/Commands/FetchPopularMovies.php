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

        $this->info("Fetching {$pages} pages of popular movies...");

        $bar = $this->output->createProgressBar($pages);

        for ($page = 1; $page <= $pages; $page++) {
            try {
                $movies = $tmdb->getPopularMovies($page);

                foreach ($movies as $movie) {
                    try {
                        Movie::updateOrCreate(
                            ['tmdb_id' => $movie['id']],
                            [
                                'title' => $movie['title'],
                                'release_year' => !empty($movie['release_date'])
                                    ? (int)substr($movie['release_date'], 0, 4)
                                    : null,
                                'poster_path' => $movie['poster_path'] ?? null,
                                'genre_ids' => $movie['genre_ids'] ?? [],
                            ]
                        );
                        $totalSaved++;
                    } catch (\Exception $e) {
                        $this->warn("Skipped movie {$movie['id']}: " . $e->getMessage());
                        continue;
                    }
                }

                $bar->advance();

                // Rate limiting (4 requests per second max)
                if ($page % 4 === 0) sleep(1);
            } catch (\Exception $e) {
                $this->error("Page {$page} failed: " . $e->getMessage());
                // Wait before retrying
                sleep(5);
            }
        }

        $bar->finish();
        $this->info("\nDone! Successfully processed {$totalSaved} movies.");
    }
}
