<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TestSessionController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/variants', [CategoryController::class, 'index']);
    Route::post('/tests/start/random', [TestSessionController::class, 'startRandomTest']);
    Route::post('/tests/start/category/{categoryId}', [TestSessionController::class, 'startCategory']);
    Route::post('/tests/{sessionId}/answer', [TestSessionController::class, 'checkAnswer']);
});
