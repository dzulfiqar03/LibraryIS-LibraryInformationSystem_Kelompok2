<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Services\BorrowingService;

class BorrowingApiController extends BaseController
{
    protected BorrowingService $borrowingService;

    public function __construct()
    {
        $this->borrowingService = new BorrowingService();
    }

    /**
     * Borrow a book
     */
    public function borrow()
    {
        // Debug logging
        $method = strtolower($this->request->getMethod());
        log_message('info', "Borrow request method: {$method}");
        log_message('info', "Request URI: " . $this->request->getUri());
        
        if ($method !== 'post') {
            return $this->response->setStatusCode(405)->setJSON([
                'success' => false,
                'message' => 'Method not allowed - received: ' . $method . ' (expected: post)'
            ]);
        }

        try {
            $data = $this->request->getJSON();
            $bookId = $data->book_id ?? null;

            if (!$bookId) {
                return $this->response->setStatusCode(400)->setJSON([
                    'success' => false,
                    'message' => 'Book ID is required'
                ]);
            }

            // Call BorrowingService to borrow
            $result = $this->borrowingService->borrow($bookId);

            return $this->response->setJSON([
                'success' => true,
                'borrowing' => $result,
                'message' => 'Book borrowed successfully'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Borrow book error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to borrow book: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Reserve a book
     */
    public function reserve()
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setStatusCode(405)->setJSON([
                'success' => false,
                'message' => 'Method not allowed'
            ]);
        }

        try {
            $data = $this->request->getJSON();
            $bookId = $data->book_id ?? null;

            if (!$bookId) {
                return $this->response->setStatusCode(400)->setJSON([
                    'success' => false,
                    'message' => 'Book ID is required'
                ]);
            }

            // For now, just return success
            // TODO: Implement reserve functionality
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Book reserved successfully'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Reserve book error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to reserve book'
            ]);
        }
    }

    /**
     * Return a book
     */
    public function returnBook()
    {
        $method = strtolower($this->request->getMethod());
        log_message('info', "Return book request method: {$method}");
        log_message('info', "Return book URI: " . $this->request->getUri());
        
        if (strtolower($this->request->getMethod()) !== 'post') {
            return $this->response->setStatusCode(405)->setJSON([
                'success' => false,
                'message' => 'Method not allowed - expected POST, got: ' . $this->request->getMethod()
            ]);
        }

        try {
            $data = $this->request->getJSON();
            $borrowingId = $data->borrowing_id ?? null;
            $bookId = $data->book_id ?? null;

            if (!$borrowingId) {
                return $this->response->setStatusCode(400)->setJSON([
                    'success' => false,
                    'message' => 'Borrowing ID is required'
                ]);
            }

            // Cast to integer and call BorrowingService to return
            $result = $this->borrowingService->returnBook((int) $borrowingId, $bookId);

            return $this->response->setJSON([
                'success' => true,
                'borrowing' => $result,
                'message' => 'Book returned successfully'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Return book error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to return book'
            ]);
        }
    }

    /**
     * Get borrowings list
     */
    public function index()
    {
        try {
            $page = $this->request->getGet('page') ?? 1;
            $status = $this->request->getGet('status') ?? null;

            log_message('info', "Loading borrowings - page: {$page}, status: " . ($status ?: 'all'));

            $results = $this->borrowingService->getBorrowings($page, 10, $status);
            
            log_message('info', "Raw getBorrowings result: " . json_encode($results));

            $borrowings = $results['data'] ?? $results;
            log_message('info', "Extracted borrowings: " . json_encode($borrowings));

            return $this->response->setJSON([
                'success' => true,
                'borrowings' => $borrowings,
                'message' => 'Borrowings retrieved',
                'debug' => [
                    'raw_results' => $results,
                    'count' => is_array($borrowings) ? count($borrowings) : 0
                ]
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Get borrowings error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to get borrowings: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Renew a borrowing
     */
    public function renew()
    {
        $method = strtolower($this->request->getMethod());
        log_message('info', "Renew book request method: {$method}");
        log_message('info', "Renew book URI: " . $this->request->getUri());
        
        if (strtolower($this->request->getMethod()) !== 'post') {
            return $this->response->setStatusCode(405)->setJSON([
                'success' => false,
                'message' => 'Method not allowed - expected POST, got: ' . $this->request->getMethod()
            ]);
        }

        try {
            $data = $this->request->getJSON();
            $borrowingId = $data->borrowing_id ?? null;

            if (!$borrowingId) {
                return $this->response->setStatusCode(400)->setJSON([
                    'success' => false,
                    'message' => 'Borrowing ID is required'
                ]);
            }

            $result = $this->borrowingService->renew((int) $borrowingId);

            return $this->response->setJSON([
                'success' => true,
                'borrowing' => $result,
                'message' => 'Book renewed successfully'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Renew book error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to renew book'
            ]);
        }
    }

    /**
     * Get member stats
     */
    public function memberStats()
    {
        try {
            $stats = $this->borrowingService->getMemberStats();

            return $this->response->setJSON([
                'success' => true,
                'stats' => $stats,
                'message' => 'Member stats retrieved'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Get member stats error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to get member stats',
                'stats' => [
                    'active_borrowings' => 0,
                    'overdue_books' => 0,
                    'total_read' => 0
                ]
            ]);
        }
    }
    
    /**
     * Debug test endpoint
     */
    public function debugTest()
    {
        $method = $this->request->getMethod();
        $headers = $this->request->getHeaders();
        $body = $this->request->getBody();
        
        return $this->response->setJSON([
            'success' => true,
            'method' => $method,
            'uri' => (string) $this->request->getUri(),
            'headers' => array_map(function($header) { return $header->getValue(); }, $headers),
            'body' => $body,
            'session_data' => [
                'has_jwt' => session()->has('jwt_token'),
                'has_user' => session()->has('user'),
                'is_logged_in' => session()->has('isLoggedIn')
            ]
        ]);
    }
}
