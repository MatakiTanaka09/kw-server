<?php

use KW\Infrastructure\Eloquents\UserMaster;
use Illuminate\Database\Seeder;

class UserMastersTableSeeder extends Seeder
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
        Factory(UserMaster::class, 10)->create();
    }
}
