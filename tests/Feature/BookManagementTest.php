<?php

namespace Tests\Feature;

use App\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     * @test
     *
     */
    public function a_book_can_be_added_to_the_library()
    {
        $response = $this->post('/books',[
            'title' => 'Cool Book Title',
            'author' => 'Adesola'
        ]);
        $this->assertCount(1,Book::all());
        $book = Book::first();
        $response->assertRedirect($book->path());
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
        $this->post('/books',[
            'title' => 'Cool Book Title',
            'author' => 'Victor'
        ]);

        $book = Book::first();

        $response = $this->patch($book->path(), [
            'title' => 'New Title',
            'author' => 'New Author'
        ]);
//        $book = Book::first();

        $this->assertEquals('New Title',Book::first()->title);
        $this->assertEquals('New Author',Book::first()->author);
        $response->assertRedirect($book->fresh()->path());
    }

    /**
     * @test
     */
    public function a_book_can_be_deleted()
    {
        $this->post('/books',[
            'title' => 'Cool Book Title',
            'author' => 'Victor'
        ]);

        $book = Book::first();
        $this->assertCount(1, Book::all());
        $response = $this->delete($book->path());
        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');

    }

}
