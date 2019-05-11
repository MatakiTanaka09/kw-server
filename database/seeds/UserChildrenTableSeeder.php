<?php

use Illuminate\Database\Seeder;
use KW\Infrastructure\Eloquents\UserChild;

class UserChildrenTableSeeder extends Seeder
{
    private $faker;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Faker\Factory::create('ja_JP');
        Factory(UserChild::class, 10)->create();
    }
}
