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
     * Login user via Member Service REST API
     * 
     * @param string $email
     * @param string $password
     * @return array|null Returns user data with JWT token on success
     */
    public function login(string $email, string $password): ?array
    {
        $url = 'http://127.0.0.1:8001/api/login';
        
        $ch = curl_init($url);
        
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode([
                'email' => $email,
                'password' => $password,
            ]),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        log_message('info', "Login API Response (HTTP {$httpCode}): " . substr($response, 0, 500));

        if (!empty($curlError)) {
            log_message('error', "Login CURL Error: {$curlError}");
            return ['success' => false, 'message' => "Connection error: {$curlError}"];
        }

        if (empty($response)) {
            return ['success' => false, 'message' => 'No response from server. Is Member Service running on port 8001?'];
        }

        try {
            $data = json_decode($response, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                log_message('error', 'Login JSON decode error: ' . json_last_error_msg());
                return ['success' => false, 'message' => 'Invalid server response format'];
            }

            // Handle Member Service response structure with meta wrapper
            if (isset($data['meta']) && isset($data['meta']['data']['access_token']['token'])) {
                $token = $data['meta']['data']['access_token']['token'];
                $user = $data['meta']['data']['user'] ?? [];
                
                $this->api->setToken($token);
                return ['success' => true, 'token' => $token, 'user' => $user];
            }

            // Also handle data.meta structure (wrapped response from registration)
            if (isset($data['data']['meta']['data']['access_token']['token'])) {
                $token = $data['data']['meta']['data']['access_token']['token'];
                $user = $data['data']['meta']['data']['user'] ?? [];
                
                $this->api->setToken($token);
                return ['success' => true, 'token' => $token, 'user' => $user];
            }

            // Fallback: check for direct token in response
            if (isset($data['token'])) {
                $token = $data['token'];
                $user = $data['user'] ?? [];
                
                $this->api->setToken($token);
                return ['success' => true, 'token' => $token, 'user' => $user];
            }

            $message = 'Login failed';
            if (isset($data['meta']['message'])) {
                $message = $data['meta']['message'];
            } elseif (isset($data['message'])) {
                $message = $data['message'];
            }
            
            log_message('warning', "Login failed with message: {$message}");
            return ['success' => false, 'message' => $message];
        } catch (\Exception $e) {
            log_message('error', 'Login exception: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Server error: ' . $e->getMessage()];
        }
    }

    /**
     * Register new user via Member Service REST API
     * 
     * @param array $data User registration data (name, email, password, phone, address)
     * @return array|null Returns user data with JWT token on success
     */
    public function register(array $data): ?array
    {
        $url = 'http://127.0.0.1:8001/api/register';
        
        // Transform frontend field names to backend field names
        // Backend requires: username, name, email, password, id_role, telephone_number, address
        $registerData = [
            'name' => $data['name'] ?? '',
            'email' => $data['email'] ?? '',
            'password' => $data['password'] ?? '',
            'username' => $data['email'] ?? '', // Use email as username if not provided
            'id_role' => 2, // Default to regular user role (member)
            'telephone_number' => $data['phone'] ?? '08000000000', // Provide valid default
            'address' => $data['address'] ?? 'Not specified',
        ];
        
        $ch = curl_init($url);
        
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($registerData),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        log_message('info', "Register API Response (HTTP {$httpCode}): " . substr($response, 0, 500));

        if (!empty($curlError)) {
            log_message('error', "Register CURL Error: {$curlError}");
            return ['success' => false, 'message' => "Connection error: {$curlError}"];
        }

        if (empty($response)) {
            return ['success' => false, 'message' => 'No response from server. Is Member Service running on port 8001?'];
        }

        try {
            $data = json_decode($response, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                log_message('error', 'Registration JSON decode error: ' . json_last_error_msg());
                return ['success' => false, 'message' => 'Invalid server response format'];
            }

            // Handle validation errors (422 status)
            if ($httpCode === 422 && isset($data['errors'])) {
                $errors = $data['errors'];
                $firstError = reset($errors);
                $errorMessage = is_array($firstError) ? reset($firstError) : $firstError;
                log_message('warning', "Register validation error: {$errorMessage}");
                return ['success' => false, 'message' => $errorMessage];
            }

            // Handle server errors (5xx status)
            if ($httpCode >= 500) {
                $message = $data['message'] ?? 'Server error during registration';
                log_message('error', "Register server error (HTTP {$httpCode}): {$message}");
                return ['success' => false, 'message' => $message];
            }

            // Handle Member Service response structure with meta wrapper
            if (isset($data['meta']) && isset($data['meta']['data']['access_token']['token'])) {
                $token = $data['meta']['data']['access_token']['token'];
                $user = $data['meta']['data']['user'] ?? [];
                
                $this->api->setToken($token);
                return ['success' => true, 'token' => $token, 'user' => $user];
            }

            // Also handle data.meta structure (wrapped response from registration)
            if (isset($data['data']['meta']['data']['access_token']['token'])) {
                $token = $data['data']['meta']['data']['access_token']['token'];
                $user = $data['data']['meta']['data']['user'] ?? [];
                
                $this->api->setToken($token);
                return ['success' => true, 'token' => $token, 'user' => $user];
            }

            // Fallback: check for direct token in response
            if (isset($data['token'])) {
                $token = $data['token'];
                $user = $data['user'] ?? [];
                
                $this->api->setToken($token);
                return ['success' => true, 'token' => $token, 'user' => $user];
            }

            $message = 'Registration failed';
            if (isset($data['meta']['message'])) {
                $message = $data['meta']['message'];
            } elseif (isset($data['message'])) {
                $message = $data['message'];
            }
            
            log_message('warning', "Register failed with message: {$message}");
            return ['success' => false, 'message' => $message];
        } catch (\Exception $e) {
            log_message('error', 'Registration exception: ' . $e->getMessage());
            return ['success' => false, 'message' => 'Server error: ' . $e->getMessage()];
        }
    }

    /**
     * Get current user profile via GraphQL Integration Service
     * Requires valid JWT token
     * 
     * @return array|null
     */
    public function getCurrentUser(): ?array
    {
        $query = <<<'GraphQL'
            query GetMe {
                me {
                    id
                    name
                    email
                    phone
                    address
                    createdAt
                    updatedAt
                }
            }
        GraphQL;

        $response = $this->api->graphql($query);

        if ($response && isset($response['data']['me'])) {
            return $response['data']['me'];
        }

        return $response;
    }

    /**
     * Update user profile
     */
    public function updateProfile(array $data): ?array
    {
        $query = <<<'GraphQL'
            mutation UpdateProfile($name: String, $phone: String, $address: String) {
                updateProfile(name: $name, phone: $phone, address: $address) {
                    success
                    message
                    user {
                        id
                        name
                        email
                        phone
                        address
                    }
                }
            }
        GraphQL;

        $response = $this->api->graphql($query, $data);

        if ($response && isset($response['data']['updateProfile'])) {
            return $response['data']['updateProfile'];
        }

        return $response;
    }

    /**
     * Change password
     */
    public function changePassword(string $currentPassword, string $newPassword): ?array
    {
        $query = <<<'GraphQL'
            mutation ChangePassword($currentPassword: String!, $newPassword: String!) {
                changePassword(currentPassword: $currentPassword, newPassword: $newPassword) {
                    success
                    message
                }
            }
        GraphQL;

        $response = $this->api->graphql($query, [
            'currentPassword' => $currentPassword,
            'newPassword' => $newPassword,
        ]);

        if ($response && isset($response['data']['changePassword'])) {
            return $response['data']['changePassword'];
        }

        return $response;
    }

    /**
     * Request password reset
     */
    public function requestPasswordReset(string $email): ?array
    {
        $query = <<<'GraphQL'
            mutation RequestPasswordReset($email: String!) {
                requestPasswordReset(email: $email) {
                    success
                    message
                }
            }
        GraphQL;

        $response = $this->api->memberGraphql($query, ['email' => $email]);

        if ($response && isset($response['data']['requestPasswordReset'])) {
            return $response['data']['requestPasswordReset'];
        }

        return $response;
    }

    /**
     * Reset password with token
     */
    public function resetPassword(string $token, string $password): ?array
    {
        $query = <<<'GraphQL'
            mutation ResetPassword($token: String!, $password: String!) {
                resetPassword(token: $token, password: $password) {
                    success
                    message
                }
            }
        GraphQL;

        $response = $this->api->memberGraphql($query, [
            'token' => $token,
            'password' => $password,
        ]);

        if ($response && isset($response['data']['resetPassword'])) {
            return $response['data']['resetPassword'];
        }

        return $response;
    }

    /**
     * Logout user
     */
    public function logout(): void
    {
        $this->api->clearToken();
        session()->destroy();
    }

    /**
     * Check if user is authenticated
     */
    public function isAuthenticated(): bool
    {
        return !empty($this->api->getToken());
    }
}

