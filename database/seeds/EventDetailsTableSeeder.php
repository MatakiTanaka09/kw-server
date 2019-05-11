<?php

use KW\Infrastructure\Eloquents\EventDetail;
use KW\Infrastructure\Eloquents\EventMaster;
use KW\Infrastructure\Eloquents\SchoolMaster;
use Illuminate\Database\Seeder;

class EventDetailsTableSeeder extends Seeder
{
    private $faker;
    private $eventMasters = [];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Faker\Factory::create('ja_JP');
        $schoolMaster = Factory(SchoolMaster::class, 10)->create();

    }

    public function createEventMaster(SchoolMaster $schoolMaster)
    {
        if (rand(1, 100) % 3 === 1) {
            $this->eventMasters[] = EventMaster::create([
                'school_masters_id' => $schoolMaster->id,
                'title'             => $this->faker->realText($maxNbChars = 10, $indexSize = 2),
                'detail'            => $this->faker->realText($maxNbChars = 200, $indexSize = 2),
            ]);
        }
    }
}
