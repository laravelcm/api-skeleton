<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', static fn () => ['message' => 'Welcome to the API version 1.0 !'])->name('home');
