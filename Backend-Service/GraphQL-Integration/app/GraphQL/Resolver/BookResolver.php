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
                'id' => $book['id'],
                'title' => $book['title'],
                'book_detail' => [
                    'authors' => $book['book_detail'][0]['authors'] ?? [],
                    
                ] ?? []
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
            'authors' => $data['book_detail'][0]['authors'] ?? [],
        ] ?? [];

        return [
            'id' => $data['id'],
            'title' => $data['title'],
            'book_detail' => $book_detail
        ];
    }
}
