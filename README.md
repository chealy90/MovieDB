<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# MovieDB
This sites lets users share their experiences with movies, create and find playlists, and find something to watch.

## Setup
After downloading the project:
1. Populate your .env file with ```cp .env.example .env``` .
2. Build the project with ```composer install``` and ````npm install``.
3. Create your database, and update your .env with your database details.
4. Create a key with ```php artisan key:generate```.
5. Turn on your database and run the migrations with ```php artisan migrate.```

To start the application:
1. ```npm run build```.
2. ```php artisan serve```.


## Using the application
### Logging in:
Users can register or log in by pressing on the "Log in" / "Register" buttons on the top right window of the stage.
All you need is to enter your name, email and password.

![image](https://github.com/user-attachments/assets/0a73966f-aba2-4694-81ed-36530cbfe069)

## Finding movies
Users can search for specific titles in the search bar in the header menu. From there users have the option to further refine their search with by genre and year, and to sort.

## Viewing movie info.
Clicking on a movie preview tile will take you to that movies focus page.
Here you will find all sorts of information about the movie, trailers, cast, and reviews from other users.

### Interacting with a movie:
Logged in users have the option to:
- Review a movie,
- Add it to their watchlist
- Mark it as watched,
- Add it to their own custom playlists







# commands (temp)
```
npm install
composer install
php artisan migrate
php artisan serve
npm run dev
php artisan storage:link
php artisan tmdb:fetch-popular 50
```
