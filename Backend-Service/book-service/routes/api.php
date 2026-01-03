<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Protected routes with JWT middleware
Route::middleware('member.jwt')->group(function () {
    Route::get('/allBook', [BookController::class, 'index']);
    Route::get('/Book/{book}', [BookController::class, 'show']);

    Route::middleware(['roles:admin'])->group(function () {
        Route::post('/Book/store/', [BookController::class, 'store'])->name('book.create');
        Route::put('/Book/update/{book}', [BookController::class, 'update'])->name('book.update');
        Route::delete('/Book/delete/{book}', [BookController::class, 'destroy'])->name('book.delete');
    });

    Route::post('/books/update-status', [BookController::class, 'updateStatus']);
});

// Temporary unprotected routes for immediate testing - these should be protected in production
Route::prefix('temp')->group(function () {
    Route::get('/allBook', [BookController::class, 'index']);
    Route::get('/Book/{book}', [BookController::class, 'show']);
    Route::post('/Book/store/', [BookController::class, 'store']);
    Route::put('/Book/update/{book}', [BookController::class, 'update']);
    Route::delete('/Book/delete/{book}', [BookController::class, 'destroy']);
});
