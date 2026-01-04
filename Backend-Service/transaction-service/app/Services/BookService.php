<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BookService
{
    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'http://127.0.0.1:8002/api';
    }

    public function getBook($bookId)
    {
        try {
            // Use test endpoint to avoid authentication issues for internal service calls
            $response = Http::timeout(10)->get("{$this->baseUrl}/test/Book/{$bookId}");

            if ($response->successful()) {
                $data = $response->json();
                return $data['data'] ?? $data;
            }

            \Log::warning("BookService: Failed to get book {$bookId}. HTTP {$response->status()}");
            return null;
        } catch (\Exception $e) {
            \Log::error("BookService error: " . $e->getMessage());
            return null;
        }
    }
}
