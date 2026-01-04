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
        $token = request()->bearerToken();



        // 2. Eksekusi POST ke Backend Transaction Service
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
            'Content-Type'  => 'application/json',
        ])->post($this->uri . 'transactions', $args['input']);

        // 3. Cek jika request gagal
        if ($response->failed()) {
            $errorMsg = $response->json('message') ?? 'Gagal membuat transaksi di Backend Service.';
            throw new \Exception($errorMsg);
        }

        $newBook = $response->json('data');
        $newId = $newBook['id'] ?? null;

        if (!$newId) {
            throw new \Exception("API tidak mengembalikan ID baru.");
        }


        $data = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get($this->uri . 'transactions/' . $newId)->json('data');


        $details = collect($data['transaction_details'])->map(function ($item) {
            return [
                'id_transaction' => $item['id_transaction'],
                'id_book' => $item['id_book'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ];
        })->toArray();

        return [
            'message' => 'Transaction created successfully',
            'data' => [
                'id' => $data['id'],
                'id_member' => $data['id_member'],
                'transaction_details' => $details
            ]
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
         // 3. Cek jika request gagal
        if ($response->failed()) {
            $errorMsg = $response->json('message') ?? 'Gagal membuat transaksi di Backend Service.';
            throw new \Exception($errorMsg);
        }

        $newBook = $response->json('data');
        $newId = $newBook['id'] ?? null;

        if (!$newId) {
            throw new \Exception("API tidak mengembalikan ID baru.");
        }


        $data = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get($this->uri . 'transactions/' . $newId)->json('data');


        $details = collect($data['transaction_details'])->map(function ($item) {
            return [
                'id_transaction' => $item['id_transaction'],
                'id_book' => $item['id_book'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ];
        })->toArray();

        return [
            'message' => 'Transaction updated successfully',
            'data' => [
                'id' => $data['id'],
                'id_member' => $data['id_member'],
                'transaction_details' => $details
            ]
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
