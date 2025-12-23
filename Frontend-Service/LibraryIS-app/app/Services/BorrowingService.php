<?php

namespace App\Services;

class BorrowingService
{
    protected ApiClient $api;

    public function __construct()
    {
        $this->api = new ApiClient();
    }

    /**
     * Get member borrowing history with pagination and filtering
     * Requires JWT token
     */
    public function getBorrowings(int $page = 1, int $perPage = 10, string $status = null): ?array
    {
        $variables = [
            'page' => $page,
            'perPage' => $perPage,
        ];

        if ($status) {
            $variables['status'] = $status;
        }

        $response = $this->api->transactionGraphql(GraphQLQueries::getBorrowings(), $variables);

        if ($response && isset($response['data']['borrowings'])) {
            return $response['data']['borrowings'];
        }

        return $response;
    }

    /**
     * Get borrowing detail by ID
     * Requires JWT token
     */
    public function getDetail(int $borrowingId): ?array
    {
        $response = $this->api->transactionGraphql(GraphQLQueries::getBorrowingDetail(), [
            'id' => (string)$borrowingId,
        ]);

        if ($response && isset($response['data']['borrowing'])) {
            return $response['data']['borrowing'];
        }

        return $response;
    }

    /**
     * Get currently active borrowings (not yet returned)
     * Requires JWT token
     */
    public function getActiveBorrowings(): ?array
    {
        $response = $this->api->transactionGraphql(GraphQLQueries::getActiveBorrowings());

        if ($response && isset($response['data']['activeBorrowings'])) {
            return $response['data']['activeBorrowings'];
        }

        return $response;
    }

    /**
     * Borrow a book
     * Requires JWT token
     */
    public function borrow(int $bookId): ?array
    {
        $response = $this->api->transactionGraphql(GraphQLQueries::borrowBook(), [
            'bookId' => (string)$bookId,
        ]);

        if ($response && isset($response['data']['borrowBook'])) {
            return $response['data']['borrowBook'];
        }

        return $response;
    }

    /**
     * Return a borrowed book
     * Requires JWT token
     */
    public function return(int $borrowingId): ?array
    {
        $response = $this->api->transactionGraphql(GraphQLQueries::returnBook(), [
            'borrowingId' => (string)$borrowingId,
        ]);

        if ($response && isset($response['data']['returnBook'])) {
            return $response['data']['returnBook'];
        }

        return $response;
    }

    /**
     * Reserve a book (when not available)
     * Requires JWT token
     */
    public function reserve(int $bookId): ?array
    {
        // Note: This would need a separate mutation in your GraphQL schema
        // For now, return null if not implemented
        return null;
    }

    /**
     * Cancel a book reservation
     * Requires JWT token
     */
    public function cancelReservation(int $reservationId): ?array
    {
        // Note: This would need a separate mutation in your GraphQL schema
        return null;
    }

    /**
     * Get user's outstanding fines
     * Requires JWT token
     */
    public function getFines(): ?array
    {
        // Note: This would need a separate query in your GraphQL schema
        return null;
    }

    /**
     * Pay a fine
     * Requires JWT token
     */
    public function payFine(int $fineId, float $amount): ?array
    {
        // Note: This would need a separate mutation in your GraphQL schema
        return null;
    }

    /**
     * Get overdue books (Librarian only)
     */
    public function getOverdueBooks(int $page = 1, int $perPage = 10): ?array
    {
        // Note: This would need a separate query in your GraphQL schema
        return null;
    }

    /**
     * Process book return (Librarian only)
     */
    public function processReturn(int $borrowingId, array $data = []): ?array
    {
        // Note: This would need a separate mutation in your GraphQL schema
        return null;
    }
}

