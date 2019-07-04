<?php

use Faker\Generator as Faker;
use KW\Infrastructure\Eloquents\Book;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'status' => $faker->randomElement([0, 5, 9, 10]),
        'price'  => $faker->randomElement([1000, 1500, 1800, 2000, 2500]),
        'remark' => $faker->text(200)
    ];
});

