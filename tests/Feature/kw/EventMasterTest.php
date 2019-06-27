<?php

namespace Tests\Feature\kw;

use KW\Infrastructure\Eloquents\EventMaster;
use KW\Infrastructure\Eloquents\EventDetail;
use Tests\KWBaseTestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;

class EventMasterTest extends KWBaseTestCase
{
    /**
     * base utils
     * - api url
     * - table
     */
    const EVENT_MASTERS = 'api/v1/kw/event-masters/';
    const EVENT_MASTERS_TABLE = 'event_masters';

    /**
     * @test
     */
    public function api_v1_event_mastersにGETメソッドでアクセスできる()
    {
        $response = $this->get(self::EVENT_MASTERS);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_event_mastersにGETメソッドでアクセスするとJSONが返却される()
    {
        $response = $this->get(self::EVENT_MASTERS);
        $this->assertThat($response->content(), $this->isJson());
    }

    /**
     * @test
     */
    public function api_v1_event_mastersにGETメソッドで取得できるユーザー情報のJSON形式は要件通りである()
    {
        $response = $this->get(self::EVENT_MASTERS);
        $eventMasters = $response->json();
        $eventMaster = $eventMasters[0];
        $this->assertSame([
            'id',
            'title',
            'detail',
            'handing',
            'event_minutes',
            'target_min_age',
            'target_max_age',
            'parent_attendant',
            'price',
            'cancel_policy',
            'pub_state',
            'arrived_at',
            'zip_code1',
            'zip_code2',
            'state',
            'city',
            'address1',
            'address2',
            'longitude',
            'latitude'
        ], array_keys($eventMaster));
    }

    /**
     * @test
     */
    public function api_v1_event_mastersにGETメソッドで取得できるユーザー情報は10件である()
    {
        $response = $this->get(self::EVENT_MASTERS);
        $response->assertJsonCount(10);
    }

    /**
     * @test
     */
    public function api_v1_event_mastersにPOSTメソッドでアクセスできる()
    {
        $eventMasters = [
            'title'            => 'test',
            'detail'           => 'test',
            'handing'          => 'test',
            'event_minutes'    => 60,
            'target_min_age'   => '4',
            'target_max_age'   => '5',
            'parent_attendant' => 0,
            'price'            => 1500,
            'cancel_policy'    => 'test',
            'pub_state'        => 0,
            'arrived_at'       => '15',
            'zip_code1'        => '115',
            'zip_code2'        => '0051',
            'state'            => '東京都',
            'city'             => '中央区',
            'address1'         => '月島',
            'address2'         => '4-19-9',
            'longitude'        => 0.0,
            'latitude'         => 0.0
        ];
        $response = $this->postJson(self::EVENT_MASTERS, $eventMasters);
        $response->assertStatus(200);
    }

    public function api_v1_event_masters_event_master_idにデータをPOSTするとevent_mastersテーブルにそのデータが追加される()
    {
        $newEventMasters = factory(EventMaster::class)->make();
        $params = [
            'title'          => $newEventMasters->title,
            'detail'         => $newEventMasters->detail,
            'handing'        => $newEventMasters->handing,
            'event_minutes'  => $newEventMasters->event_minutes,
            'target_min_age' => $newEventMasters->target_min_age,
            'target_max_age' => $newEventMasters->target_max_age,
            'price'          => $newEventMasters->price,
            'cancel_policy'  => $newEventMasters->cancel_policy,
            'pub_state'      => $newEventMasters->pub_state,
            'arrived_at'     => $newEventMasters->arrived_at,
            'zip_code1'      => $newEventMasters->zip_code1,
            'zip_code2'      => $newEventMasters->zip_code1,
            'state'          => $newEventMasters->state,
            'city'           => $newEventMasters->city,
            'address1'       => $newEventMasters->address1,
            'address2'       => $newEventMasters->address2,
            'longitude'      => $newEventMasters->longitude,
            'latitude'       => $newEventMasters->latitude
        ];
        $this->postJson(self::EVENT_MASTERS, $params);
        $this->assertDatabaseHas(self::EVENT_MASTERS_TABLE, $params);
    }

    /**
     * @test
     */
    public function POST_api_v1_event_mastersのエラーレスポンスの確認()
    {
        $params = [
            'title'            => '',
            'detail'           => '',
            'handing'          => '',
            'event_minutes'    => '',
            'target_min_age'   => '',
            'target_max_age'   => '',
            'parent_attendant' => '',
            'price'            => '',
            'cancel_policy'    => '',
            'pub_state'        => '',
            'arrived_at'       => '',
            'zip_code1'        => '',
            'zip_code2'        => '',
            'state'            => '',
            'city'             => '',
            'address1'         => '',
            'address2'         => '',
            'longitude'        => '',
            'latitude'         => ''
        ];
        $response = $this->postJson(self::EVENT_MASTERS, $params);
        $error_response = [
            'message' => "The given data was invalid.",
            'errors' => [
                'title' => [
                    'validation.required'
                ],
                'detail' => [
                    'validation.required'
                ],
                'handing' => [
                    'validation.required'
                ],
                'event_minutes' => [
                    'validation.required'
                ],
                'target_min_age' => [
                    'validation.required'
                ],
                'target_max_age' => [
                    'validation.required'
                ],
                'parent_attendant' => [
                    'validation.required'
                ],
                'price' => [
                    'validation.required'
                ],
                'cancel_policy' => [
                    'validation.required'
                ],
                'pub_state' => [
                    'validation.required'
                ],
                'arrived_at' => [
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
    public function api_v1_event_masters_event_master_idにGETメソッドでアクセスできる()
    {
        $event_master_id = $this->getFirstEventMasterId();
        $response = $this->get(self::EVENT_MASTERS. $event_master_id);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_event_mastersに存在しないevent_master_idでGETメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->get(self::EVENT_MASTERS. 'adass230394');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .EventMaster::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_event_masters_idにPUTメソッドでアクセスできる()
    {
        $event_master_id = $this->getFirstEventMasterId();
        $response = $this->putJson(self::EVENT_MASTERS. $event_master_id, [
            'title'            => 'test',
            'detail'           => 'test',
            'handing'          => 'test',
            'event_minutes'    => 60,
            'target_min_age'   => '4',
            'target_max_age'   => '5',
            'parent_attendant' => 0,
            'price'            => 1500,
            'cancel_policy'    => 'test',
            'pub_state'        => 0,
            'arrived_at'       => '15',
            'zip_code1'        => '115',
            'zip_code2'        => '0051',
            'state'            => '東京都',
            'city'             => '中央区',
            'address1'         => '月島',
            'address2'         => '4-19-9',
            'longitude'        => 0.0,
            'latitude'         => 0.0
        ]);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_event_masters_event_master_idにPUTメソッドでデータを編集できる()
    {
        $event_master_id = $this->getFirstEventMasterId();
        $response = $this->get(self::EVENT_MASTERS. $event_master_id);
        $event_master = $response->json();
        $new = [
            'title'          => 'test2',
            'detail'         => $event_master['detail'],
            'handing'        => $event_master['handing'],
            'event_minutes'  => $event_master['event_minutes'],
            'target_min_age' => $event_master['target_min_age'],
            'target_max_age' => $event_master['target_max_age'],
            'price'          => $event_master['price'],
            'cancel_policy'  => $event_master['cancel_policy'],
            'pub_state'      => $event_master['pub_state'],
            'arrived_at'     => $event_master['arrived_at'],
            'zip_code1'      => $event_master['zip_code1'],
            'zip_code2'      => $event_master['zip_code2'],
            'state'          => $event_master['state'],
            'city'           => $event_master['city'],
            'address1'       => $event_master['address1'],
            'address2'       => $event_master['address2'],
            'longitude'      => $event_master['longitude'],
            'latitude'       => $event_master['latitude'],
        ];
        $this->putJson(self::EVENT_MASTERS. $event_master_id, $new);

        $response = $this->get(self::EVENT_MASTERS. $event_master_id);
        $event_master = $response->json();
        $event_master_result = [
            'title'          => $event_master['title'],
            'detail'         => $event_master['detail'],
            'handing'        => $event_master['handing'],
            'event_minutes'  => $event_master['event_minutes'],
            'target_min_age' => $event_master['target_min_age'],
            'target_max_age' => $event_master['target_max_age'],
            'price'          => $event_master['price'],
            'cancel_policy'  => $event_master['cancel_policy'],
            'pub_state'      => $event_master['pub_state'],
            'arrived_at'     => $event_master['arrived_at'],
            'zip_code1'      => $event_master['zip_code1'],
            'zip_code2'      => $event_master['zip_code2'],
            'state'          => $event_master['state'],
            'city'           => $event_master['city'],
            'address1'       => $event_master['address1'],
            'address2'       => $event_master['address2'],
            'longitude'      => $event_master['longitude'],
            'latitude'       => $event_master['latitude'],
        ];
        $this->assertSame($new, $event_master_result);
    }

    /**
     * @test
     */
    public function api_v1_event_masters_event_master_idに存在しないevent_master_idでPUTメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->putJson(self::EVENT_MASTERS. '999', [
            'title'            => 'test',
            'detail'           => 'test',
            'handing'          => 'test',
            'event_minutes'    => 60,
            'target_min_age'   => '4',
            'target_max_age'   => '5',
            'parent_attendant' => 0,
            'price'            => 1500,
            'cancel_policy'    => 'test',
            'pub_state'        => 0,
            'arrived_at'       => '15',
            'zip_code1'        => '115',
            'zip_code2'        => '0051',
            'state'            => '東京都',
            'city'             => '中央区',
            'address1'         => '月島',
            'address2'         => '4-19-9',
            'longitude'        => 0.0,
            'latitude'         => 0.0
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .EventMaster::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_event_masters_idにDELETEメソッドでアクセスできる()
    {
        $event_master_id = $this->getFirstEventMasterId();
        EventDetail::query()->where('event_master_id', '=', $event_master_id)->delete();
        $response = $this->delete(self::EVENT_MASTERS . $event_master_id);
        $response->assertStatus(200);
    }

    private function getFirstEventMasterId()
    {
        return EventMaster::query()->first()->value('id');
    }
}
