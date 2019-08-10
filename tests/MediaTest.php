<?php

use App\Models\Media;
use App\Models\Playlist;
use App\Services\NhacCuaTuiCrawler;
use App\Facades\MediaCrawlerFactory;
use Laravel\Lumen\Testing\DatabaseMigrations;

class MediaTest extends TestCase
{
    use DatabaseMigrations;

    protected $faker;

    public function setUp(): void
    {
        parent::setUp();

        $this->faker = \Faker\Factory::create();
    }

    public function testMediaHasArtists()
    {
        $media = factory(Media::class)->create();

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $media->artists
        );
    }

    public function testMediaBelongToManyPlaylist()
    {
        $media = factory(Media::class)->create();

        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Collection', $media->playlists
        );
    }

    public function testMediaCanBeGetData()
    {
        $url = $this->faker->url;

        $playlist = factory(Playlist::class)->create();

        $media = factory(Media::class)->create();

        $crawler = Mockery::mock(NhacCuaTuiCrawler::class)
            ->makePartial();

        MediaCrawlerFactory::shouldReceive('make')
            ->with($url)
            ->andReturn($crawler);

        $crawler->shouldReceive('getMedia')
            ->once()
            ->andReturn($media);

        $request = [
            'playlist_id' => $playlist->id,
            'url' => $url,
        ];

        $response = $this->get('get-media?'.http_build_query($request));

        $response->assertResponseOk();

        $this->seeInDatabase('media', [
            'id' => $media->id
        ]);
    }

    public function testCanFetchNewDownloadUrl()
    {
        $media = factory(Media::class)->create();

        $crawler = Mockery::mock(NhacCuaTuiCrawler::class)->makePartial();

        MediaCrawlerFactory::shouldReceive('make')
            ->with($media->source_url)
            ->andReturn($crawler);

        $crawler->shouldReceive('getMedia')
            ->once()
            ->andReturn($media);

        $this->get('/medias/'.$media->id.'/fetch-new-download-url')
            ->assertResponseOk();
    }
}
