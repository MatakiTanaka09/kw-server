<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;

class KWBaseTestCase extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'TestDataTableSeeder']);
    }
}
