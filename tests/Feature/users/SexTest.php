<?php

namespace Tests\Feature;

use Tests\KWBaseTestCase;
use KW\Infrastructure\Eloquents\Sex;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;

class SexTest extends KWBaseTestCase
{
    /**
     * base utils
     * - api url
     * - table
     */
    const SEXES = 'api/v1/kw/sexes/';
    const SEXES_TABLE = 'sexes';

    /**
     * @test
     */
    public function api_v1_sexesにGETメソッドでアクセスできる()
    {
        $response = $this->get(self::SEXES);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_sexesにGETメソッドでアクセスするとJSONが返却される()
    {
        $response = $this->get(self::SEXES);
        $this->assertThat($response->content(), $this->isJson());
    }

    /**
     * @test
     */
    public function api_v1_sexesにGETメソッドで取得できるユーザー情報のJSON形式は要件通りである()
    {
        $response = $this->get(self::SEXES);
        $sexes = $response->json();
        $sex = $sexes[0];
        $this->assertSame([
            'id',
            'index',
            'name'
        ], array_keys($sex));
    }

    /**
     * @test
     */
    public function api_v1_sexesにPOSTメソッドでアクセスできる()
    {
        $sexes = [
            'index' => 4,
            'name'  => 'male'
        ];
        $response = $this->postJson(self::SEXES, $sexes);
        $response->assertStatus(200);
    }

    public function api_v1_sexesにデータをPOSTするとsexesテーブルにそのデータが追加される()
    {
        $newSexes = factory(Sex::class)->make();
        $params = [
            'index' => $newSexes->index,
            'name'  => $newSexes->name
        ];
        $this->postJson(self::SEXES, $params);
        $this->assertDatabaseHas(self::SEXES_TABLE, $params);
    }

    /**
     * @test
     */
    public function POST_api_v1_sexesのエラーレスポンスの確認()
    {
        $params = [
            'index' => '',
            'name'  => ''
        ];
        $response = $this->postJson(self::SEXES, $params);
        $error_response = [
            'message' => "The given data was invalid.",
            'errors' => [
                'index' => [
                    'validation.required'
                ],
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
    public function api_v1_sexes_sex_idにGETメソッドでアクセスできる()
    {
        $sex_id = $this->getFirstSexesId();
        $response = $this->get(self::SEXES. $sex_id);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_sexes_sex_idに存在しないsex_idでGETメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->get(self::SEXES. 33333);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .Sex::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_sexes_sex_idにPUTメソッドでアクセスできる()
    {
        $sex_id = $this->getFirstSexesId();
        $response = $this->putJson(self::SEXES. $sex_id, [
            'index' => 4,
            'name'  => 'male'
        ]);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_sexes_sex_idにPUTメソッドでデータを編集できる()
    {
        $sex_id = $this->getFirstSexesId();
        $response = $this->get(self::SEXES. $sex_id);
        $sex = $response->json();
        $new = [
            'index' => 5,
            'name'  => $sex['name']
        ];
        $this->putJson(self::SEXES. $sex_id, $new);

        $response = $this->get(self::SEXES. $sex_id);
        $sex = $response->json();
        $sex_result = [
            'index' => $sex['index'],
            'name'  => $sex['name']
        ];
        $this->assertSame($new, $sex_result);
    }

    /**
     * @test
     */
    public function api_v1_sexes_sex_idに存在しないsex_idでPUTメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->putJson(self::SEXES. 999, [
            'index' => 4,
            'name'  => 'male'
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .Sex::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_sexes_sex_idにDELETEメソッドでアクセスできる()
    {
        $sex_id = $this->getFirstSexesId();
        Sex::query()->where('id', '=', $sex_id)->delete();
        $response = $this->delete(self::SEXES . $sex_id);
        $response->assertStatus(200);
    }

    private function getFirstSexesId()
    {
        return Sex::query()->first()->value('id');
    }
}
