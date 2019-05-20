<?php

namespace Tests\Feature\kw;

use Tests\KWBaseTestCase;
use KW\Infrastructure\Eloquents\Taggable;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;

class TaggableTest extends KWBaseTestCase
{
    /**
     * base utils
     * - api url
     * - table
     */
    const TAGGABLES = 'api/v1/kw/taggables/';
    const TAGGABLES_TABLE = 'taggables';

    /**
     * @test
     */
    public function api_v1_taggablesにGETメソッドでアクセスできる()
    {
        $response = $this->get(self::TAGGABLES);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_taggablesにGETメソッドでアクセスするとJSONが返却される()
    {
        $response = $this->get(self::TAGGABLES);
        $this->assertThat($response->content(), $this->isJson());
    }

    /**
     * @test
     */
    public function api_v1_taggablesにGETメソッドで取得できるユーザー情報のJSON形式は要件通りである()
    {
        $response = $this->get(self::TAGGABLES);
        $taggables = $response->json();
        $taggable = $taggables[0];
        $this->assertSame([
            'id',
            'tag_id',
            'event_detail_id'
        ], array_keys($taggable));
    }

    /**
     * @test
     */
    public function api_v1_taggablesにPOSTメソッドでアクセスできる()
    {
        $taggables = [
            'tag_id'          => 0,
            'event_detail_id' => '7de22340-8533-4eb2-a166-b5896171fb7d'
        ];
        $response = $this->postJson(self::TAGGABLES, $taggables);
        $response->assertStatus(200);
    }

    public function api_v1_taggablesにデータをPOSTするとtaggablesテーブルにそのデータが追加される()
    {
        $newTaggables = factory(Taggable::class)->make();
        $params = [
            'tag_id'         => $newTaggables->tags_id,
            'event_detail_id' => $newTaggables->event_detail_id
        ];
        $this->postJson(self::TAGGABLES, $params);
        $this->assertDatabaseHas(self::TAGGABLES_TABLE, $params);
    }

    /**
     * @test
     */
    public function POST_api_v1_taggablesのエラーレスポンスの確認()
    {
        $params = [
            'tag_id'         => '',
            'event_detail_id' => ''
        ];
        $response = $this->postJson(self::TAGGABLES, $params);
        $error_response = [
            'message' => "The given data was invalid.",
            'errors' => [
                'tag_id' => [
                    'validation.required'
                ],
                'event_detail_id' => [
                    'validation.required'
                ]
            ]
        ];
        $response->assertExactJson($error_response);
    }

    /**
     * @test
     */
    public function api_v1_taggables_taggable_idにGETメソッドでアクセスできる()
    {
        $taggable_id = $this->getFirstTaggablesId();
        $response = $this->get(self::TAGGABLES. $taggable_id);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_taggables_taggable_idに存在しないtaggable_idでGETメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->get(self::TAGGABLES. 33333);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .Taggable::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_taggables_taggable_idapi_v1_tags_tag_idにPUTメソッドでアクセスできる()
    {
        $taggable_id = $this->getFirstTaggablesId();
        $response = $this->putJson(self::TAGGABLES. $taggable_id, [
            'tag_id'          => 0,
            'event_detail_id' => '7de22340-8533-4eb2-a166-b5896171fb7d'
        ]);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_taggables_taggable_idにPUTメソッドでデータを編集できる()
    {
        $taggable_id = $this->getFirstTaggablesId();
        $response = $this->get(self::TAGGABLES. $taggable_id);
        $taggable = $response->json();
        $new = [
            'tag_id'          => $taggable['tag_id'],
            'event_detail_id' => $taggable['event_detail_id']
        ];
        $this->putJson(self::TAGGABLES. $taggable_id, $new);

        $response = $this->get(self::TAGGABLES. $taggable_id);
        $taggable = $response->json();
        $taggable_result = [
            'tag_id'          => $taggable['tag_id'],
            'event_detail_id' => $taggable['event_detail_id']
        ];
        $this->assertSame($new, $taggable_result);
    }

    /**
     * @test
     */
    public function api_v1_taggables_taggable_idに存在しないtaggable_idでPUTメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->putJson(self::TAGGABLES. '999', [
            'tag_id'         => 1,
            'event_detail_id' => '7de22340-8533-4eb2-a166-b5896171fb7d'
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .Taggable::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_taggables_taggable_idにDELETEメソッドでアクセスできる()
    {
        $taggable_id = $this->getFirstTaggablesId();
        Taggable::query()->where('id', '=', $taggable_id)->delete();
        $response = $this->delete(self::TAGGABLES . $taggable_id);
        $response->assertStatus(200);
    }

    private function getFirstTaggablesId()
    {
        return Taggable::query()->first()->value('id');
    }
}
