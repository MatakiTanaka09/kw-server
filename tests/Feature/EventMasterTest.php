<?php

namespace Tests\Feature;

use KW\Infrastructure\Eloquents\EventMaster;
use KW\Infrastructure\Eloquents\UserChild;
use Tests\KWBaseTestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;

class EventMasterTest extends KWBaseTestCase
{
    /**
     * base api url
     */
    const EVENT_MASTERS = 'api/v1/kw/event-masters/';

    /**
     * @test
     */
    public function api_v1_event_mastersにGETメソッドでアクセスできる()
    {
        $response = $this->get(self::EVENT_MASTERS);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_event_mastersにGETメソッドでアクセスするとJSONが返却される()
    {
        $response = $this->get(self::EVENT_MASTERS);
        $this->assertThat($response->content(), $this->isJson());
    }

    /**
     * @test
     */
    public function api_v1_event_mastersにGETメソッドで取得できるユーザー情報のJSON形式は要件通りである()
    {
        $response = $this->get(self::EVENT_MASTERS);
        $eventMasters = $response->json();
        $eventMaster = $eventMasters[0];
        $this->assertSame([
            'id',
            'school_master_id',
            'category_master_id',
            'title',
            'detail'
        ], array_keys($eventMaster));
    }

    /**
     * @test
     */
    public function api_v1_event_mastersにGETメソッドで取得できるユーザー情報は10件である()
    {
        $response = $this->get(self::EVENT_MASTERS);
        $response->assertJsonCount(10);
    }
//
//    /**
//     * @test
//     */
//    public function api_v1_event_mastersにPOSTメソッドでアクセスできる()
//    {
//        $userChild = [
//            'sex_id' => 1,
//            'icon' => 'https://www.kidsweekend.jp...',
//            'first_kana' => 'tanaka yuki',
//            'last_kana' => 'tanaka yuki',
//            'birth_day' => '2019-05-11 00:00:00'
//        ];
//        $response = $this->postJson(self::EVENT_MASTERS, $userChild);
//        $response->assertStatus(200);
//    }
//
//    public function api_v1_user_childrenにデータをPOSTするとuser_childrenテーブルにそのデータが追加される()
//    {
//        $newUserChild = factory(UserChild::class)->make();
//        $params = [
//            'sex_id' => $newUserChild->sex_id,
//            'icon' => $newUserChild->icon,
//            'first_kana' => $newUserChild->first_kana,
//            'last_kana' => $newUserChild->last_kana,
//            'birth_day' => $newUserChild->birth_day
//        ];
//        $this->postJson(self::EVENT_MASTERS, $params);
//        $this->assertDatabaseHas('user_children', $params);
//    }
//
//    /**
//     * @test
//     */
//    public function POST_api_v1_user_childrenのエラーレスポンスの確認()
//    {
//        $params = [
//            'sex_id'     => '',
//            'icon'       => '',
//            'first_kana' => '',
//            'last_kana'  => '',
//            'birth_day'  => '',
//        ];
//        $response = $this->postJson(self::EVENT_MASTERS, $params);
//        $error_response = [
//            'message' => "The given data was invalid.",
//            'errors' => [
//                'sex_id' => [
//                    'validation.required'
//                ],
//                'first_kana' => [
//                    'validation.required'
//                ],
//                'last_kana' => [
//                    'validation.required'
//                ],
//                'birth_day' => [
//                    'validation.required'
//                ]
//            ]
//        ];
//        $response->assertExactJson($error_response);
//    }
//
//    /**
//     * @test
//     */
//    public function api_v1_event_masters_idにGETメソッドでアクセスできる()
//    {
//        $user_child_id = $this->getFirstEventMasterId();
//        $response = $this->get(self::EVENT_MASTERS. $user_child_id);
//        $response->assertStatus(200);
//    }
//
//    /**
//     * @test
//     */
//    public function api_v1_user_childrenに存在しないuser_child_idでGETメソッドでアクセスすると404が返却される()
//    {
//        $response = $this->get(self::EVENT_MASTERS. 'adass230394');
//        $response->assertStatus(200);
//    }
//
//    /**
//     * @test
//     */
//    public function api_v1_event_masters_idにPUTメソッドでアクセスできる()
//    {
//        $user_child_id = $this->getFirstEventMasterId();
//        $response = $this->putJson(self::EVENT_MASTERS. $user_child_id, [
//            'sex_id' => 1,
//            'icon' => 'https://www.kidsweekend.jp...',
//            'first_kana' => 'tanaka yuki',
//            'last_kana' => 'tanaka yuki',
//            'birth_day' => '2019-05-11 00:00:00'
//        ]);
//        $response->assertStatus(200);
//    }
//
//    /**
//     * @test
//     */
//    public function api_v1_user_children_user_child_idにPUTメソッドでデータを編集できる()
//    {
//        $user_child_id = $this->getFirstEventMasterId();
//        $response = $this->get(self::EVENT_MASTERS. $user_child_id);
//        $user_child = $response->json();
//        $new = [
//            'sex_id'     => 1,
//            'icon'       => $user_child['icon'],
//            'first_kana' => $user_child['first_kana'],
//            'last_kana'  => $user_child['last_kana'],
//            'birth_day'  => $user_child['birth_day']
//        ];
//        $this->putJson(self::EVENT_MASTERS. $user_child_id, $new);
//
//        $response = $this->get(self::EVENT_MASTERS. $user_child_id);
//        $user_child = $response->json();
//        $user_child_result = [
//            'sex_id'     =>  $user_child['sex_id'],
//            'icon'       => $user_child['icon'],
//            'first_kana' => $user_child['first_kana'],
//            'last_kana'  => $user_child['last_kana'],
//            'birth_day'  => $user_child['birth_day']
//        ];
//        $this->assertSame($new, $user_child_result);
//    }
//
//    /**
//     * @test
//     */
//    public function api_v1_user_children_user_child_idに存在しないuser_child_idでPUTメソッドでアクセスすると500が返却される()
//    {
//        $this->withoutExceptionHandling();
//        $response = $this->putJson(self::EVENT_MASTERS. '999', [
//            'sex_id' => 1,
//            'icon' => 'https://www.kidsweekend.jp...',
//            'first_kana' => 'tanaka yuki',
//            'last_kana' => 'tanaka yuki',
//            'birth_day' => '2019-05-11 00:00:00'
//        ]);
//        $response->assertStatus(Response::HTTP_NOT_FOUND);
//        $response->assertHeader('Content-Type', 'application/json');
//        $response->assertJson([
//            'message' => 'No query results for model [KW\Infrastructure\Eloquents\UserChild].'
//        ]);
//    }
//
//    /**
//     * @test
//     */
//    public function api_v1_event_masters_idにDELETEメソッドでアクセスできる()
//    {
//        $user_child_id = $this->getFirstEventMasterId();
//        ChildParent::query()->where('user_child_id', '=', $user_child_id)->delete();
//        $response = $this->delete(self::EVENT_MASTERS . $user_child_id);
//        $response->assertStatus(200);
//    }

    private function getFirstEventMasterId()
    {
        return EventMaster::query()->first()->value('id');
    }
}
