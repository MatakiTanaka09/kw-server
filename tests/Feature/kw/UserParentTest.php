<?php

namespace Tests\Feature\kw;

use KW\Infrastructure\Eloquents\ChildParent;
use KW\Infrastructure\Eloquents\UserMaster;
use KW\Infrastructure\Eloquents\UserParent;
use Tests\KWBaseTestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;

class UserParentTest extends KWBaseTestCase
{
    /**
     * base utils
     * - api url
     * - table
     */
    const USER_PARENTS = 'api/v1/kw/user-parents/';
    const EVENT_MASTERS_TABLE = 'user_parents';

    /**
     * @test
     */
    public function api_v1_user_parentsにGETメソッドでアクセスできる()
    {
        $response = $this->get(self::USER_PARENTS);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_user_parentsにGETメソッドでアクセスするとJSONが返却される()
    {
        $response = $this->get(self::USER_PARENTS);
        $this->assertThat($response->content(), $this->isJson());
    }

    /**
     * @test
     */
    public function api_v1_user_parentsにGETメソッドで取得できるユーザー情報のJSON形式は要件通りである()
    {
        $response = $this->get(self::USER_PARENTS);
        $userParents = $response->json();
        $userParent = $userParents[0];
        $this->assertSame([
            'id',
            'user_master_id',
            'sex_id',
            'icon',
            'full_name',
            'full_kana',
            'tel',
            'zip_code1',
            'zip_code2',
            'state',
            'city',
            'address1',
            'address2',
            'created_at',
            'updated_at'
        ], array_keys($userParent));
    }

    /**
     * @test
     */
    public function api_v1_user_parentsにGETメソッドで取得できるユーザー情報は10件である()
    {
        $response = $this->get(self::USER_PARENTS);
        $response->assertJsonCount(10);
    }

    /**
     * @test
     */
    public function api_v1_user_parentsにPOSTメソッドでアクセスできる()
    {
        $userParent = [
            'user_master_id' => 1000,
            'sex_id'         => 1,
            'icon'           => 'https://www.kidsweekend.jp...',
            'full_name'      => 'tanaka yuki',
            'full_kana'      => 'tanaka yuki',
            'tel'            => '090-8016-4826',
            'zip_code1'      => '115',
            'zip_code2'      => '0051',
            'state'          => '東京都',
            'city'           => '北区',
            'address1'       => '浮間4-19-9',
            'address2'       => 'シティーハイツ202号室'
        ];
        $response = $this->postJson(self::USER_PARENTS, $userParent);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_user_parentsにデータをPOSTするとuser_parentsテーブルにそのデータが追加される()
    {
        $newUser = factory(UserParent::class)->make();
        $params = [
            'user_master_id' => $newUser->user_master_id,
            'sex_id'         => $newUser->sex_id,
            'icon'           => $newUser->icon,
            'full_name'      => $newUser->full_name,
            'full_kana'      => $newUser->full_kana,
            'tel'            => $newUser->tel,
            'zip_code1'      => $newUser->zip_code1,
            'zip_code2'      => $newUser->zip_code2,
            'state'          => $newUser->state,
            'city'           => $newUser->city,
            'address1'       => $newUser->address1,
            'address2'       => $newUser->address2
        ];
        $this->postJson(self::USER_PARENTS, $params);
        $this->assertDatabaseHas(self::EVENT_MASTERS_TABLE, $params);
    }

    /**
     * @test
     */
    public function POST_api_v1_user_parentsのエラーレスポンスの確認()
    {
        $params = [
            'user_master_id' => '',
            'icon' => '',
            'sex_id'   => '',
            'full_name'  => '',
            'full_kana'  => '',
            'tel'        => '',
            'zip_code1'  => '',
            'zip_code2'  => '',
            'state'      => '',
            'city'       => '',
            'address1'   => '',
            'address2'   => '',
        ];
        $response = $this->postJson(self::USER_PARENTS, $params);
        $error_response = [
            'message' => "The given data was invalid.",
            'errors' => [
                'user_master_id' => [
                    'validation.required'
                ],
                'sex_id' => [
                    'validation.required'
                ],
                'full_name' => [
                    'validation.required'
                ],
                'full_kana' => [
                    'validation.required'
                ],
                'tel' => [
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
                ]
            ]
        ];
        $response->assertExactJson($error_response);
    }


    /**
     * @test
     */
    public function api_v1_user_parents_user_parent_idにGETメソッドでアクセスできる()
    {
        $user_parent_id = $this->getFirstUserParentId();
        $response = $this->get(self::USER_PARENTS. $user_parent_id);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_user_parents_user_parent_idにGETメソッドでアクセスするとユーザー情報が返却される()
    {
        $user_parent_id = $this->getFirstUserParentId();
        $response = $this->get(self::USER_PARENTS. $user_parent_id);
        $this->assertSame([
            'id',
            'user_master_id',
            'sex_id',
            'icon',
            'full_name',
            'full_kana',
            'tel',
            'zip_code1',
            'zip_code2',
            'state',
            'city',
            'address1',
            'address2'
        ], array_keys($response->json()));
    }

    /**
     * @test
     */
    public function api_v1_user_parents_user_parent_idに存在しないuser_parent_idでGETメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();$response = $this->get(self::USER_PARENTS. 'adass230394');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .UserParent::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_user_parents_user_parent_idからchild_parentsでそれらに紐づくuser_child_idを取得するためにGETメソッドでアクセスするとユーザーとお子さんの情報が返却される()
    {
        $user_parent_id = $this->getFirstUserParentId();
        $response = $this->get(self::USER_PARENTS. $user_parent_id. "/children");
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_user_parents_user_parent_idにPUTメソッドでアクセスできる()
    {
        $user_parent_id = $this->getFirstUserParentId();
        $response = $this->putJson(self::USER_PARENTS. $user_parent_id, [
            'sex_id'         => 1,
            'icon'           => 'https://www.kidsweekend.jp...',
            'full_name'      => 'tanaka yuki',
            'full_kana'      => 'tanaka yuki',
            'tel'            => '090-8016-4826',
            'zip_code1'      => '115',
            'zip_code2'      => '0051',
            'state'          => '東京都',
            'city'           => '北区',
            'address1'       => '浮間4-19-9',
            'address2'       => 'シティーハイツ202号室'
        ]);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_user_parents_user_parent_idにPUTメソッドでデータを編集できる()
    {
        $user_parent_id = $this->getFirstUserParentId();
        $response = $this->get(self::USER_PARENTS. $user_parent_id);
        $user_parent = $response->json();
        $new = [
//            'user_master_id' => 102,
            'sex_id'  => 1,
            'icon'      => $user_parent['icon'],
            'full_name' => $user_parent['full_name'],
            'full_kana' => $user_parent['full_kana'],
            'tel'       => $user_parent['tel'],
            'zip_code1' => $user_parent['zip_code1'],
            'zip_code2' => $user_parent['zip_code2'],
            'state'     => $user_parent['state'],
            'city'      => $user_parent['city'],
            'address1'  => $user_parent['address1'],
            'address2'  => $user_parent['address2']
        ];
        $this->putJson(self::USER_PARENTS. $user_parent_id, $new);

        $response = $this->get(self::USER_PARENTS. $user_parent_id);
        $user_parent = $response->json();
        $user_parent_result = [
//            'user_master_id' => $user_parent['user_master_id'],
            'sex_id'    => $user_parent['sex_id'],
            'icon'      => $user_parent['icon'],
            'full_name' => $user_parent['full_name'],
            'full_kana' => $user_parent['full_kana'],
            'tel'       => $user_parent['tel'],
            'zip_code1' => $user_parent['zip_code1'],
            'zip_code2' => $user_parent['zip_code2'],
            'state'     => $user_parent['state'],
            'city'      => $user_parent['city'],
            'address1'  => $user_parent['address1'],
            'address2'  => $user_parent['address2']
        ];
        $this->assertSame($new, $user_parent_result);
    }

    /**
     * @test
     */
    public function api_v1_user_parents_user_parent_idに存在しないuser_parent_idでPUTメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->putJson(self::USER_PARENTS. '999', [
            'user_master_id' => 1,
            'sex_id'    => 1,
            'icon'      => 'https://www.kidsweekend.jp...',
            'full_name' => 'full_name',
            'full_kana' => 'full_kana',
            'tel'       => 'tel',
            'zip_code1' => 'zip_code1',
            'zip_code2' => 'zip_code2',
            'state'     => 'state',
            'city'      => 'city',
            'address1'  => 'address1',
            'address2'  => 'address2'
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .UserParent::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_user_parents_user_parent_idにDELETEメソッドでアクセスできる()
    {
        $user_parent_id = $this->getFirstUserParentId();
        ChildParent::query()->where('user_parent_id', '=', $user_parent_id)->delete();
        $response = $this->delete(self::USER_PARENTS . $user_parent_id);
        $response->assertStatus(200);
    }

    private function getFirstUserParentId()
    {
        return UserParent::query()->first()->value('id');
    }

    private function getFirstUserMasterId()
    {
        return UserMaster::query()->first()->value('id');
    }

    public function exists($user_parent_id)
    {
        return UserParent::query()->where('id', '=', $user_parent_id)->exists();
    }

    private function replaceUserMasterId(&$params)
    {
        $user_parent_id = $this->getFirstUserParentId();
        foreach ($params as $key => $param) {
            if (array_get($param, 'user_parent_id')) {
                $params[$key]['user_parent_id'] = $user_parent_id;
            }
        }
    }
}
