<?php

use Illuminate\Database\Seeder;
use KW\Infrastructure\Eloquents\EventMaster;

class EventMastersTableSeeder extends Seeder
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
        Factory(EventMaster::class, 10)->create();
    }
}
