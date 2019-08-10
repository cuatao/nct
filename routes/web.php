<?php

$router->get('/', function () use ($router) {
    return view('home');
});

$router->get('get-media', 'MediaController@getDataFromUrl');
$router->get('medias/{id}/fetch-new-download-url', 'MediaController@fetchNewDownloadUrl');
$router->get('playlists/{slug}', 'PlaylistController@show');
$router->get('playlists', 'PlaylistController@index');
$router->get('search', 'MediaController@search');
