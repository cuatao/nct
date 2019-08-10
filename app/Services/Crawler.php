<?php

namespace App\Services;

abstract class Crawler
{
    protected $url;

    protected $client;

    protected $crawler;

    public function __construct($url)
    {
        $this->client = new \Goutte\Client();

        $this->url = $url;

        $this->crawler = $this->client->request('GET', $this->url);
    }
}
