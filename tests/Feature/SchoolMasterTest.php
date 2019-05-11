<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SchoolMasterTest extends TestCase
{
    /**
     * @test
     */
    public function api_v1_school_mastersにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/school-masters');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_school_mastersにPOSTメソッドでアクセスできる()
    {
        $response = $this->post('api/v1/school-masters');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_school_masters_idにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/school-masters/{school_masters_id}');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_school_masters_idにPUTメソッドでアクセスできる()
    {
        $response = $this->put('api/v1/school-masters/{school_masters_id}');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_school_masters_idにDELETEメソッドでアクセスできる()
    {
        $response = $this->delete('api/v1/school-masters/{school_masters_id}');
        $response->assertStatus(200);
    }
}
