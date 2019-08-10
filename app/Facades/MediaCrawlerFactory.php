<?php

namespace App\Facades;

use App\Services\Crawler;
use Illuminate\Support\Facades\Facade;

/**
 * @method static Crawler make($url)
 */
class MediaCrawlerFactory extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \App\Services\Factory\MediaCrawlerFactory::class;
    }
}
