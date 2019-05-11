<?php

use Faker\Generator as Faker;
use KW\Infrastructure\Eloquents\Tag;

$factory->define(Tag::class, function (Faker $faker) {
    return [
        "name" => $faker->realText(10)
    ];
});
