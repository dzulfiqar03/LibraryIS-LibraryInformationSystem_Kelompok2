<?php

namespace App\Services;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class BookServices
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected Book $book)
    {
        //
    }

    public function getAll()
    {
        return $this->book::with('book_detail')->latest()->get();
    }

    public function getById($id)
    {
        return $this->book::findOrFail($id)->get();
    }
    public function createBook(array $data)
    {
        return DB::transaction(function () use ($data) {

            $book = $this->book->create(['title' => $data['title']]);

            if (request()->is('graphql')) {
                if (!empty($data['detail'])) {
                    $book->book_detail()->create([
                        'authors'           => $data['detail']['authors'] ?? null,
                        'isbn'              => $data['detail']['isbn'] ?? null,
                        'publisher'         => $data['detail']['publisher'] ?? null,
                        'publication_year'  => $data['detail']['publication_year'] ?? null,
                        'category'          => $data['detail']['category'] ?? 'uncategorized',
                        'description'       => $data['detail']['description'] ?? null,
                        'pages'             => $data['detail']['pages'] ?? null,
                        'quantity'          => $data['detail']['quantity'] ?? 1,
                        'languages'         => $data['detail']['languages'] ?? null,
                        'url_cover'         => $data['detail']['url_cover'] ?? null,
                        'url_ebook'         => $data['detail']['url_ebook'] ?? null,
                        'status'            => $data['detail']['status'] ?? 'available',
                    ]);
                }
            } else {
                // For REST API calls
                $book->book_detail()->create([
                    'authors'           => $data['authors'] ?? null,
                    'isbn'              => $data['isbn'] ?? null,
                    'publisher'         => $data['publisher'] ?? null,
                    'publication_year'  => $data['publication_year'] ?? null,
                    'category'          => $data['category'] ?? 'uncategorized',
                    'description'       => $data['description'] ?? null,
                    'pages'             => $data['pages'] ?? null,
                    'quantity'          => $data['quantity'] ?? 1,
                    'languages'         => $data['languages'] ?? null,
                    'url_cover'         => $data['url_cover'] ?? null,
                    'url_ebook'         => $data['url_ebook'] ?? null,
                    'status'            => $data['status'] ?? 'available',
                ]);
            }

            return $book->load('book_detail');
        });
    }

    public function updateBook($id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {

            $book = $this->book->findOrFail($id);
            $book->update(['title' => $data['title']]);

            if (request()->is('graphql')) {
                if (!empty($data['detail'])) {
                    $book->book_detail()->updateOrCreate(
                        ['id_book' => $book->id],
                        [
                            'authors'           => $data['detail']['authors'] ?? null,
                            'isbn'              => $data['detail']['isbn'] ?? null,
                            'publisher'         => $data['detail']['publisher'] ?? null,
                            'publication_year'  => $data['detail']['publication_year'] ?? null,
                            'category'          => $data['detail']['category'] ?? 'uncategorized',
                            'description'       => $data['detail']['description'] ?? null,
                            'pages'             => $data['detail']['pages'] ?? null,
                            'quantity'          => $data['detail']['quantity'] ?? 1,
                            'languages'         => $data['detail']['languages'] ?? null,
                            'url_cover'         => $data['detail']['url_cover'] ?? null,
                            'url_ebook'         => $data['detail']['url_ebook'] ?? null,
                            'status'            => $data['detail']['status'] ?? 'available',
                        ]
                    );
                }
            } else {
                // For REST API calls
                $book->book_detail()->updateOrCreate(
                    ['id_book' => $book->id],
                    [
                        'authors'           => $data['authors'] ?? null,
                        'isbn'              => $data['isbn'] ?? null,
                        'publisher'         => $data['publisher'] ?? null,
                        'publication_year'  => $data['publication_year'] ?? null,
                        'category'          => $data['category'] ?? 'uncategorized',
                        'description'       => $data['description'] ?? null,
                        'pages'             => $data['pages'] ?? null,
                        'quantity'          => $data['quantity'] ?? 1,
                        'languages'         => $data['languages'] ?? null,
                        'url_cover'         => $data['url_cover'] ?? null,
                        'url_ebook'         => $data['url_ebook'] ?? null,
                        'status'            => $data['status'] ?? 'available',
                    ]
                );
            }

            return $book->load('book_detail');
        });
    }

    public function deleteBook($id)
    {
        return DB::transaction(function () use ($id) {
            $book = $this->book->findOrFail($id);

            // Delete related book_detail first (cascade should handle this, but being explicit)
            $book->book_detail()->delete();

            // Delete the book
            $book->delete();

            return true;
        });
    }
}
