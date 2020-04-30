<?php

use Illuminate\Support\Facades\Route;

// Register an user
Route::post('/register', 'AuthController@register');

// Admin
Route::group(['middleware' => 'admin'], function () {
    // Users list
    Route::get('/users/index', 'UserController@index');

    // Create an user
    Route::post('/users/create', 'UserController@store');
});

// User
Route::group(['middleware' => 'user'], function () {
    // Make a payment
    Route::post('/pay', 'PaymentController@pay');

    // Payment Status
    Route::get('/status', 'PaymentController@status');
});
