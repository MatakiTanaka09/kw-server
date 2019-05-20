<?php

namespace Tests\Feature\kw;

use KW\Infrastructure\Eloquents\CompanyMaster;
use Tests\KWBaseTestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;

class CompanyMasterTest extends KWBaseTestCase
{
    /**
     * base utils
     * - api url
     * - table
     */
    const COMPANY_MASTERS = 'api/v1/kw/company-masters/';
    const COMPANY_MASTERS_TABLE = 'company_masters';

    /**
     * @test
     */
    public function api_v1_company_mastersにGETメソッドでアクセスできる()
    {
        $response = $this->get(self::COMPANY_MASTERS);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_company_mastersにGETメソッドでアクセスするとJSONが返却される()
    {
        $response = $this->get(self::COMPANY_MASTERS);
        $this->assertThat($response->content(), $this->isJson());
    }

    /**
     * @test
     */
    public function api_v1_company_mastersにGETメソッドで取得できるユーザー情報のJSON形式は要件通りである()
    {
        $response = $this->get(self::COMPANY_MASTERS);
        $schoolMasters = $response->json();
        $schoolMaster = $schoolMasters[0];
        $this->assertSame([
            'id',
            'name',
            'detail',
            'email',
            'url',
            'tel',
            'icon',
            'zip_code1',
            'zip_code2',
            'state',
            'city',
            'address1',
            'address2',
            'longitude',
            'latitude'
        ], array_keys($schoolMaster));
    }

    /**
     * @test
     */
    public function api_v1_company_mastersにGETメソッドで取得できるユーザー情報は10件である()
    {
        $response = $this->get(self::COMPANY_MASTERS);
        $response->assertJsonCount(10);
    }

    /**
     * @test
     */
    public function api_v1_company_mastersにPOSTメソッドでアクセスできる()
    {
        $schoolMaster = [
            'name'      => 'Kidsweekend',
            'detail'    => '親の余暇時間をそうぞうするKidsSeedが運営する',
            'email'     => 'info@kidsseed.jp',
            'url'       => 'https://www.kidsweekend.jp...',
            'tel'       => '090-0000-9999',
            'icon'      => 'https://www.kidsweekend.jp...',
            'zip_code1' => '111',
            'zip_code2' => '2222',
            'state'     => '東京都',
            'city'      => '中央区',
            'address1'  => '月島',
            'address2'  => '1-1-1',
            'longitude' => 32.2,
            'latitude'  => 20.8
        ];
        $response = $this->postJson(self::COMPANY_MASTERS, $schoolMaster);
        $response->assertStatus(200);
    }

    public function api_v1_company_mastersデータをPOSTするとcompany_mastersテーブルにそのデータが追加される()
    {
        $newCompanyMaster = factory(CompanyMaster::class)->make();
        $params = [
            'name'      => $newCompanyMaster->name,
            'detail'    => $newCompanyMaster->detail,
            'email'     => $newCompanyMaster->email,
            'url'       => $newCompanyMaster->url,
            'tel'       => $newCompanyMaster->tel,
            'icon'      => $newCompanyMaster->icon,
            'zip_code1' => $newCompanyMaster->zip_code1,
            'zip_code2' => $newCompanyMaster->zip_code2,
            'state'     => $newCompanyMaster->state,
            'city'      => $newCompanyMaster->city,
            'address1'  => $newCompanyMaster->address1,
            'address2'  => $newCompanyMaster->address2,
            'longitude' => $newCompanyMaster->longitude,
            'latitude'  => $newCompanyMaster->latitude
        ];
        $this->postJson(self::COMPANY_MASTERS, $params);
        $this->assertDatabaseHas(self::COMPANY_MASTERS, $params);
    }

    /**
     * @test
     */
    public function POST_api_v1_company_mastersのエラーレスポンスの確認()
    {
        $params = [
            'name'      => '',
            'detail'    => '',
            'email'     => '',
            'url'       => '',
            'tel'       => '',
            'icon'      => '',
            'zip_code1' => '',
            'zip_code2' => '',
            'state'     => '',
            'city'      => '',
            'address1'  => '',
            'address2'  => '',
            'longitude' => '',
            'latitude'  => ''
        ];
        $response = $this->postJson(self::COMPANY_MASTERS, $params);
        $error_response = [
            'message' => "The given data was invalid.",
            'errors' => [
                'name' => [
                    'validation.required'
                ],
                'detail' => [
                    'validation.required'
                ],
                'email' => [
                    'validation.required'
                ],
                'url' => [
                    'validation.required'
                ],
                'tel' => [
                    'validation.required'
                ],
                'icon' => [
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
                ],
                'address2' => [
                    'validation.required'
                ],
                'longitude' => [
                    'validation.required'
                ],
                'latitude' => [
                    'validation.required'
                ]
            ]
        ];
        $response->assertExactJson($error_response);
    }

    /**
     * @test
     */
    public function api_v1_company_masters_company_master_idにGETメソッドでアクセスできる()
    {
        $company_master_id = $this->getFirstCompanyMasterId();
        $response = $this->get(self::COMPANY_MASTERS. $company_master_id);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_company_masters_company_master_idに存在しないcompany_master_idでGETメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->get(self::COMPANY_MASTERS. 'adass230394');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .CompanyMaster::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_company_masters_company_master_idにPUTメソッドでアクセスできる()
    {
        $school_master_id = $this->getFirstCompanyMasterId();
        $response = $this->putJson(self::COMPANY_MASTERS. $school_master_id, [
            'name'      => 'Kidsweekend',
            'detail'    => '親の余暇時間をそうぞうするKidsSeedが運営する',
            'email'     => 'info@kidsseed.jp',
            'url'       => 'https://www.kidsweekend.jp...',
            'tel'       => '090-0000-9999',
            'icon'      => 'https://www.kidsweekend.jp...',
            'zip_code1' => '111',
            'zip_code2' => '2222',
            'state'     => '東京都',
            'city'      => '中央区',
            'address1'  => '月島',
            'address2'  => '1-1-1',
            'longitude' => 32.2,
            'latitude'  => 20.8
        ]);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_company_masters_company_master_idにPUTメソッドでデータを編集できる()
    {
        $school_master_id = $this->getFirstCompanyMasterId();
        $response = $this->get(self::COMPANY_MASTERS. $school_master_id);
        $school_master = $response->json();
        $new = [
            'name'      => $school_master['name'],
            'detail'    => $school_master['detail'],
            'email'     => $school_master['email'],
            'url'       => $school_master['url'],
            'tel'       => $school_master['tel'],
            'icon'      => $school_master['icon'],
            'zip_code1' => $school_master['zip_code1'],
            'zip_code2' => $school_master['zip_code2'],
            'state'     => $school_master['state'],
            'city'      => $school_master['city'],
            'address1'  => $school_master['address1'],
            'address2'  => $school_master['address2'],
            'longitude' => $school_master['longitude'],
            'latitude'  => $school_master['latitude']
        ];
        $this->putJson(self::COMPANY_MASTERS. $school_master_id, $new);

        $response = $this->get(self::COMPANY_MASTERS. $school_master_id);
        $school_master = $response->json();
        $school_master_result = [
            'name'      => $school_master['name'],
            'detail'    => $school_master['detail'],
            'email'     => $school_master['email'],
            'url'       => $school_master['url'],
            'tel'       => $school_master['tel'],
            'icon'      => $school_master['icon'],
            'zip_code1' => $school_master['zip_code1'],
            'zip_code2' => $school_master['zip_code2'],
            'state'     => $school_master['state'],
            'city'      => $school_master['city'],
            'address1'  => $school_master['address1'],
            'address2'  => $school_master['address2'],
            'longitude' => $school_master['longitude'],
            'latitude'  => $school_master['latitude']
        ];
        $this->assertSame($new, $school_master_result);
    }

    /**
     * @test
     */
    public function api_v1_company_masters_company_master_idに存在しないcompany_master_idでPUTメソッドでアクセスすると500が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->putJson(self::COMPANY_MASTERS. '999', [
            'name'      => 'Kidsweekend',
            'detail'    => '親の余暇時間をそうぞうするKidsSeedが運営する',
            'email'     => 'info@kidsseed.jp',
            'url'       => 'https://www.kidsweekend.jp...',
            'tel'       => '090-0000-9999',
            'icon'      => 'https://www.kidsweekend.jp...',
            'zip_code1' => '111',
            'zip_code2' => '2222',
            'state'     => '東京都',
            'city'      => '中央区',
            'address1'  => '月島',
            'address2'  => '1-1-1',
            'longitude' => 32.2,
            'latitude'  => 20.8
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .CompanyMaster::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_company_masters_company_master_idにDELETEメソッドでアクセスできる()
    {
        $company_master_id = $this->getFirstCompanyMasterId();
        CompanyMaster::query()->where('id', '=', $company_master_id)->delete();
        $response = $this->delete(self::COMPANY_MASTERS . $company_master_id);
        $response->assertStatus(200);
    }

    private function getFirstCompanyMasterId()
    {
        return CompanyMaster::query()->first()->value('id');
    }
}
