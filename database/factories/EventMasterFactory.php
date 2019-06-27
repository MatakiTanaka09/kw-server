<?php

use Faker\Generator as Faker;
use KW\Infrastructure\Eloquents\EventMaster;
use KW\Infrastructure\Eloquents\SchoolMaster;

$factory->define(EventMaster::class, function (Faker $faker) {
    return [
        "title"  => $faker->realText($maxNbChars = 10, $indexSize = 2),
        "detail" => $faker->realText($maxNbChars = 200, $indexSize = 2),
        'handing'          => $faker->text(200),
        'event_minutes'    => $faker->numberBetween(15, 90),
        'target_min_age'   => $faker->numberBetween(0, 5),
        'target_max_age'   => $faker->numberBetween(6, 10),
        'parent_attendant' => $faker->boolean($chanceOfGettingTrue = 20),
        'price'            => $faker->randomElement([1000, 1500, 1800, 2000, 2500]),
        'cancel_policy'    => $faker->text(200),
        'arrived_at'       => $faker->numberBetween(5, 15),
        'zip_code1'        => $faker->regexify('[1-9]{3}'),
        'zip_code2'        => $faker->regexify('[1-9]{4}'),
        'state'            => '東京都',
        'city'             => $faker->randomElement(['中央区', '渋谷区', '江東区']),
        'address1'         => $faker->randomElement(['月島', '二子玉川', '豊洲']),
        'address2'         => $faker->randomElement(['1-1-1', '2-2-2', '3-3-3']),
        'latitude'         => $faker->latitude,
        'longitude'        => $faker->longitude
    ];
});
