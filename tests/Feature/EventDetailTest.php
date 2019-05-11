<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EventDetailTest extends TestCase
{
    /**
     * @test
     */
    public function api_v1_event_detailsにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/event-details');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_event_detailsにPOSTメソッドでアクセスできる()
    {
        $response = $this->post('api/v1/event-details');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_event_details_idにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/event-details/{event_details_id}');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_event_details_idにPUTメソッドでアクセスできる()
    {
        $response = $this->put('api/v1/event-details/{event_details_id}');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_event_details_idにDELETEメソッドでアクセスできる()
    {
        $response = $this->delete('api/v1/event-details/{event_details_id}');
        $response->assertStatus(200);
    }
}
