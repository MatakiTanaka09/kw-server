<?php

use Faker\Generator as Faker;
use KW\Infrastructure\Eloquents\EventPr;

$factory->define(EventPr::class, function (Faker $faker) {
    return [
        "pr" => $faker->text(200)
    ];
});
