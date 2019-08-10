<?php

namespace App\Services\Factory;

use InvalidArgumentException;
use App\Services\NhacCuaTuiCrawler;

class MediaCrawlerFactory
{
    public function make($url)
    {
        switch (get_domain_from_url($url)) {
            case 'nhaccuatui.com':
            case 'www.nhaccuatui.com':
                return new NhacCuaTuiCrawler($url);
            default:
                throw new InvalidArgumentException(__('Invalid url source.'));
        }
    }
}
