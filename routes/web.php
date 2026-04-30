<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])
            ->name('login.post');
    });

    // Protected routes (faqat adminlar)
    Route::middleware(['auth', 'admin.web'])->group(function () {
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Categories
        Route::resource('categories', CategoryController::class);
        //Questions
        Route::resource('questions', QuestionController::class);
        //Users
        Route::resource('users', UserController::class)->only(['index', 'show', 'destroy']);
    });
});
