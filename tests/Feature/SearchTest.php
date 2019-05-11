<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchTest extends TestCase
{
    /**
     * @test
     */
    public function api_v1_search_dateにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/search/date');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_search_ageにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/search/age');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_search_placeにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/search/place');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_search_priceにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/search/price');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_search_categoryにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/search/category');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_search_tagにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/search/tag');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_search_schoolにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/search/school');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_search_reviewにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/search/review');
        $response->assertStatus(200);
    }
}
