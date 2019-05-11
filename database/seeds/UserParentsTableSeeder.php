<?php

use KW\Infrastructure\Eloquents\UserParent;
use Illuminate\Database\Seeder;

class UserParentsTableSeeder extends Seeder
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
        Factory(UserParent::class, 10)->create();
    }
}
