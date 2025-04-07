<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model {
    use HasFactory;

    protected $fillable = [
        'tmdb_id',
        'title',
        'release_year',
        'poster_path',
        'genre_ids',
        'rating',
    ];

    protected $casts = [
        'genre_ids' => 'array',
        'rating' => 'float',
    ];
}
