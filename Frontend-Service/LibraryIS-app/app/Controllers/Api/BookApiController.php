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
            log_message('info', 'BookApiController: Starting book retrieval');
            
            $filters = [
                'search' => $this->request->getGet('search') ?? '',
                'category' => $this->request->getGet('category') ?? '',
                'language' => $this->request->getGet('language') ?? '',
            ];
            $page = $this->request->getGet('page') ?? 1;

            log_message('info', 'BookApiController: Filters: ' . json_encode($filters));
            log_message('info', 'BookApiController: Current session: ' . json_encode(session()->get()));

            $results = $this->bookService->getAllBooks($filters, $page, 12);
            
            // Handle null response from service
            if ($results === null) {
                log_message('error', 'BookApiController: Service returned null');
                return $this->response->setStatusCode(500)->setJSON([
                    'success' => false,
                    'message' => 'Failed to retrieve books from service',
                    'debug' => [
                        'service_response' => 'null',
                        'session_token' => session()->get('jwt_token') ? 'present' : 'missing'
                    ]
                ]);
            }

            log_message('info', 'BookApiController: Successfully retrieved ' . count($results) . ' books');

            return $this->response->setJSON([
                'success' => true,
                'books' => $results,
                'message' => 'Books retrieved successfully',
                'debug' => [
                    'count' => count($results),
                    'filters' => $filters
                ]
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Get books error: ' . $e->getMessage());
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to get books: ' . $e->getMessage(),
                'debug' => [
                    'exception' => $e->getMessage(),
                    'line' => $e->getLine(),
                    'file' => $e->getFile()
                ]
            ]);
        }
    }
}
