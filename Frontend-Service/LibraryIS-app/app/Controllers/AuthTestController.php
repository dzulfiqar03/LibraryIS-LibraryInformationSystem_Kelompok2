<?php

namespace App\Controllers;

use App\Services\BookService;

class AuthTestController extends BaseController
{
    public function testWithAuth()
    {
        // Simulate a logged-in user session for testing
        session()->set([
            'isLoggedIn' => true,
            'member_data' => [
                'id' => '019b8347-5e6c-7176-bc21-bbe8ae82752b',
                'email' => 'admin@library.com',
                'username' => 'admin'
            ],
            'jwt_token' => 'test_token_for_debugging'
        ]);
        
        return redirect()->to('/member/books/search');
    }
    
    public function loginTest()
    {
        // Set minimal session for testing
        session()->set([
            'isLoggedIn' => true,
            'member_data' => [
                'id' => 'test-member-id',
                'email' => 'test@member.com',
                'username' => 'testuser'
            ]
        ]);
        
        return view('test_login', [
            'session_data' => session()->get(),
            'title' => 'Login Test'
        ]);
    }
}