<?php

namespace Tests\Feature;

use Tests\KWBaseTestCase;
use KW\Infrastructure\Eloquents\CompanyAndMember;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;

class CompanyAndMemberTest extends KWBaseTestCase
{
    /**
     * base utils
     * - api url
     * - table
     */
    const COMPANY_AND_MEMBERS = 'api/v1/kw/company-and-members/';
    const COMPANY_AND_MEMBERS_TABLE = 'company_and_members';

    /**
     * @test
     */
    public function api_v1_company_and_membersにGETメソッドでアクセスできる()
    {
        $response = $this->get(self::COMPANY_AND_MEMBERS);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_company_and_membersにGETメソッドでアクセスするとJSONが返却される()
    {
        $response = $this->get(self::COMPANY_AND_MEMBERS);
        $this->assertThat($response->content(), $this->isJson());
    }

    /**
     * @test
     */
    public function api_v1_company_and_membersにGETメソッドで取得できるユーザー情報のJSON形式は要件通りである()
    {
        $response = $this->get(self::COMPANY_AND_MEMBERS);
        $company_and_members = $response->json();
        $company_and_member = $company_and_members[0];
        $this->assertSame([
            'id',
            'company_master_id',
            'company_admin_master_id',
            'name'
        ], array_keys($company_and_member));
    }

    /**
     * @test
     */
    public function api_v1_company_and_membersにPOSTメソッドでアクセスできる()
    {
        $company_and_members = [
            'company_master_id'        => '656684cb-e5d6-4756-a27a-8e30e97a08ac',
            'company_admin_master_id'  => 34,
            'name'                     => 'Kidsweekend'
        ];
        $response = $this->postJson(self::COMPANY_AND_MEMBERS, $company_and_members);
        $response->assertStatus(200);
    }

    public function api_v1_company_and_membersにデータをPOSTするとcompany_and_membersテーブルにそのデータが追加される()
    {
        $newCompanyAndMembers = factory(CompanyAndMember::class)->make();
        $params = [
            'company_master_id'       => $newCompanyAndMembers->company_master_id,
            'company_admin_master_id' => $newCompanyAndMembers->company_admin_master_id,
            'name'                    => $newCompanyAndMembers->name
        ];
        $this->postJson(self::COMPANY_AND_MEMBERS, $params);
        $this->assertDatabaseHas(self::COMPANY_AND_MEMBERS_TABLE, $params);
    }

    /**
     * @test
     */
    public function POST_api_v1_company_and_membersのエラーレスポンスの確認()
    {
        $params = [
            'company_master_id'       => '',
            'company_admin_master_id' => '',
            'name'                    => ''
        ];
        $response = $this->postJson(self::COMPANY_AND_MEMBERS, $params);
        $error_response = [
            'message' => "The given data was invalid.",
            'errors' => [
                'company_master_id' => [
                    'validation.required'
                ],
                'company_admin_master_id' => [
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
    public function api_v1_company_and_members_company_and_member_idにGETメソッドでアクセスできる()
    {
        $company_and_member_id = $this->getFirstCompanyAndMembersId();
        $response = $this->get(self::COMPANY_AND_MEMBERS. $company_and_member_id);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_company_and_membersに存在しないcompany_and_member_idでGETメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->get(self::COMPANY_AND_MEMBERS. 'adass230394');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .CompanyAndMember::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_company_and_members_company_and_member_idにPUTメソッドでアクセスできる()
    {
        $company_and_member_id = $this->getFirstCompanyAndMembersId();
        $response = $this->putJson(self::COMPANY_AND_MEMBERS. $company_and_member_id, [
            'company_master_id'        => '656684cb-e5d6-4756-a27a-8e30e97a08ac',
            'company_admin_master_id'  => 99,
            'name'                     => 'Kidsweekend'
        ]);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_company_and_members_company_and_member_idにPUTメソッドでデータを編集できる()
    {
        $company_and_member_id = $this->getFirstCompanyAndMembersId();
        $response = $this->get(self::COMPANY_AND_MEMBERS. $company_and_member_id);
        $company_and_member = $response->json();
        $new = [
            'company_master_id'        => $company_and_member['company_master_id'],
            'company_admin_master_id'  => $company_and_member['company_admin_master_id'],
            'name'                     => 'Kidswee'
        ];
        $this->putJson(self::COMPANY_AND_MEMBERS. $company_and_member_id, $new);

        $response = $this->get(self::COMPANY_AND_MEMBERS. $company_and_member_id);
        $company_and_member = $response->json();
        $company_and_member_result = [
            'company_master_id'        => $company_and_member['company_master_id'],
            'company_admin_master_id'  => $company_and_member['company_admin_master_id'],
            'name'                     => $company_and_member['name']
        ];
        $this->assertSame($new, $company_and_member_result);
    }

    /**
     * @test
     */
    public function api_v1_company_and_members_company_and_member_idに存在しないcompany_and_member_idでPUTメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->putJson(self::COMPANY_AND_MEMBERS. '999', [
            'company_master_id'        => '656684cb-e5d6-4756-a27a-8e30e97a08ac',
            'company_admin_master_id'  => 34,
            'name'                     => 'Kidsweekend'
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .CompanyAndMember::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_company_and_members_company_and_member_idにDELETEメソッドでアクセスできる()
    {
        $child_parent_id = $this->getFirstCompanyAndMembersId();
        CompanyAndMember::query()->where('id', '=', $child_parent_id)->delete();
        $response = $this->delete(self::COMPANY_AND_MEMBERS . $child_parent_id);
        $response->assertStatus(200);
    }

    private function getFirstCompanyAndMembersId()
    {
        return CompanyAndMember::query()->first()->value('id');
    }
}
