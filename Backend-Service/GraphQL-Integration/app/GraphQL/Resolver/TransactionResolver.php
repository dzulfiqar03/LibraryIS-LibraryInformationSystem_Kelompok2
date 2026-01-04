<?php

namespace App\GraphQL\Resolver;

use Illuminate\Support\Facades\Http;

class TransactionResolver
{
    /**
     * Create a new class instance.
     */

    protected string $url = 'http://127.0.0.1:8003/api/';

public function all()
{
    $token = request()->bearerToken();

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Accept' => 'application/json',
    ])->get($this->url . 'transactions');

    $data = $response->json('data');

    $transactions = array_map(function ($transaction) {
        return [
            'id'               => $transaction['id'],
            'id_member'        => $transaction['id_member'],
            'transaction_date' => $transaction['transaction_date'],
            'return_date'      => $transaction['return_date'],
            'status'           => $transaction['status'],

            'transaction_details' => array_map(function ($detail) {
                return [
                    'id'             => $detail['id'],
                    'id_book'        => $detail['id_book'],
                    'id_transaction' => $detail['id_transaction'],
                    'price'          => $detail['price'],
                    'quantity'       => $detail['quantity'],
                ];
            }, $transaction['transaction_details'])
        ];
    }, $data);

    return [
        'transactionList' => $transactions
    ];
}


    public function find($_, array $args)
    {
        $token = request()->bearerToken();

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get($this->url . 'transactions/' . $args['id']);

        $data = $response->json('data');

        if (!$data) {
            return null;
        }

        $transaction_details = array_map(function ($detail) {
            return [
                'id' => $detail['id'],
                'id_transaction' => $detail['id_transaction'],
                'id_book' => $detail['id_book'],
                'quantity' => $detail['quantity'],
                'price' => $detail['price'],
            ];
        }, $data['transaction_details'] ?? []);


        return [
            'id' => $data['id'],
            'id_member' => $data['id_member'],
            'transaction_date' => $data['transaction_date'],
            'return_date' => $data['return_date'],
            'status' => $data['status'],
            'transaction_details' => $transaction_details,
        ];
    }

    public function create($_, array $args)
    {
        $token = request()->bearerToken();

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->post($this->url . 'transactions', $args['input']);  
        $data = $response->json('data');
        return [
            'message' => 'berhasil disimpan',
            'data' => $data,
        ];

    }
}
