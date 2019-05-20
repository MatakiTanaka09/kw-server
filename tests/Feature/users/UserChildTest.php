<?php

namespace Tests\Feature\users;

use KW\Infrastructure\Eloquents\ChildParent;
use KW\Infrastructure\Eloquents\UserChild;
use KW\Infrastructure\Eloquents\UserParent;
use Tests\KWBaseTestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;

class UserChildTest extends KWBaseTestCase
{
    /**
     * base utils
     * - api url
     * - table
     */
    const USER_CHILDREN = 'api/v1/users/user-children/';
    const USER_CHILDREN_TABLE = 'user_children';

    /**
     * @test
     */
    public function api_v1_user_childrenにPOSTメソッドでアクセスできる()
    {
        $userChild = [
            'sex_id' => 1,
            'icon' => 'https://www.kidsweekend.jp...',
            'first_kana' => 'tanaka yuki',
            'last_kana' => 'tanaka yuki',
            'birth_day' => '2019-05-11 00:00:00'
        ];
        $response = $this->postJson(self::USER_CHILDREN, $userChild);
        $response->assertStatus(200);
    }

    public function api_v1_user_childrenにデータをPOSTするとuser_childrenテーブルにそのデータが追加される()
    {
        $newUserChild = factory(UserChild::class)->make();
        $params = [
            'sex_id' => $newUserChild->sex_id,
            'icon' => $newUserChild->icon,
            'first_kana' => $newUserChild->first_kana,
            'last_kana' => $newUserChild->last_kana,
            'birth_day' => $newUserChild->birth_day
        ];
        $this->postJson(self::USER_CHILDREN, $params);
        $this->assertDatabaseHas(self::USER_CHILDREN_TABLE, $params);
    }

    /**
     * @test
     */
    public function POST_api_v1_user_childrenのエラーレスポンスの確認()
    {
        $params = [
            'sex_id'     => '',
            'icon'       => '',
            'first_kana' => '',
            'last_kana'  => '',
            'birth_day'  => '',
        ];
        $response = $this->postJson(self::USER_CHILDREN, $params);
        $error_response = [
            'message' => "The given data was invalid.",
            'errors' => [
                'sex_id' => [
                    'validation.required'
                ],
                'first_kana' => [
                    'validation.required'
                ],
                'last_kana' => [
                    'validation.required'
                ],
                'birth_day' => [
                    'validation.required'
                ]
            ]
        ];
        $response->assertExactJson($error_response);
    }

    /**
     * @test
     */
    public function api_v1_user_children_idにGETメソッドでアクセスできる()
    {
        $user_child_id = $this->getFirstUserChildId();
        $response = $this->get(self::USER_CHILDREN. $user_child_id);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_user_childrenに存在しないuser_child_idでGETメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->get(self::USER_CHILDREN. 'adass230394');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .UserChild::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_user_children_idにPUTメソッドでアクセスできる()
    {
        $user_child_id = $this->getFirstUserChildId();
        $response = $this->putJson(self::USER_CHILDREN. $user_child_id, [
            'sex_id' => 1,
            'icon' => 'https://www.kidsweekend.jp...',
            'first_kana' => 'tanaka yuki',
            'last_kana' => 'tanaka yuki',
            'birth_day' => '2019-05-11 00:00:00'
        ]);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_user_children_user_child_idにPUTメソッドでデータを編集できる()
    {
        $user_child_id = $this->getFirstUserChildId();
        $response = $this->get(self::USER_CHILDREN. $user_child_id);
        $user_child = $response->json();
        $new = [
            'sex_id'     => 1,
            'icon'       => $user_child['icon'],
            'first_kana' => $user_child['first_kana'],
            'last_kana'  => $user_child['last_kana'],
            'birth_day'  => $user_child['birth_day']
        ];
        $this->putJson(self::USER_CHILDREN. $user_child_id, $new);

        $response = $this->get(self::USER_CHILDREN. $user_child_id);
        $user_child = $response->json();
        $user_child_result = [
            'sex_id'     => $user_child['sex_id'],
            'icon'       => $user_child['icon'],
            'first_kana' => $user_child['first_kana'],
            'last_kana'  => $user_child['last_kana'],
            'birth_day'  => $user_child['birth_day']
        ];
        $this->assertSame($new, $user_child_result);
    }

    /**
     * @test
     */
    public function api_v1_user_children_user_child_idに存在しないuser_child_idでPUTメソッドでアクセスすると500が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->putJson(self::USER_CHILDREN. '999', [
            'sex_id' => 1,
            'icon' => 'https://www.kidsweekend.jp...',
            'first_kana' => 'tanaka yuki',
            'last_kana' => 'tanaka yuki',
            'birth_day' => '2019-05-11 00:00:00'
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .UserChild::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_user_children_idにDELETEメソッドでアクセスできる()
    {
        $user_child_id = $this->getFirstUserChildId();
        UserChild::query()->where('id', '=', $user_child_id)->delete();
        $response = $this->delete(self::USER_CHILDREN . $user_child_id);
        $response->assertStatus(200);
    }

    private function getFirstUserChildId()
    {
        return UserChild::query()->first()->value('id');
    }
}
