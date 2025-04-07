<?php

namespace App\Console\Commands;

use App\Models\Movie;
use App\Services\TmdbService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

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
                        $posterPath = $movie['poster_path'] ?? null;
                        $localPosterPath = null;

                        if ($posterPath) {
                            $imageUrl = 'https://image.tmdb.org/t/p/w500' . $posterPath;

                            // Hash the filename for uniqueness
                            $extension = pathinfo($posterPath, PATHINFO_EXTENSION) ?: 'jpg';
                            $hashedFilename = md5($posterPath) . '.' . $extension;
                            $storagePath = 'public/posters/' . $hashedFilename;
                            $publicPath = 'storage/posters/' . $hashedFilename;

                            // Skip download if file already exists
                            if (!Storage::exists($storagePath)) {
                                $imageContents = @file_get_contents($imageUrl);

                                if ($imageContents) {
                                    Storage::disk('public')->put('posters/' . $hashedFilename, $imageContents);
                                    $this->line("Downloaded poster: {$hashedFilename}");
                                } else {
                                    $this->warn("Could not download poster for movie ID {$movie['id']}");
                                }
                            }

                            $localPosterPath = $publicPath;
                        }

                        Movie::updateOrCreate(
                            ['tmdb_id' => $movie['id']],
                            [
                                'title' => $movie['title'],
                                'release_year' => !empty($movie['release_date'])
                                    ? (int)substr($movie['release_date'], 0, 4)
                                    : null,
                                'poster_path' => $localPosterPath,
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
                sleep(5);
            }
        }

        $bar->finish();
        $this->info("\nDone! Successfully processed {$totalSaved} movies.");
    }
}
