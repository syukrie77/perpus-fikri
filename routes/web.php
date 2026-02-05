<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User can view borrowings
    Route::resource('borrowings', \App\Http\Controllers\BorrowingController::class);

    // Admin only routes
    Route::middleware('admin')->group(function () {
        Route::resource('books', \App\Http\Controllers\BookController::class);
        Route::resource('users', \App\Http\Controllers\UserController::class);
    });
});

require __DIR__.'/auth.php';
