<?php

namespace App\Services;

use App\Models\Media;

trait HasMedia
{
    /**
     * Parse title of media item
     */
    abstract protected function getTitle();

    /**
     * Parse type of media
     */
    abstract protected function getType();

    /**
     * Get thumbnail image url
     */
    abstract protected function getImage();

    /**
     * Get list of artists
     */
    abstract protected function getArtists();

    /**
     * Detect unique id from url
     */
    abstract protected function getKeyFromUrl();

    /**
     * Get download url
     */
    abstract protected function getDownloadUrl();

    /**
     * Return name of source
     */
    protected function source()
    {
        return 'empty';
    }

    /**
     * Get media info and save into database
     *
     * @return Media
     */
    public function getMedia() : Media
    {
        $media = Media::updateOrCreate([
            'key' => $this->getKeyFromUrl(),
        ], [
            'title' => $this->getTitle(),
            'type' => $this->getType(),
            'image_path' => $this->getImage(),
            'key' => $this->getKeyFromUrl(),
            'download_url' => $this->getDownloadUrl(),
            'source' => $this->source(),
            'source_url' => $this->url,
        ]);

        return tap($media)->saveArtists($this->getArtists());
    }
}
