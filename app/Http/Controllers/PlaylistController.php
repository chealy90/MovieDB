<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PlaylistController extends Controller
{
    //

    public function store(Request $request){
        $request->validate([
            'playlist_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    
        $playlist = new Playlist(); // Or List(), depending on your model name
        $playlist->playlist_name = $request->input('playlist_name');
        $playlist->description = $request->input('description');
        $playlist->userID = auth()->id();
        $playlist->save();

        return redirect()->back()->with('success', 'Playlist created successfully.');
    }

    public function addToPlaylist(Request $request){
        // Prevent duplicates
        $alreadyExists = DB::table('playlist_movie')
        ->where('playlistID', $request->input('playlistID'))
        ->where('movieID', $request->input('movieID'))
        ->exists();

        if ($alreadyExists) {
            return redirect()->back()->with('info', 'Movie already exists in this playlist.');
        }

        // Insert movie into playlist
        DB::table('playlist_movie')->insert([
            'playlistID' => $request->input('playlistID'),
            'movieID' => $request->input('movieID'),
            'created_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Movie added to playlist.');
    }

    public function show($playlistID){
        $playlist = Playlist::where('id', $playlistID)->first();
        $movies = DB::table('playlist_movie')
            ->join('movies', 'playlist_movie.movieID', '=', 'movies.id')
            ->where('playlist_movie.playlistID', $playlistID)
            ->select('movies.*')  
            ->get();
    
        $user = User::where('id', $playlist->userID)->first();

        

        return view('profile.playlist', [
            'playlist' => $playlist,
            'movies' => $movies,
            'user' => $user
        ]);
    }

    public function removeFromPlaylist($playlistID, $movieID, Request $request){
        DB::table('playlist_movie')
        ->where('playlistID', $playlistID)
        ->where('movieID', $movieID)
        ->delete();

    return redirect()->back()->with('success', 'Movie removed from playlist.');
    }

    public function destroy($id, Request $request){
        $playlist = Playlist::findOrFail($id);

     // Ensure the logged-in user owns the playlist
        if (auth()->id() !== $playlist->userID) {
            abort(403, 'Unauthorized action.');
        }

        DB::table('playlist_movie')->where('playlistID', $id)->delete();

        $playlist->delete();

        return redirect()->route('profile.private')->with('success', 'Playlist deleted successfully.');
    }
}
