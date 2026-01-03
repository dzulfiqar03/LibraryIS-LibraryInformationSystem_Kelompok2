<?php

namespace App\Services;

class RecommendationService
{
    private $baseUrl;
    private $timeout;

    public function __construct()
    {
        $this->baseUrl = 'http://localhost:8003/api';
        $this->timeout = 30;
    }

    private function makeRequest($method, $endpoint, $data = null, $headers = [])
    {
        $token = session()->get('jwt_token');
        
        if (!$token) {
            throw new \Exception('Authentication token not found');
        }

        $defaultHeaders = [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
            'Accept: application/json'
        ];

        $headers = array_merge($defaultHeaders, $headers);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->baseUrl . $endpoint,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
        } elseif ($method === 'PUT') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            if ($data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new \Exception('Curl error: ' . $error);
        }

        curl_close($ch);

        $decodedResponse = json_decode($response, true);

        if ($httpCode >= 400) {
            throw new \Exception($decodedResponse['message'] ?? 'HTTP Error: ' . $httpCode);
        }

        return $decodedResponse;
    }

    public function getMemberRecommendations($memberId, $limit = 10)
    {
        $endpoint = "/members/{$memberId}/recommendations";
        if ($limit) {
            $endpoint .= "?limit={$limit}";
        }
        return $this->makeRequest('GET', $endpoint);
    }

    public function generateRecommendations($memberId)
    {
        return $this->makeRequest('POST', "/members/{$memberId}/recommendations/generate");
    }

    public function refreshRecommendations($memberId)
    {
        return $this->makeRequest('PUT', "/members/{$memberId}/recommendations/refresh");
    }

    public function markAsViewed($recommendationId)
    {
        return $this->makeRequest('PUT', "/recommendations/{$recommendationId}/viewed");
    }
}