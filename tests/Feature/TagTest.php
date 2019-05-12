<?php

namespace Tests\Feature;

use Tests\KWBaseTestCase;
use KW\Infrastructure\Eloquents\Tag;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;

class TagTest extends KWBaseTestCase
{
    /**
     * base utils
     * - api url
     * - table
     */
    const TAGS = 'api/v1/kw/tags/';
    const TAGS_TABLE = 'tags';

    /**
     * @test
     */
    public function api_v1_tagsにGETメソッドでアクセスできる()
    {
        $response = $this->get(self::TAGS);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_tagsにGETメソッドでアクセスするとJSONが返却される()
    {
        $response = $this->get(self::TAGS);
        $this->assertThat($response->content(), $this->isJson());
    }

    /**
     * @test
     */
    public function api_v1_tagsにGETメソッドで取得できるユーザー情報のJSON形式は要件通りである()
    {
        $response = $this->get(self::TAGS);
        $tags = $response->json();
        $tag = $tags[0];
        $this->assertSame([
            'id',
            'name'
        ], array_keys($tag));
    }

    /**
     * @test
     */
    public function api_v1_tagsにPOSTメソッドでアクセスできる()
    {
        $tags = [
            'name' => 'タグ'
        ];
        $response = $this->postJson(self::TAGS, $tags);
        $response->assertStatus(200);
    }

    public function api_v1_tagsにデータをPOSTするとtagsテーブルにそのデータが追加される()
    {
        $newTags = factory(Tag::class)->make();
        $params = [
            'name'     => $newTags->name
        ];
        $this->postJson(self::TAGS, $params);
        $this->assertDatabaseHas(self::TAGS_TABLE, $params);
    }

    /**
     * @test
     */
    public function POST_api_v1_tagsのエラーレスポンスの確認()
    {
        $params = [
            'name'     => ''
        ];
        $response = $this->postJson(self::TAGS, $params);
        $error_response = [
            'message' => "The given data was invalid.",
            'errors' => [
                'name' => [
                    'validation.required'
                ]
            ]
        ];
        $response->assertExactJson($error_response);
    }

    /**
     * @test
     */
    public function api_v1_tags_tag_idにGETメソッドでアクセスできる()
    {
        $tag_id = $this->getFirstTagsId();
        $response = $this->get(self::TAGS. $tag_id);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_tags_tag_idに存在しないtag_idでGETメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->get(self::TAGS. 33333);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .Tag::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_tags_tag_idにPUTメソッドでアクセスできる()
    {
        $tag_id = $this->getFirstTagsId();
        $response = $this->putJson(self::TAGS. $tag_id, [
            'name'     => 'タグ'
        ]);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_tags_tag_idにPUTメソッドでデータを編集できる()
    {
        $tag_id = $this->getFirstTagsId();
        $response = $this->get(self::TAGS. $tag_id);
        $tag = $response->json();
        $new = [
            'name' => $tag['name']
        ];
        $this->putJson(self::TAGS. $tag_id, $new);

        $response = $this->get(self::TAGS. $tag_id);
        $tag = $response->json();
        $tag_result = [
            'name'     => $tag['name']
        ];
        $this->assertSame($new, $tag_result);
    }

    /**
     * @test
     */
    public function api_v1_tags_tag_idに存在しないtag_idでPUTメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->putJson(self::TAGS. '999', [
            'name'     => 'others'
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .Tag::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_tags_tag_idにDELETEメソッドでアクセスできる()
    {
        $tag_id = $this->getFirstTagsId();
        Tag::query()->where('id', '=', $tag_id)->delete();
        $response = $this->delete(self::TAGS . $tag_id);
        $response->assertStatus(200);
    }

    private function getFirstTagsId()
    {
        return Tag::query()->first()->value('id');
    }
}
