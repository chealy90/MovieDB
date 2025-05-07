<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/*
public function usersWatching()
{
    return $this->belongsToMany(User::class, 'watchlist_movie')
                ->withPivot('watched')
                ->withTimestamps();
}


// this will be needed to access the users watchlist in the profile section


*/



class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'pfp',
        'bio',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function moviesLiked()
    {
        return $this->hasMany(MovieLike::class, 'user_id', 'id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
    }

    public function savedLists()
    {
        return $this->hasMany(SavedList::class, 'user_id', 'id');
    }

    public function logs()
    {
        return $this->hasMany(Logs::class, 'user_id', 'id');

    public function watchlist() {
        return $this->belongsToMany(Movie::class, 'watchlist_movie')
            ->withTimestamps();
    }


    public function watchedList(){
        return $this->belongsToMany(Movie::class, 'watched_movie')
            ->withTimestamps();
    }
}
