<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        $transactions = Transaction::with('transaction_details')
            ->latest()
            ->paginate(10);

        return response()->json([
            'message' => 'Berhasil',
            'data' => $transactions
        ], 200);
    }

    public function store(TransactionRequest $request)
    {
        try {
            $transaction = $this->transactionService->createTransaction($request->validated());

            
            return response()->json([
                'message' => 'Transaksi berhasil dibuat',
                'data' => $transaction
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal membuat transaksi',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function show($id)
    {
        try {
            $transaction = $this->transactionService->getTransactionWithDetails($id);

            return response()->json([
                'message' => 'Berhasil',
                'data' => $transaction
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Transaksi tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }


    public function update($id, TransactionRequest $request)
    {
        try {
            $transaction = $this->transactionService->returnTransaction($id, $request->validated());

            return response()->json([
                'message' => 'Buku berhasil dikembalikan',
                'data' => $transaction
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengembalikan buku',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy($id, TransactionRequest $request)
    {
        $book = $this->transactionService->deleteTransaction($id, $request->validated());

        return response()->json(
            [
                'message' => 'berhasil dihapus',
                'data' => $book
            ],
            200
        )->pretty();
    }

    public function getMemberTransactions($memberId)
    {
        try {
            $transactions = $this->transactionService->getMemberTransactions($memberId);

            return response()->json([
                'message' => 'Berhasil',
                'data' => $transactions
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mendapatkan transaksi member',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}
