<?php

use Faker\Generator as Faker;
use KW\Infrastructure\Eloquents\CategoryMaster;

$factory->define(CategoryMaster::class, function (Faker $faker) {
    return [
        "name" => $faker->realText(20),
        "color" => $faker->realText(20),
        "filename" => $faker->realText(20),
    ];
});
