<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryMasterTest extends TestCase
{
    /**
     * @test
     */
    public function api_v1_category_mastersにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/category-masters');
        $response->assertStatus(200);
    }

    public function api_v1_category_mastersにGETメソッドでアクセスするとJSONが返却される()
    {

    }
    public function api_v1_category_mastersにGETメソッドで取得できるユーザー情報のJSON形式は要件通りである()
    {

    }
    public function api_v1_category_mastersにGETメソッドで取得できるユーザー情報は10件である()
    {

    }

    /**
     * @test
     */
    public function api_v1_category_mastersにPOSTメソッドでアクセスできる()
    {
        $response = $this->post('api/v1/category-masters');
        $response->assertStatus(200);
    }

    public function api_v1_company_mastersにデータをPOSTするとcategory_mastersテーブルにそのデータが追加される()
    {

    }

    /**
     * @test
     */
    public function api_v1_category_masters_category_master_idにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/category-masters/{category_masters_id}');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_category_masters_category_master_idにPUTメソッドでアクセスできる()
    {
        $response = $this->put('api/v1/category-masters/{category_masters_id}');
        $response->assertStatus(200);
    }

    public function api_v1_category_masters_category_master_idにPUTメソッドでデータを編集できる()
    {

    }

    public function api_v1_category_masters_category_master_idに存在しないcategory_master_idでPUTメソッドでアクセスすると500が返却される()
    {

    }

    /**
     * @test
     */
    public function api_v1_category_masters_category_master_idにDELETEメソッドでアクセスできる()
    {
        $response = $this->delete('api/v1/category-masters/{category_masters_id}');
        $response->assertStatus(200);
    }
}
