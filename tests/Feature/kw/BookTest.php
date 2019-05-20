<?php

namespace Tests\Feature\kw;

use Tests\KWBaseTestCase;
use KW\Infrastructure\Eloquents\Book;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;

class BookTest extends KWBaseTestCase
{
    /**
     * base utils
     * - api url
     * - table
     */
    const BOOKS = 'api/v1/kw/books/';
    const BOOKS_TABLE = 'books';

    /**
     * @test
     */
    public function api_v1_booksにGETメソッドでアクセスできる()
    {
        $response = $this->get(self::BOOKS);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_booksにGETメソッドでアクセスするとJSONが返却される()
    {
        $response = $this->get(self::BOOKS);
        $this->assertThat($response->content(), $this->isJson());
    }

    /**
     * @test
     */
    public function api_v1_booksにGETメソッドで取得できるユーザー情報のJSON形式は要件通りである()
    {
        $response = $this->get(self::BOOKS);
        $books = $response->json();
        $book = $books[0];
        $this->assertSame([
            'id',
            'child_parent_id',
            'event_detail_id',
            'status',
            'price'
        ], array_keys($book));
    }

    /**
     * @test
     */
    public function api_v1_booksにPOSTメソッドでアクセスできる()
    {
        $books = [
            'child_parent_id' => 1,
            'event_detail_id' => 'fce485a5-f5c9-49ee-8b26-31712e7dc7c2',
            'status'          => 0,
            'price'           => 1500
        ];
        $response = $this->postJson(self::BOOKS, $books);
        $response->assertStatus(200);
    }

    public function api_v1_booksにデータをPOSTするとbooksテーブルにそのデータが追加される()
    {
        $newBooks = factory(Book::class)->make();
        $params = [
            'child_parent_id' => $newBooks->child_parent_id,
            'event_detail_id' => $newBooks->event_detail_id,
            'status'          => $newBooks->status,
            'price'           => $newBooks->price
        ];
        $this->postJson(self::BOOKS, $params);
        $this->assertDatabaseHas(self::BOOKS_TABLE, $params);
    }

    /**
     * @test
     */
    public function POST_api_v1_booksのエラーレスポンスの確認()
    {
        $params = [
            'child_parent_id' => '',
            'event_detail_id' => '',
            'status'          => '',
            'price'           => ''
        ];
        $response = $this->postJson(self::BOOKS, $params);
        $error_response = [
            'message' => "The given data was invalid.",
            'errors' => [
                'child_parent_id' => [
                    'validation.required'
                ],
                'event_detail_id' => [
                    'validation.required'
                ],
                'status' => [
                    'validation.required'
                ],
                'price' => [
                    'validation.required'
                ]
            ]
        ];
        $response->assertExactJson($error_response);
    }

    /**
     * @test
     */
    public function api_v1_books_book_idにGETメソッドでアクセスできる()
    {
        $book_id = $this->getFirstBookId();
        $response = $this->get(self::BOOKS. $book_id);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_booksに存在しないbook_idでGETメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->get(self::BOOKS. 'adass230394');
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .Book::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_books_book_idにPUTメソッドでアクセスできる()
    {
        $book_id = $this->getFirstBookId();
        $response = $this->putJson(self::BOOKS. $book_id, [
            'child_parent_id' => 1,
            'event_detail_id' => 'fce485a5-f5c9-49ee-8b26-31712e7dc7c2',
            'status'          => 0,
            'price'           => 1500
        ]);
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function api_v1_books_book_idにPUTメソッドでデータを編集できる()
    {
        $book_id = $this->getFirstBookId();
        $response = $this->get(self::BOOKS. $book_id);
        $book = $response->json();
        $new = [
            'child_parent_id' => 1,
            'event_detail_id' => 'fce485a5-f5c9-49ee-8b26-31712e7dc7c2',
            'status'          => $book['status'],
            'price'           => $book['price']
        ];
        $this->putJson(self::BOOKS. $book_id, $new);

        $response = $this->get(self::BOOKS. $book_id);
        $book = $response->json();
        $book_result = [
            'child_parent_id' => $book['child_parent_id'],
            'event_detail_id' => $book['event_detail_id'],
            'status'          => $book['status'],
            'price'           => $book['price']
        ];
        $this->assertSame($new, $book_result);
    }

    /**
     * @test
     */
    public function api_v1_books_book_idに存在しないbook_idでPUTメソッドでアクセスすると404が返却される()
    {
        $this->withoutExceptionHandling();
        $response = $this->putJson(self::BOOKS. '999', [
            'child_parent_id' => 1,
            'event_detail_id' => 'fce485a5-f5c9-49ee-8b26-31712e7dc7c2',
            'status'          => 0,
            'price'           => 1500
        ]);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertJson([
            'message' => 'No query results for model [' .Book::class. '].'
        ]);
    }

    /**
     * @test
     */
    public function api_v1_books_book_idにDELETEメソッドでアクセスできる()
    {
        $book_id = $this->getFirstBookId();
        Book::query()->where('id', '=', $book_id)->delete();
        $response = $this->delete(self::BOOKS . $book_id);
        $response->assertStatus(200);
    }

    private function getFirstBookId()
    {
        return Book::query()->first()->value('id');
    }
}
