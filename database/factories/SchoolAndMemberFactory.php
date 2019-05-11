<?php

use Faker\Generator as Faker;
use KW\Infrastructure\Eloquents\SchoolAndMember;
use KW\Infrastructure\Eloquents\SchoolAdminMaster;

$factory->define(SchoolAndMember::class, function (Faker $faker) {
    return [
        'school_admin_master_id' => function() {
            return factory(SchoolAdminMaster::class)->create()->id;
        },
        'name' => $faker->text(10),
    ];
});
