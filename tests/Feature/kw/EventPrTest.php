<?php

namespace Tests\Feature\kw;

use Tests\KWBaseTestCase;
use KW\Infrastructure\Eloquents\EventPr;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;

class EventPrTest extends KWBaseTestCase
{
    /**
     * base utils
     * - api url
     * - table
     */
    const EVENT_PRS = 'api/v1/kw/event-prs/';
    const EVENT_PRS_TABLE = 'event_prs';

    /**
     * @test
     */
    public function api_v1_event_prsにGETメソッドでアクセスできる()
    {
        $response = $this->get(self::EVENT_PRS);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_event_prsにGETメソッドでアクセスするとJSONが返却される()
    {
        $response = $this->get(self::EVENT_PRS);
        $this->assertThat($response->content(), $this->isJson());
    }

    /**
     * @test
     */
    public function api_v1_event_prsにGETメソッドで取得できるユーザー情報のJSON形式は要件通りである()
    {
        $response = $this->get(self::EVENT_PRS);
        $event_prs = $response->json();
        $event_pr = $event_prs[0];
        $this->assertSame([
            'id',
            'pr'
        ], array_keys($event_pr));
    }

    /**
     * @test
     */
    public function api_v1_event_prsにPOSTメソッドでアクセスできる()
    {
        $event_prs = [
            'pr' => '日本一高い山にお散歩できる'
        ];
        $response = $this->postJson(self::EVENT_PRS, $event_prs);
        $response->assertStatus(200);
    }

    public function api_v1_event_prsにデータをPOSTするとprsテーブルにそのデータが追加される()
    {
        $newEventPrs = factory(EventPr::class)->make();
        $params = [
            'pr' => $newEventPrs->pr
        ];
        $this->postJson(self::EVENT_PRS, $params);
        $this->assertDatabaseHas(self::EVENT_PRS_TABLE, $params);
    }

    /**
     * @test
     */
    public function POST_api_v1_event_prsのエラーレスポンスの確認()
    {
        $params = [
            'pr' => ''
        ];
        $response = $this->postJson(self::EVENT_PRS, $params);
        $error_response = [
            'message' => "The given data was invalid.",
            'errors' => [
                'pr' => [
                    'validation.required'
                ]
            ]
        ];
        $response->assertExactJson($error_response);
    }

    /**
     * @test
     */
    public function api_v1_event_prs_pr_idにGETメソッドでアクセスできる()
    {
        $event_pr_id = $this->getFirstEventPrsId();
        $response = $this->get(self::EVENT_PRS. $event_pr_id);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_event_prs_pr_idに存在しないpr_idでGETメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->get(self::EVENT_PRS. 33333);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .EventPr::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_event_prs_pr_idにPUTメソッドでアクセスできる()
    {
        $event_pr_id = $this->getFirstEventPrsId();
        $response = $this->putJson(self::EVENT_PRS. $event_pr_id, [
            'pr' => '日本一高い山にお散歩できる'
        ]);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_event_prs_pr_idにPUTメソッドでデータを編集できる()
    {
        $event_pr_id = $this->getFirstEventPrsId();
        $response = $this->get(self::EVENT_PRS. $event_pr_id);
        $event_pr = $response->json();
        $new = [
            'pr' => $event_pr['pr']
        ];
        $this->putJson(self::EVENT_PRS. $event_pr_id, $new);

        $response = $this->get(self::EVENT_PRS. $event_pr_id);
        $event_pr = $response->json();
        $event_pr_result = [
            'pr' => $event_pr['pr']
        ];
        $this->assertSame($new, $event_pr_result);
    }

    /**
     * @test
     */
    public function api_v1_event_prs_pr_idに存在しないpr_idでPUTメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->putJson(self::EVENT_PRS. '9999', [
            'pr' => '日本一高い山にお散歩できる'
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .EventPr::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_event_prs_pr_idにDELETEメソッドでアクセスできる()
    {
        $event_pr_id = $this->getFirstEventPrsId();
        EventPr::query()->where('id', '=', $event_pr_id)->delete();
        $response = $this->delete(self::EVENT_PRS . $event_pr_id);
        $response->assertStatus(200);
    }

    private function getFirstEventPrsId()
    {
        return EventPr::query()->first()->value('id');
    }
}
