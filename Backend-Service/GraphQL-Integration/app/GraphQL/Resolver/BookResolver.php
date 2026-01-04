<?php

namespace App\GraphQL\Resolver;

use Illuminate\Support\Facades\Http;

class BookResolver
{
    /**
     * Create a new class instance.
     */

    protected string $url = 'http://127.0.0.1:8002/api/';

    public function all()
    {
        $token = request()->bearerToken();
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get($this->url . 'allBook');
        $data = $response->json('data');

        $books = array_map(function ($book) {
            return [
                'id'    => $book['id'],
                'title' => $book['title'],
                'book_detail' => [
                    'authors'          => $book['book_detail']['authors'] ?? null,
                    'isbn'             => $book['book_detail']['isbn'] ?? null,
                    'publisher'        => $book['book_detail']['publisher'] ?? null,
                    'publication_year' => $book['book_detail']['publication_year'] ?? null,
                    'category'         => $book['book_detail']['category'] ?? 'uncategorized',
                    'description' => $book['book_detail']['description'] ?? null,
                    'pages' => $book['book_detail']['pages'] ?? null,
                    'quantity' => $book['book_detail']['quantity'] ?? null,
                    'languages' => $book['book_detail']['languages'] ?? null,
                    'url_cover' => $book['book_detail']['url_cover'] ?? null,
                    'url_ebook' => $book['book_detail']['url_ebook'] ?? null,
                    'status'           => $book['book_detail']['status'] ?? 'available',
                ]
            ];
        }, $data);

        return [
            'booksList' => $books
        ];
    }

    public function find($_, array $args)
    {
        $token = request()->bearerToken();

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get($this->url . 'Book/' . $args['id']);

        $data = $response->json('data');

        if (!$data) {
            return null;
        }

        $book_detail = [
            'authors'          => $data['book_detail']['authors'] ?? null,
            'isbn'             => $data['book_detail']['isbn'] ?? null,
            'publisher'        => $data['book_detail']['publisher'] ?? null,
            'publication_year' => $data['book_detail']['publication_year'] ?? null,
            'category'         => $data['book_detail']['category'] ?? 'uncategorized',
            'description' => $data['book_detail']['description'] ?? null,
            'pages' => $data['book_detail']['pages'] ?? null,
            'quantity' => $data['book_detail']['quantity'] ?? null,
            'languages' => $data['book_detail']['languages'] ?? null,
            'url_cover' => $data['book_detail']['url_cover'] ?? null,
            'url_ebook' => $data['book_detail']['url_ebook'] ?? null,
            'status'           => $data['book_detail']['status'] ?? 'available',
        ] ?? [];

        return [
            'id' => $data['id'],
            'title' => $data['title'],
            'book_detail' => $book_detail
        ];
    }
}
