<?php

namespace Tests\Feature\kw;

use Tests\KWBaseTestCase;
use KW\Infrastructure\Eloquents\Image;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;

class ImageTest extends KWBaseTestCase
{
    /**
     * base utils
     * - api url
     * - table
     */
    const IMAGES = 'api/v1/kw/images/';
    const IMAGES_TABLE = 'images';

    /**
     * @test
     */
    public function api_v1_imagesにGETメソッドでアクセスできる()
    {
        $response = $this->get(self::IMAGES);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_imagesにGETメソッドでアクセスするとJSONが返却される()
    {
        $response = $this->get(self::IMAGES);
        $this->assertThat($response->content(), $this->isJson());
    }

    /**
     * @test
     */
    public function api_v1_imagesにGETメソッドで取得できるユーザー情報のJSON形式は要件通りである()
    {
        $response = $this->get(self::IMAGES);
        $images = $response->json();
        $image = $images[0];
        $this->assertSame([
            'id',
            'target_type',
            'target_id',
            'filename',
            'created_at',
            'updated_at'
        ], array_keys($image));
    }

    /**
     * @test
     */
    public function api_v1_images_image_idにGETメソッドでアクセスできる()
    {
        $image_id = $this->getFirstImagesId();
        $response = $this->get(self::IMAGES. $image_id);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_images_image_idに存在しないpr_idでGETメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->get(self::IMAGES. 33333);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .Image::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_images_image_idにPUTメソッドでアクセスできる()
    {
        $image_id = $this->getFirstImagesId();
        $response = $this->putJson(self::IMAGES. $image_id, [
            'filename' => 'filename'
        ]);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_images_image_idにPUTメソッドでデータを編集できる()
    {
        $image_id = $this->getFirstImagesId();
        $response = $this->get(self::IMAGES. $image_id);
        $image = $response->json();
        $new = [
            'filename' => $image['filename']
        ];
        $this->putJson(self::IMAGES. $image_id, $new);

        $response = $this->get(self::IMAGES. $image_id);
        $image = $response->json();
        $image_result = [
            'filename' => $image['filename']
        ];
        $this->assertSame($new, $image_result);
    }

    /**
     * @test
     */
    public function api_v1_images_image_idに存在しないpr_idでPUTメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->putJson(self::IMAGES. '9999', [
            'filename' => 'filename'
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .Image::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_images_image_idにDELETEメソッドでアクセスできる()
    {
        $image_id = $this->getFirstImagesId();
        Image::query()->where('id', '=', $image_id)->delete();
        $response = $this->delete(self::IMAGES . $image_id);
        $response->assertStatus(200);
    }

    private function getFirstImagesId()
    {
        return Image::query()->first()->value('id');
    }
}
