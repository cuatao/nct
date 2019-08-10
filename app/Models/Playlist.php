<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;

class Playlist extends Model
{
    use Sluggable, SluggableScopeHelpers;

    protected $fillable = [
        'name', 'slug', 'image_path',
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
                'source' => 'name'
            ]
        ];
    }

    /**
     * All of the media that belongs to the playlist.
     */
    public function media()
    {
        return $this->belongsToMany(Media::class);
    }

    /**
     * Get list of all playlist.
     *
     * @return array
     */
    public static function listing()
    {
        return Playlist::with('artists')->get()->map(function ($item, $key) {
            return [
                'text' => $item['name'],
                'value' => $item['id'],
                'description' => $item->artists,
                'imageSrc' => $item['image_path'],
            ];
        })->toArray();
    }

    /**
     * All of artists belong to media of the playlist
     */
    public function artists()
    {
        return $this->hasOne(MediaPlaylist::class)
            ->join('artist_media', 'artist_media.media_id', '=', 'media_playlist.media_id')
            ->join('artists', 'artist_media.artist_id', '=', 'artists.id')
            ->selectRaw('playlist_id, GROUP_CONCAT(distinct " ", artists.name) as artists_name')
            ->groupBy('playlist_id');
    }

    /**
     * Get artists list attribute
     */
    public function getArtistsAttribute()
    {
        if (! array_key_exists('artists', $this->relations)) {
            $this->load('artists');
        }

        $related = $this->getRelation('artists');

        return ($related) ? $related->artists_name : '';
    }

    /**
     * Set image path
     */
    public function setImagePathAttribute($value)
    {
        if ($this->attributes['image_path']) {
            return $value;
        }

        $this->attributes['image_path'] = $value;
    }

    /**
     * Get image path with default value
     */
    public function getImagePathAttribute($value)
    {
        return $value ?? 'https://via.placeholder.com/300';
    }

    /**
     * Add media to the playlist
     *
     * @param Media $media
     */
    public function addMedia(Media $media)
    {
        $this->media()->syncWithoutDetaching($media);

        $this->update(['image_path' => $media->image_path]);
    }
}
