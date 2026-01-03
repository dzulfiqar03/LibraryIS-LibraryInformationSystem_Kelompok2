<?php

namespace App\Controllers\Member;

use App\Controllers\BaseController;
use App\Services\BookService;
use App\Services\BorrowingService;

class BookController extends BaseController
{
    protected BookService $bookService;
    protected BorrowingService $borrowingService;

    public function __construct()
    {
        $this->bookService = new BookService();
        $this->borrowingService = new BorrowingService();
    }

    public function search()
    {
        $data = [
            'user' => session()->get('user')
        ];

        return view('member/books/search', $data);
    }

    public function detail($bookId)
    {
        try {
            $book = $this->bookService->getBookById($bookId);
            
            if (!$book) {
                throw new \Exception('Book not found');
            }

            $data = [
                'bookId' => $bookId,
                'book' => $book,
                'user' => session()->get('user')
            ];

            return view('member/books/detail', $data);
        } catch (\Exception $e) {
            session()->setFlashdata('error', $e->getMessage());
            return redirect()->to('member/books/search');
        }
    }

    public function recommendations()
    {
        try {
            $recommendations = $this->bookService->getRecommendations();
            
            $data = [
                'recommendations' => $recommendations ?? [],
                'user' => session()->get('user')
            ];

            return view('member/books/recommendations', $data);
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Failed to load recommendations');
            return redirect()->to('member/dashboard');
        }
    }

    // API Methods for AJAX calls
    public function apiGetBooks()
    {
        try {
            $page = $this->request->getGet('page') ?? 1;
            $perPage = $this->request->getGet('per_page') ?? 12;
            
            $books = $this->bookService->getAllBooks([], (int)$page, (int)$perPage);
            $books = $books ?? []; // Handle null response
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $books,
                'books' => $books,
                'pagination' => [
                    'current_page' => (int)$page,
                    'total_pages' => is_array($books) ? ceil(count($books) / $perPage) : 1
                ]
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function apiSearchBooks()
    {
        try {
            $input = $this->request->getJSON(true);
            $search = $input['search'] ?? '';
            $category = $input['category'] ?? '';
            $language = $input['language'] ?? '';
            $page = $input['page'] ?? 1;
            $perPage = 12;
            
            if (empty($search) && empty($category) && empty($language)) {
                // No filters, get all books
                $books = $this->bookService->getAllBooks([], (int)$page, $perPage);
            } else {
                // Use search functionality
                $books = $this->bookService->search($search, (int)$page, $perPage);
            }
            
            // Handle null response from service
            $books = $books ?? [];
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $books['data'] ?? $books,
                'books' => $books['data'] ?? $books,
                'pagination' => $books['pagination'] ?? [
                    'current_page' => (int)$page,
                    'total_pages' => 1
                ]
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function apiBorrowBook()
    {
        try {
            $input = $this->request->getJSON(true);
            $bookId = $input['book_id'] ?? null;
            
            // Debug logging
            log_message('info', 'Borrow request - Input: ' . json_encode($input));
            log_message('info', 'Borrow request - Book ID: ' . $bookId);
            
            if (!$bookId) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Book ID is required'
                ])->setStatusCode(400);
            }
            
            // Validate bookId is numeric
            if (!is_numeric($bookId)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Book ID must be a number'
                ])->setStatusCode(400);
            }
            
            $result = $this->borrowingService->borrow((int)$bookId);
            log_message('info', 'Borrow result: ' . json_encode($result));
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Book borrowed successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to borrow book. It may not be available.'
                ])->setStatusCode(400);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function apiReserveBook()
    {
        try {
            $input = $this->request->getJSON(true);
            $bookId = $input['book_id'] ?? null;
            
            if (!$bookId) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Book ID is required'
                ])->setStatusCode(400);
            }
            
            // For now, treat reserve the same as borrow
            // You can implement separate reserve logic later
            $result = $this->borrowingService->borrow($bookId);
            
            if ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Book reserved successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to reserve book'
                ])->setStatusCode(400);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ])->setStatusCode(500);
        }
    }
}
