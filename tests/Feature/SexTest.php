<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SexTest extends TestCase
{
    /**
     * @test
     */
    public function api_v1_sexesにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/sexes');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_sexesにPOSTメソッドでアクセスできる()
    {
        $response = $this->post('api/v1/sexes');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_sexes_sex_idにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/sexes/{sex_id}');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_sexes_sex_idにPUTメソッドでアクセスできる()
    {
        $response = $this->put('api/v1/sexes/{sex_id}');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_sexes_sex_idにDELETEメソッドでアクセスできる()
    {
        $response = $this->delete('api/v1/sexes/{sex_id}');
        $response->assertStatus(200);
    }
}
