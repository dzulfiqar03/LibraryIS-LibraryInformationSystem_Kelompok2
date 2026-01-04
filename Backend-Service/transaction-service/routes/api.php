<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\FineController;
use App\Http\Controllers\RecommendationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['member.jwt'])->group(function () {

    Route::middleware(['roles:admin'])->group(function () {
        Route::get('/transactions', [TransactionController::class, 'index']);

        Route::post('/transactions', [TransactionController::class, 'store']);
        Route::get('/transactions/{id}', [TransactionController::class, 'show']);
        Route::put('/transactions/{id}/return', [TransactionController::class, 'update']);
        Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);
        // Fine management routes
        Route::get('/transaction/fines', [FineController::class, 'getAllFine']);

        Route::get('/members/fines', [FineController::class, 'getMemberFines']);
        Route::post('/fines', [FineController::class, 'createFine']);
        Route::put('/fines/{fineId}/pay', [FineController::class, 'payFine']);
        Route::get('/fines/unpaid', [FineController::class, 'getAllUnpaidFines']);

        // Recommendation routes
        Route::post('/members/{memberId}/recommendations/generate', [RecommendationController::class, 'generateRecommendations']);
        Route::put('/members/{memberId}/recommendations/refresh', [RecommendationController::class, 'refreshRecommendations']);
    });


    Route::middleware(['roles:member'])->group(function () {
        Route::get('/members/{memberId}/transactions', [TransactionController::class, 'getMemberTransactions']);
        Route::get('/members/{memberId}/fines', [FineController::class, 'getMemberFines']);
        Route::get('/fines/{fineId}', [FineController::class, 'getFineDetails']);
        Route::get('/members/{memberId}/recommendations', [RecommendationController::class, 'getMemberRecommendations']);
        Route::put('/recommendations/{recommendationId}/viewed', [RecommendationController::class, 'markAsViewed']);
    });
});

// Temporary unprotected routes for testing - remove in production
Route::prefix('temp')->group(function () {
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::get('/transactions/{id}', [TransactionController::class, 'show']);
    Route::put('/transactions/{id}/return', [TransactionController::class, 'update']);
    Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);
    Route::get('/members/{memberId}/transactions', [TransactionController::class, 'getMemberTransactions']);
});
