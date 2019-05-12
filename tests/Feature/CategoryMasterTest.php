<?php

namespace Tests\Feature;

use Tests\KWBaseTestCase;
use KW\Infrastructure\Eloquents\CategoryMaster;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;

class CategoryMasterTest extends KWBaseTestCase
{
    /**
     * base utils
     * - api url
     * - table
     */
    const CATEGORY_MASTERS = 'api/v1/kw/category-masters/';
    const CATEGORY_MASTERS_TABLE = 'category_masters';

    /**
     * @test
     */
    public function api_v1_company_and_membersにGETメソッドでアクセスできる()
    {
        $response = $this->get(self::CATEGORY_MASTERS);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_category_mastersにGETメソッドでアクセスするとJSONが返却される()
    {
        $response = $this->get(self::CATEGORY_MASTERS);
        $this->assertThat($response->content(), $this->isJson());
    }

    /**
     * @test
     */
    public function api_v1_category_mastersにGETメソッドで取得できるユーザー情報のJSON形式は要件通りである()
    {
        $response = $this->get(self::CATEGORY_MASTERS);
        $category_masters = $response->json();
        $category_master = $category_masters[0];
        $this->assertSame([
            'id',
            'name',
            'color',
            'filename'
        ], array_keys($category_master));
    }

    /**
     * @test
     */
    public function api_v1_category_mastersにPOSTメソッドでアクセスできる()
    {
        $category_masters = [
            'name' => 'others',
            'color' => '#000000',
            'filename' => 'images/sample.png'
        ];
        $response = $this->postJson(self::CATEGORY_MASTERS, $category_masters);
        $response->assertStatus(200);
    }

    public function api_v1_category_mastersにデータをPOSTするとcategory_mastersテーブルにそのデータが追加される()
    {
        $newCategoryMasters = factory(CategoryMaster::class)->make();
        $params = [
            'name'     => $newCategoryMasters->name,
            'color'    => $newCategoryMasters->color,
            'filename' => $newCategoryMasters->filename
        ];
        $this->postJson(self::CATEGORY_MASTERS, $params);
        $this->assertDatabaseHas(self::CATEGORY_MASTERS_TABLE, $params);
    }

    /**
     * @test
     */
    public function POST_api_v1_category_mastersのエラーレスポンスの確認()
    {
        $params = [
            'name'     => '',
            'color'    => '',
            'filename' => ''
        ];
        $response = $this->postJson(self::CATEGORY_MASTERS, $params);
        $error_response = [
            'message' => "The given data was invalid.",
            'errors' => [
                'name' => [
                    'validation.required'
                ],
                'color' => [
                    'validation.required'
                ],
                'filename' => [
                    'validation.required'
                ]
            ]
        ];
        $response->assertExactJson($error_response);
    }

    /**
     * @test
     */
    public function api_v1_category_masters_category_master_idにGETメソッドでアクセスできる()
    {
        $category_master_id = $this->getFirstCategoryMastersId();
        $response = $this->get(self::CATEGORY_MASTERS. $category_master_id);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_company_and_membersに存在しないcompany_and_member_idでGETメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->get(self::CATEGORY_MASTERS. 'adass230394');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .CategoryMaster::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_company_and_members_company_and_member_idにPUTメソッドでアクセスできる()
    {
        $company_and_member_id = $this->getFirstCategoryMastersId();
        $response = $this->putJson(self::CATEGORY_MASTERS. $company_and_member_id, [
            'name'     => 'others',
            'color'    => '#000000',
            'filename' => 'images/sample.png'
        ]);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_company_and_members_company_and_member_idにPUTメソッドでデータを編集できる()
    {
        $company_and_member_id = $this->getFirstCategoryMastersId();
        $response = $this->get(self::CATEGORY_MASTERS. $company_and_member_id);
        $company_and_member = $response->json();
        $new = [
            'name'     => $company_and_member['name'],
            'color'    => '#000000',
            'filename' => $company_and_member['filename'],
        ];
        $this->putJson(self::CATEGORY_MASTERS. $company_and_member_id, $new);

        $response = $this->get(self::CATEGORY_MASTERS. $company_and_member_id);
        $company_and_member = $response->json();
        $company_and_member_result = [
            'name'     => $company_and_member['name'],
            'color'    => $company_and_member['color'],
            'filename' => $company_and_member['filename'],
        ];
        $this->assertSame($new, $company_and_member_result);
    }

    /**
     * @test
     */
    public function api_v1_company_and_members_company_and_member_idに存在しないcompany_and_member_idでPUTメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->putJson(self::CATEGORY_MASTERS. '999', [
            'name'     => 'others',
            'color'    => '#000000',
            'filename' => 'images/sample.png'
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .CategoryMaster::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_company_and_members_company_and_member_idにDELETEメソッドでアクセスできる()
    {
        $child_parent_id = $this->getFirstCategoryMastersId();
        CategoryMaster::query()->where('id', '=', $child_parent_id)->delete();
        $response = $this->delete(self::CATEGORY_MASTERS . $child_parent_id);
        $response->assertStatus(200);
    }

    private function getFirstCategoryMastersId()
    {
        return CategoryMaster::query()->first()->value('id');
    }
}
