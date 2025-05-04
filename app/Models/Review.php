<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $fillable = [
        'reviewID',
        'movieID',
        'userID',
        'rating',
        'description',
        'datePosted',
        'username'
    ];
}
