<?php

namespace App\Services;

use CodeIgniter\HTTP\CURLRequest;

class BookService
{
    protected string $baseUrl = 'http://127.0.0.1:8000/api/';  // Adjust if needed from .env
    protected CURLRequest $client;

    public function __construct()
    {
        $this->client = \Config\Services::curlrequest();
    }

    private function getHeaders(): array
    {
        $token = session()->get('jwt_token');
        return [
            'Authorization' => $token ? 'Bearer ' . $token : '',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
    }

    /**
     * Get all books with filtering and pagination
     */
    public function getAllBooks(array $filters = [], int $page = 1, int $perPage = 12): ?array
    {
        try {
            $response = $this->client->get($this->baseUrl . 'allBook', [
                'headers' => $this->getHeaders(),
                'query' => array_merge([
                    'page' => $page,
                    'per_page' => $perPage  // Adjust if backend uses 'per_page'
                ], $filters)
            ]);

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody(), true);
                return $data['data'] ?? $data ?? [];
            }

            throw new \Exception('Failed to fetch books. Status: ' . $response->getStatusCode());
        } catch (\Exception $e) {
            log_message('error', 'Get all books error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Search books - Since no search endpoint, fetch all and filter (or add to backend)
     */
    public function search(string $query, int $page = 1, int $perPage = 12): ?array
    {
        $allBooks = $this->getAllBooks([], 1, 100);  // Fetch larger set for filtering

        if (!$allBooks) {
            return null;
        }

        $filtered = array_filter($allBooks, function ($book) use ($query) {
            $search = strtolower($query);
            return str_contains(strtolower($book['title'] ?? ''), $search) ||
                   str_contains(strtolower($book['author'] ?? ''), $search) ||
                   str_contains(strtolower($book['isbn'] ?? ''), $search);
        });

        $offset = ($page - 1) * $perPage;
        $paginated = array_slice($filtered, $offset, $perPage);

        return [
            'data' => $paginated,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => ceil(count($filtered) / $perPage),
                'total' => count($filtered)
            ]
        ];
    }

    /**
     * Get book details by ID
     */
    public function getDetail(int $bookId): ?array
    {
        try {
            $response = $this->client->get($this->baseUrl . "Book/{$bookId}", [
                'headers' => $this->getHeaders()
            ]);

            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody(), true);
                return $data['data'] ?? $data ?? null;
            }

            throw new \Exception('Book not found. Status: ' . $response->getStatusCode());
        } catch (\Exception $e) {
            log_message('error', 'Get book detail error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get book recommendations - Random from all
     */
    public function getRecommendations(int $limit = 20): ?array
    {
        $allBooks = $this->getAllBooks([], 1, 100);
        if (!$allBooks) return null;

        shuffle($allBooks);
        return array_slice($allBooks, 0, $limit);
    }

    /**
     * Get books by category - Filter from all
     */
    public function getByCategory(string $category, int $page = 1, int $perPage = 12): ?array
    {
        return $this->search($category, $page, $perPage);
    }

    /**
     * Check book availability
     */
    public function checkAvailability(int $bookId): ?array
    {
        $book = $this->getDetail($bookId);
        if (!$book) return null;

        return [
            'available' => ($book['quantity'] ?? 0) > 0
        ];
    }

    /**
     * Get book by ID (alias)
     */
    public function getBookById(int $bookId): ?array
    {
        return $this->getDetail($bookId);
    }

    /**
     * Create book (Admin only)
     */
    public function createBook(array $data): ?array
    {
        try {
            $response = $this->client->post($this->baseUrl . 'Book/store', [
                'headers' => $this->getHeaders(),
                'json' => $data
            ]);

            if ($response->getStatusCode() === 200 || $response->getStatusCode() === 201) {
                $result = json_decode($response->getBody(), true);
                return $result['data'] ?? $result ?? [];
            }

            throw new \Exception('Failed to create book. Status: ' . $response->getStatusCode());
        } catch (\Exception $e) {
            log_message('error', 'Create book error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Update book (Admin only)
     */
    public function updateBook(int $bookId, array $data): ?array
    {
        try {
            $response = $this->client->put($this->baseUrl . "Book/update/{$bookId}", [
                'headers' => $this->getHeaders(),
                'json' => $data
            ]);

            if ($response->getStatusCode() === 200) {
                $result = json_decode($response->getBody(), true);
                return $result['data'] ?? $result ?? [];
            }

            throw new \Exception('Failed to update book. Status: ' . $response->getStatusCode());
        } catch (\Exception $e) {
            log_message('error', 'Update book error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Delete book (Admin only)
     */
    public function deleteBook(int $bookId): ?array
    {
        try {
            $response = $this->client->delete($this->baseUrl . "Book/delete/{$bookId}", [
                'headers' => $this->getHeaders()
            ]);

            if ($response->getStatusCode() === 200 || $response->getStatusCode() === 204) {
                $result = json_decode($response->getBody(), true);
                return $result['data'] ?? $result ?? [];
            }

            throw new \Exception('Failed to delete book. Status: ' . $response->getStatusCode());
        } catch (\Exception $e) {
            log_message('error', 'Delete book error: ' . $e->getMessage());
            return null;
        }
    }

    // Backward compatibility
    public function create(array $data): ?array { return $this->createBook($data); }
    public function update(int $bookId, array $data): ?array { return $this->updateBook($bookId, $data); }
    public function delete(int $bookId): ?array { return $this->deleteBook($bookId); }
}