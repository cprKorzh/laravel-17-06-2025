<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

// Маршруты для аутентификации
Route::middleware('guest')->group(function () {
    // Регистрация
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    
    // Авторизация
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Маршруты для авторизованных пользователей
Route::middleware('auth')->group(function () {
    // Выход
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Заявки
    Route::get('/requests', [RequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/create', [RequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [RequestController::class, 'store'])->name('requests.store');
    Route::get('/requests/{id}', [RequestController::class, 'show'])->name('requests.show');
    
    // Отзывы
    Route::get('/requests/{id}/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
    Route::post('/requests/{id}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    
    // Панель администратора
    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::put('/requests/{id}/status', [AdminController::class, 'updateStatus'])->name('admin.requests.status');
        Route::delete('/requests/{id}', [AdminController::class, 'destroy'])->name('admin.requests.destroy');
    });
});
