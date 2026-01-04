<?php

namespace App\GraphQL\Resolver;

use App\Models\Transaction;

class TransactionResolver
{

    public function all()
    {
        $transaction = Transaction::with(['transaction_details', 'fine_payment'])
            ->whereHas('fine_payment')
            ->get();
        return [
            'transactionList' => $transaction
        ];
    }

    public function find($_, array $args)
    {
        $transaction = Transaction::with('transaction_details')->findOrFail($args['id']);
        return $transaction;
    }
}
