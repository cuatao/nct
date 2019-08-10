<?php

namespace App\Http\View\Composers;

use App\Models\Playlist;
use Illuminate\View\View;

class PlaylistComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('playlists', Playlist::listing());
    }
}
