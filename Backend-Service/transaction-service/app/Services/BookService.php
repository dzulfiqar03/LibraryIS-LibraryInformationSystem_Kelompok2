<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BookService
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = config('services.book_service.url');
        $this->token = config('services.book_service.token');
    }

    public function getBook($bookId)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Accept' => 'application/json'
            ])->get($this->baseUrl . '/api/Book/' . $bookId);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to fetch book', [
                'book_id' => $bookId,
                'response' => $response->body()
            ]);
            return null;
        } catch (\Exception $e) {
            Log::error('Exception fetching book', [
                'book_id' => $bookId,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    public function validateBook($bookId)
    {
        $book = $this->getBook($bookId);
        return $book !== null;
    }

    public function updateBookStatus($bookId, $status)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Accept' => 'application/json'
            ])->put($this->baseUrl . '/api/Book/update/' . $bookId, [
                'status' => $status
            ]);

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Exception updating book status', [
                'book_id' => $bookId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
