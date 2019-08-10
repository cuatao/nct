<?php

use Illuminate\Database\Seeder;

class PlaylistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\Playlist::class, 10)->create();
    }
}
