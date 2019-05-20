<?php

namespace Tests\Feature\users;

use KW\Infrastructure\Eloquents\EventDetail;
use Tests\KWBaseTestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;

class EventDetailTest extends KWBaseTestCase
{
    /**
     * base utils
     * - api url
     * - table
     */
    const EVENT_DETAILS = 'api/v1/kw/event-details/';
    const EVENT_DETAILS_TABLE = 'event_details';

    /**
     * @test
     */
    public function api_v1_event_details_event_detail_idにGETメソッドでアクセスできる()
    {
        $event_detail_id = $this->getFirstEventDetailId();
        $response = $this->get(self::EVENT_DETAILS. $event_detail_id);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_event_mastersに存在しないevent_detail_idでGETメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->get(self::EVENT_DETAILS. 'adass230394');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .EventDetail::class. '].'
        ]);
    }

    private function getFirstEventDetailId()
    {
        return EventDetail::query()->first()->value('id');
    }
}
