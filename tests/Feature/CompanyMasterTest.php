<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompanyMasterTest extends TestCase
{
    /**
     * @test
     */
    public function api_v1_company_mastersにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/company-masters');
        $response->assertStatus(200);
    }

    public function api_v1_company_mastersにGETメソッドでアクセスするとJSONが返却される()
    {

    }
    public function api_v1_company_mastersにGETメソッドで取得できるユーザー情報のJSON形式は要件通りである()
    {

    }
    public function api_v1_company_mastersにGETメソッドで取得できるユーザー情報は10件である()
    {

    }

    /**
     * @test
     */
    public function api_v1_company_mastersにPOSTメソッドでアクセスできる()
    {
        $response = $this->post('api/v1/company-masters');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_company_masters_idにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/company-masters/{school_masters_id}');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_company_masters_idにPUTメソッドでアクセスできる()
    {
        $response = $this->put('api/v1/company-masters/{school_masters_id}');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_company_masters_idにDELETEメソッドでアクセスできる()
    {
        $response = $this->delete('api/v1/company-masters/{school_masters_id}');
        $response->assertStatus(200);
    }
}
