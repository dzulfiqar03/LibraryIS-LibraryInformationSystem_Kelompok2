<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionService
{
    protected $memberService;
    protected $bookService;

    public function __construct(
        MemberService $memberService,
        BookService $bookService
    ) {
        $this->memberService = $memberService;
        $this->bookService = $bookService;
    }

    public function createTransaction(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Validate member
            if (!$this->memberService->validateMember($data['id_member'])) {
                throw new \Exception('Member not found');
            }

            // Validate books
            foreach ($data['books'] as $book) {
                if (!$this->bookService->validateBook($book['id_book'])) {
                    throw new \Exception('Book not found: ' . $book['id_book']);
                }
            }

            // Create transaction
            $transaction = Transaction::create([
                'id_member' => $data['id_member'],
                'transaction_date' => now(),
                'due_date' => Carbon::parse($data['transaction_date'])->addDays(7),
                'status' => 'borrowed'
            ]);

            // Create transaction details
            foreach ($data['books'] as $book) {
                TransactionDetail::create([
                    'id_transaction' => $transaction->id,
                    'id_book' => $book['id_book'],
                    'quantity' => $book['quantity'] ?? 1,
                    'price' => $book['price'] ?? 0
                ]);

                // Update book status in book-service
                $this->bookService->updateBookStatus($book['id_book'], 'borrowed');
            }

            return $this->getTransactionWithDetails($transaction->id);
        });
    }

    public function returnTransaction($transactionId)
    {
        return DB::transaction(function () use ($transactionId) {
            $transaction = Transaction::findOrFail($transactionId);

            if ($transaction->status === 'returned') {
                throw new \Exception('Transaction already returned');
            }

            $transaction->update([
                'return_date' => now(),
                'status' => 'returned'
            ]);

            // Calculate fine if any
            $fine = $this->calculateFine($transaction);
            if ($fine > 0) {
                $transaction->update(['fine_amount' => $fine]);
            }

            // Update book statuses
            foreach ($transaction->transaction_details as $detail) {
                $this->bookService->updateBookStatus($detail->id_book, 'available');
            }

            return $this->getTransactionWithDetails($transactionId);
        });
    }

    protected function calculateFine(Transaction $transaction)
    {
        if ($transaction->return_date <= $transaction->due_date) {
            return 0;
        }

        $daysLate = $transaction->return_date->diffInDays($transaction->due_date);
        return $daysLate * 5000; // Rp 5000 per hari keterlambatan
    }

    public function getTransactionWithDetails($transactionId)
    {
        $transaction = Transaction::with('transaction_details')->findOrFail($transactionId);

        // Get member details from member-service
        $transaction->member_details = $this->memberService->getMember($transaction->id_member);

        // Get book details from book-service
        foreach ($transaction->transaction_details as $detail) {
            $detail->book_details = $this->bookService->getBook($detail->id_book);
        }

        return $transaction;
    }

    public function getMemberTransactions($memberId)
    {
        $transactions = Transaction::where('id_member', $memberId)
            ->with('transaction_details')
            ->latest()
            ->get();

        foreach ($transactions as $transaction) {
            $transaction->member_details = $this->memberService->getMember($memberId);

            foreach ($transaction->transaction_details as $detail) {
                $detail->book_details = $this->bookService->getBook($detail->id_book);
            }
        }

        return $transactions;
    }
}
