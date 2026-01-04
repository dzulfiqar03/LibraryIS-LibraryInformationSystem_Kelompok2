<?php

namespace App\GraphQL\Mutations;

use App\GraphQL\Resolver\TransactionResolver;
use Illuminate\Support\Facades\Http;

class BookMutation
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public string $uri = 'http://localhost:8002/api/';

    public function create($_, array $args)
    {
        $token = request()->bearerToken();

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->post($this->uri . 'Book/store', $args['input']);

        if ($response->failed()) {
            throw new \Exception("Gagal menyimpan buku: " . $response->body());
        }

        $newBook = $response->json('data');
        $newId = $newBook['id'] ?? null;

        if (!$newId) {
            throw new \Exception("API tidak mengembalikan ID baru.");
        }


        $data = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get($this->uri . 'Book/' . $newId)->json('data');


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
            'message' => 'Book created successfully',
            'data' => [
                'id' => $data['id'],
                'title' => $data['title'],
                'book_detail' => $book_detail

            ] // Data lengkap termasuk ID dari database
        ];
    }

    public function update($_, array $args)
    {
        // Logic to update a transaction
        $token = request()->bearerToken();
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->put($this->uri . 'Book/update' . $args['id'], $args['input']);


        $data = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get($this->uri . 'Book/' . $args['id'])->json('data');


        $book_detail = [
            'authors'          => $newBook['book_detail']['authors'] ?? null,
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
            'message' => 'Book updated successfully',
            'data' => [
                'id' => $data['id'],
                'title' => $data['title'],
                'book_detail' => $book_detail

            ] // Data lengkap termasuk ID dari database
        ];
    }

    public function delete($_, array $args)
    {
        // Logic to delete a transaction

        $token = request()->bearerToken();
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->delete($this->uri . 'Book/delete/' . $args['id']);
        $data = $response->json('data');
        return [
            'message' => 'Book deleted successfully',
            'data' => Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get($this->uri . 'allBook')->json('data'),
        ];
    }
}
