<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp()
    {
        parent::setUp();
//        $this->artisan('cache:clear');
//        $this->artisan('migrate:fresh');
//        \DB::beginTransaction();
    }
}
