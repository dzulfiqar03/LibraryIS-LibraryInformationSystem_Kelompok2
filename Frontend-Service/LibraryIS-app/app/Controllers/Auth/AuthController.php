<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Services\AuthService;

class AuthController extends BaseController
{
    protected AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function login()
    {
        // Redirect if already logged in
        if (session()->has('jwt_token')) {
            return redirect()->to('/member/dashboard');
        }

        return view('auth/login');
    }

    /**
     * Process login via Member Service API
     */
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

        // Call Member Service API for authentication
        $loginResult = $this->authService->login($email, $password);

        if (!$loginResult || !isset($loginResult['success']) || !$loginResult['success']) {
            $errorMessage = $loginResult['message'] ?? 'Invalid email or password';
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }

        // Store user data in session
        $userData = $loginResult['user'] ?? [];
        session()->set('user', $userData);
        session()->set('isLoggedIn', true);

        // Set remember me if checked
        if ($remember) {
            session()->set('remember_me', true);
        }

        return redirect()->to('/member/dashboard')
            ->with('success', 'Login successful!');
    }

    public function register()
    {
        // Redirect if already logged in
        if (session()->has('jwt_token')) {
            return redirect()->to('/member/dashboard');
        }

        return view('auth/register');
    }

    /**
     * Process registration via Member Service API
     */
    public function registerProcess()
    {
        $rules = [
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
            'phone' => 'permit_empty|regex_match[/^[\d\-\+\(\)\s]*$/]',
            'address' => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
            'phone' => $this->request->getPost('phone') ?? null,
            'address' => $this->request->getPost('address') ?? null,
        ];

        // Call Member Service API to register
        $registerResult = $this->authService->register($data);

        if (!$registerResult || !isset($registerResult['success']) || !$registerResult['success']) {
            $errorMessage = $registerResult['message'] ?? 'Registration failed';
            return redirect()->back()
                ->withInput()
                ->with('error', $errorMessage);
        }

        // Store user data and token from registration
        if (isset($registerResult['token']) && isset($registerResult['user'])) {
            session()->set('user', $registerResult['user']);
            session()->set('isLoggedIn', true);
            
            return redirect()->to('/member/dashboard')
                ->with('success', 'Registration successful! Welcome to LibraryIS');
        }

        return redirect()->to('/auth/login')
            ->with('success', 'Registration successful! Please log in.');
    }

    /**
     * Logout user
     */
    public function logout()
    {
        $this->authService->logout();
        return redirect()->to('/')
            ->with('success', 'You have been logged out');
    }

    public function forgotPassword()
    {
        return view('auth/forgot-password');
    }

    /**
     * Process forgot password request
     */
    public function processForgotPassword()
    {
        $rules = [
            'email' => 'required|valid_email',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getPost('email');

        // Call Member Service API to request password reset
        $result = $this->authService->requestPasswordReset($email);

        if (!$result || !isset($result['success']) || !$result['success']) {
            $errorMessage = $result['message'] ?? 'Failed to process request';
            return redirect()->back()
                ->with('error', $errorMessage);
        }

        return redirect()->to('/auth/login')
            ->with('success', 'Password reset link sent to your email');
    }

    /**
     * Reset password with token
     */
    public function resetPassword(string $token = null)
    {
        if (!$token) {
            return redirect()->to('/auth/forgot-password')
                ->with('error', 'Invalid reset token');
        }

        return view('auth/reset-password', ['token' => $token]);
    }

    /**
     * Process password reset
     */
    public function processResetPassword()
    {
        $rules = [
            'token' => 'required',
            'password' => 'required|min_length[8]',
            'password_confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors());
        }

        $token = $this->request->getPost('token');
        $password = $this->request->getPost('password');

        // Call Member Service API to reset password
        $result = $this->authService->resetPassword($token, $password);

        if (!$result || !isset($result['success']) || !$result['success']) {
            $errorMessage = $result['message'] ?? 'Failed to reset password';
            return redirect()->back()
                ->with('error', $errorMessage);
        }

        return redirect()->to('/auth/login')
            ->with('success', 'Password reset successful! Please log in with your new password');
    }
}
