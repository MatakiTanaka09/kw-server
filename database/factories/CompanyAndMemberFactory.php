<?php

use Faker\Generator as Faker;
use KW\Infrastructure\Eloquents\CompanyAndMember;
use KW\Infrastructure\Eloquents\CompanyAdminMaster;

$factory->define(CompanyAndMember::class, function (Faker $faker) {
    return [
        'company_admin_master_id' => function() {
            return factory(CompanyAdminMaster::class)->create()->id;
        },
        'name' => $faker->text(10),
    ];
});
