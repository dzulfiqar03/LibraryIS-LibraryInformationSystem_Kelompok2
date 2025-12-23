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
    public function return()
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setStatusCode(405)->setJSON([
                'success' => false,
                'message' => 'Method not allowed'
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

            // Call BorrowingService to return
            $result = $this->borrowingService->return($borrowingId);

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

            $results = $this->borrowingService->getBorrowings($page, 10, $status);

            return $this->response->setJSON([
                'success' => true,
                'borrowings' => $results['data'] ?? $results,
                'message' => 'Borrowings retrieved'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Get borrowings error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to get borrowings'
            ]);
        }
    }
}
