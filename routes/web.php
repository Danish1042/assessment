<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Admin Routes

Route::middleware(['auth', 'verified', 'isAdmin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::post('/question-store', [AdminController::class, 'store'])->name('questions.store');
    // Add more routes for admin panel as needed
});


// User Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/user-dashboard',[UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::post('/user-submit-answers',[UserDashboardController::class, 'submit_answers'])->name('submit.answers');

    // Add more routes for admin panel as needed
});





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
