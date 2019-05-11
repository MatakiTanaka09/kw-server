<?php

use Faker\Generator as Faker;
use KW\Infrastructure\Eloquents\EventDetail;
use KW\Infrastructure\Eloquents\CategoryMaster;

$factory->define(EventDetail::class, function (Faker $faker) {
    return [
        'event_master_id'  => $faker->uuid,
        'category_master_id' => function() {
            return factory(CategoryMaster::class)->create()->id;
        },
        'title'            => $faker->text(10),
        'detail'           => $faker->text(200),
        'started_at'       => $faker->dateTimeBetween('-0 years', '-0years')->format('Y-m-d H:m:s'),
        'expired_at'       => $faker->dateTimeBetween('-0 years', '-0years')->format('Y-m-d H:m:s'),
        'capacity_members' => $faker->numberBetween(3, 15),
        'target_min_age'   => $faker->numberBetween(0, 5),
        'target_max_age'   => $faker->numberBetween(6, 10),
        'pr'               => $faker->text(30),
        'parent_attendant' => $faker->boolean($chanceOfGettingTrue = 20),
        'price'            => $faker->randomElement([1000, 1500, 1800, 2000, 2500]),
        'canceled_at'      => $faker->numberBetween(1, 7),
        'pub_state'        => $faker->boolean($chanceOfGettingTrue = 20),
        'arrived_at'       => $faker->numberBetween(5, 15),
        'zip_code1'       => $faker->regexify('[1-9]{3}'),
        'zip_code2'       => $faker->regexify('[1-9]{4}'),
        'state'            => '東京都',
        'city'             => $faker->randomElement(['中央区', '渋谷区', '江東区']),
        'address1'         => $faker->randomElement(['月島', '二子玉川', '豊洲']),
        'address2'         => $faker->randomElement(['1-1-1', '2-2-2', '3-3-3']),
        'latitude'         => $faker->latitude,
        'longitude'        => $faker->longitude
    ];
});
