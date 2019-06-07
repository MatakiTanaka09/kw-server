<?php

namespace Tests\Feature\kw;

use KW\Infrastructure\Eloquents\EventMaster;
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
    public function api_v1_event_detailsにGETメソッドでアクセスできる()
    {
        $response = $this->get(self::EVENT_DETAILS);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_event_detailsにGETメソッドでアクセスするとJSONが返却される()
    {
        $response = $this->get(self::EVENT_DETAILS);
        $this->assertThat($response->content(), $this->isJson());
    }

    /**
     * @test
     */
    public function api_v1_event_detailsにGETメソッドで取得できるユーザー情報のJSON形式は要件通りである()
    {
        $response = $this->get(self::EVENT_DETAILS);
        $eventDetails = $response->json();
        $eventDetail = $eventDetails[0];
        $this->assertSame([
            'id',
            'event_master_id',
            'event_pr_id',
            'title',
            'detail',
            'started_at',
            'expired_at',
            'pub_state',
            'zip_code1',
            'zip_code2',
            'state',
            'city',
            'address1',
            'address2',
            'longitude',
            'latitude'
        ], array_keys($eventDetail));
    }

    /**
     * @test
     */
    public function api_v1_event_detailsにPOSTメソッドでアクセスできる()
    {
        $eventDetails = [
            'event_master_id'  => 'fce485a5-f5c9-49ee-8b26-31712e7dc7c2',
            'event_pr_id'      => 1,
            'title'            => '楽しいKW開発',
            'detail'           => 'サービス開発を学ぶ',
            'started_at'       => '2019-05-11 10:00:00',
            'expired_at'       => '2019-05-11 11:00:00',
            'pub_state'        => 0,
            'zip_code1'        => '111',
            'zip_code2'        => '2222',
            'state'            => '東京都',
            'city'             => '中央区',
            'address1'         => '月島',
            'address2'         => '1-1-1',
            'longitude'        => 32.2,
            'latitude'         => 20.8
        ];
        $response = $this->postJson(self::EVENT_DETAILS, $eventDetails);
        $response->assertStatus(200);
    }

    public function api_v1_event_details_event_detail_idにデータをPOSTするとevent_detailsテーブルにそのデータが追加される()
    {
        $newEventDetails = factory(EventMaster::class)->make();
        $params = [
            'event_master_id'  => $newEventDetails->event_master_id,
            'event_pr_id'      => $newEventDetails->event_pr_id,
            'title'            => $newEventDetails->title,
            'detail'           => $newEventDetails->detail,
            'started_at'       => $newEventDetails->started_at,
            'expired_at'       => $newEventDetails->expired_at,
            'pub_state'        => $newEventDetails->pub_state,
            'zip_code1'        => $newEventDetails->zip_code1,
            'zip_code2'        => $newEventDetails->zip_code2,
            'state'            => $newEventDetails->state,
            'city'             => $newEventDetails->city,
            'address1'         => $newEventDetails->address1,
            'address2'         => $newEventDetails->address2,
            'longitude'        => $newEventDetails->longitude,
            'latitude'         => $newEventDetails->latitude
        ];
        $this->postJson(self::EVENT_DETAILS, $params);
        $this->assertDatabaseHas(self::EVENT_DETAILS_TABLE, $params);
    }

    /**
     * @test
     */
    public function POST_api_v1_event_detailsのエラーレスポンスの確認()
    {
        $params = [
            'event_master_id'  => '',
            'event_pr_id'      => '',
            'title'            => '',
            'detail'           => '',
            'started_at'       => '',
            'expired_at'       => '',
            'pub_state'        => '',
            'zip_code1'        => '',
            'zip_code2'        => '',
            'state'            => '',
            'city'             => '',
            'address1'         => '',
            'address2'         => '',
            'longitude'        => '',
            'latitude'         => ''
        ];
        $response = $this->postJson(self::EVENT_DETAILS, $params);
        $error_response = [
            'message' => "The given data was invalid.",
            'errors' => [
                'event_master_id' => [
                    'validation.required'
                ],
                'event_pr_id' => [
                    'validation.required'
                ],
                'title' => [
                    'validation.required'
                ],
                'detail' => [
                    'validation.required'
                ],
                'started_at' => [
                    'validation.required'
                ],
                'expired_at' => [
                    'validation.required'
                ],
                'pub_state' => [
                    'validation.required'
                ],
                'zip_code1' => [
                    'validation.required'
                ],
                'zip_code2' => [
                    'validation.required'
                ],
                'state' => [
                    'validation.required'
                ],
                'city' => [
                    'validation.required'
                ],
                'address1' => [
                    'validation.required'
                ],
                'address2' => [
                    'validation.required'
                ],
                'longitude' => [
                    'validation.required'
                ],
                'latitude' => [
                    'validation.required'
                ]
            ]
        ];
        $response->assertExactJson($error_response);
    }

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

    /**
     * @test
     */
    public function api_v1_event_details_event_detail_idにPUTメソッドでアクセスできる()
    {
        $event_detail_id = $this->getFirstEventDetailId();
        $response = $this->putJson(self::EVENT_DETAILS. $event_detail_id, [
            'event_master_id'  => 'fce485a5-f5c9-49ee-8b26-31712e7dc7c2',
            'event_pr_id'      => 1,
            'title'            => '楽しいKW開発',
            'detail'           => 'サービス開発を学ぶ',
            'started_at'       => '2019-05-11 10:00:00',
            'expired_at'       => '2019-05-11 11:00:00',
            'pub_state'        => 0,
            'zip_code1'        => '111',
            'zip_code2'        => '2222',
            'state'            => '東京都',
            'city'             => '中央区',
            'address1'         => '月島',
            'address2'         => '1-1-1',
            'longitude'        => 32.2,
            'latitude'         => 20.8
        ]);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_event_details_event_detail_idにPUTメソッドでデータを編集できる()
    {
        $event_detail_id = $this->getFirstEventDetailId();
        $response = $this->get(self::EVENT_DETAILS. $event_detail_id);
        $event_detail = $response->json();
        $new = [
            'event_master_id'  => $event_detail['event_master_id'],
            'event_pr_id'      => $event_detail['event_pr_id'],
            'title'            => $event_detail['title'],
            'detail'           => $event_detail['detail'],
            'started_at'       => $event_detail['started_at'],
            'expired_at'       => $event_detail['expired_at'],
            'pub_state'        => $event_detail['pub_state'],
            'zip_code1'        => $event_detail['zip_code1'],
            'zip_code2'        => $event_detail['zip_code2'],
            'state'            => $event_detail['state'],
            'city'             => $event_detail['city'],
            'address1'         => $event_detail['address1'],
            'address2'         => $event_detail['address2'],
            'longitude'        => $event_detail['longitude'],
            'latitude'         => $event_detail['latitude']
        ];
        $this->putJson(self::EVENT_DETAILS. $event_detail_id, $new);

        $response = $this->get(self::EVENT_DETAILS. $event_detail_id);
        $event_detail = $response->json();
        $event_detail_result = [
            'event_master_id'  => $event_detail['event_master_id'],
            'event_pr_id'      => $event_detail['event_pr_id'],
            'title'            => $event_detail['title'],
            'detail'           => $event_detail['detail'],
            'started_at'       => $event_detail['started_at'],
            'expired_at'       => $event_detail['expired_at'],
            'pub_state'        => $event_detail['pub_state'],
            'zip_code1'        => $event_detail['zip_code1'],
            'zip_code2'        => $event_detail['zip_code2'],
            'state'            => $event_detail['state'],
            'city'             => $event_detail['city'],
            'address1'         => $event_detail['address1'],
            'address2'         => $event_detail['address2'],
            'longitude'        => $event_detail['longitude'],
            'latitude'         => $event_detail['latitude']
        ];
        $this->assertSame($new, $event_detail_result);
    }

    /**
     * @test
     */
    public function aapi_v1_event_details_event_detail_idに存在しないevent_detail_idでPUTメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->putJson(self::EVENT_DETAILS. '999', [
            'event_master_id'  => 'fce485a5-f5c9-49ee-8b26-31712e7dc7c2',
            'event_pr_id'      => 1,
            'title'            => '楽しいKW開発',
            'detail'           => 'サービス開発を学ぶ',
            'started_at'       => '2019-05-11 10:00:00',
            'expired_at'       => '2019-05-11 11:00:00',
            'pub_state'        => 0,
            'zip_code1'        => '111',
            'zip_code2'        => '2222',
            'state'            => '東京都',
            'city'             => '中央区',
            'address1'         => '月島',
            'address2'         => '1-1-1',
            'longitude'        => 32.2,
            'latitude'         => 20.8
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .EventDetail::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_event_details_event_detail_idにDELETEメソッドでアクセスできる()
    {
        $event_detail_id = $this->getFirstEventDetailId();
        EventDetail::query()->where('id', '=', $event_detail_id)->delete();
        $response = $this->delete(self::EVENT_DETAILS . $event_detail_id);
        $response->assertStatus(200);
    }

    private function getFirstEventDetailId()
    {
        return EventDetail::query()->first()->value('id');
    }
}
