<?php

namespace Tests\Feature;

use Tests\KWBaseTestCase;
use KW\Infrastructure\Eloquents\Role;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;

class RoleTest extends KWBaseTestCase
{
    /**
     * base utils
     * - api url
     * - table
     */
    const ROLES = 'api/v1/kw/roles/';
    const ROLES_TABLE = 'roles';

    /**
     * @test
     */
    public function api_v1_rolesにGETメソッドでアクセスできる()
    {
        $response = $this->get(self::ROLES);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_rolessにGETメソッドでアクセスするとJSONが返却される()
    {
        $response = $this->get(self::ROLES);
        $this->assertThat($response->content(), $this->isJson());
    }

    /**
     * @test
     */
    public function api_v1_rolesにGETメソッドで取得できるユーザー情報のJSON形式は要件通りである()
    {
        $response = $this->get(self::ROLES);
        $tags = $response->json();
        $tag = $tags[0];
        $this->assertSame([
            'id',
            'name',
            'role'
        ], array_keys($tag));
    }

    /**
     * @test
     */
    public function api_v1_rolesにPOSTメソッドでアクセスできる()
    {
        $tags = [
            'name' => 'testman',
            'role' => 7
        ];
        $response = $this->postJson(self::ROLES, $tags);
        $response->assertStatus(200);
    }

    public function api_v1_rolesにデータをPOSTするとrolesテーブルにそのデータが追加される()
    {
        $newRoles = factory(Role::class)->make();
        $params = [
            'name' => $newRoles->name,
            'role' => $newRoles->role
        ];
        $this->postJson(self::ROLES, $params);
        $this->assertDatabaseHas(self::ROLES_TABLE, $params);
    }

    /**
     * @test
     */
    public function POST_api_v1_rolesのエラーレスポンスの確認()
    {
        $params = [
            'name' => '',
            'role' => ''
        ];
        $response = $this->postJson(self::ROLES, $params);
        $error_response = [
            'message' => "The given data was invalid.",
            'errors' => [
                'name' => [
                    'validation.required'
                ],
                'role' => [
                    'validation.required'
                ]
            ]
        ];
        $response->assertExactJson($error_response);
    }

    /**
     * @test
     */
    public function api_v1_roles_role_idにGETメソッドでアクセスできる()
    {
        $role_id = $this->getFirstRolesId();
        $response = $this->get(self::ROLES. $role_id);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_roles_role_idに存在しないrole_idでGETメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->get(self::ROLES. 33333);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .Role::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_roles_role_idにPUTメソッドでアクセスできる()
    {
        $role_id = $this->getFirstRolesId();
        $response = $this->putJson(self::ROLES. $role_id, [
            'name' => 'testman',
            'role' => 7
        ]);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_roles_role_idにPUTメソッドでデータを編集できる()
    {
        $role_id = $this->getFirstRolesId();
        $response = $this->get(self::ROLES. $role_id);
        $role = $response->json();
        $new = [
            'name' => $role['name'],
            'role' => $role['role']
        ];
        $this->putJson(self::ROLES. $role_id, $new);

        $response = $this->get(self::ROLES. $role_id);
        $role = $response->json();
        $role_result = [
            'name' => $role['name'],
            'role' => $role['role']
        ];
        $this->assertSame($new, $role_result);
    }

    /**
     * @test
     */
    public function api_v1_roles_role_idに存在しないrole_idでPUTメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->putJson(self::ROLES. '999', [
            'name' => 'testman',
            'role' => 7
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .Role::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_roles_role_idにDELETEメソッドでアクセスできる()
    {
        $role_id = $this->getFirstRolesId();
        Role::query()->where('id', '=', $role_id)->delete();
        $response = $this->delete(self::ROLES . $role_id);
        $response->assertStatus(200);
    }

    private function getFirstRolesId()
    {
        return Role::query()->first()->value('id');
    }
}
