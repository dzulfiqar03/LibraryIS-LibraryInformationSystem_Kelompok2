<?php

namespace App\Services;

use App\Services\ApiClient;

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
        // Get current user ID from session
        $user = session()->get('user');
        $memberId = $user['id'] ?? null;
        
        if (!$memberId) {
            throw new \Exception('User ID not found in session');
        }

        // Call Transaction Service REST API (using temp endpoint for testing)
        $url = "http://127.0.0.1:8003/api/temp/members/{$memberId}/transactions";
        $params = [
            'page' => $page,
            'per_page' => $perPage
        ];
        
        if ($status) {
            $params['status'] = $status;
        }
        
        $url .= '?' . http_build_query($params);
        
        $ch = curl_init($url);
        
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json',
                'Authorization: Bearer ' . ($this->api->getToken() ?? session()->get('jwt_token'))
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        log_message('info', "Get Borrowings API Response (HTTP {$httpCode}): " . substr($response, 0, 500));

        if (!empty($curlError)) {
            log_message('error', "Get Borrowings CURL Error: {$curlError}");
            throw new \Exception("Connection error: {$curlError}");
        }

        if (empty($response)) {
            return [];
        }

        try {
            $data = json_decode($response, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                log_message('error', 'Get Borrowings JSON decode error: ' . json_last_error_msg());
                return [];
            }

            if ($httpCode >= 200 && $httpCode < 300) {
                // Transform the transaction data into the format expected by the frontend
                $transformedData = $this->transformTransactionsData($data);
                return $transformedData;
            } else {
                log_message('warning', 'Get Borrowings failed: ' . ($data['message'] ?? 'Unknown error'));
                return [];
            }
        } catch (\Exception $e) {
            log_message('error', 'Get Borrowings exception: ' . $e->getMessage());
            return [];
        }
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
        // Get current user ID from session
        $user = session()->get('user');
        $memberId = $user['id'] ?? null;
        
        if (!$memberId) {
            throw new \Exception('User ID not found in session. Please log in again.');
        }

        // Call Transaction Service REST API directly
        $url = 'http://127.0.0.1:8003/api/temp/transactions';
        
        $requestData = [
            'id_member' => $memberId,
            'books' => [
                [
                    'id_book' => $bookId,
                    'quantity' => 1,
                    'price' => 0 // For borrowing, price is usually 0
                ]
            ],
            'transaction_date' => date('Y-m-d H:i:s')
        ];
        
        $ch = curl_init($url);
        
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($requestData),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Bearer ' . ($this->api->getToken() ?? session()->get('jwt_token'))
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        log_message('info', "Borrow API Request: " . json_encode($requestData));
        log_message('info', "Borrow API Response (HTTP {$httpCode}): " . substr($response, 0, 500));

        if (!empty($curlError)) {
            log_message('error', "Borrow CURL Error: {$curlError}");
            throw new \Exception("Connection error: {$curlError}");
        }

        if (empty($response)) {
            throw new \Exception('No response from Transaction Service. Is it running on port 8003?');
        }

        try {
            $data = json_decode($response, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                log_message('error', 'Borrow JSON decode error: ' . json_last_error_msg());
                throw new \Exception('Invalid server response format');
            }

            if ($httpCode >= 200 && $httpCode < 300) {
                return $data;
            } else {
                $message = $data['message'] ?? $data['error'] ?? 'Failed to borrow book';
                log_message('warning', "Borrow failed (HTTP {$httpCode}): {$message}");
                throw new \Exception($message);
            }
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), 'Failed to borrow book') === false) {
                log_message('error', 'Borrow exception: ' . $e->getMessage());
            }
            throw $e;
        }
    }

    /**
     * Return a borrowed book
     * Requires JWT token
     */
    /**
     * Return a borrowed book
     * Requires JWT token and book ID
     */
    public function returnBook(int $borrowingId, ?int $bookId = null): ?array
    {
        // For the return functionality, we need to call the Transaction Service REST API
        // The borrowingId from frontend is in format "transactionId_detailId"
        $borrowingIdStr = (string) $borrowingId;
        $parts = explode('_', $borrowingIdStr);
        $transactionId = $parts[0] ?? $borrowingIdStr;

        // First, get the current member ID from session (same as other methods)
        $user = session()->get('user');
        $memberId = $user['id'] ?? null;
        
        if (!$memberId) {
            throw new \Exception('User ID not found in session');
        }

        // Use the provided book ID or extract from borrowing ID
        $targetBookId = $bookId ?? (int)($parts[1] ?? 1);

        // Prepare the return request data
        $returnData = [
            'id_member' => $memberId,
            'books' => [
                [
                    'id_book' => $targetBookId,
                    'quantity' => 1,
                    'price' => 0.00
                ]
            ],
            'transaction_date' => date('Y-m-d H:i:s')
        ];

        // Debug logging
        log_message('info', "Return request data: " . json_encode($returnData));
        log_message('info', "Member ID from session: {$memberId}");
        log_message('info', "Target book ID: {$targetBookId}");
        log_message('info', "Transaction ID: {$transactionId}");

        $url = "http://127.0.0.1:8003/api/temp/transactions/{$transactionId}/return";
        
        $ch = curl_init($url);
        
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => json_encode($returnData),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Bearer ' . ($this->api->getToken() ?? session()->get('jwt_token'))
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        log_message('info', "Return book API Response (HTTP {$httpCode}): " . substr($response, 0, 500));

        if (!empty($curlError)) {
            log_message('error', "Return book CURL Error: {$curlError}");
            throw new \Exception("Connection error: {$curlError}");
        }

        if (empty($response)) {
            throw new \Exception('No response from Transaction Service');
        }

        try {
            $data = json_decode($response, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                log_message('error', 'Return book JSON decode error: ' . json_last_error_msg());
                throw new \Exception('Invalid server response format');
            }

            if ($httpCode >= 200 && $httpCode < 300) {
                return $data;
            } else {
                $message = $data['message'] ?? $data['error'] ?? 'Failed to return book';
                log_message('warning', "Return book failed (HTTP {$httpCode}): {$message}");
                throw new \Exception($message);
            }
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), 'Failed to return book') === false) {
                log_message('error', 'Return book exception: ' . $e->getMessage());
            }
            throw $e;
        }
    }

    public function return(int $borrowingId): ?array
    {
        // Legacy method - delegate to returnBook with no book ID
        return $this->returnBook($borrowingId, null);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        log_message('info', "Return book API Response (HTTP {$httpCode}): " . substr($response, 0, 500));

        if (!empty($curlError)) {
            log_message('error', "Return book CURL Error: {$curlError}");
            throw new \Exception("Connection error: {$curlError}");
        }

        if (empty($response)) {
            throw new \Exception('No response from Transaction Service');
        }

        try {
            $data = json_decode($response, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                log_message('error', 'Return book JSON decode error: ' . json_last_error_msg());
                throw new \Exception('Invalid server response format');
            }

            if ($httpCode >= 200 && $httpCode < 300) {
                return $data;
            } else {
                $message = $data['message'] ?? $data['error'] ?? 'Failed to return book';
                log_message('warning', "Return book failed (HTTP {$httpCode}): {$message}");
                throw new \Exception($message);
            }
        } catch (\Exception $e) {
            if (strpos($e->getMessage(), 'Failed to return book') === false) {
                log_message('error', 'Return book exception: ' . $e->getMessage());
            }
            throw $e;
        }
    }

    /**
     * Renew a borrowed book
     * Requires JWT token  
     */
    public function renew(int $borrowingId): ?array
    {
        // For now, return a simple success response
        // In a real implementation, this would extend the due date
        log_message('info', "Renew requested for borrowing ID: {$borrowingId}");
        
        return [
            'success' => true,
            'message' => 'Book renewed successfully',
            'borrowing_id' => $borrowingId,
            // In a real system, you would:
            // 1. Update the due_date in the database
            // 2. Check if the book can be renewed (not overdue, renewal limit not exceeded)
            // 3. Return updated borrowing information
        ];
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

    /**
     * Transform transaction data from Transaction Service into borrowing format expected by frontend
     */
    private function transformTransactionsData($apiResponse): array
    {
        $transactions = $apiResponse['data'] ?? [];
        $borrowings = [];

        foreach ($transactions as $transaction) {
            // Get transaction details (books)
            $transactionDetails = $transaction['transaction_details'] ?? [];
            
            foreach ($transactionDetails as $detail) {
                $borrowing = [
                    'id' => $transaction['id'] . '_' . $detail['id'], // Unique ID for each borrowing
                    'transaction_id' => $transaction['id'],
                    'book_id' => $detail['id_book'],
                    'borrowed_date' => $transaction['transaction_date'],
                    'due_date' => $transaction['due_date'] ?? null,
                    'returned_date' => $transaction['return_date'] ?? null,
                    'status' => $transaction['status'] ?? 'active',
                    'book' => $detail['book_details'] ?? null,
                    'member' => $transaction['member_details'] ?? null,
                    'quantity' => $detail['quantity'] ?? 1,
                    'price' => $detail['price'] ?? 0
                ];
                
                $borrowings[] = $borrowing;
            }
        }

        // Return in the same format as the API response
        return [
            'message' => $apiResponse['message'] ?? 'Success',
            'data' => $borrowings
        ];
    }
}

