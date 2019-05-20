<?php

namespace Tests\Feature\kw;

use Tests\KWBaseTestCase;
use KW\Infrastructure\Eloquents\SchoolAndMember;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;

class SchoolAndMemberTest extends KWBaseTestCase
{
    /**
     * base utils
     * - api url
     * - table
     */
    const SCHOOL_AND_MEMBERS = 'api/v1/kw/school-and-members/';
    const SCHOOL_AND_MEMBERS_TABLE = 'school_and_members';

    /**
     * @test
     */
    public function api_v1_school_and_membersにGETメソッドでアクセスできる()
    {
        $response = $this->get(self::SCHOOL_AND_MEMBERS);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_school_and_membersにGETメソッドでアクセスするとJSONが返却される()
    {
        $response = $this->get(self::SCHOOL_AND_MEMBERS);
        $this->assertThat($response->content(), $this->isJson());
    }

    /**
     * @test
     */
    public function api_v1_school_and_membersにGETメソッドで取得できるユーザー情報のJSON形式は要件通りである()
    {
        $response = $this->get(self::SCHOOL_AND_MEMBERS);
        $school_and_members = $response->json();
        $school_and_member = $school_and_members[0];
        $this->assertSame([
            'id',
            'school_master_id',
            'school_admin_master_id',
            'name'
        ], array_keys($school_and_member));
    }

    /**
     * @test
     */
    public function api_v1_school_and_membersにPOSTメソッドでアクセスできる()
    {
        $school_and_members = [
            'school_master_id'        => '656684cb-e5d6-4756-a27a-8e30e97a08ac',
            'school_admin_master_id'  => 34,
            'name'                    => 'Kidsweekend'
        ];
        $response = $this->postJson(self::SCHOOL_AND_MEMBERS, $school_and_members);
        $response->assertStatus(200);
    }

    public function api_v1_school_and_membersにデータをPOSTするとschool_and_membersテーブルにそのデータが追加される()
    {
        $newSchoolAndMembers = factory(SchoolAndMember::class)->make();
        $params = [
            'school_master_id'       => $newSchoolAndMembers->school_master_id,
            'school_admin_master_id' => $newSchoolAndMembers->school_admin_master_id,
            'name'                   => $newSchoolAndMembers->name
        ];
        $this->postJson(self::SCHOOL_AND_MEMBERS, $params);
        $this->assertDatabaseHas(self::SCHOOL_AND_MEMBERS_TABLE, $params);
    }

    /**
     * @test
     */
    public function POST_api_v1_school_and_membersのエラーレスポンスの確認()
    {
        $params = [
            'school_master_id'       => '',
            'school_admin_master_id' => '',
            'name'                   => ''
        ];
        $response = $this->postJson(self::SCHOOL_AND_MEMBERS, $params);
        $error_response = [
            'message' => "The given data was invalid.",
            'errors' => [
                'school_master_id' => [
                    'validation.required'
                ],
                'school_admin_master_id' => [
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
    public function api_v1_school_and_members_school_and_member_idにGETメソッドでアクセスできる()
    {
        $school_and_member_id = $this->getFirstSchoolAndMembersId();
        $response = $this->get(self::SCHOOL_AND_MEMBERS. $school_and_member_id);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_school_and_membersに存在しないschool_and_member_idでGETメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->get(self::SCHOOL_AND_MEMBERS. 'adass230394');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .SchoolAndMember::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_school_and_members_school_and_member_idにPUTメソッドでアクセスできる()
    {
        $school_and_member_id = $this->getFirstSchoolAndMembersId();
        $response = $this->putJson(self::SCHOOL_AND_MEMBERS. $school_and_member_id, [
            'school_master_id'        => '656684cb-e5d6-4756-a27a-8e30e97a08ac',
            'school_admin_master_id'  => 99,
            'name'                    => 'Kidsweekend'
        ]);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_school_and_members_school_and_member_idにPUTメソッドでデータを編集できる()
    {
        $school_and_member_id = $this->getFirstSchoolAndMembersId();
        $response = $this->get(self::SCHOOL_AND_MEMBERS. $school_and_member_id);
        $school_and_member = $response->json();
        $new = [
            'school_master_id'        => $school_and_member['school_master_id'],
            'school_admin_master_id'  => $school_and_member['school_admin_master_id'],
            'name'                    => 'Kidswee'
        ];
        $this->putJson(self::SCHOOL_AND_MEMBERS. $school_and_member_id, $new);

        $response = $this->get(self::SCHOOL_AND_MEMBERS. $school_and_member_id);
        $school_and_member = $response->json();
        $school_and_member_result = [
            'school_master_id'       => $school_and_member['school_master_id'],
            'school_admin_master_id' => $school_and_member['school_admin_master_id'],
            'name'                   => $school_and_member['name']
        ];
        $this->assertSame($new, $school_and_member_result);
    }

    /**
     * @test
     */
    public function api_v1_school_and_members_school_and_member_idに存在しないschool_and_member_idでPUTメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->putJson(self::SCHOOL_AND_MEMBERS. '999', [
            'school_master_id'        => '656684cb-e5d6-4756-a27a-8e30e97a08ac',
            'school_admin_master_id'  => 34,
            'name'                    => 'Kidsweekend'
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .SchoolAndMember::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_school_and_members_school_and_member_idにDELETEメソッドでアクセスできる()
    {
        $child_parent_id = $this->getFirstSchoolAndMembersId();
        SchoolAndMember::query()->where('id', '=', $child_parent_id)->delete();
        $response = $this->delete(self::SCHOOL_AND_MEMBERS . $child_parent_id);
        $response->assertStatus(200);
    }

    private function getFirstSchoolAndMembersId()
    {
        return SchoolAndMember::query()->first()->value('id');
    }
}
