<?php

namespace App\Controllers;

use App\Services\BookService;

class DebugController extends BaseController
{
    public function testBookApi()
    {
        $bookService = new BookService();
        
        echo "<h1>Book API Debug</h1>";
        
        try {
            $books = $bookService->getAllBooks();
            echo "<h2>Books Response:</h2>";
            echo "<pre>" . print_r($books, true) . "</pre>";
        } catch (\Exception $e) {
            echo "<h2>Error:</h2>";
            echo "<p>" . $e->getMessage() . "</p>";
        }
        
        echo "<hr>";
        
        // Test direct API call
        echo "<h2>Direct API Test:</h2>";
        $token = session()->get('jwt_token');
        echo "<p>JWT Token: " . ($token ? 'Present' : 'Missing') . "</p>";
        
        if ($token) {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => 'http://127.0.0.1:8002/api/allBook',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $token,
                    'Accept: application/json',
                    'Content-Type: application/json'
                ]
            ]);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            echo "<p>HTTP Status: " . $httpCode . "</p>";
            echo "<pre>" . htmlspecialchars($response) . "</pre>";
        }
    }
}