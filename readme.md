NCT Crawler Tool
===

## Table of Contents

[TOC]

## My Comment

> I have received the test with request build two simple pages
> 1. A web page to select a playlist (in a dropdown list) **and** enter a URL of the page that contains video or media item to crawl
>
> 2. A web page to show the playlist listing (crawler result)
> 
>
> I think the first page description is not really clear. It took me a few hours to think about it.
>
> I have two ways of thinking: 1. User select the playlist, then enter url to get media data and save to this playlist; 2. Or user can select the playlist to show all media in that, then click one media to get data.
>
> After all, I decided to choose the first one. I note here for you to understand what I did.

Demo
---
I have prepared a short clip demo.

https://youtu.be/7rRjk9fXNJA

Setup
---
1. Open a terminal and run:
    ```sh
    docker-compose up -d 
    ```

2. Run composer and database migration and seeding
    ```sh
   docker exec -it nct_app composer install
   docker exec -it nct_app php artisan migrate:fresh --seed
    ```
4. Visit http://0.0.0.0:8888 on your browser.

5. To stop and remove all the containers use thedown command:
    ```sh
    docker-compose down
    ```
    
Technical
---
I choose PHP 7 with Lumen framework and some package:

>- cviebrock/eloquent-sluggable: Easy creation of slugs for your Eloquent models in Laravel
>
>- fabpot/goutte: Provides a nice API to crawl websites and extract data from the HTML/XML responses
>
>- barryvdh/laravel-debugbar: Displays a debug bar in the browser with information from Laravel/Lumen
>
> I use this package to check my query (query times, n+1,...), runtime exception,..
> 

Answer the question
---
> Could we crawl hot video items from this source
https://www.tiktok.com/vi/trending in a similar way? How and/or Why?

Yes.
First, we will get `html source` from this page and get `json string` from `"itemList":` to first `}}`, then decode `json` to get list `videos`

###### tags: `Lumen` `Documentation` `Crawler` `NhacCuaTui` `CocCoc-testing`
