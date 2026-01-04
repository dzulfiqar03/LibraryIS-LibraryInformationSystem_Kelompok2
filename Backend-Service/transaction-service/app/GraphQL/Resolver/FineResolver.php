<?php

namespace App\GraphQL\Resolver;

use App\Models\FinePayment;
use App\Models\Transaction;
use App\Services\FineService;

class FineResolver
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function all()
    {
        $transaction = Transaction::with(['transaction_details', 'fine_payment'])
            ->whereHas('fine_payment')
            ->get();
        return [
            'fineList' => $transaction
        ];
    }

    public function findMemberFine($_, array $args)
    {

        $transactionMember = app(FineService::class)
            ->getMemberFines($args['id']);
        return $transactionMember;
    }
}
