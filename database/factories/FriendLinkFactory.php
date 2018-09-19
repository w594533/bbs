<?php

use Faker\Generator as Faker;

$factory->define(App\Models\FriendLink::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(10),
        'url' => $faker->url()
    ];
});
