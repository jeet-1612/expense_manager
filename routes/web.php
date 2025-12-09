<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Auth Routes (Manual)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Expenses
    Route::resource('expenses', ExpenseController::class);
    
    // Categories
    Route::resource('categories', CategoryController::class)->except(['show']);

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Extra routes for statistics and export
    Route::get('/expenses/statistics', [ExpenseController::class, 'statistics'])->name('expenses.statistics');
    Route::get('/expenses/export', [ExpenseController::class, 'export'])->name('expenses.export');
});

Route::post('/login', function () {
    $credentials = request()->only('email', 'password');
    
    if (Auth::attempt($credentials)) {
        request()->session()->regenerate();
        return redirect()->route('dashboard');
    }
    
    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
})->name('login.post');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');