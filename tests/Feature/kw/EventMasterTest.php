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
            'school_master_id',
            'category_master_id',
            'title',
            'detail'
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
            'school_master_id'   => 'fce485a5-f5c9-49ee-8b26-31712e7dc7c2',
            'category_master_id' => 1,
            'title'              => 'バスタ新宿',
            'detail'             => '日常空間としてのターミナル'
        ];
        $response = $this->postJson(self::EVENT_MASTERS, $eventMasters);
        $response->assertStatus(200);
    }

    public function api_v1_event_masters_event_master_idにデータをPOSTするとevent_mastersテーブルにそのデータが追加される()
    {
        $newEventMasters = factory(EventMaster::class)->make();
        $params = [
            'school_master_id'   => $newEventMasters->school_master_id,
            'category_master_id' => $newEventMasters->category_master_id,
            'title'              => $newEventMasters->title,
            'detail'             => $newEventMasters->detail
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
            'school_master_id'    => '',
            'category_master_id'  => '',
            'title'               => '',
            'detail'              => ''
        ];
        $response = $this->postJson(self::EVENT_MASTERS, $params);
        $error_response = [
            'message' => "The given data was invalid.",
            'errors' => [
                'school_master_id' => [
                    'validation.required'
                ],
                'category_master_id' => [
                    'validation.required'
                ],
                'title' => [
                    'validation.required'
                ],
                'detail' => [
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
            'school_master_id'   => 'fce485a5-f5c9-49ee-8b26-31712e7dc7c2',
            'category_master_id' => 1,
            'title'              => 'バスタ新宿',
            'detail'             => '日常空間としてのターミナル'
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
            'school_master_id'   => 'ef49ee06-199f-4e2f-96ad-64f2cec3b36e',
            'category_master_id' => 2,
            'title'              => $event_master['title'],
            'detail'             => $event_master['detail']
        ];
        $this->putJson(self::EVENT_MASTERS. $event_master_id, $new);

        $response = $this->get(self::EVENT_MASTERS. $event_master_id);
        $event_master = $response->json();
        $event_master_result = [
            'school_master_id'   => $event_master['school_master_id'],
            'category_master_id' => $event_master['category_master_id'],
            'title'              => $event_master['title'],
            'detail'             => $event_master['detail']
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
            'school_master_id'   => 'fce485a5-f5c9-49ee-8b26-31712e7dc7c2',
            'category_master_id' => 1,
            'title'              => 'バスタ新宿',
            'detail'             => '日常空間としてのターミナル'
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
