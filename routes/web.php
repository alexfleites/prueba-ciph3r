<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Container\Attributes\Auth;

Route::get('/', function () {
    return redirect('/admin');
});

Route::post('register', [AuthController::class, 'register']);
