<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MemberService
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = config('services.member_service.url');
        $this->token = config('services.member_service.token');
    }

    public function getMember($memberId)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
                'Accept' => 'application/json'
            ])->get($this->baseUrl . '/api/User/' . $memberId);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('Failed to fetch member', [
                'member_id' => $memberId,
                'response' => $response->body()
            ]);
            return null;
        } catch (\Exception $e) {
            Log::error('Exception fetching member', [
                'member_id' => $memberId,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    public function validateMember($memberId)
    {
        $member = $this->getMember($memberId);
        return $member !== null;
    }
}
