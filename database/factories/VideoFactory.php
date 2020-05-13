<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Video;
use Faker\Generator as Faker;

$factory->define(Video::class, function (Faker $faker) {
    return [
        'title'         =>      $faker->sentence(6),
        'name'          =>      $faker->name(6),
        'url'           =>      $faker->url(),
        'category_id'   =>      function () {
        return App\Category::inRandomOrder()->first()->id;
    }
    ];
});
