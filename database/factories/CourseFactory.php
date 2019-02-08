<?php

$factory->define(App\Course::class, function (Faker\Generator $faker) {
    $name =  $faker->name;
    return [
        "title" => $name,
        "slug" => str_slug($name),
        "description" => $name,
        "price" => $faker->randomNumber(2),
        "start_date" => $faker->date("Y-m-d", $max = 'now'),
        "published" => 0,
    ];
});
