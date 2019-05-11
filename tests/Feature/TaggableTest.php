<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaggableTest extends TestCase
{
    /**
     * @test
     */
    public function api_v1_taggablesにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/taggables');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_taggablesにPOSTメソッドでアクセスできる()
    {
        $response = $this->post('api/v1/taggables');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_taggables_idにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/taggables/{taggables_id}');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_taggables_idにPUTメソッドでアクセスできる()
    {
        $response = $this->put('api/v1/taggables/{taggables_id}');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_taggables_idにDELETEメソッドでアクセスできる()
    {
        $response = $this->delete('api/v1/taggables/{taggables_id}');
        $response->assertStatus(200);
    }
}
