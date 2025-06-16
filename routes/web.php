<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Container\Attributes\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::post('register', [AuthController::class, 'register']);
