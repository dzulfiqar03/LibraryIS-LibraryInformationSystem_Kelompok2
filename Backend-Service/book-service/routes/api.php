<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
