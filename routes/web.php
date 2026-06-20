<?php

use App\Http\Controllers\Api\AuthController as ApiAuthController;
use App\Http\Controllers\Api\UserController as ApiUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::middleware('admin')->group(function () {
    Route::get('/users/index', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/create', [UserController::class, 'store'])->name('users.create');
});

Route::middleware('user')->group(function () {
    Route::post('/pay', [PaymentController::class, 'pay'])->name('pay');
    Route::get('/status', [PaymentController::class, 'status'])->name('status');
});
