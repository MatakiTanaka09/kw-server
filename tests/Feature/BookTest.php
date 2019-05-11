<?php

namespace Tests\Feature;

use Tests\KWBaseTestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;


class BookTest extends KWBaseTestCase
{
    /**
     * @test
     */
    public function api_v1_booksにGETメソッドでアクセスできる()
    {
        $response = $this->get('api/v1/books');
        $response->assertStatus(200);
    }

    public function api_v1_booksにGETメソッドでアクセスするとJSONが返却される()
    {

    }

    public function api_v1_booksにGETメソッドで取得できるユーザー情報のJSON形式は要件通りである()
    {

    }

    public function api_v1_booksにGETメソッドで取得できるユーザー情報は10件である()
    {

    }


    /**
     * @test
     */
    public function api_v1_booksにPOSTメソッドでアクセスできる()
    {
        $response = $this->post('api/v1/books');
        $response->assertStatus(200);
    }

    public function api_v1_booksにデータをPOSTするとbooksテーブルにそのデータが追加される()
    {
        $response = $this->post('api/v1/books');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_api_v1_books_book_idにGETメソッドでアクセスできるる()
    {
        $response = $this->get('api/v1/books/{books_id}');
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_api_v1_books_book_idにPUTメソッドでアクセスできるる()
    {
        $response = $this->put('api/v1/books/{books_id}');
        $response->assertStatus(200);
    }

    public function api_v1_api_v1_books_book_idにPUTメソッドでデータを編集できる()
    {

    }

    public function api_v1_api_v1_books_book_idに存在しないbook_idでPUTメソッドでアクセスすると500が返却される()
    {

    }

    /**
     * @test
     */
    public function api_v1_books_idにDELETEメソッドでアクセスできる()
    {
        $response = $this->delete('api/v1/books/{books_id}');
        $response->assertStatus(200);
    }
}
