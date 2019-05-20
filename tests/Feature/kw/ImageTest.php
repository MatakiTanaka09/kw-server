<?php

namespace Tests\Feature\kw;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ImageTest extends TestCase
{
    /**
     * @test
     */
    public function api_v1_imagesにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/images');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_imagesにPOSTメソッドでアクセスできる()
    {
        $response = $this->post('api/v1/images');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_images_idにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/images/{images_id}');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_images_idにPUTメソッドでアクセスできる()
    {
        $response = $this->put('api/v1/images/{images_id}');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_images_idにDELETEメソッドでアクセスできる()
    {
        $response = $this->delete('api/v1/images/{images_id}');
        $response->assertStatus(200);
    }
}
