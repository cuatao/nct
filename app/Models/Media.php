<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Media extends Model
{
    use Sluggable;

    protected $fillable = [
        'slug',
        'image_path',
        'title',
        'download_url',
        'source_url',
        'key',
        'source',
        'type',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    /**
     * All of the playlists that contains media.
     */
    public function playlists()
    {
        return $this->belongsToMany(Playlist::class);
    }

    /**
     * All of the artists that belong to the media.
     */
    public function artists()
    {
        return $this->belongsToMany(Artist::class)->withTimestamps();
    }

    /**
     * Create media from array data.
     *
     * @param array $data
     * @return Media
     */

    public static function createFromData($data = []) : Media
    {
        $media = static::create($data);

        return tap($media)->saveArtists($data['artists'] ?? []);
    }

    /**
     * Save artists info
     *
     * @param array $artists
     */
    public function saveArtists($artists = []) : void
    {
        foreach ($artists as $name) {
            $artist = Artist::firstOrCreate(['name' => $name]);

            $this->artists()->syncWithoutDetaching($artist->id);
        }
    }

    /**
     * Scope filter by keyword
     *
     */
    public function scopeFilterByKeyword($query, $keyword)
    {
        $keyword = '%'.$keyword.'%';

        return $query->where(function ($query) use ($keyword) {
            $query->where('title', 'like', $keyword)
                ->orWhereHas('artists', function ($query) use ($keyword) {
                    $query->where('name', 'like', $keyword);
                });
        });

    }
}
