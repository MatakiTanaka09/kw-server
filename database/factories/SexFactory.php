<?php

use Faker\Generator as Faker;
use KW\Infrastructure\Eloquents\Sex;

$factory->define(Sex::class, function (Faker $faker) {
    return [
        'index' => 5,
        'name'  => 'female'
    ];
});
