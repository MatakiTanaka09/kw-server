<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call([
//             UserMastersTableSeeder::class,
//             UserParentsTableSeeder::class,
//             UserChildrenTableSeeder::class,
//             BooksTableSeeder::class,
//             EventDetailsTableSeeder::class,
            TestDataTableSeeder::class
         ]);
    }
}
