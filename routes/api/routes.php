<?php

declare(strict_types=1);

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class);

Route::prefix('v1')->as('v1:')->group(
    base_path('routes/api/v1/api.php'),
);
