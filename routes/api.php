<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::get('/variants', [CategoryController::class, 'index']);
    Route::get('/questions/variants/{id}', [QuestionController::class, 'getQuestionsByCategory']);
    Route::get('/questions/random', [QuestionController::class, 'getRandomQuestions']);
    Route::post('/tests/start/random', [TestController::class, 'startRandomTest']);
    Route::post('/tests/start/category/{categoryId}', [TestController::class, 'startCategory']);
});
