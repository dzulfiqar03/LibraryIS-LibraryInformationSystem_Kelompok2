<?php

namespace App\GraphQL\Mutations;


use App\Models\Transaction;
use App\Services\TransactionService;

class TransactionMutation
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function create($_, array $args)
    {
        app(TransactionService::class)
            ->createTransaction($args['input']);

        return [
            'message' => 'berhasil disimpan',
            'data' => app(TransactionService::class)->getAll(),
        ];
    }

    public function update($_, array $args)
    {
        app(TransactionService::class)
            ->returnTransaction($args['id'], $args['input']);
        return [
            'message' => 'berhasil diupdate',
            'data' => app(TransactionService::class)->getAll()
        ];
    }

    public function delete($_, array $args)
    {
       $transaction = Transaction::find($args['id']);
       $transaction->delete();

        return [
            'message' => 'berhasil dihapus',
            'data' => app(TransactionService::class)->getAll()
        ];
    }
}
