<?php

namespace Tests\Feature\users;

use Tests\KWBaseTestCase;
use KW\Infrastructure\Eloquents\ChildParent;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;

class ChildParentTest extends KWBaseTestCase
{
    /**
     * base utils
     * - api url
     * - table
     */
    const CHILD_PARENTS = 'api/v1/users/child-parents/';
    const CHILD_PARENTS_TABLE = 'child_parents';

    /**
     * @test
     */
    public function api_v1_child_parentsにPOSTメソッドでアクセスできる()
    {
        $books = [
            'user_parent_id' => '656684cb-e5d6-4756-a27a-8e30e97a08ac',
            'user_child_id'  => 'fce485a5-f5c9-49ee-8b26-31712e7dc7c2'
        ];
        $response = $this->postJson(self::CHILD_PARENTS, $books);
        $response->assertStatus(200);
    }

    public function api_v1_child_parentsにデータをPOSTするとchild_parentsテーブルにそのデータが追加される()
    {
        $newChildParents = factory(ChildParent::class)->make();
        $params = [
            'user_parent_id' => $newChildParents->user_parent_id,
            'user_child_id'  => $newChildParents->user_child_id,
        ];
        $this->postJson(self::CHILD_PARENTS, $params);
        $this->assertDatabaseHas(self::CHILD_PARENTS_TABLE, $params);
    }

    /**
     * @test
     */
    public function POST_api_v1_child_parentsのエラーレスポンスの確認()
    {
        $params = [
            'user_parent_id' => '',
            'user_child_id'  => ''
        ];
        $response = $this->postJson(self::CHILD_PARENTS, $params);
        $error_response = [
            'message' => "The given data was invalid.",
            'errors' => [
                'user_parent_id' => [
                    'validation.required'
                ],
                'user_child_id' => [
                    'validation.required'
                ]
            ]
        ];
        $response->assertExactJson($error_response);
    }

    /**
     * @test
     */
    public function api_v1_child_parents_idにGETメソッドでアクセスできる()
    {
        $child_parent_id = $this->getFirstChildParentId();
        $response = $this->get(self::CHILD_PARENTS. $child_parent_id);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_child_parentsに存在しないchild_parent_idでGETメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->get(self::CHILD_PARENTS. 'adass230394');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .ChildParent::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_child_parents_child_parent_idにPUTメソッドでアクセスできる()
    {
        $book_id = $this->getFirstChildParentId();
        $response = $this->putJson(self::CHILD_PARENTS. $book_id, [
            'child_parent_id' => 1,
            'event_detail_id' => 'fce485a5-f5c9-49ee-8b26-31712e7dc7c2',
            'status'          => 0,
            'price'           => 1500
        ]);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_child_parents_child_parent_idにPUTメソッドでデータを編集できる()
    {
        $child_parent_id = $this->getFirstChildParentId();
        $response = $this->get(self::CHILD_PARENTS. $child_parent_id);
        $child_parent = $response->json();
        $new = [
            'user_parent_id' => '656684cb-e5d6-4756-a27a-8e30e97a08ac',
            'user_child_id'  => $child_parent['user_child_id']
        ];
        $this->putJson(self::CHILD_PARENTS. $child_parent_id, $new);

        $response = $this->get(self::CHILD_PARENTS. $child_parent_id);
        $child_parent = $response->json();
        $child_parent_result = [
            'user_parent_id' => $child_parent['user_parent_id'],
            'user_child_id'  => $child_parent['user_child_id']
        ];
        $this->assertSame($new, $child_parent_result);
    }

    /**
     * @test
     */
    public function api_v1_child_parents_child_parent_idに存在しないchild_parent_idでPUTメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->putJson(self::CHILD_PARENTS. '999', [
            'user_parent_id' => '656684cb-e5d6-4756-a27a-8e30e97a08ac',
            'user_child_id'  => 'fce485a5-f5c9-49ee-8b26-31712e7dc7c2'
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .ChildParent::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_child_parents_child_parent_idにDELETEメソッドでアクセスできる()
    {
        $child_parent_id = $this->getFirstChildParentId();
        ChildParent::query()->where('id', '=', $child_parent_id)->delete();
        $response = $this->delete(self::CHILD_PARENTS . $child_parent_id);
        $response->assertStatus(200);
    }

    private function getFirstChildParentId()
    {
        return ChildParent::query()->first()->value('id');
    }
}
