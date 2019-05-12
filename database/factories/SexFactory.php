<?php

use Faker\Generator as Faker;
use KW\Infrastructure\Eloquents\Sex;

$factory->define(Sex::class, function (Faker $faker) {
    return [
        'sex_index' => 1,
        'name'      => 'female'
    ];
});
