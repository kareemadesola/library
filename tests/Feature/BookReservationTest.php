<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     * @test
     *
     */
    public function a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();
        $response = $this->post('/books',[
            'title' => 'Cool Book Title',
            'author' => 'Adesola'
        ]);
        $response->assertOk();
        $this->assertCount(1,Book::all());
//        return $this;
    }

    /**
     * @test
     */
    public function a_title_is_required()
    {
//        $this->withoutExceptionHandling();
        $response = $this->post('/books',[
            'title' => '',
            'author' => 'Adesola'
        ]);
//        $response->assertOk();
        $response->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function an_author_is_required()
    {
//        $this->withoutExceptionHandling();
        $response = $this->post('/books',[
            'title' => 'Cool Book Title',
            'author' => ''
        ]);
//        $response->assertOk();
        $response->assertSessionHasErrors('author');
    }

 /**
     * @test
     */
    public function a_book_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $this->post('/books',[
            'title' => 'Cool Book Title',
            'author' => 'Victor'
        ]);

        $book = Book::first();

        $this->patch('/books/'.$book->id,[
            'title' => 'New Title',
            'author' => 'New Author'
        ]);

        $this->assertEquals('New Title',Book::first()->title);
        $this->assertEquals('New Author',Book::first()->author);
    }

}
