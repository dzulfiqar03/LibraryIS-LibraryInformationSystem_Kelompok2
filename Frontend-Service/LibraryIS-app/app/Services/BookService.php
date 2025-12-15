<?php

namespace App\Services;

class BookService
{
    protected ApiClient $api;

    public function __construct()
    {
        $this->api = new ApiClient();
    }

    /**
     * Search books
     */
    public function search(array $filters = [], int $page = 1, int $perPage = 12): ?array
    {
        $params = array_merge($filters, [
            'page' => $page,
            'per_page' => $perPage,
        ]);

        return $this->api->get('/books/search', $params);
    }

    /**
     * Get book details
     */
    public function getDetail(int $bookId): ?array
    {
        return $this->api->get("/books/{$bookId}");
    }

    /**
     * Get book recommendations
     */
    public function getRecommendations(int $limit = 20): ?array
    {
        return $this->api->get('/books/recommendations', ['limit' => $limit]);
    }

    /**
     * Get book by category
     */
    public function getByCategory(string $category, int $page = 1, int $perPage = 12): ?array
    {
        return $this->api->get('/books', [
            'category' => $category,
            'page' => $page,
            'per_page' => $perPage,
        ]);
    }

    /**
     * Get featured books
     */
    public function getFeatured(int $limit = 10): ?array
    {
        return $this->api->get('/books/featured', ['limit' => $limit]);
    }

    /**
     * Create book (Librarian only)
     */
    public function create(array $data): ?array
    {
        return $this->api->post('/books', $data);
    }

    /**
     * Update book (Librarian only)
     */
    public function update(int $bookId, array $data): ?array
    {
        return $this->api->put("/books/{$bookId}", $data);
    }

    /**
     * Delete book (Librarian only)
     */
    public function delete(int $bookId): ?array
    {
        return $this->api->delete("/books/{$bookId}");
    }
}
