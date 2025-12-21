<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:api', 'roles:admin'])->group(function () {
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::get('/transactions/{id}', [TransactionController::class, 'show']);
    Route::put('/transactions/{id}/return', [TransactionController::class, 'returnBook']);
    Route::get('/members/{memberId}/transactions', [TransactionController::class, 'getMemberTransactions']);
});
