<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReviewTest extends TestCase
{
    /**
     * @test
     */
    public function api_v1_reviewsにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/reviews');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_reviewsにPOSTメソッドでアクセスできる()
    {
        $response = $this->post('api/v1/reviews');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_reviews_idにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/reviews/{reviews_id}');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_reviews_idにPUTメソッドでアクセスできる()
    {
        $response = $this->put('api/v1/reviews/{reviews_id}');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_reviews_idにDELETEメソッドでアクセスできる()
    {
        $response = $this->delete('api/v1/reviews/{reviews_id}');
        $response->assertStatus(200);
    }
}
