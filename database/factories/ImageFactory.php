<?php

use Faker\Generator as Faker;
use KW\Infrastructure\Eloquents\Image;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'imageable_id' => $faker->uuid,
        'imageable_type' => $faker->realText(10),
        'url' => "http://amazon.s3.com..."
    ];
});
