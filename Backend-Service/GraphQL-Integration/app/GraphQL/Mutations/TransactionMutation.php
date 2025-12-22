<?php

namespace App\GraphQL\Mutations;

use App\GraphQL\Resolver\TransactionResolver;
use Illuminate\Support\Facades\Http;

class TransactionMutation
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public string $uri = 'http://localhost:8003/api/';

    public function create($_, array $args)
    {
        // Logic to create a transaction

        $token = request()->bearerToken();

        Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->post($this->uri . 'transactions', $args['input']);
        return [
            'message' => 'Transaction created successfully',
            'data' => Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get($this->uri . 'transactions')->json('data'),
        ];
    }

    public function update($_, array $args)
    {
        // Logic to update a transaction

        $token = request()->bearerToken();
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->put($this->uri . 'transactions/' . $args['input']['id_member'] . '/return', $args['input']);
        $data = $response->json('data');
        return [
            'message' => 'Transaction updated successfully',
            'data' => Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get($this->uri . 'transactions')->json('data'),
        ];
    }

    public function delete($_, array $args)
    {
        // Logic to delete a transaction

        $token = request()->bearerToken();
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->delete($this->uri . 'transactions/' . $args['id']);
        $data = $response->json('data');
        return [
            'message' => 'Transaction deleted successfully',
            'data' => Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get($this->uri . 'transactions')->json('data'),
        ];
    }
}
