<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyAndMemberTest extends TestCase
{
    /**
     * @test
     */
    public function api_v1_company_and_membersにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/company-and-members');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_company_and_membersにPOSTメソッドでアクセスできる()
    {
        $response = $this->post('api/v1/company-and-members');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_company_and_members_idにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/company-and-members/{company_and_members_id}');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_company_and_members_idにPUTメソッドでアクセスできる()
    {
        $response = $this->put('api/v1/company-and-members/{company_and_members_id}');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_company_and_members_idにDELETEメソッドでアクセスできる()
    {
        $response = $this->delete('api/v1/company-and-members/{company_and_members_id}');
        $response->assertStatus(200);
    }
}
