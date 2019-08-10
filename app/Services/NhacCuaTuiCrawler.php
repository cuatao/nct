<?php

namespace App\Services;

class NhacCuaTuiCrawler extends Crawler
{
    use HasPlaylist, HasMedia;

    protected function source()
    {
        return 'nct';
    }

    protected function getTitle():string
    {
        return $this->crawler->filter('div.name_title h1')->first()->text();
    }

    protected function getType()
    {
        $type = split_string_by_from_to($this->crawler->html(), 'type: \'', "'");

        return ($type == 'song') ? 'audio' : 'video';
    }

    protected function getImage()
    {
        return $this->crawler->filter('meta[name=thumbnail]')->first()->attr('content');
    }

    protected function getArtists()
    {
        $artists = [];

        $this->crawler->filter('div.name_title h2.name-singer a')
            ->each(function (\Symfony\Component\DomCrawler\Crawler $node, $i) use (&$artists) {
                $artists[] = $node->text();
            });

        return $artists;
    }

    protected function getKeyFromUrl()
    {
        if (preg_match('/(?<=.)[a-zA-Z0-9]+(?=\.html)/', $this->url, $matches)) {
            return $matches[0];
        }

        return '';
    }

    public function getDownloadUrl()
    {
        if (preg_match('#xmlURL = "(.+?)";#', $this->crawler->html(), $matches)) {
            $xmlData = file_get_contents(htmlspecialchars_decode($matches[1]));

            if (preg_match('#<!\[CDATA\[(.+?)\?st=#', $xmlData, $matches)) {
                return $matches[1].split_string_by_from_to($xmlData, $matches[1], ']]');
            }
        }

        return false;
    }
}
