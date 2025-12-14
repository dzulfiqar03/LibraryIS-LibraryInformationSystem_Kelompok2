<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware(['roles:admin'])->group(function () {
        Route::get('/allUser', [UserController::class, 'index']);
        Route::get('/User/{user}', [UserController::class, 'show']);
    });

    Route::get('/validate-token', function (Request $request) {
        return response()->json([
            'valid' => true,
            'user' => auth()->user()
        ]);
    });
});
