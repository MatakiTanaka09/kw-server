<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SchoolAndMemberTest extends TestCase
{
    /**
     * @test
     */
    public function api_v1_school_and_membersにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/school-and-members');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_school_and_membersにPOSTメソッドでアクセスできる()
    {
        $response = $this->post('api/v1/school-and-members');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_school_and_members_idにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/school-and-members/{school_and_members_id}');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_school_and_members_idにPUTメソッドでアクセスできる()
    {
        $response = $this->put('api/v1/school-and-members/{school_and_members_id}');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_school_and_members_idにDELETEメソッドでアクセスできる()
    {
        $response = $this->delete('api/v1/school-and-members/{school_and_members_id}');
        $response->assertStatus(200);
    }
}
