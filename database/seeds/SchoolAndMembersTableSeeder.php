<?php

use Illuminate\Database\Seeder;
use KW\Infrastructure\Eloquents\SchoolAndMember;

class SchoolAndMembersTableSeeder extends Seeder
{
    private $faker;
    private $schoolAndMembers = [];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Faker\Factory::create('ja_JP');
        $userChildren = factory(SchoolAndMember::class, 10)->create();
        foreach ($userChildren as $userChild) {
            $this->createSchoolAndMember($userChild);
            $this->createSchoolAndMember($userChild);
            $this->createSchoolAndMember($userChild);
        }
    }

    public function createSchoolAndMember(SchoolAndMember $schoolAndMember)
    {
        if (rand(1, 100) % 3 === 1) {
            $this->books[] = SchoolAndMember::create([
                'school_masters_id' => $schoolAndMember->id,
                'school_admin_masters_id' => $schoolAndMember->school_admin_masters_id,
                'name' => $this->faker->text(10)
            ]);
        }
    }

    public function create()
    {
        return parent::__invoke(); // TODO: Change the autogenerated stub
    }
}
