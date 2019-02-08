<?php

$factory->define(App\Topic::class, function (Faker\Generator $faker) {
    return [
        "course_id" => factory('App\Course')->create(),
        "title" => $faker->name,
        "slug" => $faker->name,
        "description" => $faker->name,
        "possition" => $faker->randomNumber(2),
        "free_lesson" => 0,
        "published" => 0,
    ];
});
