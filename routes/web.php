<?php

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\WebAuthController;
use App\Http\Controllers\User\TestController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\LeaderboardController;
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
    });
});


// Ochiq routelar (Hamma kira oladi)
Route::get('/login', [WebAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [WebAuthController::class, 'login'])->name('login.post');

Route::get('/register', [WebAuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [WebAuthController::class, 'register'])->name('register.post');


Route::middleware('auth')->group(function () {
    // Dashboard - Bu "Yo'riqnoma" sahifasi bo'ladi
    Route::get('/dashboard', [WebAuthController::class, 'dashboard'])->name('dashboard');
    
    // Profile - Bu shaxsiy ma'lumotlar va avatar yuklash sahifasi
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');
    
    // Testlar guruhi...
    Route::middleware('auth')->prefix('tests')->name('tests.')->group(function () {
        Route::get('/', [TestController::class, 'index'])->name('index');
        Route::get('/categories', [TestController::class, 'categories'])->name('categories');
        Route::get('/random', [TestController::class, 'startRandom'])->name('random');
        Route::get('/category/{id}', [TestController::class, 'startCategory'])->name('category');
        Route::get('/statistics', [TestController::class, 'statistics'])->name('statistics');
        
        // Yangi qator: Natijani statistika uchun saqlash (AJAX orqali)
        Route::post('/save-result', [TestController::class, 'saveResult'])->name('save');
    });

    Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');
});
