<?php

namespace App\Http\Controllers;

use App\Models\Playlist;

class PlaylistController extends Controller
{
    /**
     * Listing playlist
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $playlists = Playlist::with('artists')->get();

        return view('playlist', compact('playlists'));
    }

    /**
     * Show playlist detail with media list
     *
     * @param $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $playlist = Playlist::with('media.artists')->whereSlug($slug)->first();

        return view('media', compact('playlist'));
    }
}
