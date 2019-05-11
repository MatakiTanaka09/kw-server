<?php

use Faker\Generator as Faker;
use KW\Infrastructure\Eloquents\CompanyMaster;

$factory->define(CompanyMaster::class, function (Faker $faker) {
    return [
        "name"      => $faker->realText($maxNbChars = 10, $indexSize = 2),
        "detail"    => $faker->realText($maxNbChars = 200, $indexSize = 2),
        'email'     => $faker->unique()->safeEmail,
        'url'       => "http://amazon.s3.com...",
        'icon'      => "http://amazon.s3.com...",
        'tel'       => $faker->phoneNumber,
        'zip_code1' => $faker->regexify('[1-9]{3}'),
        'zip_code2' => $faker->regexify('[1-9]{4}'),
        'state'     => '東京都',
        'city'      => $faker->randomElement(['中央区', '渋谷区', '江東区']),
        'address1'  => $faker->randomElement(['月島', '二子玉川', '豊洲']),
        'address2'  => $faker->randomElement(['1-1-1', '2-2-2', '3-3-3']),
        'latitude'  => $faker->latitude,
        'longitude' => $faker->longitude
    ];
});
