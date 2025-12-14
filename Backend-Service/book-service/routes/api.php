<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('member.jwt')->group(function () {
    Route::get('/allBook', [BookController::class, 'index']);
    Route::get('/Book/{book}', [BookController::class, 'show']);
});

