<?php

namespace App\GraphQL\Resolver;

use Illuminate\Support\Facades\Http;

class MemberResolver
{
    /**
     * Create a new class instance.
     */
    protected string $url = 'http://127.0.0.1:8001/api/';

    public function all()
    {
        $token = request()->bearerToken();
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get($this->url . 'allUser');
        $data = $response->json('Data') ?? [];

        $users = array_map(function ($user) {
            return [
                'id' => $user['id'] ?? null,
                'email' => $user['email'] ?? null,
                'user_detail' => [
                    'id' => $user['user_detail']['id'] ?? null,
                    'username' => $user['user_detail']['username'] ?? null,
                    'name' => $user['user_detail']['name'] ?? null,
                    'id_role' => $user['user_detail']['id_role'] ?? null,
                    'telephone_number' => $user['user_detail']['telephone_number'] ?? null,
                    'roles' => [
                        'id' => $user['user_detail']['roles']['id'] ?? null,
                        'role' => $user['user_detail']['roles']['role'] ?? null,
                    ]
                ]
            ];
        }, $data);

        return [
            'user' => $users
        ];
    }


public function find($_, array $args)
{
    $token = request()->bearerToken();

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->get($this->url . 'User/' . $args['id']);

    $data = $response->json('data');

    // Jika data user tidak ditemukan
    if (!$data) {
        return null;
    }

    // Ambil data detail agar kode lebih bersih
    $detail = $data['user_detail'] ?? null;

    return [
        'id'    => $data['id'],
        'email' => $data['email'],
        'user_detail' => $detail ? [
            'id'               => $detail['id'] ?? null,
            'username'         => $detail['username'] ?? null,
            'name'             => $detail['name'] ?? null,
            'id_role'          => $detail['id_role'] ?? null,
            'telephone_number' => $detail['telephone_number'] ?? null,
            'roles'            => isset($detail['roles']) ? [
                'id'   => $detail['roles']['id'] ?? null,
                'role' => $detail['roles']['role'] ?? null,
            ] : null
        ] : null
    ];
}
}
