<?php

use Faker\Generator as Faker;
use KW\Infrastructure\Eloquents\UserMaster;
use KW\Infrastructure\Eloquents\UserParent;

$factory->define(UserParent::class, function (Faker $faker) {
    return [
        'user_master_id' => function() {
            return factory(UserMaster::class)->create()->id;
        },
        'sex_id'         => $faker->randomElement([1, 2]),
        'icon'           => "http://amazon.s3.com...",
        'full_name'      => $faker->name,
        'full_kana'      => $faker->name,
        'tel'            => $faker->phoneNumber,
        'zip_code1'      => $faker->regexify('[1-9]{3}'),
        'zip_code2'      => $faker->regexify('[1-9]{4}'),
        'state'          => '東京都',
        'city'           => $faker->randomElement(['中央区', '渋谷区', '江東区']),
        'address1'       => $faker->randomElement(['月島', '二子玉川', '豊洲']),
        'address2'       => $faker->randomElement(['1-1-1', '2-2-2', '3-3-3'])
    ];
});

