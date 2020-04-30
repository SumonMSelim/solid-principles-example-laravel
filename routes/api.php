<?php

use Illuminate\Support\Facades\Route;

// Register an user
Route::post('/register', 'AuthController@register');

// Admin Panel
Route::group(['middleware' => 'admin'], function () {
    // Create an user
    Route::post('/users/create', 'UserController@create');
});
