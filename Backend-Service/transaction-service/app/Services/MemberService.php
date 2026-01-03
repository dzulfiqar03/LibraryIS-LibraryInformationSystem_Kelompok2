<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MemberService
{
    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = 'http://127.0.0.1:8001/api';
    }

    public function getMember($memberId)
    {
        try {
            // For now, return a placeholder since Member Service doesn't have public member endpoint
            // In production, you would need to add a proper endpoint or use internal service communication
            return [
                'id' => $memberId,
                'name' => 'Member',
                'email' => 'member@example.com'
            ];

            // Commented out until proper endpoint is available
            // $response = Http::timeout(10)->get("{$this->baseUrl}/User/{$memberId}");
            // if ($response->successful()) {
            //     return $response->json()['data'] ?? $response->json();
            // }
            // return null;
        } catch (\Exception $e) {
            \Log::error("MemberService error: " . $e->getMessage());
            return null;
        }
    }
}
