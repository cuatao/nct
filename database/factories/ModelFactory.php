<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\Playlist::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
//        'image_path' => $faker->imageUrl(500, 500),
    ];
});

$factory->define(App\Models\Media::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->name,
        'image_path' => $faker->imageUrl(500, 500),
        'download_url' => $faker->url,
        'source_url' => $faker->url,
        'source' => $faker->word,
        'key' => $faker->uuid,
        'type' => $faker->randomElement(['video', 'audio']),
    ];
});
