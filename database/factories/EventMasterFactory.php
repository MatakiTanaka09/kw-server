<?php

use Faker\Generator as Faker;
use KW\Infrastructure\Eloquents\EventMaster;
use KW\Infrastructure\Eloquents\SchoolMaster;

$factory->define(EventMaster::class, function (Faker $faker) {
    return [
        "title"  => $faker->realText($maxNbChars = 10, $indexSize = 2),
        "detail" => $faker->realText($maxNbChars = 200, $indexSize = 2),
    ];
});
