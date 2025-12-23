<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Services\BookService;

class BookApiController extends BaseController
{
    protected BookService $bookService;

    public function __construct()
    {
        $this->bookService = new BookService();
    }

    /**
     * Search books via AJAX
     */
    public function search()
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setStatusCode(405)->setJSON([
                'success' => false,
                'message' => 'Method not allowed'
            ]);
        }

        try {
            $data = $this->request->getJSON();
            $query = $data->search ?? '';
            $category = $data->category ?? '';
            $language = $data->language ?? '';
            $page = $data->page ?? 1;

            // Call BookService to search
            $results = $this->bookService->search($query, $page, 12);

            return $this->response->setJSON([
                'success' => true,
                'books' => $results['data'] ?? [],
                'pagination' => $results['pagination'] ?? [],
                'message' => 'Search completed'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Book search error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Search failed: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get book detail via AJAX
     */
    public function detail($bookId)
    {
        try {
            $book = $this->bookService->getDetail($bookId);

            return $this->response->setJSON([
                'success' => true,
                'book' => $book,
                'message' => 'Book detail retrieved'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Get book detail error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to get book details'
            ]);
        }
    }

    /**
     * Get all books with filters
     */
    public function index()
    {
        try {
            $filters = [
                'search' => $this->request->getGet('search') ?? '',
                'category' => $this->request->getGet('category') ?? '',
                'language' => $this->request->getGet('language') ?? '',
            ];
            $page = $this->request->getGet('page') ?? 1;

            $results = $this->bookService->getAllBooks($filters, $page, 12);

            return $this->response->setJSON([
                'success' => true,
                'books' => $results['data'] ?? $results,
                'message' => 'Books retrieved'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Get books error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to get books'
            ]);
        }
    }
}
