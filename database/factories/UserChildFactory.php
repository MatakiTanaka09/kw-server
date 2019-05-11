<?php

use Faker\Generator as Faker;
use KW\Infrastructure\Eloquents\UserChild;

$factory->define(UserChild::class, function (Faker $faker) {
    return [
        'first_kana' => $faker->name,
        'last_kana'  => $faker->name,
        'sex_id'   => $faker->randomElement([1, 2]),
        'icon'       => "http://amazon.s3.com...",
        'birth_day'  => $faker->dateTimeBetween('-10 years', '-0years')->format('Y-m-d H:m:s')
    ];
});
