<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\FinePayment;
use Carbon\Carbon;
use Illuminate\Support\Str;

class FineService
{
    public function getOverdueTransactions($memberId = null)
    {
        $query = Transaction::where('return_date', null)
            ->where('due_date', '<', now())
            ->where('status', 'borrowed');

        if ($memberId) {
            $query->where('id_member', $memberId);
        }

        return $query->get();
    }

    public function getMemberFines($memberId)
    {
        $overdueTransactions = $this->getOverdueTransactions($memberId);
        $fines = [];

        foreach ($overdueTransactions as $transaction) {
            $daysOverdue = max(0, Carbon::parse($transaction->due_date)->diffInDays(now(), false));
            $fineAmount = $daysOverdue * 5000; // Rp 5000 per day

            // Check if there's an existing unpaid fine
            $existingFine = FinePayment::where('id_transaction', $transaction->id)
                ->where('status', '!=', 'paid')
                ->first();

            $fines[] = [
                'transaction' => $transaction,
                'days_overdue' => $daysOverdue,
                'fine_amount' => $fineAmount,
                'existing_fine' => $existingFine,
                'can_pay' => $fineAmount > 0
            ];
        }

        return $fines;
    }

    public function createFinePayment($transactionId)
    {
        $transaction = Transaction::find($transactionId);
        if (!$transaction) {
            throw new \Exception('Transaction not found');
        }

        $daysOverdue = max(0, Carbon::parse($transaction->due_date)->diffInDays(now(), false));
        $fineAmount = $daysOverdue * 5000;

        if ($fineAmount <= 0) {
            throw new \Exception('No fine required for this transaction');
        }

        // Check if fine payment already exists
        $existingFine = FinePayment::where('id_transaction', $transactionId)
            ->where('status', '!=', 'paid')
            ->first();

        if ($existingFine) {
            // Update the amount if different
            $existingFine->update([
                'amount' => $fineAmount,
                'days_overdue' => $daysOverdue
            ]);
            return $existingFine;
        }

        return FinePayment::create([
            'id_transaction' => $transactionId,
            'id_member' => $transaction->id_member,
            'fine_amount' => $fineAmount,
            'days_overdue' => $daysOverdue,
            'status' => 'unpaid',
            'payment_method' => null,
            'paid_at' => null
        ]);
    }

    public function payFine($finePaymentId, $paymentMethod = 'cash')
    {
        $fine = FinePayment::find($finePaymentId);
        if (!$fine) {
            throw new \Exception('Fine payment not found');
        }

        if ($fine->status === 'paid') {
            throw new \Exception('Fine already paid');
        }

        return $fine->markAsPaid($paymentMethod);
    }

    public function getAllUnpaidFines()
    {
        return FinePayment::where('status', 'unpaid')
            ->with(['transaction' => function($query) {
                $query->select('id', 'id_member', 'transaction_date', 'due_date');
            }])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getMemberTotalFine($memberId)
    {
        return FinePayment::where('id_member', $memberId)
            ->where('status', 'unpaid')
            ->sum('fine_amount');
    }
}
