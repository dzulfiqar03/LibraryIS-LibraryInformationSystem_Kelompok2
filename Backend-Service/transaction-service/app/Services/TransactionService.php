<?php

namespace App\Services;

use App\Jobs\Consume\ConsumeTransaction;
use App\Jobs\Consume\ConsumeTransactionBorrowed;
use App\Jobs\Publish\BookSnaphotJob;
use App\Jobs\Publish\TransactionBorrowedJob;
use App\Jobs\Publish\TransactionJob;
use App\Models\Book;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Services\MemberService;
use App\Services\BookService;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Queue;

class TransactionService
{
    protected $memberService;
    protected $bookService;

    public function __construct()
    {
        $this->memberService = new MemberService();
        $this->bookService = new BookService();
    }

    public function getAll()
    {
        return Transaction::with('transaction_details')->latest()->get();
    }

    public function createTransaction(array $data)
    {
        $books = collect($data['books'])->map(fn($b) => [
            'id_book' => $b['id_book'],
            'quantity' => $b['quantity'] ?? 1,
            'price' => $b['price'] ?? 0,
            'status' => 'borrowed',
        ])->toArray();

        $transaction = Transaction::create([
            'id_member' => $data['id_member'],
            'transaction_date' => now(),
            'due_date' => now()->addDays(14), // Set due date to 2 weeks from now
            'status' => 'borrowed'
        ]);

        foreach ($books as $book) {
            TransactionDetail::create([
                'id_transaction' => $transaction->id,
                'id_book' => $book['id_book'],
                'quantity' => $book['quantity'],
                'price' => $book['price'],
            ]);
        }


        TransactionJob::dispatch($books, $transaction->id, $data['id_member'])
            ->onQueue('transaction.book');
        BookSnaphotJob::dispatch($books, 'borrowed', 'update')
            ->onQueue('snapshot.book');

        return $transaction;
    }


    public function returnTransaction(string $memberId, array $data)
    {
        $bookIds = collect($data['books'])->pluck('id_book')->toArray();

        // Debug logging
        \Log::info("Return transaction attempt", [
            'member_id' => $memberId,
            'book_ids' => $bookIds,
            'data' => $data
        ]);

        // Check if member has any transactions at all
        $allTransactions = Transaction::where('id_member', $memberId)->get();
        \Log::info("All transactions for member {$memberId}", ['count' => $allTransactions->count()]);

        // Check if member has any borrowed transactions
        $borrowedTransactions = Transaction::where('id_member', $memberId)
            ->where('status', 'borrowed')
            ->whereNull('return_date')
            ->get();
        \Log::info("Borrowed transactions for member {$memberId}", ['count' => $borrowedTransactions->count()]);

        $transactions = Transaction::where('id_member', $memberId)
            ->where('status', 'borrowed') // Only look for active borrowed transactions
            ->whereNull('return_date') // Only transactions that haven't been returned yet
            ->whereHas('transaction_details', function ($query) use ($bookIds) {
                $query->whereIn('id_book', $bookIds);
            })
            ->get();

        \Log::info("Matching transactions found", ['count' => $transactions->count()]);

        if ($transactions->isEmpty()) {
            throw new \Exception("No borrowed transactions found for this member with given books.");
        }

        $result = [];

        foreach ($transactions as $transaction) {
            $books = collect($data['books'])->map(fn($b) => [
                'id_book' => $b['id_book'],
                'quantity' => $b['quantity'] ?? 1,
                'price' => $b['price'] ?? 0,
                'status' => 'returned',
            ])->toArray();

            $transaction->update([
                'return_date' => now(),
                'status' => 'returned',
            ]);

            $fine = $this->calculateFine($transaction);
            if ($fine > 0) {
                $transaction->update([
                    'status' => 'overdue',
                    'fine_amount' => $fine
                ]);
            }

            BookSnaphotJob::dispatch($books, 'returned', 'update')
                ->onQueue('snapshot.book');

            TransactionJob::dispatch($books, $transaction->id, $data['id_member'])
                ->onQueue('transaction.book');

            $result[] = $this->getTransactionWithDetails($transaction->id);
        }

        return $result;
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

    public function deleteTransaction($memberId, array $data)
    {
        $bookIds = collect($data['books'])->pluck('id_book')->toArray();

        $transactions = Transaction::where('id_member', $memberId)
            ->whereHas('transaction_details', function ($query) use ($bookIds) {
                $query->whereIn('id_book', $bookIds);
            })
            ->get();

        if ($transactions->isEmpty()) {
            throw new \Exception("No borrowed transactions found for this member with given books.");
        }

        $result = [];

        foreach ($transactions as $transaction) {
            $books = collect($data['books'])->map(fn($b) => [
                'id_book' => $b['id_book'],
                'quantity' => $b['quantity'] ?? 1,
                'price' => $b['price'] ?? 0,
                'status' => 'deleted',
            ])->toArray();

            // Ambil data sebelum delete
            $transactionData = $this->getTransactionWithDetails($transaction->id);

            $transaction->delete();

            BookSnaphotJob::dispatch($books, 'deleted', 'delete')
                ->onQueue('snapshot.book');

            $result[] = $transactionData;
        }

        return $result;
    }
}
