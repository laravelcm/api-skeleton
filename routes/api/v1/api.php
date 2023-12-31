<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\AuthController;

Route::get('/', static fn () => ['message' => 'Welcome to the API version 1.0 !'])->name('home');

Route::controller(AuthController::class)->group(function() {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
});
