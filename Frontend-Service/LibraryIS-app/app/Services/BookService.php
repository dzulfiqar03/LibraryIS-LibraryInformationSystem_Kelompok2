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
     * Get all books with filtering and pagination
     */
    public function getAllBooks(array $filters = [], int $page = 1, int $perPage = 12): ?array
    {
        $response = $this->api->bookGraphql(GraphQLQueries::getAllBooks(), array_merge([
            'page' => $page,
            'perPage' => $perPage,
        ], $filters));

        if ($response && isset($response['data']['books'])) {
            return $response['data']['books'];
        }

        return $response;
    }

    /**
     * Search books
     */
    public function search(string $query, int $page = 1, int $perPage = 12): ?array
    {
        $response = $this->api->bookGraphql(GraphQLQueries::searchBooks(), [
            'query' => $query,
            'page' => $page,
            'perPage' => $perPage,
        ]);

        if ($response && isset($response['data']['searchBooks'])) {
            return $response['data']['searchBooks'];
        }

        return $response;
    }

    /**
     * Get book details by ID
     */
    public function getDetail(int $bookId): ?array
    {
        $response = $this->api->bookGraphql(GraphQLQueries::getBookDetail(), [
            'id' => (string)$bookId,
        ]);

        if ($response && isset($response['data']['book'])) {
            return $response['data']['book'];
        }

        return $response;
    }

    /**
     * Get book recommendations
     */
    public function getRecommendations(int $limit = 20): ?array
    {
        $response = $this->api->bookGraphql(GraphQLQueries::getRecommendations(), [
            'limit' => $limit,
        ]);

        if ($response && isset($response['data']['recommendations'])) {
            return $response['data']['recommendations'];
        }

        return $response;
    }

    /**
     * Get books by category
     */
    public function getByCategory(string $category, int $page = 1, int $perPage = 12): ?array
    {
        $response = $this->api->graphql(GraphQLQueries::getBooksByCategory(), [
            'category' => $category,
            'page' => $page,
            'perPage' => $perPage,
        ]);

        if ($response && isset($response['data']['booksByCategory'])) {
            return $response['data']['booksByCategory'];
        }

        return $response;
    }

    /**
     * Get all book categories
     */
    public function getCategories(): ?array
    {
        $response = $this->api->graphql(GraphQLQueries::getCategories());

        if ($response && isset($response['data']['categories'])) {
            return $response['data']['categories'];
        }

        return $response;
    }

    /**
     * Check book availability
     */
    public function checkAvailability(int $bookId): ?array
    {
        $response = $this->api->graphql(GraphQLQueries::checkBookAvailability(), [
            'bookId' => (string)$bookId,
        ]);

        if ($response && isset($response['data']['book'])) {
            return $response['data']['book'];
        }

        return $response;
    }

    /**
     * Create book (Librarian only)
     */
    public function create(array $data): ?array
    {
        // This would need a separate mutation - adjust based on your actual schema
        return $this->api->post('/books', $data);
    }

    /**
     * Update book (Librarian only)
     */
    public function update(int $bookId, array $data): ?array
    {
        // This would need a separate mutation - adjust based on your actual schema
        return $this->api->put("/books/{$bookId}", $data);
    }

    /**
     * Delete book (Librarian only)
     */
    public function delete(int $bookId): ?array
    {
        // This would need a separate mutation - adjust based on your actual schema
        return $this->api->delete("/books/{$bookId}");
    }
}
