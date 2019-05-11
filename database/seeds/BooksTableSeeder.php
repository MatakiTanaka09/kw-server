<?php

use Illuminate\Database\Seeder;
use KW\Infrastructure\Eloquents\Book;
use KW\Infrastructure\Eloquents\UserChild;

class BooksTableSeeder extends Seeder
{
    private $faker;
    private $books = [];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->faker = Faker\Factory::create('ja_JP');
        $userChildren = factory(UserChild::class, 10)->create();
        foreach ($userChildren as $userChild) {
            $this->createBook($userChild);
            $this->createBook($userChild);
            $this->createBook($userChild);
            $this->createBook($userChild);
        }
    }

    public function createBook(UserChild $userChild)
    {
        if (rand(1, 100) % 3 === 1) {
            $this->books[] = Book::create([
                'user_children_id' => $userChild->id,
                'user_parents_id' => $userChild->user_parents_id,
                'event_details_id' => $this->faker->uuid,
                'status' => $this->faker->randomElement([0, 5, 9, 10]),
                'price' => $this->faker->randomElement([1000, 1500, 1800, 2000, 2500]),
            ]);
        }
    }
}
