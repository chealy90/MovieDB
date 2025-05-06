<?php

namespace App\Http\Controllers;

use App\Services\TmdbService;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    protected $tmdbService;

    public function __construct(TmdbService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }

    public function show($id)
    {
        // Fetch person details and their movies
        $person = $this->tmdbService->getPersonDetails($id);
        $movies = $this->tmdbService->getPersonMovies($id);

        return view('person.show', compact('person', 'movies'));
    }
}
