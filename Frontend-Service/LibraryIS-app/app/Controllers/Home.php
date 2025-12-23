<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class Home extends BaseController
{
    public function index(): ResponseInterface|string
    {
        // Redirect if already logged in
        if (session()->has('jwt_token') && session()->has('user')) {
            return redirect()->to('/member/dashboard');
        }

        return view('home');
    }
}
