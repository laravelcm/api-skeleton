<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/', static fn () => ['message' => 'Welcome to the API !']);

Route::prefix('v1')->as('v1:')->group(
    base_path('routes/api/v1/api.php'),
);
