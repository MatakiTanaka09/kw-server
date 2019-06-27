<?php

use Illuminate\Database\Seeder;
use KW\Infrastructure\Eloquents\UserMaster;
use KW\Infrastructure\Eloquents\UserParent;
use KW\Infrastructure\Eloquents\UserChild;
use KW\Infrastructure\Eloquents\ChildParent;
use KW\Infrastructure\Eloquents\EventDetail;
use KW\Infrastructure\Eloquents\EventMaster;
use KW\Infrastructure\Eloquents\SchoolAdminMaster;
use KW\Infrastructure\Eloquents\SchoolMaster;
use KW\Infrastructure\Eloquents\SchoolAndMember;
use KW\Infrastructure\Eloquents\Taggable;
use KW\Infrastructure\Eloquents\Tag;
use KW\Infrastructure\Eloquents\CategoryMaster;
use KW\Infrastructure\Eloquents\Categorizable;
use KW\Infrastructure\Eloquents\Image;
use KW\Infrastructure\Eloquents\CompanyAdminMaster;
use KW\Infrastructure\Eloquents\CompanyMaster;
use KW\Infrastructure\Eloquents\CompanyAndMember;
use KW\Infrastructure\Eloquents\Role;
use KW\Infrastructure\Eloquents\EventSchoolMaster;

class TestDataTableSeeder extends Seeder
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
        factory(UserParent::class, 10)->create();
        $userParents = UserParent::all();

        /**
         * child_parentsテーブルの紐付け
         */
        factory(UserChild::class, 10)
            ->create()
            ->each(function($userChild) use($userParents) {
                $userChild->userParents()->attach(
                    $userParents->random(rand(1,3))->pluck('id')->toArray()
                );
            });

        /**
         *
         */
        $childParents = ChildParent::all();

        factory(SchoolMaster::class, 10)
            ->create()
            ->each(function($schoolMaster) {
                $schoolMaster->schoolAndMembers()->save(factory(SchoolAndMember::class)->make());
//                $schoolMaster->categoryMasters()->save(factory(CategoryMaster::class)->make());
                $schoolMaster->images()->create(['url' => 'https://kw-prod-bucket.s3-ap-northeast-1.amazonaws.com/category/science.jpeg']);
            });

        factory(EventMaster::class, 5)
            ->create()
            ->each(function($eventMaster) {
                $eventMaster->images()->create(['url' => 'https://kw-prod-bucket.s3-ap-northeast-1.amazonaws.com/category/science.jpeg']);
//                $eventMaster->categoryMasters()->save(factory(CategoryMaster::class)->make());
                $eventMaster->eventDetails()->save(factory(EventDetail::class)->make());
//                $eventMaster->schoolMasters()->attach(
//                    $schoolMasters->random(rand(1,3))->pluck('id')->toArray()
//                );
            });

        $schoolMasters = SchoolMaster::all();
        $eventMasters = EventMaster::all();
        foreach ($schoolMasters as $schoolMaster) {
            $schoolMaster->eventMasters()->attach(
                $eventMasters->random(rand(1,2))->pluck('id')->toArray()
            );
        }

        factory(CompanyMaster::class, 10)
            ->create()
            ->each(function($companyMaster) {
                $companyMaster->companyAndMembers()->save(factory(CompanyAndMember::class)->make());
            });

        factory(Tag::class, 10)->create();
        $tags = Tag::all();
        $eventDetails = EventDetail::all();
        $userChildren = UserChild::all();

        foreach ($eventDetails as $eventDetail) {
            $userParentId = $userParents->random(rand(1,2))->pluck('id')->toArray();

            $eventDetail->books()->attach(
                $userParentId,
                [
                    'id' => $this->faker->uuid,
                    'user_child_id' => $userChildren->random()->id,
                    'status' => $this->faker->randomElement([0, 5, 9, 10]),
                    'price' => $this->faker->randomElement([1000, 1500, 1800, 2000, 2500])
                ]
            );
            $eventDetail->reviews()->attach(
                $userParents->random(rand(1,3))->pluck('id')->toArray(),
                [
                    'comment' => $this->faker->realText(),
                    'star_amount' => $this->faker->randomElement([1, 2, 3, 4, 5])
                ]
            );
            $eventDetail->tags()->attach(
                $tags->random(rand(1,3))->pluck('id')->toArray()
            );

        }

        DB::table('roles')->insert([
            ['name' => 'system-admin', 'role' => 1],
            ['name' => 'kw-ope', 'role' => 3],
            ['name' => 'organization-admin', 'role' => 5],
            ['name' => 'organization-ope', 'role' => 7],
            ['name' => 'general-user', 'role' => 10],
        ]);

        $roles = Role::all();
        $userMasters = UserMaster::all();
        $schoolAdminMasters = SchoolAdminMaster::all();
        $companyAdminMasters = CompanyAdminMaster::all();

        foreach ($userMasters as $userMaster) {
            $userMaster->roles()->attach(
                $roles->random(1)->pluck('id')->toArray()
            );
        }

        foreach ($schoolAdminMasters as $schoolAdminMaster) {
            $schoolAdminMaster->roles()->attach(
                $roles->random(1)->pluck('id')->toArray()
            );
        }

        foreach ($companyAdminMasters as $companyAdminMaster) {
            $companyAdminMaster->roles()->attach(
                $roles->random(1)->pluck('id')->toArray()
            );
        }

        DB::table('category_masters')->insert([
            [
                "name"       => "その他",
                "filename"   => "https://kw-prod-bucket.s3-ap-northeast-1.amazonaws.com/category/science.jpeg",
                "color"      => "red",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name"       => "アート",
                "color"      => "red",
                "filename"   => "https://kw-prod-bucket.s3-ap-northeast-1.amazonaws.com/category/science.jpeg",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name"       => "教育",
                "color"      => "red",
                "filename"   => "https://kw-prod-bucket.s3-ap-northeast-1.amazonaws.com/category/science.jpeg",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name"       => "外国語",
                "color"      => "red",
                "filename"   => "https://kw-prod-bucket.s3-ap-northeast-1.amazonaws.com/category/science.jpeg",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name"       => "音楽",
                "color"      => "red",
                "filename"   => "https://kw-prod-bucket.s3-ap-northeast-1.amazonaws.com/category/science.jpeg",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "name"       => "テクノロジー",
                "color"      => "red",
                "filename"   => "https://kw-prod-bucket.s3-ap-northeast-1.amazonaws.com/category/science.jpeg",
                "created_at" => now(),
                "updated_at" => now()

            ],
            [
                "name"       => "スポーツ",
                "color"      => "red",
                "filename"   => "https://kw-prod-bucket.s3-ap-northeast-1.amazonaws.com/category/science.jpeg",
                "created_at" => now(),
                "updated_at" => now()
            ]
        ]);

        $categoryMasters = CategoryMaster::all();
        $schoolMasters = SchoolMaster::all();
        $eventMasters = EventMaster::all();

        foreach ($schoolMasters as $schoolMaster) {
            $schoolMaster->categoryMasters()->attach(
                $categoryMasters->random(1)->pluck('id')->toArray()
            );
        }

        foreach ($eventMasters as $eventMaster) {
            $eventMaster->categoryMasters()->attach(
                $categoryMasters->random(1)->pluck('id')->toArray()
            );
        }

        DB::table('sexes')->insert([
            [
                "name"       => "not_known",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name"       => "male",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name"       => "female",
                "created_at" => now(),
                "updated_at" => now()
            ],
            [
                "name"       => "not_applicable",
                "created_at" => now(),
                "updated_at" => now()
            ]
        ]);
    }
}
