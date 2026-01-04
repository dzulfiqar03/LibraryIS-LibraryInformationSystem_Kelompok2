<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResponseResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'meta' => $this->resource['auth'] === 'Login' ? [
                'code' => 200,
                'message' => $this->resource['status'] === 'error' ? 'Validasi Gagal' : ($this->resource['status'] === 'Login Berhasil' || $this->resource['status'] !== 'Email Salah' || $this->resource['status'] !== 'Password Salah' ? 'User Berhasil Login' : 'User Not Found'),
                 'data' => [
                    'user' => $this->resource['user'] ?? auth()->user(),
                    'access_token' => [
                        'token' => $this->resource['token'] ?? null,
                        'type' => 'Bearer',
                        'expires_in' => auth()->factory()->getTTL() * 60,
                    ] ?? null,
                ],
            ] : ($this->resource['auth'] === 'Register' ? [
                'code' => 200,
                'message' => $this->resource['status'] === 'error' ? 'Validasi Gagal' : ($this->resource['status'] === 'Register Berhasil' ? 'User created successfully!' : 'User Not Created'),
                // ⬇️ DATA UTAMA
                'data' => [
                    'user' => $this->resource['user'] ?? auth()->user(),
                    'access_token' => [
                        'token' => $this->resource['token'] ?? null,
                        'type' => 'Bearer',
                        'expires_in' => auth()->factory()->getTTL() * 60,
                    ] ?? null,
                ],
            ] : [
                'code' => 200,
                'message' => 'Logout successfully!',

            ]),


        ];
    }

    public function withResponse($request, $response)
    {
        $response->setStatusCode($this['status'] === 'Success' ? $this['code'] ?? 200 : 422)->pretty();
    }
}
