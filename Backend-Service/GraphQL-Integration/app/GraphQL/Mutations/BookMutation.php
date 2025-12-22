<?php

namespace App\GraphQL\Mutations;

use App\GraphQL\Resolver\TransactionResolver;
use Illuminate\Support\Facades\Http;

class BookMutation
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public string $uri = 'http://localhost:8002/api/';

    public function create($_, array $args)
    {
        // Logic to create a transaction

        $token = request()->bearerToken();

        Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->post($this->uri . 'Book/store', $args['input']);
        return [
            'message' => 'Book created successfully',
            'data' => Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get($this->uri . 'allBook')->json('data'),
        ];
    }

    public function update($_, array $args)
    {
        // Logic to update a transaction

        $token = request()->bearerToken();
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->put($this->uri . 'Book/update' . $args['id'], $args['input']);
        $data = $response->json('data');
        return [
            'message' => 'Book updated successfully',
            'data' => Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get($this->uri . 'allBook')->json('data'),
        ];
    }

    public function delete($_, array $args)
    {
        // Logic to delete a transaction

        $token = request()->bearerToken();
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->delete($this->uri . 'Book/delete/' . $args['id']);
        $data = $response->json('data');
        return [
            'message' => 'Book deleted successfully',
            'data' => Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ])->get($this->uri . 'allBook')->json('data'),
        ];
    }
}
