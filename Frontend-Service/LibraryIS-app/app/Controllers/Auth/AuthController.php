<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function loginProcess()
    {
        // Validate input
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember') ? true : false;

        // TODO: Integrate with backend API for authentication
        // For now, mock authentication
        $user = [
            'id' => 1,
            'name' => 'Member Name',
            'email' => $email,
            'role' => 'member',
        ];

        session()->set('user', $user);
        session()->set('isLoggedIn', true);

        return redirect()->to('/member/dashboard');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function registerProcess()
    {
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // TODO: Call backend API to register user
        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
        ];

        session()->setFlash('success', 'Registration successful! Please log in.');
        return redirect()->to('/auth/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    public function forgotPassword()
    {
        return view('auth/forgot-password');
    }

    public function processForgotPassword()
    {
        $email = $this->request->getPost('email');

        // TODO: Call backend API to send reset email
        session()->setFlash('success', 'Password reset link sent to your email.');
        return redirect()->to('/auth/login');
    }
}
