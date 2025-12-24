<?php

namespace App\Services;

class ApiClient
{
    protected string $graphqlUrl;
    protected string $bookServiceUrl;
    protected string $transactionServiceUrl;
    protected ?string $token = null;

    public function __construct()
    {
        // Set URLs from environment
        $this->graphqlUrl = getenv('GRAPHQL_SERVICE_URL') ?? 'http://127.0.0.1:8000/api/graphql';
        $this->bookServiceUrl = getenv('BOOK_SERVICE_URL') ?? 'http://127.0.0.1:8002/api/graphql';
        $this->transactionServiceUrl = getenv('TRANSACTION_SERVICE_URL') ?? 'http://127.0.0.1:8003/api/graphql';

        // Get token from session if exists
        if (session()->has('jwt_token')) {
            $this->token = session()->get('jwt_token');
        }
    }

    /**
     * Execute GraphQL query to GraphQL Integration Service
     */
    public function graphql(string $query, array $variables = []): ?array
    {
        return $this->executeGraphQL($this->graphqlUrl, $query, $variables);
    }

    /**
     * Execute GraphQL query to Book Service
     */
    public function bookGraphql(string $query, array $variables = []): ?array
    {
        return $this->executeGraphQL($this->bookServiceUrl, $query, $variables);
    }

    /**
     * Execute GraphQL query to Transaction Service
     */
    public function transactionGraphql(string $query, array $variables = []): ?array
    {
        return $this->executeGraphQL($this->transactionServiceUrl, $query, $variables);
    }

    /**
     * Execute GraphQL query
     */
    protected function executeGraphQL(string $url, string $query, array $variables = []): ?array
    {
        try {
            $payload = [
                'query' => $query,
            ];

            if (!empty($variables)) {
                $payload['variables'] = $variables;
            }

            $response = $this->curlPost($url, $payload, $this->getHeaders());
            return $this->handleResponse($response);
        } catch (\Exception $e) {
            log_message('error', 'GraphQL Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Make POST request using cURL
     */
    protected function curlPost(string $url, array $data, array $headers = []): string
    {
        $ch = curl_init($url);
        
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => $this->formatHeaders($headers),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);

        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            log_message('error', 'cURL Error: ' . curl_error($ch));
        }
        
        curl_close($ch);
        
        return $response ?: '';
    }

    /**
     * Make GET request using cURL
     */
    protected function curlGet(string $url, array $headers = []): string
    {
        $ch = curl_init($url);
        
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_HTTPHEADER => $this->formatHeaders($headers),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);

        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            log_message('error', 'cURL Error: ' . curl_error($ch));
        }
        
        curl_close($ch);
        
        return $response ?: '';
    }

    /**
     * Format headers array for cURL
     */
    protected function formatHeaders(array $headers): array
    {
        $formatted = [];
        foreach ($headers as $key => $value) {
            $formatted[] = "$key: $value";
        }
        return $formatted;
    }

    /**
     * Make GET request
     */
    public function get(string $endpoint, array $params = []): ?array
    {
        try {
            // Determine which service URL to use based on endpoint
            $baseUrl = $this->graphqlUrl;
            if (strpos($endpoint, '/api/') === 0) {
                // Use book service URL for /api/ endpoints
                $baseUrl = rtrim($this->bookServiceUrl, '/api/graphql');
            }
            
            $url = $baseUrl . '/' . ltrim($endpoint, '/');
            if (!empty($params)) {
                $url .= '?' . http_build_query($params);
            }
            
            $response = $this->curlGet($url, $this->getHeaders());
            return $this->handleResponse($response);
        } catch (\Exception $e) {
            log_message('error', 'API GET Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Make POST request
     */
    public function post(string $endpoint, array $data = []): ?array
    {
        try {
            // Determine which service URL to use based on endpoint
            $baseUrl = $this->graphqlUrl;
            if (strpos($endpoint, '/api/') === 0) {
                // Use book service URL for /api/ endpoints
                $baseUrl = rtrim($this->bookServiceUrl, '/api/graphql');
            }
            
            $url = $baseUrl . '/' . ltrim($endpoint, '/');
            $response = $this->curlPost($url, $data, $this->getHeaders());
            return $this->handleResponse($response);
        } catch (\Exception $e) {
            log_message('error', 'API POST Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Make PUT request
     */
    public function put(string $endpoint, array $data = []): ?array
    {
        try {
            // Determine which service URL to use based on endpoint
            $baseUrl = $this->graphqlUrl;
            if (strpos($endpoint, '/api/') === 0) {
                // Use book service URL for /api/ endpoints
                $baseUrl = rtrim($this->bookServiceUrl, '/api/graphql');
            }
            
            $url = $baseUrl . '/' . ltrim($endpoint, '/');
            
            $ch = curl_init($url);
            
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_CUSTOMREQUEST => 'PUT',
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => $this->formatHeaders($this->getHeaders()),
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
            ]);

            $response = curl_exec($ch);
            curl_close($ch);
            
            return $this->handleResponse($response ?: '');
        } catch (\Exception $e) {
            log_message('error', 'API PUT Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Make DELETE request
     */
    public function delete(string $endpoint): ?array
    {
        try {
            // Determine which service URL to use based on endpoint
            $baseUrl = $this->graphqlUrl;
            if (strpos($endpoint, '/api/') === 0) {
                // Use book service URL for /api/ endpoints
                $baseUrl = rtrim($this->bookServiceUrl, '/api/graphql');
            }
            
            $url = $baseUrl . '/' . ltrim($endpoint, '/');
            
            $ch = curl_init($url);
            
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_CUSTOMREQUEST => 'DELETE',
                CURLOPT_HTTPHEADER => $this->formatHeaders($this->getHeaders()),
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
            ]);

            $response = curl_exec($ch);
            curl_close($ch);
            
            return $this->handleResponse($response ?: '');
        } catch (\Exception $e) {
            log_message('error', 'API DELETE Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Set JWT authentication token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
        session()->set('jwt_token', $token);
    }

    /**
     * Get current token
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * Clear authentication token
     */
    public function clearToken(): void
    {
        $this->token = null;
        session()->remove('jwt_token');
    }

    /**
     * Get request headers
     */
    protected function getHeaders(): array
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        if ($this->token) {
            $headers['Authorization'] = 'Bearer ' . $this->token;
        }

        return $headers;
    }

    /**
     * Handle API response
     */
    protected function handleResponse(string $response): ?array
    {
        if (empty($response)) {
            log_message('warning', 'Empty API response');
            return null;
        }

        try {
            $data = json_decode($response, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                log_message('error', 'JSON decode error: ' . json_last_error_msg());
                return null;
            }

            // Check for GraphQL errors
            if (isset($data['errors'])) {
                $errors = $data['errors'];
                if (is_array($errors) && count($errors) > 0) {
                    $errorMsg = $errors[0]['message'] ?? 'Unknown GraphQL error';
                    log_message('warning', 'GraphQL Error: ' . $errorMsg);
                    
                    // Check for authentication errors
                    if (stripos($errorMsg, 'unauthorized') !== false || stripos($errorMsg, 'unauthenticated') !== false) {
                        $this->clearToken();
                    }
                }
                return $data;
            }

            return $data;
        } catch (\Exception $e) {
            log_message('error', 'Response handling error: ' . $e->getMessage());
            return null;
        }
    }
}
