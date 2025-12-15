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
     * Get member borrowings
     */
    public function getBorrowings(int $page = 1, int $perPage = 10): ?array
    {
        return $this->api->get('/borrowings', [
            'page' => $page,
            'per_page' => $perPage,
        ]);
    }

    /**
     * Get borrowing detail
     */
    public function getDetail(int $borrowingId): ?array
    {
        return $this->api->get("/borrowings/{$borrowingId}");
    }

    /**
     * Borrow a book
     */
    public function borrow(int $bookId): ?array
    {
        return $this->api->post('/borrowings', [
            'book_id' => $bookId,
        ]);
    }

    /**
     * Return a book
     */
    public function return(int $borrowingId): ?array
    {
        return $this->api->post("/borrowings/{$borrowingId}/return", []);
    }

    /**
     * Reserve a book
     */
    public function reserve(int $bookId): ?array
    {
        return $this->api->post('/reservations', [
            'book_id' => $bookId,
        ]);
    }

    /**
     * Cancel reservation
     */
    public function cancelReservation(int $reservationId): ?array
    {
        return $this->api->delete("/reservations/{$reservationId}");
    }

    /**
     * Get user's fines
     */
    public function getFines(): ?array
    {
        return $this->api->get('/fines');
    }

    /**
     * Pay fine
     */
    public function payFine(int $fineId, float $amount): ?array
    {
        return $this->api->post("/fines/{$fineId}/pay", [
            'amount' => $amount,
        ]);
    }

    /**
     * Get overdue books (Librarian)
     */
    public function getOverdueBooks(int $page = 1, int $perPage = 10): ?array
    {
        return $this->api->get('/borrowings/overdue', [
            'page' => $page,
            'per_page' => $perPage,
        ]);
    }

    /**
     * Process return (Librarian)
     */
    public function processReturn(int $borrowingId, array $data = []): ?array
    {
        return $this->api->post("/borrowings/{$borrowingId}/process-return", $data);
    }
}
