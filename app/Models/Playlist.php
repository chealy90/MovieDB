<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Playlist extends Model
{
    //
    protected $table = 'user_playlists';

    protected $fillable = [
        'id',
        'userID',
        'playlist_name',
        'description',
        'created_at',
        'updated_at'
    ];


    public function movies(){
        return $this->belongsToMany(Movie::class, 'playlist_movie', 'playlistID', 'movieID');

    }

    public function user(){
        return $this->belongsTo(User::class);
    }


    
    
}
