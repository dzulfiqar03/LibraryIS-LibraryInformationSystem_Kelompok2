<?php

namespace App\Controllers;

use App\Services\BookService;

class TestBookController extends BaseController
{
    public function testBooks()
    {
        $bookService = new BookService();
        
        header('Content-Type: application/json');
        
        try {
            $books = $bookService->getAllBooks();
            
            echo json_encode([
                'success' => true,
                'books' => $books,
                'count' => count($books ?? [])
            ], JSON_PRETTY_PRINT);
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], JSON_PRETTY_PRINT);
        }
    }
}