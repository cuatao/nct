<?php

namespace App\Http\Controllers;

use App\Models\Playlist;

class PlaylistController extends Controller
{
    public function index()
    {
        $playlists = Playlist::with('artists')->get();

        return view('playlist', compact('playlists'));
    }

    public function show($slug)
    {
        $playlist = Playlist::with('media.artists')->whereSlug($slug)->first();

        return view('media', compact('playlist'));
    }
}
