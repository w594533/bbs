<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Models\Reply::class, function (Faker $faker) {
    $updated_at = $faker->dateTimeThisMonth();
    $created_at = $faker->dateTimeThisMonth($updated_at);
    return [
        'body' => $faker->sentence(),
        'created_at' => $created_at,
        'updated_at' => $updated_at
    ];
});
