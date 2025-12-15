<?php

namespace App\GraphQL\Resolver;

use App\Models\Book;

class BookResolver
{
    /**
     * Create a new class instance.
     */
    public function all()
    {
        $book = Book::with('book_detail')->get();
        return [
            'booksList' => $book
        ];
    }

    public function find($_, array $args)
    {
        $book = Book::with('book_detail')->findOrFail($args['id']);
        return $book;
    }
}
