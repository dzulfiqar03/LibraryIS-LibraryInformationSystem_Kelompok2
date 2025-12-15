<?php

namespace App\Services;

class AuthService
{
    protected ApiClient $api;

    public function __construct()
    {
        $this->api = new ApiClient();
    }

    /**
     * Login user
     */
    public function login(string $email, string $password): ?array
    {
        $response = $this->api->post('/auth/login', [
            'email' => $email,
            'password' => $password,
        ]);

        if ($response && isset($response['token'])) {
            $this->api->setToken($response['token']);
        }

        return $response;
    }

    /**
     * Register new user
     */
    public function register(array $data): ?array
    {
        return $this->api->post('/auth/register', $data);
    }

    /**
     * Get current user profile
     */
    public function getCurrentUser(): ?array
    {
        return $this->api->get('/auth/me');
    }

    /**
     * Update user profile
     */
    public function updateProfile(array $data): ?array
    {
        return $this->api->put('/auth/profile', $data);
    }

    /**
     * Change password
     */
    public function changePassword(string $currentPassword, string $newPassword): ?array
    {
        return $this->api->post('/auth/change-password', [
            'current_password' => $currentPassword,
            'new_password' => $newPassword,
        ]);
    }

    /**
     * Request password reset
     */
    public function requestPasswordReset(string $email): ?array
    {
        return $this->api->post('/auth/forgot-password', [
            'email' => $email,
        ]);
    }

    /**
     * Reset password with token
     */
    public function resetPassword(string $token, string $password): ?array
    {
        return $this->api->post('/auth/reset-password', [
            'token' => $token,
            'password' => $password,
        ]);
    }

    /**
     * Logout
     */
    public function logout(): void
    {
        session()->destroy();
    }
}
