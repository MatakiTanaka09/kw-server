<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagTest extends TestCase
{
    /**
     * @test
     */
    public function api_v1_tagsにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/tags');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_tagsにPOSTメソッドでアクセスできる()
    {
        $response = $this->post('api/v1/tags');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_tags_idにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/tags/{tags_id}');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_tags_idにPUTメソッドでアクセスできる()
    {
        $response = $this->put('api/v1/tags/{tags_id}');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_tags_idにDELETEメソッドでアクセスできる()
    {
        $response = $this->delete('api/v1/tags/{tags_id}');
        $response->assertStatus(200);
    }
}
