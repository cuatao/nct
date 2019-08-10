<?php

use App\Models\Playlist;
use Laravel\Lumen\Testing\DatabaseMigrations;

class PlaylistTest extends TestCase
{
    use DatabaseMigrations;

    public function testPlaylistHasMedia()
    {
        $playlist = factory(Playlist::class)->create();

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $playlist->media
        );
    }
}
