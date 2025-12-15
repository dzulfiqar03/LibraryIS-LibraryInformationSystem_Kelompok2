<?php

namespace App\Services;

use CodeIgniter\HTTP\Client\Client;
use CodeIgniter\HTTP\Client\Response;

class ApiClient
{
    protected Client $client;
    protected string $baseUrl;
    protected ?string $token = null;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 10,
            'verify' => false, // Only for development
        ]);

        // Set base URL from environment
        $this->baseUrl = getenv('API_BASE_URL') ?? 'http://localhost:3000/api';

        // Get token from session if exists
        if (session()->has('api_token')) {
            $this->token = session()->get('api_token');
        }
    }

    /**
     * Make GET request
     */
    public function get(string $endpoint, array $params = []): ?array
    {
        try {
            $url = $this->baseUrl . '/' . ltrim($endpoint, '/');
            
            $response = $this->client->get($url, [
                'headers' => $this->getHeaders(),
                'query' => $params,
            ]);

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
            $url = $this->baseUrl . '/' . ltrim($endpoint, '/');
            
            $response = $this->client->post($url, [
                'headers' => $this->getHeaders(),
                'json' => $data,
            ]);

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
            $url = $this->baseUrl . '/' . ltrim($endpoint, '/');
            
            $response = $this->client->put($url, [
                'headers' => $this->getHeaders(),
                'json' => $data,
            ]);

            return $this->handleResponse($response);
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
            $url = $this->baseUrl . '/' . ltrim($endpoint, '/');
            
            $response = $this->client->delete($url, [
                'headers' => $this->getHeaders(),
            ]);

            return $this->handleResponse($response);
        } catch (\Exception $e) {
            log_message('error', 'API DELETE Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Set authentication token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
        session()->set('api_token', $token);
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
    protected function handleResponse(Response $response): ?array
    {
        $statusCode = $response->getStatusCode();

        if ($statusCode === 401) {
            // Token expired or invalid
            session()->destroy();
            return null;
        }

        if ($statusCode >= 200 && $statusCode < 300) {
            $body = $response->getBody();
            return json_decode($body, true) ?? [];
        }

        log_message('warning', 'API Error: ' . $statusCode . ' ' . $response->getBody());
        return null;
    }
}
